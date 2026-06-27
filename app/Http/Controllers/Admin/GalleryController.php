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
        $this->middleware(['permission:gallery-list'],   ['only' => ['index', 'show']]);
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
            $requestData = $this->baseGalleryData($request);
            $this->dbObject::beginTransaction();

            $gallery = $this->galleryRepository->createData($requestData + [
                'type'           => $request->hasFile('video_file') ? 'video' : 'image',
                'file_path'      => null,
                'thumbnail_path' => null,
                'sort_order'     => 0,
            ]);

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $gallery->images()->create([
                        'file_path'  => basename(UserHelper::uploadImage($image, 'gallery')),
                    ]);
                }
            }

            if ($request->hasFile('video_file')) {
                $gallery->update([
                    'type'      => 'video',
                    'file_path' => basename(UserHelper::uploadImage($request->file('video_file'), 'gallery')),
                ]);
            }

            if ($request->hasFile('thumbnail_path')) {
                $gallery->update([
                    'thumbnail_path' => basename(UserHelper::uploadImage($request->file('thumbnail_path'), 'gallery/thumbnails')),
                ]);
            }

            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Gallery item created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function show($id)
    {
        $gallery = $this->galleryRepository->getDataById(decrypt($id));
        $gallery->load(['images', 'destination', 'tour', 'statusName']);

        return view('admin.gallery.show', compact('gallery'));
    }

    public function edit($id)
    {
        $gallery      = $this->galleryRepository->getDataById(decrypt($id));
        $gallery->load('images');
        $statuses     = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        $destinations = $this->destinationRepository->getForDropdown();
        $tours        = $this->tourRepository->getForDropdown();
        return view('admin.gallery.edit', compact('gallery', 'statuses', 'destinations', 'tours'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->baseGalleryData($request, false);
            $gallery     = $this->galleryRepository->getDataById($id);
            $removeIds = $request->input('remove_gallery_image_ids', []);
            if (is_array($removeIds) && !empty($removeIds)) {
                $imagesToRemove = $gallery->images()->whereIn('id', $removeIds)->get();
                foreach ($imagesToRemove as $oldImage) {
                    if (!empty($oldImage->file_path)) {
                        UserHelper::deleteImage('gallery', $oldImage->file_path);
                    }
                }
                $gallery->images()->whereIn('id', $removeIds)->delete();
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $gallery->images()->create([
                        'file_path'  => basename(UserHelper::uploadImage($image, 'gallery')),
                    ]);
                }
            }

            if ($request->hasFile('video_file')) {
                if (!empty($gallery->file_path)) {
                    UserHelper::deleteImage('gallery', $gallery->file_path);
                }
                $requestData['file_path'] = basename(UserHelper::uploadImage($request->file('video_file'), 'gallery'));
                $requestData['type'] = 'video';
            } else {
                $requestData['file_path'] = $gallery->file_path;
                $requestData['type'] = !empty($gallery->file_path) ? 'video' : 'image';
            }

            if ($request->hasFile('thumbnail_path')) {
                if (!empty($gallery->thumbnail_path)) {
                    UserHelper::deleteImage('gallery/thumbnails', $gallery->thumbnail_path);
                }
                $requestData['thumbnail_path'] = basename(UserHelper::uploadImage($request->file('thumbnail_path'), 'gallery/thumbnails'));
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
            $gallery = $this->galleryRepository->getDataById(decrypt($id));
            if ($gallery) {
                $gallery->load('images');
                foreach ($gallery->images as $image) {
                    if (!empty($image->file_path)) {
                        UserHelper::deleteImage('gallery', $image->file_path);
                    }
                }
                $gallery->images()->delete();

                if (!empty($gallery->file_path)) {
                    UserHelper::deleteImage('gallery', $gallery->file_path);
                }
                if (!empty($gallery->thumbnail_path)) {
                    UserHelper::deleteImage('gallery/thumbnails', $gallery->thumbnail_path);
                }
                $gallery->delete();
            }
            return $this->successAjaxResponse($this->indexRouteName, 'Gallery item deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }

    private function baseGalleryData($request, bool $withDefaultStatus = true): array
    {
        $data = $this->galleryRepository->getDataFromRequest($request);
        $data['is_featured'] = $request->boolean('is_featured') ?? true;

        if ($withDefaultStatus && empty($data['status'])) {
            $status = $this->statusRepository->getDataOnBasisOfFilter([
                'name'   => config('constants.active_status_name'),
                'module' => config('constants.common_status_name'),
            ])->first();
            $data['status'] = $status?->id;
        }

        return $data;
    }
}
