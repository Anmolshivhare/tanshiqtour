<?php

namespace App\DataTables;

use App\Models\Enquiry;
use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EnquiryDataTable extends DataTable
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
                $viewRoute   = $user->can('enquiry-show')   ? route('admin.enquiries.show',   encrypt($row->id)) : '';
                $deleteRoute = $user->can('enquiry-delete') ? route('admin.enquiries.destroy', encrypt($row->id)) : '';
                $editRoute   = '';
                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })
            ->editColumn('status', function ($row) {
                return $row->status?->label() ?? 'N/A';
            })
            ->editColumn('tour_id', function ($row) {
                return $row->tour->title ?? 'General';
            })
            ->setRowId('id');
    }

    public function query(Enquiry $model): QueryBuilder
    {
        return $model->newQuery()->with('tour');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('enquiries')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            ->orderBy('3', 'desc')
            ->parameters([
                'processing' => false,
                'language'   => ['searchPlaceholder' => __('labels.search')],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title(__('labels.id'))->width(50)->addClass('text-center'),
            Column::make('name')->title('Name')->addClass('text-center'),
            Column::make('email')->title('Email')->addClass('text-center'),
            Column::make('tour_id')->title('Tour')->addClass('text-center'),
            Column::make('status')->title(__('labels.status'))->addClass('text-center'),
            Column::make('created_at')->title(__('labels.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('labels.action'))
                ->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Enquiries_' . date('YmdHis');
    }
}
