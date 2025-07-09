<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\LaboratoriumUnpam;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BarangFormUpdate extends Component
{
    public $barang_id, $nama, $kategori_barang_id, $meja_id, $status, $lab_id, $spesifikasi, $deskripsi;
    public $kategoriBarangs = [], $mejas = [], $laboratoriumUnpams = [];
    public bool $showMejaSelect = false;

    public function mount($hash)
    {
        $id = decrypt($hash);
        $barang = Barang::with(['kategoriBarang', 'meja', 'laboratoriumUnpam'])->findOrFail($id);

        $this->barang_id = $barang->id;
        $this->nama = $barang->nama;
        $this->kategori_barang_id = $barang->kategori_barang_id;
        $this->meja_id = $barang->meja_id;
        $this->status = $barang->status;
        $this->lab_id = $barang->lab_id;
        $this->spesifikasi = $barang->spesifikasi;
        $this->deskripsi = $barang->deskripsi;

        $this->loadKategoriBarangs();
        $this->loadLaboratoriumUnpams();

        // LOGIKA BARU: tampilkan select meja jika kategori BUKAN 'meja'
        $kategori = KategoriBarang::find($this->kategori_barang_id);
        if ($kategori && strtolower($kategori->nama) !== 'meja') {
            $this->showMejaSelect = true;
            $this->loadMejas();
        } else {
            $this->showMejaSelect = false;
            $this->mejas = [];
        }
    }

    public function updatedKategoriBarangId($value)
    {
        $this->showMejaSelect = false;
        $this->meja_id = null;

        if ($value) {
            $kategoriBarang = KategoriBarang::find($value);

            if ($kategoriBarang && strtolower($kategoriBarang->nama) == 'meja') {
                // Jika kategori adalah 'meja', JANGAN tampilkan select meja
                $this->showMejaSelect = false;
                $this->mejas = [];
                $this->meja_id = null;
            } else {
                // Jika kategori bukan 'meja', tampilkan select meja dan load mejas
                $this->showMejaSelect = true;
                $this->loadMejas();
            }
        } else {
            $this->showMejaSelect = false;
            $this->mejas = [];
            $this->meja_id = null;
        }
    }

    public function loadKategoriBarangs()
    {
        $this->kategoriBarangs = KategoriBarang::select('id','nama')->get();
    }

    public function loadMejas()
    {
        $user = auth()->user();
        $peran = $user->role->nama_peran;

        $mejasQuery = Barang::with(['laboratoriumUnpam.lokasi'])
            ->select('id', 'nama', 'lab_id')
            ->whereHas('kategoriBarang', function ($query) {
                $query->where('nama', 'like', '%meja%');
            });

        if ($peran != 'admin') {
            $mejasQuery->whereHas('laboratoriumUnpam', function ($q) use ($user) {
                $q->where('lokasi_id', $user->lokasi_id);
            });
        }

        $this->mejas = $mejasQuery->get();
    }

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

    private function checkMejaIdAndLabId()
    {
        $meja = $this->meja_id;
        $lab = $this->lab_id;

        if ($meja) {
            $meja = Barang::find($meja);
            if ($meja && $meja->lab_id != $lab) {
                return false;
            }
        }
        return true;
    }

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

    public function update()
    {
        $this->validateForm();

        if (!$this->validateMejaLabRelation()) {
            return;
        }

        try {
            DB::beginTransaction();

            $barang = Barang::findOrFail($this->barang_id);

            $barang->update([
                'nama' => $this->nama,
                'kategori_barang_id' => $this->kategori_barang_id,
                'meja_id' => $this->meja_id,
                'status' => $this->status,
                'lab_id' => $this->lab_id,
                'spesifikasi' => $this->spesifikasi,
                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();
            session()->flash('success', 'Barang berhasil diubah.');
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat mengubah barang');
        }
    }

    public function render()
    {
        return view('livewire.barang.barang-form-update');
    }
}
