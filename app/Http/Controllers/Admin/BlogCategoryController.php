<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCategoryDataTable;
use App\Helpers\SlugHelper;
use App\Http\Requests\Admin\BlogCategory\CreateRequest;
use App\Http\Requests\Admin\BlogCategory\UpdateRequest;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\StatusRepository;
use DB;
use Exception;

class BlogCategoryController extends WebController
{
    protected $blogCategoryRepository;
    protected $statusRepository;
    protected $dbObject;

    public function __construct(BlogCategoryRepository $blogCategoryRepository, StatusRepository $statusRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
        $this->statusRepository       = $statusRepository;
        $this->indexRouteName         = 'admin.blog-categories.index';
        $this->dbObject               = DB::class;
        $this->middleware(['permission:blog-category-list'],   ['only' => ['index']]);
        $this->middleware(['permission:blog-category-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:blog-category-edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['permission:blog-category-delete'], ['only' => ['destroy']]);
    }

    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.blog-categories.index');
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->blogCategoryRepository->getDataFromRequest($request);
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
            $this->blogCategoryRepository->createData($requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Blog category created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function edit($id)
    {
        $blogCategory = $this->blogCategoryRepository->getDataById(decrypt($id));
        $statuses     = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        return view('admin.blog-categories.edit', compact('blogCategory', 'statuses'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->blogCategoryRepository->getDataFromRequest($request);
            $this->dbObject::beginTransaction();
            $this->blogCategoryRepository->updateData($id, $requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Blog category updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->blogCategoryRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Blog category deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
