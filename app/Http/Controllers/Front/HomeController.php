<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\DestinationRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $destinationRepository;

    /**
     * 
     */
    public function __construct(DestinationRepository $destinationRepository)
    {
        $this->destinationRepository = $destinationRepository;
    }

    public function index()
    {
        $destinationsData = $this->destinationRepository->getActiveDestinations();

        return view('home', compact('destinationsData'));
    }

    public function tours()
    {
        return view('tours');
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

        return view('destination-details', compact('destination'));
    }

    public function careers()
    {
        return view('careers');
    }
}
