<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\GalleryDataTable;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\Gallery\CreateRequest;
use App\Http\Requests\Admin\Gallery\UpdateRequest;
use App\Repositories\DestinationRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\StatusRepository;
use App\Repositories\TourRepository;
use DB;
use Exception;

class GalleryController extends WebController
{
    protected $galleryRepository;
    protected $statusRepository;
    protected $destinationRepository;
    protected $tourRepository;
    protected $dbObject;

    public function __construct(
        GalleryRepository $galleryRepository,
        StatusRepository $statusRepository,
        DestinationRepository $destinationRepository,
        TourRepository $tourRepository,
    ) {
        $this->galleryRepository     = $galleryRepository;
        $this->statusRepository      = $statusRepository;
        $this->destinationRepository = $destinationRepository;
        $this->tourRepository        = $tourRepository;
        $this->indexRouteName        = 'admin.galleries.index';
        $this->dbObject              = DB::class;
        $this->middleware(['permission:gallery-list'],   ['only' => ['index']]);
        $this->middleware(['permission:gallery-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:gallery-edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['permission:gallery-delete'], ['only' => ['destroy']]);
    }

    public function index(GalleryDataTable $dataTable)
    {
        return $dataTable->render('admin.gallery.index');
    }

    public function create()
    {
        $destinations = $this->destinationRepository->getForDropdown();
        $tours        = $this->tourRepository->getForDropdown();
        return view('admin.gallery.create', compact('destinations', 'tours'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->galleryRepository->getDataFromRequest($request);
            if ($request->hasFile('file_path')) {
                $requestData['file_path'] = basename(UserHelper::uploadImage($request->file('file_path'), 'gallery'));
            }
            if ($request->hasFile('thumbnail_path')) {
                $requestData['thumbnail_path'] = basename(UserHelper::uploadImage($request->file('thumbnail_path'), 'gallery/thumbnails'));
            }
            if (empty($requestData['status'])) {
                $status = $this->statusRepository->getDataOnBasisOfFilter([
                    'name'   => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name'),
                ])->first();
                $requestData['status'] = $status->id;
            }
            $this->dbObject::beginTransaction();
            $this->galleryRepository->createData($requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Gallery item created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function edit($id)
    {
        $gallery      = $this->galleryRepository->getDataById(decrypt($id));
        $statuses     = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        $destinations = $this->destinationRepository->getForDropdown();
        $tours        = $this->tourRepository->getForDropdown();
        return view('admin.gallery.edit', compact('gallery', 'statuses', 'destinations', 'tours'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->galleryRepository->getDataFromRequest($request);
            $gallery     = $this->galleryRepository->getDataById($id);
            if ($request->hasFile('file_path')) {
                if (!empty($gallery->file_path)) UserHelper::deleteImage('gallery', $gallery->file_path);
                $requestData['file_path'] = basename(UserHelper::uploadImage($request->file('file_path'), 'gallery'));
            }
            $this->dbObject::beginTransaction();
            $this->galleryRepository->updateData($id, $requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Gallery item updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->galleryRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Gallery item deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
