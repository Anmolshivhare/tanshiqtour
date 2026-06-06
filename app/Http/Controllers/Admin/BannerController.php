<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerDataTable;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\Banner\CreateRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest;
use App\Repositories\BannerRepository;
use App\Repositories\StatusRepository;
use DB;
use Exception;

class BannerController extends WebController
{
    protected $bannerRepository;
    protected $statusRepository;
    protected $dbObject;

    public function __construct(
        BannerRepository $bannerRepository,
        StatusRepository $statusRepository,
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->statusRepository = $statusRepository;
        $this->indexRouteName   = 'admin.banners.index';
        $this->dbObject         = DB::class;
        $this->middleware(['permission:banner-list'],   ['only' => ['index']]);
        $this->middleware(['permission:banner-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:banner-edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['permission:banner-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:banner-show'],   ['only' => ['show']]);
    }

    public function index(BannerDataTable $dataTable)
    {
        return $dataTable->render('admin.banner.index');
    }

    public function create()
    {
        $statuses = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);

        return view('admin.banner.create', compact('statuses'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->bannerRepository->getDataFromRequest($request);

            if ($request->hasFile('image')) {
                $requestData['image'] = basename(UserHelper::uploadImage($request->file('image'), config('constants.banner_image_path')));
            }

            if (empty($requestData['status'])) {
                $status = $this->statusRepository->getDataOnBasisOfFilter([
                    'name'   => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name'),
                ])->first();
                $requestData['status'] = $status->id;
            }

            $this->dbObject::beginTransaction();
            $this->bannerRepository->createData($requestData);
            $this->dbObject::commit();

            return $this->successResponse($this->indexRouteName, 'Banner created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();

            return $this->errorResponse($exception);
        }
    }

    public function show($id)
    {
        $banner = $this->bannerRepository->getDataById(decrypt($id));

        return view('admin.banner.show', compact('banner'));
    }

    public function edit($id)
    {
        $banner = $this->bannerRepository->getDataById(decrypt($id));
        $statuses = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);

        return view('admin.banner.edit', compact('banner', 'statuses'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->bannerRepository->getDataFromRequest($request);
            $banner = $this->bannerRepository->getDataById($id);

            if ($request->hasFile('image')) {
                if (!empty($banner->image)) {
                    UserHelper::deleteImage(config('constants.banner_image_path'), $banner->image);
                }

                $requestData['image'] = basename(UserHelper::uploadImage($request->file('image'), config('constants.banner_image_path')));
            }

            $this->dbObject::beginTransaction();
            $this->bannerRepository->updateData($id, $requestData);
            $this->dbObject::commit();

            return $this->successResponse($this->indexRouteName, 'Banner updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();

            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $banner = $this->bannerRepository->getDataById(decrypt($id));

            if (!empty($banner->image)) {
                UserHelper::deleteImage(config('constants.banner_image_path'), $banner->image);
            }

            $this->bannerRepository->deleteDataById(decrypt($id));

            return $this->successAjaxResponse($this->indexRouteName, 'Banner deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
