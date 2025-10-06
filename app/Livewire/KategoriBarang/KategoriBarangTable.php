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
    public string $currentRoute = '';

    public function setUp(): array
    {
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
                ->sortable(),

            Column::action('Aksi')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(KategoriBarang $row): array
    {
        return [
            Button::make('edit')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>')
                ->id()
                ->class("btn btn-sm btn-warning")
                ->dispatch('open-edit-modal', ['hash' => encrypt($row->id)])
                ->attributes([
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#formModalUpdate',
                ]),

            Button::make('delete')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
         viewBox="0 0 24 24" fill="none" stroke="currentColor"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         class="feather feather-trash-2">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
        <path d="M10 11v6"></path>
        <path d="M14 11v6"></path>
        <path d="M15 6V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v2"></path>
    </svg>')
                ->id()
                ->class("btn btn-sm btn-danger")
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
