<?php

namespace App\DataTables;

use App\Models\Review;
use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReviewDataTable extends DataTable
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
                $viewRoute   = $user->can('review-show')   ? route('admin.reviews.show',   encrypt($row->id)) : '';
                $deleteRoute = $user->can('review-delete') ? route('admin.reviews.destroy', encrypt($row->id)) : '';
                $editRoute   = '';
                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })
            ->editColumn('status', function ($row) {
                return $row->status == 1 ? 'Active' : 'Inactive';
            })
            ->editColumn('tour_id', function ($row) {
                return $row->tour->title ?? 'N/A';
            })
            ->editColumn('rating', function ($row) {
                return $row->rating . ' ⭐';
            })
            ->setRowId('id');
    }

    public function query(Review $model): QueryBuilder
    {
        return $model->newQuery()->with('tour');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reviews')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            ->orderBy('5', 'desc')
            ->parameters([
                'processing' => false,
                'language'   => ['searchPlaceholder' => __('labels.search')],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title(__('labels.id'))->width(50)->addClass('text-center'),
            Column::make('reviewer_name')->title('Reviewer')->addClass('text-center'),
            Column::make('tour_id')->title('Tour')->addClass('text-center'),
            Column::make('rating')->title('Rating')->addClass('text-center'),
            Column::make('status')->title(__('labels.status'))->addClass('text-center'),
            Column::make('created_at')->title(__('labels.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('labels.action'))
                ->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Reviews_' . date('YmdHis');
    }
}
