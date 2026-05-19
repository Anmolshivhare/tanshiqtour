<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionsDataTable;
use App\Http\Requests\Admin\Permission\CreateRequest;
use App\Http\Requests\Admin\Permission\UpdateRequest;
use App\Repositories\PermissionRepository;
use DB;
use Exception;

class PermissionController extends WebController
{
    protected $permissionRepository;

    protected $dbObject;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->dbObject = DB::class;
        $this->indexRouteName = 'admin.permissions.index';
        $this->middleware(['permission:permission-list'], ['only' => ['index']]);
        $this->middleware(['permission:permission-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:permission-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:permission-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:permission-show'], ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PermissionsDataTable $dataTable)
    {
        return $dataTable->render('admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionRepository->getAllData();
        $permissions = $permissions->whereNull('parent_id');
        return view('admin.permission.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $permissionRequest = $this->permissionRepository->getDataFromRequest($request);
            $this->dbObject::beginTransaction();
            $permissionRequest['guard_name'] = config('constants.guard_name');
            $permission = $this->permissionRepository->createData($permissionRequest);
            if (isset($permissionRequest['parent']) && $permissionRequest['parent'] != 'none') {
                $parent = $this->permissionRepository->getDataById($permissionRequest['parent']);
                if ($parent) {
                    $parent->appendNode($permission);
                }
            }
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, trans('app.data_created', ['action' => __('labels.permission')]));
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->permissionRepository->getDataById(decrypt($id));
        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Show the details of a permissions by their encrypted ID.

     * @param string $id The encrypted permission ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = $this->permissionRepository->getDataById(decrypt($id));
        return view('admin.permission.show', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->permissionRepository->getDataFromRequest($request);
            $this->dbObject::beginTransaction();
            $permission = $this->permissionRepository->updateData($id, $requestData);
            if ($requestData['parent'] ?? 'none' !== 'none') {
                $parent = $this->permissionRepository->getDataById($requestData['parent']);
                if ($parent) {
                    $parent->appendNode($permission);
                }
            } else {
                $permission->makeRoot();
            }
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, trans('app.data_updated', ['action' => __('labels.permission')]));
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->permissionRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, trans('app.data_deleted', ['action' => __('labels.permission')]));
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
