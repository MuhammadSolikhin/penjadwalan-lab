<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Laboran\ProsesPengajuanBooking\ProsesPengajuanBookingTable;
use App\Livewire\Laboran\ProsesPengajuanBooking\DetailProsesPengajuanBooking;
use App\Livewire\Laboran\ProsesPengajuanBooking\TerimaProsesPengajuanBooking;
use App\Livewire\Laboran\ProsesPengajuanBooking\TolakProsesPengajuanBooking;
use App\Livewire\KategoriBarang\KategoriBarangTable;
use App\Livewire\KategoriBarang\KategoriBarangFormStore;
use App\Livewire\KategoriBarang\KategoriBarangFormUpdate;
use App\Livewire\KategoriBarang\KategoriBarangFormDestroy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('laboran.prosespengajuanbooking.proses-pengajuan-booking-table', ProsesPengajuanBookingTable::class);
        Livewire::component('laboran.prosespengajuanbooking.detail-proses-pengajuan-booking', DetailProsesPengajuanBooking::class);
        Livewire::component('laboran.prosespengajuanbooking.terima-proses-pengajuan-booking', TerimaProsesPengajuanBooking::class);
        Livewire::component('laboran.prosespengajuanbooking.tolak-proses-pengajuan-booking', TolakProsesPengajuanBooking::class);
        Livewire::component('kategoribarang.kategori-barang-table', KategoriBarangTable::class);
        Livewire::component('kategori-barang.kategori-barang-form-store', KategoriBarangFormStore::class);
        Livewire::component('kategori-barang.kategori-barang-form-update', KategoriBarangFormUpdate::class);
        Livewire::component('kategoribarang.kategori-barang-form-destroy', KategoriBarangFormDestroy::class);
    }
}
