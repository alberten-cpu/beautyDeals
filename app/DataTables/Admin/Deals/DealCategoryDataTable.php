<?php

namespace App\DataTables\Admin\Deals;

use App\DataTables\Admin\DataTable;
use App\Models\DealCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class DealCategoryDataTable extends DataTable
{
    protected string $tableName = 'category-table';

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
                                        'route' => 'categories.edit',
                                        'class' => 'dropdown-item',
                                    ],
                                'Delete' =>
                                    [
                                        'class' => 'dropdown-item delete-button',
                                        'attributes' => "data-bs-toggle=modal data-bs-target=#delete-popup data-action=" . route('categories.destroy', $query->categoryId)
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
    public function query(DealCategory $model): QueryBuilder
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
            Column::make('categoryName')
                ->title(__('Category Name'))
                ->width(50),
            Column::make('categoryStatus')
                ->title(__('Status'))
                ->render("function () {
                return this.categoryStatus===true ? '" . __('Active') . "' : '" . __('Inactive') . "' }")
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
                ->action("window.location = '" . route('categories.create') . "';")
                ->text(__('Create'))
                ->addClass('buttons-html5')
        ];
    }
}
