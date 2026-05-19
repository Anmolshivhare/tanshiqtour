<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Helpers\UserHelper;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
                $editRoute = $user->can('user-edit') ? route('admin.users.edit', encrypt($row->id)) : '';
                $deleteRoute = $user->can('user-delete') ? route('admin.users.destroy', encrypt($row->id)) : '';
                $viewRoute = $user->can('user-show') ? route('admin.users.show', encrypt($row->id)) : '';
                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })
            ->editColumn('status', function ($row) {
                return $row->statusName->name ?? 'N/A';
            })
            // ->editColumn('role', function ($row) {
            //     // dd($row);
            //     return $row->roles?->name ?? 'N/A';
            // })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();

    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        $userCreate = $this->user->can('user-create');
        $dataTable = $this->builder()
            ->setTableId('users')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            // ->dom('Bfrtip')
            ->orderBy('3', 'desc');

        $buttons = [];
        if ($userCreate) {
            $buttons[] = Button::make('add')
                ->attr(['class' => 'btn text-center btn-primary'])
                ->text(__('buttons.create'));
        }
        $dataTable->buttons($buttons);

        return $dataTable
            ->parameters([
                'processing' => false,
                'language' => [
                    'searchPlaceholder' => __('labels.search'),
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
                ->title(__('labels.id'))
                ->width(50)
                ->addClass('text-center'),
            Column::make('name')->title(__('labels.name'))->addClass('text-center'),
            Column::make('email')->title(__('labels.email'))->addClass('text-center'),
            // Column::make('role.name')->title(__('labels.role'))->addClass('text-center'),
            Column::make('status')->title(__('labels.status'))->addClass('text-center'),
            Column::make('created_at')->title(__('labels.created_at'))->addClass('text-center'),
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
        return 'User_' . date('YmdHis');
    }
}
