<?php

namespace App\DataTables;

use App\Helpers\UserHelper;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
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
                $editRoute = $user->can('role-edit') ? route('admin.roles.edit', encrypt($row->id)) : '';
                $deleteRoute = $user->can('role-delete') ? route('admin.roles.destroy', encrypt($row->id)) : '';
                $viewRoute = $user->can('role-show') ? route('admin.roles.show', encrypt($row->id)) : '';

                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  Role  $model
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        $createRole = $this->user->can('role-create');
        $dataTable = $this->builder()
            ->setTableId('roles')
            ->columns($this->getColumns())
            ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            ->minifiedAjax()
            ->orderBy('2', 'desc');


        $buttons = [];
        if ($createRole) {
            $buttons[] = Button::make('add')
                ->attr(['class' => 'btn text-center btn-primary']) // Directly set the class attribute
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
        return 'Roles_' . date('YmdHis');
    }
}
