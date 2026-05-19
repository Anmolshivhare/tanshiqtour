<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DestinationDataTable;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\Destination\CreateRequest;
use App\Http\Requests\Admin\Destination\UpdateRequest;
use App\Repositories\DestinationRepository;
use App\Repositories\StatusRepository;
use DB;
use Exception;

class DestinationController extends WebController
{
    protected $destinationRepository;
    protected $statusRepository;
    protected $dbObject;

    public function __construct(
        DestinationRepository $destinationRepository,
        StatusRepository $statusRepository,
    ) {
        $this->destinationRepository = $destinationRepository;
        $this->statusRepository      = $statusRepository;
        $this->indexRouteName        = 'admin.destinations.index';
        $this->dbObject              = DB::class;
        $this->middleware(['permission:destination-list'],   ['only' => ['index']]);
        $this->middleware(['permission:destination-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:destination-edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['permission:destination-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:destination-show'],   ['only' => ['show']]);
    }

    public function index(DestinationDataTable $dataTable)
    {
        return $dataTable->render('admin.destinations.index');
    }

    public function create()
    {
        $statuses = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        return view('admin.destinations.create', compact('statuses'));
    }

    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->destinationRepository->getDataFromRequest($request);
            if ($request->hasFile('featured_image')) {
                $requestData['featured_image'] = basename(UserHelper::uploadImage($request->file('featured_image'), 'destinations'));
            }
            if ($request->hasFile('banner_image')) {
                $requestData['banner_image'] = basename(UserHelper::uploadImage($request->file('banner_image'), 'destinations'));
            }
            // Auto-generate slug if not set
            if (empty($requestData['slug'])) {
                $requestData['slug'] = \Str::slug($requestData['name']);
            }
            // Default status to active if not provided
            if (empty($requestData['status'])) {
                $status = $this->statusRepository->getDataOnBasisOfFilter([
                    'name'   => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name'),
                ])->first();
                $requestData['status'] = $status->id;
            }
            $this->dbObject::beginTransaction();
            $this->destinationRepository->createData($requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Destination created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function show($id)
    {
        $destination = $this->destinationRepository->getDataById(decrypt($id));
        return view('admin.destinations.show', compact('destination'));
    }

    public function edit($id)
    {
        $destination = $this->destinationRepository->getDataById(decrypt($id));
        $statuses    = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        return view('admin.destinations.edit', compact('destination', 'statuses'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->destinationRepository->getDataFromRequest($request);
            $destination = $this->destinationRepository->getDataById($id);
            if ($request->hasFile('featured_image')) {
                if (!empty($destination->featured_image)) {
                    UserHelper::deleteImage('destinations', $destination->featured_image);
                }
                $requestData['featured_image'] = basename(UserHelper::uploadImage($request->file('featured_image'), 'destinations'));
            }
            if ($request->hasFile('banner_image')) {
                if (!empty($destination->banner_image)) {
                    UserHelper::deleteImage('destinations', $destination->banner_image);
                }
                $requestData['banner_image'] = basename(UserHelper::uploadImage($request->file('banner_image'), 'destinations'));
            }
            $this->dbObject::beginTransaction();
            $this->destinationRepository->updateData($id, $requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Destination updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->destinationRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Destination deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
