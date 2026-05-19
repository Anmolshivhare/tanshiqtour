<?php

namespace App\DataTables;

use App\Models\Destination;
use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DestinationDataTable extends DataTable
{
    private $user;

    public function __construct()
    {
        $this->user = UserHelper::getLoggedInUser();
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $user = $this->user;
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($user) {
                $editRoute   = $user->can('destination-edit')   ? route('admin.destinations.edit',    encrypt($row->id)) : '';
                $deleteRoute = $user->can('destination-delete') ? route('admin.destinations.destroy', encrypt($row->id)) : '';
                $viewRoute   = $user->can('destination-show')   ? route('admin.destinations.show',   encrypt($row->id)) : '';
                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })
            ->editColumn('status', function ($row) {
                return $row->statusName->name ?? 'N/A';
            })
            ->setRowId('id');
    }

    public function query(Destination $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $userCreate = $this->user->can('destination-create');
        $dataTable  = $this->builder()
            ->setTableId('destinations')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            ->orderBy('3', 'desc');

        $buttons = [];
        if ($userCreate) {
            $buttons[] = Button::make('add')
                ->attr(['class' => 'btn text-center btn-primary'])
                ->text(__('buttons.create'));
        }
        $dataTable->buttons($buttons);

        return $dataTable->parameters([
            'processing' => false,
            'language'   => ['searchPlaceholder' => __('labels.search')],
        ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title(__('labels.id'))->width(50)->addClass('text-center'),
            Column::make('name')->title('Name')->addClass('text-center'),
            Column::make('country')->title('Country')->addClass('text-center'),
            Column::make('city')->title('City')->addClass('text-center'),
            Column::make('status')->title(__('labels.status'))->addClass('text-center'),
            Column::make('created_at')->title(__('labels.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('labels.action'))
                ->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Destinations_' . date('YmdHis');
    }
}
