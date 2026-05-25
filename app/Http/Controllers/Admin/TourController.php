<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TourDataTable;
use App\Helpers\SlugHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\Tour\CreateRequest;
use App\Http\Requests\Admin\Tour\UpdateRequest;
use App\Repositories\DestinationRepository;
use App\Repositories\StatusRepository;
use App\Repositories\TourRepository;
use App\Repositories\ItineraryDayRepository;
use DB;
use Exception;

class TourController extends WebController
{
    protected $tourRepository;
    protected $statusRepository;
    protected $destinationRepository;
    protected $itineraryDayRepository;
    protected $dbObject;

    public function __construct(
        TourRepository $tourRepository,
        StatusRepository $statusRepository,
        DestinationRepository $destinationRepository,
        ItineraryDayRepository $itineraryDayRepository,
    ) {
        $this->tourRepository         = $tourRepository;
        $this->statusRepository       = $statusRepository;
        $this->destinationRepository  = $destinationRepository;
        $this->itineraryDayRepository = $itineraryDayRepository;
        $this->indexRouteName         = 'admin.tours.index';
        $this->dbObject               = DB::class;
        $this->middleware(['permission:tour-list'],   ['only' => ['index']]);
        $this->middleware(['permission:tour-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:tour-edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['permission:tour-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:tour-show'],   ['only' => ['show']]);
    }

    public function index(TourDataTable $dataTable)
    {
        return $dataTable->render('admin.tours.index');
    }

    public function create()
    {
        $destinations = $this->destinationRepository->getForDropdown();
        return view('admin.tours.create', compact('destinations'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->tourRepository->getDataFromRequest($request);
            if ($request->hasFile('featured_image')) {
                $requestData['featured_image'] = basename(UserHelper::uploadImage($request->file('featured_image'), 'tours'));
            }
            if (empty($requestData['slug'])) {
                $requestData['slug'] = SlugHelper::make($requestData['name']);
            }
            if (empty($requestData['status'])) {
                $status = $this->statusRepository->getDataOnBasisOfFilter([
                    'name'   => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name'),
                ])->first();
                $requestData['status'] = $status->id;
            }
            $this->dbObject::beginTransaction();
            $tour = $this->tourRepository->createData($requestData);

            // Handle multiple gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $index => $image) {
                    $path = basename(UserHelper::uploadImage($image, 'tours/gallery'));
                    $tour->images()->create(['image_path' => $path, 'sort_order' => $index]);
                }
            }

            // Save itinerary days
            if ($request->has('itinerary') && is_array($request->input('itinerary'))) {
                foreach ($request->input('itinerary') as $day) {
                    if (!empty($day['title'])) {
                        $day['tour_id'] = $tour->id;
                        $this->itineraryDayRepository->createData($day);
                    }
                }
            }

            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Tour created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function show($id)
    {
        $tour = $this->tourRepository->getWithRelations((int) decrypt($id));
        return view('admin.tours.show', compact('tour'));
    }

    public function edit($id)
    {
        $tour         = $this->tourRepository->getWithRelations((int) decrypt($id));
        $statuses     = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        $destinations = $this->destinationRepository->getForDropdown();
        return view('admin.tours.edit', compact('tour', 'statuses', 'destinations'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->tourRepository->getDataFromRequest($request);
            $tour        = $this->tourRepository->getDataById($id);
            if ($request->hasFile('featured_image')) {
                if (!empty($tour->featured_image)) {
                    UserHelper::deleteImage('tours', $tour->featured_image);
                }
                $requestData['featured_image'] = basename(UserHelper::uploadImage($request->file('featured_image'), 'tours'));
            }
            $this->dbObject::beginTransaction();
            $this->tourRepository->updateData($id, $requestData);

            // Remove only selected existing gallery images
            $removeIds = $request->input('remove_gallery_image_ids', []);
            if (is_array($removeIds) && !empty($removeIds)) {
                $imagesToRemove = $tour->images()->whereIn('id', $removeIds)->get();
                foreach ($imagesToRemove as $oldImage) {
                    if (!empty($oldImage->image_path)) {
                        UserHelper::deleteImage('tours/gallery', $oldImage->image_path);
                    }
                }
                $tour->images()->whereIn('id', $removeIds)->delete();
            }

            // Append new gallery images (do not remove old automatically)
            if ($request->hasFile('gallery_images')) {
                $nextOrder = (int) ($tour->images()->max('sort_order') ?? -1) + 1;
                foreach ($request->file('gallery_images') as $index => $image) {
                    $path = basename(UserHelper::uploadImage($image, 'tours/gallery'));
                    $tour->images()->create(['image_path' => $path, 'sort_order' => ($nextOrder + $index)]);
                }
            }

            // Replace itinerary days (also supports deleting all days)
            $this->itineraryDayRepository->deleteByTourId((int) $id);
            if ($request->has('itinerary') && is_array($request->input('itinerary'))) {
                foreach ($request->input('itinerary') as $day) {
                    if (!empty($day['title'])) {
                        $day['tour_id'] = $id;
                        $this->itineraryDayRepository->createData($day);
                    }
                }
            }

            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Tour updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tourRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Tour deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
