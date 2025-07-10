<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class BarangFormDestroy extends Component
{

    public $barang;
    public $nama, $kategoriBarang, $meja, $status, $laboratorium;

    public bool $showModal = false;

    #[On('barangDestroyModal')]
    public function barangDestroyModal($hash)
    {
        $id = decrypt($hash);
        $barang = Barang::with(['kategoriBarang', 'meja', 'laboratoriumUnpam'])->findOrFail($id);

        if ($barang) {
            $this->barang = $barang;
            $this->nama = $barang->nama;
            $this->kategoriBarang = $barang->kategoriBarang ? $barang->kategoriBarang->nama : 'Tidak Diketahui';
            $this->meja = $barang->meja;
            $this->status = $barang->status;
            $this->laboratorium = $barang->laboratoriumUnpam ? $barang->laboratoriumUnpam->nama_laboratorium : 'Tidak Diketahui';
        } else {
            $this->nama = 'Tidak Diketahui';
        }
        $this->showModal = true;
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();
            
            $barang = Barang::findOrFail($this->barang->id);

            if ($barang) {
                $barang->delete();
            }

            DB::commit();
            $this->showModal = false;
            // validasi di sweetalert
        } catch (Exception $e) {
            DB::rollBack();
            $this->showModal = false;
            // validasi di sweetalert
        }
    }

    public function render()
    {
        return view('livewire.barang.barang-form-destroy');
    }
}
