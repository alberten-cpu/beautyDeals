<?php

namespace App\DataTables\Admin;

use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable as CoreDataTable;

class DataTable extends CoreDataTable
{
    /**
     * @var string
     */
    protected string $dom = '<"float-md-start"f><"float-md-end mt-2"B><"wrapper"t><"d-md-flex justify-content-md-between"<l><i><p>>';
    /**
     * @var bool
     */
    protected bool $ordering = false;
    /**
     * @var string
     */
    protected string $pagingTYpe = 'numbers';
    /**
     * @var bool
     */
    protected bool $enableDelete = true;

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->tableName)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom($this->dom)
            ->responsive()
            ->ordering($this->ordering)
            ->pagingType($this->pagingTYpe)
            ->colReorderEnable()
            ->stateSave()
            ->buttons($this->buttons())
            ->setPluginAttribute('delete',$this->enableDelete)
            ->parameters([
                'language' => [
                    'search' => '',
                    'searchPlaceholder' => __('Search'),
                ]
            ]);
    }

    /**
     * @return array
     */
    protected function buttons(): array
    {
        return [];
    }
}
