<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\User\CreateRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Repositories\RoleRepository;
use App\Repositories\StatusRepository;
use App\Repositories\UserRepository;
use DB;
use Exception;

class UserController extends WebController
{
    protected $roleRepository;

    protected $userRepository;

    protected $statusRepository;

    protected $dbObject;

    public function __construct(
        RoleRepository $roleRepository,
        UserRepository $userRepository,
        StatusRepository $statusRepository,
    ) {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->statusRepository = $statusRepository;
        $this->indexRouteName = 'admin.users.index';
        $this->dbObject = DB::class;
        $this->middleware(['permission:user-list'], ['only' => ['index']]);
        $this->middleware(['permission:user-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:user-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:user-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:user-show'], ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->getAllData();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->userRepository->getDataFromRequest($request);
            if ($request->hasFile('profile_pic')) {
                $destinationPath = 'profile_images';
                $requestData['profile_pic'] = basename(UserHelper::uploadImage($request->file('profile_pic'), $destinationPath));
            }
            $status = $this->statusRepository->getDataOnBasisOfFilter(
                [
                    'name' => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name')
                ]
            )->first();
            $requestData['status'] = $status->id;
            $this->dbObject::beginTransaction();
            $user = $this->userRepository->createData($requestData);
            $roleId = (int) $requestData['role'];
            if (isset($roleId)) {
                $user->assignRole($roleId);
            }
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, trans('app.data_created', ['action' => __('labels.user')]));
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
        $roles = $this->roleRepository->getAllData();
        $user = $this->userRepository->getDataById(decrypt($id));
        $userRole = $user->roles->first();
        $status = $this->statusRepository->getDataOnBasisOfFilter(
            [
                'module' => config('constants.common_status_name')
            ]
        );
        return view('admin.users.edit', compact('user', 'roles', 'userRole', 'status'));
    }

    /**
     * Show the details of an users by their encrypted ID.
     *
     * @param string $id The encrypted user ID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->getDataById(decrypt($id));
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $requestData = $this->userRepository->getDataFromRequest($request);
        try {
            if ($request->hasFile('profile_pic')) {
                $user = $this->userRepository->getDataById($id);
                $destinationPath = 'profile_images';
                $filename = $user->profile_pic;
                if (!empty($user->profile_pic)) {
                    UserHelper::deleteImage($destinationPath, $filename);
                }
                $requestData['profile_pic'] = basename(UserHelper::uploadImage($request->file('profile_pic'), $destinationPath));
            }
            $this->dbObject::beginTransaction();
            $user = $this->userRepository->updateData($id, $requestData);
            $userRole = $user->roles->first();
            if (!empty($userRole)) {
                $user->removeRole($userRole);
            }
            $roleId = (int) $requestData['role'];
            $user->assignRole($roleId);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, trans('app.data_updated', ['action' => __('labels.user')]));
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
            $this->userRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, trans('app.data_deleted', ['action' => __('labels.user')]));
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
