<?php

namespace App\Livewire\Barang;

use \App\Models\KategoriBarang;
use \Exception;
use App\Models\Barang;
use App\Models\LaboratoriumUnpam;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BarangFormStore extends Component
{
    /**
     * Belum Buat Validasi Check Kapasitas Lab nya berdasarkan meja
     */

    public $nama, $kategori_barang_id, $meja_id, $status, $lab_id, $spesifikasi, $deskripsi;
    public $kategoriBarangs = [], $mejas = [], $laboratoriumUnpams = [];
    public bool $showMejaSelect = false;

    public function mount()
    {
        $this->loadKategoriBarangs();
        $this->loadLaboratoriumUnpams();
    }

    /**
     * Update the meja_id based on the selected kategori_barang_id.
     * If the selected kategori_barang_id is 'meja', it will show the meja selection.
     * If the selected kategori_barang_id is not 'meja', it will hide the meja selection.
     */
    public function updatedKategoriBarangId($value)
    {
        $this->showMejaSelect = false;

        $kategoriId = $value;

        if ($kategoriId)
        {
            $kategoriBarang = KategoriBarang::find($kategoriId);
        
            if($kategoriBarang == 'meja') {
                $this->showMejaSelect = true;
                $this->loadMejas();
            } else {
                $this->showMejaSelect = false;
                $this->meja_id = null;
            }
        }
    }

    /**
     * Load all kategori barangs from the database.
     */
    public function loadKategoriBarangs()
    {
        $this->kategoriBarangs = KategoriBarang::select('id','nama')->get();
    }

    /**
     * Load all mejas from the database.
     * If the user is an admin, it loads all mejas.
     * If the user is not an admin, it filters mejas based on the user's location.
     * It also filters mejas to only include those that belong to the 'meja'
     * category in the barang table.
     */
    public function loadMejas()
    {
        $user = auth()->user();
        $peran = $user->role->nama_peran;

        $mejasQuery = Barang::with(['laboratoriumUnpam.lokasi'])
            ->select('id', 'nama', 'lab_id')
            ->whereHas('kategoriBarang', function ($query) {
                $query->where('nama', 'like', '%meja%');
            });
        
        if ($peran != 'admin')
        {
            $mejasQuery->whereHas('laboratoriumUnpam', function ($q) use ($user) {
                $q->where('lokasi_id', $user->lokasi_id);
            });
        }

        $this->mejas = $mejasQuery->get();
    }

    /**
     * Load all laboratorium unpams based on the user's role and location.
     * If the user is an admin, all laboratorium unpams are loaded except those with 'fleksiblle' location.
     * If the user is not an admin, only laboratorium unpams from the user's location are loaded.
     */
    public function loadLaboratoriumUnpams()
    {
        $user = auth()->user();
        $peran = $user->role->nama_peran;

        $laboratoriumUnpamsQuery = LaboratoriumUnpam::with('lokasi')->select('id', 'nama_laboratorium', 'lokasi_id');

        if ($peran == 'admin') {
            $laboratoriumUnpamsQuery->where('lokasi_id', '!=', 'fleksiblle');
        } else {
            $laboratoriumUnpamsQuery->where('lokasi_id', $user->lokasi_id);
        }

        $this->laboratoriumUnpams = $laboratoriumUnpamsQuery->get();

    }

    /**
     * Check if meja_id and lab_id are valid.
     * If meja_id is provided, it checks if the meja belongs to the same lab as lab_id.
     * If meja_id is null or the lab of meja matches the lab_id, it returns true.
     * If meja_id is provided but does not match the lab_id, it returns false.
     */
    private function checkMejaIdAndLabId()
    {
        $meja = $this->meja_id;
        $lab = $this->lab_id;

        if ($meja) {
            $meja = Barang::find($meja);
            if ($meja && $meja->lab_id != $lab) {
                // Lab meja dan lab barang tidak sama
                return false;
            }
        }
        // Jika meja_id null atau lab sama, return true
        return true;
    }

    /**
     * Validasi relasi antara meja dan laboratorium.
     * Jika tidak valid, tambahkan error pada meja_id.
     * Return true jika valid, false jika tidak.
     */
    private function validateMejaLabRelation()
    {
        if (!$this->checkMejaIdAndLabId()) {
            $this->addError('meja_id', 'Meja yang dipilih tidak sesuai dengan laboratorium yang dipilih.');
            return false;
        }
        return true;
    }

    public function validateForm()
    {
         $rules = [
            'nama' => 'required|string|max:255',
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'meja_id' => 'nullable|exists:barangs,id',
            'status' => 'required|in:digunakan,rusak,hilang,tidak dipakai',
            'lab_id' => 'required|exists:laboratorium_unpams,id',
            'spesifikasi' => 'required|string|max:1000',
            'deskripsi' => 'required|string|max:1000',
        ];

        $messages = [
            'nama.required' => 'Nama barang harus diisi.',
            'kategori_barang_id.required' => 'Kategori barang harus dipilih.',
            'meja_id.exists' => 'Meja yang dipilih tidak valid.',
            'status.required' => 'Status barang harus dipilih.',
            'lab_id.required' => 'Laboratorium harus dipilih.',
            'spesifikasi.required' => 'Spesifikasi barang harus diisi.',
            'spesifikasi.string' => 'Spesifikasi harus berupa teks.',
            'spesifikasi.max' => 'Spesifikasi maksimal 1000 karakter.',
            'deskripsi.required' => 'Deskripsi barang harus diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ];

        $this->validate($rules, $messages);
    }

    public function store()
    {
        $this->validateForm();

        if (!$this->validateMejaLabRelation()) {
            return;
        }

        try {

            DB::beginTransaction();

            Barang::create([
                'nama' => $this->nama,
                'kategori_barang_id' => $this->kategori_barang_id,
                'meja_id' => $this->meja_id,
                'status' => $this->status,
                'lab_id' => $this->lab_id,
                'spesifikasi' => $this->spesifikasi,
                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();
            session()->flash('success', 'Barang berhasil ditambahkan.');
            return redirect()->route('barang.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menambahkan barang');
        }
    }

    public function render()
    {
        return view('livewire.barang.barang-form-store');
    }
}
