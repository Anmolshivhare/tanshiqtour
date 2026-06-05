<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\WishlistRepository;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->middleware('auth');
    }

    /**
     * Show user's wishlist.
     */
    public function index()
    {
        $userId   = UserHelper::getLoggedInUser()->id;
        $wishlist = $this->wishlistRepository->getUserWishlist($userId);
        return view('front.wishlist', compact('wishlist'));
    }

    /**
     * Toggle wishlist (AJAX).
     */
    public function toggle(Request $request)
    {
        $request->validate(['tour_id' => 'required|exists:tours,id']);
        $userId  = UserHelper::getLoggedInUser()->id;
        $added   = $this->wishlistRepository->toggleWishlist($userId, (int) $request->tour_id);
        return response()->json([
            'success' => true,
            'added'   => $added,
            'message' => $added ? 'Added to wishlist.' : 'Removed from wishlist.',
        ]);
    }
}
