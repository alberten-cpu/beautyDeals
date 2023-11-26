<?php

namespace App\DataTables\Admin\Deals;

use App\DataTables\Admin\DataTable;
use App\Models\DealSubCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class DealSubCategoryDataTable extends DataTable
{
    protected string $tableName = 'subCategory-table';

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
                                        'route' => 'sub_categories.edit',
                                        'class' => 'dropdown-item',
                                    ],
                                'Delete' =>
                                    [
                                        'class' => 'dropdown-item delete-button',
                                        'attributes' => "data-bs-toggle=modal data-bs-target=#delete-popup data-action=" . route('sub_categories.destroy', $query->dealSubCategoryId)
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
    public function query(DealSubCategory $model): QueryBuilder
    {
        return $model->newQuery()->with('category');
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
            Column::make('dealSubCategoryName')
                ->title(__('Category Name'))
                ->width(50),
            Column::make('categoryName')
                ->title(__('Category Name'))
                ->data('category.categoryName')
                ->width(50),
            Column::make('dealSubCategoryStatus')
                ->title(__('Status'))
                ->render("function () {
                return this.dealSubCategoryStatus===true ? '" . __('Active') . "' : '" . __('Inactive') . "' }")
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
                ->action("window.location = '" . route('sub_categories.create') . "';")
                ->text(__('Create'))
                ->addClass('buttons-html5')
        ];
    }
}
