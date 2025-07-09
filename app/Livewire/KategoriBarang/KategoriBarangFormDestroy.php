<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class KategoriBarangFormDestroy extends Component
{
    public $nama, $deskripsi;
    public $kategoriBarangId;

    public bool $showModal = false;

    #[On('kategoriBarangDestroyModal')]
    public function kategoriBarangDestroyModal($hash)
    {
        $id = decrypt($hash);
        $kategoriBarang = KategoriBarang::findOrFail($id);

        if ($kategoriBarang) {
            $this->kategoriBarangId = $id;
            $this->nama = $kategoriBarang->nama;
        } else {
            $this->nama = 'Tidak Diketahui';
        }

        $this->showModal = true;
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $kategoriBarang = KategoriBarang::findOrFail($this->kategoriBarangId);

            if($kategoriBarang) {
                $kategoriBarang->delete();
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
        return view('livewire.kategori-barang.kategori-barang-form-destroy');
    }
}
