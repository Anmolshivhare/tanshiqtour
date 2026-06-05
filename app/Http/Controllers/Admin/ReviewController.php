<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReviewDataTable;
use App\Enums\ReviewStatus;
use App\Repositories\ReviewRepository;
use Exception;

class ReviewController extends WebController
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->indexRouteName   = 'admin.reviews.index';
        $this->middleware(['permission:review-list'],   ['only' => ['index']]);
        $this->middleware(['permission:review-show'],   ['only' => ['show']]);
        $this->middleware(['permission:review-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:review-approve'], ['only' => ['approve']]);
    }

    public function index(ReviewDataTable $dataTable)
    {
        return $dataTable->render('admin.reviews.index');
    }

    public function show($id)
    {
        $review = $this->reviewRepository->getDataById(decrypt($id));
        return view('admin.reviews.show', compact('review'));
    }

    // public function approve($id)
    // {
    //     try {
    //         $this->reviewRepository->updateData(decrypt($id), ['status' => ReviewStatus::Approved->value]);
    //         return $this->successAjaxResponse($this->indexRouteName, 'Review approved successfully.');
    //     } catch (Exception $exception) {
    //         return $this->errorAjaxResponse($exception);
    //     }
    // }

    public function destroy($id)
    {
        try {
            $this->reviewRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Review deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
