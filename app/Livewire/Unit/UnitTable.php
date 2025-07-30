<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class UnitTable extends PowerGridComponent
{
    public string $tableName = 'units';
    public function setUp(): array
    {

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount()
        ];
    }

    public string $currentRoute = '';

    public function datasource(): Builder
    {
        return Unit::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('nama_unit')
            ->add('jenis_unit')
            ->add('kode_unit')
            ->add('created_at_formatted', function (Unit $model) {
                return Carbon::parse($model->created_at)->format('d M Y H:i');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Nama unit', 'nama_unit')
                ->sortable()
                ->searchable(),

            Column::make('Jenis unit', 'jenis_unit')
                ->sortable()
                ->searchable(),

            Column::make('Kode unit', 'kode_unit')
                ->sortable()
                ->searchable(),

            Column::make('Dibuat', 'created_at_formatted')
                ->sortable()
                ->searchable(),

            Column::action('Aksi')
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(Unit $row): array
    {
        return [
            Button::make('edit')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>')
                ->class('btn btn-sm btn-warning')
                ->dispatch('open-edit-modal', ['hash' => encrypt($row->id)])
                ->attributes([
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#formModalUpdate',
                ]),
        ];
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
