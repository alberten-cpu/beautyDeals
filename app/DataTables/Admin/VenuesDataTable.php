<?php

namespace App\DataTables\Admin;

use App\Models\Venues;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class VenuesDataTable extends DataTable
{
    protected string $tableName = 'venues-table';

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
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
                                        'route' => 'venues.edit',
                                        'class' => 'dropdown-item',
                                    ],
                                'Delete' =>
                                    [
                                        'class' => 'dropdown-item delete-button',
                                        'attributes' => "data-bs-toggle=modal data-bs-target=#delete-popup data-action=" . route('venues.destroy', $query->venueId)
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
    public function query(Venues $model): QueryBuilder
    {
        return $model->newQuery()->with('user');
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
            Column::make('venueName')
                ->title(__('Vendor Name'))
                ->width(50),
            Column::make('vendorEmail')
                ->title(__('Vendor Email'))
                ->data('user.email')
                ->width(50),
            Column::make('vendorPhoneNumber')
                ->title(__('Vendor Phone'))
                ->data('user.PhoneNumber')
                ->width(50),
            Column::make('venueType')
                ->title(__('Type'))
                ->width(50),
            Column::make('placeName')
                ->title(__('Venue Place'))
                ->width(50),
            Column::make('venueStatus')
                ->title(__('Status'))
                ->render("function () {
                return this.venueStatus===true ? '" . __('Active') . "' : '" . __('Inactive') . "' }")
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
                ->action("window.location = '" . route('venues.create') . "';")
                ->text(__('Create'))
                ->addClass('buttons-html5')
        ];
    }
}
