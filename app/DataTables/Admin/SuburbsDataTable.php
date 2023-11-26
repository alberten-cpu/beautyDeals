<?php

namespace App\DataTables\Admin;

use App\Models\Suburb;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class SuburbsDataTable extends DataTable
{
    protected string $tableName = 'suburbs-table';

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        dd($query);
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId('id')
            ->addColumn('action', function ($query) {
                return view('template.admin.datatable.action.select', compact('query'))
                    ->with(
                        ['buttons' =>
                            [
                                'Edit' =>
                                    [
                                        'route' => 'suburbs.edit',
                                        'class' => 'dropdown-item',
                                    ],
                                'Delete' =>
                                    [
                                        'class' => 'dropdown-item delete-button',
                                        'attributes' => "data-bs-toggle=modal data-bs-target=#delete-popup data-action=" . route('suburbs.destroy', $query->id)
                                    ]
                            ]
                        ]
                    );
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Suburb $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('no')
                ->title(__('No'))
                ->data('DT_RowIndex')
                ->searchable(false)
                ->orderable(false)
                ->width(50),
            Column::make('suburb')
                ->title(__('Suburb'))
                ->width(50),
            Column::make('latitude')
                ->title(__('Latitude'))
                ->width(50),
            Column::make('longitude')
                ->title(__('Longitude'))
                ->width(50),
            Column::make('status')
                ->title(__('Status'))
                ->render("function () {
                return this.status===true ? '" . __('Active') . "' : '" . __('Inactive') . "' }")
                ->width(50),
            Column::make()->computed('action')
                ->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60),
        ];
    }

    /**
     * @return array
     */
    protected function buttons(): array
    {
        return [
            Button::make()
                ->action("window.location = '" . route('suburbs.create') . "';")
                ->text(__('Create'))
                ->addClass('buttons-html5')
        ];
    }
}
