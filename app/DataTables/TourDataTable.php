<?php

namespace App\DataTables;

use App\Models\Tour;
use App\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TourDataTable extends DataTable
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
                $editRoute   = $user->can('tour-edit')   ? route('admin.tours.edit',    encrypt($row->id)) : '';
                $deleteRoute = $user->can('tour-delete') ? route('admin.tours.destroy', encrypt($row->id)) : '';
                $viewRoute   = $user->can('tour-show')   ? route('admin.tours.show',   encrypt($row->id)) : '';
                return view('admin.layouts.partials.dataTable-action-button', compact('editRoute', 'deleteRoute', 'viewRoute'));
            })
            ->editColumn('status', function ($row) {
                return $row->statusName->name ?? 'N/A';
            })
            ->editColumn('is_featured', function ($row) {
                return $row->is_featured ? 'Yes' : 'No';
            })
            ->editColumn('price_per_person', function ($row) {
                return $row->price_per_person ? '₹' . number_format($row->price_per_person, 2) : 'N/A';
            })
            ->setRowId('id');
    }

    public function query(Tour $model): QueryBuilder
    {
        return $model->newQuery()->with('destination');
    }

    public function html(): HtmlBuilder
    {
        $userCreate = $this->user->can('tour-create');
        $dataTable  = $this->builder()
            ->setTableId('tours')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'search-bar-wrapper'Bf>r<'table-wrapper yajra-table-custom-class table-responsive'tr><'pagination-wrapper'p>")
            ->orderBy('6', 'desc');

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
            Column::make('title')->title('Title')->addClass('text-center'),
            Column::make('location')->title('Location')->addClass('text-center'),
            Column::make('duration')->title('Duration')->addClass('text-center'),
            Column::make('price_per_person')->title('Price/Person')->addClass('text-center'),
            Column::make('is_featured')->title(__('labels.is_featured'))->addClass('text-center'),
            Column::make('status')->title(__('labels.status'))->addClass('text-center'),
            Column::make('created_at')->title(__('labels.created_at'))->addClass('text-center'),
            Column::computed('action')->title(__('labels.action'))
                ->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Tours_' . date('YmdHis');
    }
}
