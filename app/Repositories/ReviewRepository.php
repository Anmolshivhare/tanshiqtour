<?php

namespace App\Repositories;

use App\Enums\ReviewStatus;
use App\Models\Review;

class ReviewRepository extends BaseRepository
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function getDataFromRequest($request): array
    {
        return $request->only([
            'tour_id',
            'user_id',
            'reviewer_name',
            'reviewer_email',
            'rating',
            'review_title',
            'review_body',
            'status',
        ]);
    }

    public function getPendingReviews()
    {
        return $this->model->where('status', 0)->with('tour')->get();
    }

    public function getApprovedReviews()
    {
        return $this->model->where('status', 1)->with(['tour.destination']) ->latest()->take(12)->get();
    }

    public function getByTourId(int $tourId)
    {
        return $this->model->where('tour_id', $tourId)->where('status', 1)->get();
    }
}
