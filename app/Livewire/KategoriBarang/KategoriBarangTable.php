<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class KategoriBarangTable extends PowerGridComponent
{
    public string $tableName = 'kategori-barangs';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return KategoriBarang::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama')
            ->add('deskripsi')
            ->add('created_at_formmatted', fn(KategoriBarang $model) => Carbon::parse($model->created_at)->locale('id')->translatedFormat('d F Y H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Nama', 'nama')
                ->sortable()
                ->searchable(),

            Column::make('Deskripsi', 'deskripsi')
                ->sortable()
                ->searchable(),
            
            Column::make('Dibuat', 'created_at_formmatted')
                ->sortable()
                ->searchable(),

            Column::action('Aksi')
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    public function actions(KategoriBarang $row): array
    {
        return [
            Button::make('edit')
                ->slot('Ubah')
                ->id()
                ->class("btn btn-sm btn-primary text-white")
                ->route('kategori-barang.edit', ['hash' => encrypt($row->id)]),

            Button::make('delete')
                ->slot('Hapus')
                ->id()
                ->class("btn btn-sm btn-danger text-white")
                ->dispatch('kategoriBarangDestroyModal', ['hash' => encrypt($row->id)]),
        ];
    }

    public function noDataLabel(): string|View
    { 
        return 'Tidak ada data yang ditemukan.';
        // return view('dishes.no-data');
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
