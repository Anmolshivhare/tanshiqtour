<?php

namespace App\DataTables;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Helpers\UserHelper;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionsDataTable extends DataTable
{
    private $user;

    public function __construct()
    {
        $this->user = UserHelper::getLoggedInUser();
    }

    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $user = $this->user;
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($user) {
                $editRoute = $user->can('permission-edit') ? route('admin.permissions.edit', encrypt($row->id)) : '';
                $deleteRoute = $user->can('permission-delete') ? route('admin.permissions.destroy', encrypt($row->id)) : '';
                $viewRoute = $user->can('permission-show') ? route('admin.permissions.show', encrypt($row->id)) : '';

                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  Permission  $model
     */
    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        $permissionCreate = $this->user->can('permission-create');
        $dataTable = $this->builder()
            ->setTableId('permissions')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            // ->dom('Bfrtip')
            ->stateSave(true)
            ->orderBy('2', 'desc');
        $buttons = [];
        if (!empty($permissionCreate)) {
            $buttons[] = Button::make('add')
                ->attr(['class' => 'btn text-center btn-primary'])
                ->text(__('buttons.create'));
        }
        $dataTable->buttons($buttons);

        return $dataTable->parameters([
            'processing' => false,
            'language' => [
                'searchPlaceholder' => __('labels.search_placeholder'),
            ],
        ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title(__('labels.sr_no'))
                ->width(50)
                ->addClass('text-center'),
            Column::make('name')->title(__('labels.name')),
            Column::make('created_at')->title(__('labels.created_at')),
            Column::make('updated_at')->title(__('labels.updated_at')),
            Column::computed('action')->title(__('labels.action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Permissions_' . date('YmdHis');
    }
}
