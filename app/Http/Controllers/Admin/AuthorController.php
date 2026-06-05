<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AuthorDataTable;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\Author\CreateRequest;
use App\Http\Requests\Admin\Author\UpdateRequest;
use App\Repositories\AuthorRepository;
use App\Repositories\StatusRepository;
use DB;
use Exception;

class AuthorController extends WebController
{
    protected $authorRepository;
    protected $statusRepository;
    protected $dbObject;

    public function __construct(
        AuthorRepository $authorRepository,
        StatusRepository $statusRepository
    ) {
        $this->authorRepository = $authorRepository;
        $this->statusRepository = $statusRepository;
        $this->indexRouteName = 'admin.authors.index';
        $this->dbObject = DB::class;
        $this->middleware(['permission:author-list'], ['only' => ['index']]);
        $this->middleware(['permission:author-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:author-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:author-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:author-show'], ['only' => ['show']]);
    }

    public function index(AuthorDataTable $dataTable)
    {
        return $dataTable->render('admin.author.index');
    }

    public function create()
    {
        return view('admin.author.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->authorRepository->getDataFromRequest($request);
            if ($request->hasFile('profile_image')) {
                $requestData['profile_image'] = basename(UserHelper::uploadImage($request->file('profile_image'), 'authors'));
            }
            if (empty($requestData['status'])) {
                $status = $this->statusRepository->getDataOnBasisOfFilter([
                    'name'   => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name'),
                ])->first();
                $requestData['status'] = $status->id ?? null;
            }

            $this->dbObject::beginTransaction();
            $this->authorRepository->createData($requestData);
            $this->dbObject::commit();

            return $this->successResponse($this->indexRouteName, 'Author created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function show($id)
    {
        $authorData = $this->authorRepository->getDataById(decrypt($id));
        return view('admin.author.show', compact('authorData'));
    }

    public function edit($id)
    {
        $authorData = $this->authorRepository->getDataById(decrypt($id));
        $status = $this->statusRepository->getDataOnBasisOfFilter([
            'module' => config('constants.common_status_name'),
        ])->pluck('name', 'id');

        return view('admin.author.edit', compact('authorData', 'status'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->authorRepository->getDataFromRequest($request);
            $authorData = $this->authorRepository->getDataById($id);
            if ($request->hasFile('profile_image')) {
                if (!empty($authorData->profile_image)) {
                    UserHelper::deleteImage('authors', $authorData->profile_image);
                }
                $requestData['profile_image'] = basename(UserHelper::uploadImage($request->file('profile_image'), 'authors'));
            }
            $this->dbObject::beginTransaction();
            $this->authorRepository->updateData($id, $requestData);
            $this->dbObject::commit();

            return $this->successResponse($this->indexRouteName, 'Author updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $authorData = $this->authorRepository->getDataById(decrypt($id));
            if (!empty($authorData->profile_image)) {
                UserHelper::deleteImage('authors', $authorData->profile_image);
            }
            $this->authorRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Author deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
