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
        return [
        ];
    }

    public function actions(Unit $row): array
    {
        return [
            Button::make('edit')
                ->slot('Ubah')
                ->id()
                ->class('btn btn-sm btn-primary text-white')
                ->route('unit.edit', ['hash' => encrypt($row->id)]),
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
