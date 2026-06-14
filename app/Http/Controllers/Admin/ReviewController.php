<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReviewDataTable;
use App\Repositories\ReviewRepository;
use Exception;
use Illuminate\Http\Request;

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
        $this->middleware(['permission:review-approve'], ['only' => ['approve', 'updateStatus']]);
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

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        try {
            $review = $this->reviewRepository->updateData(decrypt($id), [
                'status' => (int) $validated['status'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Review status updated successfully.',
                'data' => [
                    'id' => $review->id,
                    'status' => (int) $review->status,
                    'label' => $review->status == 1 ? 'Active' : 'Inactive',
                ],
            ]);
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }

    public function approve($id)
    {
        try {
            $this->reviewRepository->updateData(decrypt($id), ['status' => 1]);
            return redirect()->route($this->indexRouteName)->with('message', 'Review approved successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }

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
