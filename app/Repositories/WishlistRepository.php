<?php

namespace App\Repositories;

use App\Models\Wishlist;

class WishlistRepository extends BaseRepository
{
    public function __construct(Wishlist $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all wishlisted tours for a user.
     */
    public function getUserWishlist(int $userId)
    {
        return $this->model->where('user_id', $userId)->with('tour')->get();
    }

    /**
     * Toggle a tour in user's wishlist.
     * Returns true if added, false if removed.
     */
    public function toggleWishlist(int $userId, int $tourId): bool
    {
        $existing = $this->model->where('user_id', $userId)->where('tour_id', $tourId)->first();
        if ($existing) {
            $existing->delete();
            return false;
        }
        $this->model->create(['user_id' => $userId, 'tour_id' => $tourId]);
        return true;
    }

    /**
     * Check if a tour is in user's wishlist.
     */
    public function isWishlisted(int $userId, int $tourId): bool
    {
        return $this->model->where('user_id', $userId)->where('tour_id', $tourId)->exists();
    }
}
