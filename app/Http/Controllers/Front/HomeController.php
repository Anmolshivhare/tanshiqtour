<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Repositories\BannerRepository;
use App\Repositories\DestinationRepository;
use App\Repositories\TourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;

class HomeController extends Controller
{

    protected $destinationRepository;

    protected $bannerRepository;

    protected $tourRepository;

    /**
     * 
     */
    public function __construct(
        DestinationRepository $destinationRepository,
        BannerRepository $bannerRepository,
        TourRepository $tourRepository
    ) {
        $this->destinationRepository = $destinationRepository;
        $this->bannerRepository = $bannerRepository;
        $this->tourRepository = $tourRepository;
    }

    public function index()
    {
        $destinationsData = $this->destinationRepository->getFeaturedDestinations();
        $featuredTours = $this->tourRepository->getFeaturedTours();
        $clientReviews = Review::approved()
            ->with(['tour.destination'])
            ->latest()
            ->take(12)
            ->get();
        $banners = $this->bannerRepository->getActiveBanners();
        $fallbackSlides = collect([
            [
                'title' => 'Heaven on Earth',
                'subtitle' => 'India',
                'description' => 'Discover the breathtaking valleys, lakes and mountain meadows of Kashmir.',
                'image' => Vite::asset('resources/images/banner1.webp'),
                'button_text' => 'Explore Kashmir',
                'button_url' => route('front.tours'),
                'overlay_class' => '',
            ],
            [
                'title' => 'Bali Beach Escape',
                'subtitle' => 'Indonesia',
                'description' => 'Pristine beaches, lush rice terraces and vibrant culture await you in paradise.',
                'image' => Vite::asset('resources/images/banner2.webp'),
                'button_text' => 'Explore Bali',
                'button_url' => route('front.tours'),
                'overlay_class' => 'tt-banner-slide__overlay--teal',
            ],
            [
                'title' => 'Dubai Luxury',
                'subtitle' => 'UAE',
                'description' => 'Iconic skylines, desert safaris and world-class hospitality in the City of Gold.',
                'image' => Vite::asset('resources/images/banner3.webp'),
                'button_text' => 'Explore Dubai',
                'button_url' => route('front.tours'),
                'overlay_class' => 'tt-banner-slide__overlay--gold',
            ],
            [
                'title' => 'Swiss Alps Dream',
                'subtitle' => 'Europe',
                'description' => 'Snow-capped peaks, charming villages and crystal-clear lakes of Switzerland.',
                'image' => Vite::asset('resources/images/banner4.webp'),
                'button_text' => 'Explore Switzerland',
                'button_url' => route('front.tours'),
                'overlay_class' => 'tt-banner-slide__overlay--blue',
            ],
            [
                'title' => 'Maldives Paradise',
                'subtitle' => 'Maldives',
                'description' => 'Overwater bungalows, turquoise lagoons and the world\'s most stunning sunsets.',
                'image' => Vite::asset('resources/images/banner5.webp'),
                'button_text' => 'Explore Maldives',
                'button_url' => route('front.tours'),
                'overlay_class' => 'tt-banner-slide__overlay--cyan',
            ],
        ]);

        $bannerSlides = $banners->map(function ($banner, $index) use ($fallbackSlides) {
            $fallback = $fallbackSlides->get($index % $fallbackSlides->count());

            return [
                'title' => $banner->title ?: $fallback['title'],
                'subtitle' => $banner->subtitle ?: $fallback['subtitle'],
                'description' => $banner->description ?: $fallback['description'],
                'image' => !empty($banner->image)
                    ? asset('storage/' . config('constants.banner_image_path') . '/' . $banner->image)
                    : $fallback['image'],
                'button_text' => $banner->button_text ?: $fallback['button_text'],
                'button_url' => $banner->button_url ?: $fallback['button_url'],
                'overlay_class' => $fallback['overlay_class'],
            ];
        });

        if ($bannerSlides->isEmpty()) {
            $bannerSlides = $fallbackSlides;
        }

        return view('home', compact('destinationsData', 'featuredTours', 'clientReviews', 'banners', 'bannerSlides'));
    }

    public function tours(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        if ($request->ajax() || $request->wantsJson()) {
            $tours = $search === ''
                ? $this->tourRepository->getActiveToursPaginated('', 9)
                : $this->tourRepository->getActiveToursFiltered($search);

            return response()->json([
                'html' => view('front.tours.results', compact('tours', 'search'))->render(),
                'count' => $tours instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                    ? $tours->total()
                    : $tours->count(),
            ]);
        }

        $tours = $this->tourRepository->getActiveToursPaginated($search);

        return view('tours', compact('tours', 'search'));
    }

    public function tourDetails(string $slug)
    {
        $tour = $this->tourRepository->getActiveBySlugWithRelations($slug);

        if (!$tour) {
            abort(404);
        }

        $relatedTours = $this->tourRepository->getFeaturedTours(8)
            ->filter(fn($t) => $t->id !== $tour->id)
            ->take(6)
            ->values();

        return view('tour-details', compact('tour', 'relatedTours'));
    }

    public function about()
    {
        $destinationsData = $this->destinationRepository->getActiveDestinations();
        
        return view('about', compact('destinationsData'));
    }

    public function contact()
    {
        return view('contact');
    }

    /**
     * Display a paginated list of active destinations, with optional search functionality.
     */
    public function destinations(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        if ($request->ajax() || $request->wantsJson()) {
            $destinations = $search === ''
                ? $this->destinationRepository->getActiveDestinationsPaginated('', 9)
                : $this->destinationRepository->getActiveDestinationsFiltered($search);

            return response()->json([
                'html' => view('front.destinations.results', compact('destinations', 'search'))->render(),
                'count' => $destinations instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                    ? $destinations->total()
                    : $destinations->count(),
            ]);
        }

        $destinations = $this->destinationRepository->getActiveDestinationsPaginated($search);

        return view('destinations', compact('destinations', 'search'));
    }

    /**
     * Show the details of a specific destination based on the provided slug.
     */
    public function destinationDetails($slug)
    {
        $destination = $this->destinationRepository->getActiveBySlug($slug);
        $destinationsData = $this->destinationRepository->getActiveDestinations();
        return view('destination-details', compact('destination', 'destinationsData'));
    }

    public function careers()
    {
        return view('careers');
    }

    /**
     * Store a new review submitted from the tour details page.
     */
    public function storeReview(Request $request, string $slug)
    {
        $tour = $this->tourRepository->getActiveBySlugWithRelations($slug);

        if (!$tour) {
            abort(404);
        }

        $validated = $request->validate([
            'reviewer_name'  => 'required|string|max:100',
            'reviewer_email' => 'required|email|max:150',
            'rating'         => 'required|integer|min:1|max:5',
            'review_title'   => 'nullable|string|max:150',
            'review_body'    => 'required|string|max:2000',
            'client_pic'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $clientPic = null;
        if ($request->hasFile('client_pic')) {
            $file      = $request->file('client_pic');
            $filename  = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('reviews', $filename, 'public');
            $clientPic = $filename;
        }
        Review::create([
            'tour_id'        => $tour->id,
            'reviewer_name'  => $validated['reviewer_name'],
            'reviewer_email' => $validated['reviewer_email'],
            'rating'         => $validated['rating'],
            'review_title'   => $validated['review_title'] ?? null,
            'review_body'    => $validated['review_body'],
            'client_pic'     => $clientPic,
            'created_by'     => auth()->id(),
            'status'         => 0, // pending — admin must approve
        ]);

        $message = 'Thank you! Your review has been submitted and is pending approval.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        }

        return redirect()
            ->route('front.tour-details', $slug)
            ->with('review_success', $message);
    }
}
