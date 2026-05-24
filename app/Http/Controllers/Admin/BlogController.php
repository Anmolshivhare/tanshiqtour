<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogDataTable;
use App\Helpers\DateHelper;
use App\Helpers\SlugHelper;
use App\Helpers\UserHelper;
use App\Http\Requests\Admin\Blog\CreateRequest;
use App\Http\Requests\Admin\Blog\UpdateRequest;
use App\Repositories\AuthorRepository;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogRepository;
use App\Repositories\StatusRepository;
use DB;
use Exception;

class BlogController extends WebController
{
    protected $blogRepository;
    protected $authorRepository;
    protected $blogCategoryRepository;
    protected $statusRepository;
    protected $dbObject;

    public function __construct(
        BlogRepository $blogRepository,
        AuthorRepository $authorRepository,
        BlogCategoryRepository $blogCategoryRepository,
        StatusRepository $statusRepository,
    ) {
        $this->blogRepository         = $blogRepository;
        $this->authorRepository       = $authorRepository;
        $this->blogCategoryRepository = $blogCategoryRepository;
        $this->statusRepository       = $statusRepository;
        $this->indexRouteName         = 'admin.blogs.index';
        $this->dbObject               = DB::class;
        $this->middleware(['permission:blog-list'],   ['only' => ['index']]);
        $this->middleware(['permission:blog-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:blog-edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['permission:blog-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:blog-show'],   ['only' => ['show']]);
    }

    /**
     * Display a listing of the blog posts.
     *
     * @param BlogDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors    = $this->authorRepository->getActiveAuthors();
        $categories = $this->blogCategoryRepository->getForDropdown();
        return view('admin.blog.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created blog post in storage.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $requestData = $this->blogRepository->getDataFromRequest($request);
            if ($request->hasFile('featured_image')) {
                $requestData['featured_image'] = basename(UserHelper::uploadImage($request->file('featured_image'), 'blogs'));
            }
            if (empty($requestData['slug'])) {
                $requestData['slug'] = SlugHelper::make($requestData['title']);
            }
            if (!empty($requestData['published_at'])) {
                $requestData['published_at'] = DateHelper::formatDateTime($requestData['published_at']);
            }
            if (empty($requestData['status'])) {
                $status = $this->statusRepository->getDataOnBasisOfFilter([
                    'name'   => config('constants.active_status_name'),
                    'module' => config('constants.common_status_name'),
                ])->first();
                $requestData['status'] = $status->id;
            }
            $this->dbObject::beginTransaction();
            $this->blogRepository->createData($requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Blog post created successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    /**
     * Display the specified blog post.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = $this->blogRepository->getDataById(decrypt($id));
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog post.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog       = $this->blogRepository->getDataById(decrypt($id));
        $statuses   = $this->statusRepository->getDataOnBasisOfFilter(['module' => config('constants.common_status_name')]);
        $authors    = $this->authorRepository->getAllData()->pluck('name', 'id');
        $categories = $this->blogCategoryRepository->getForDropdown();
        return view('admin.blog.edit', compact('blog', 'statuses', 'authors', 'categories'));
    }

    /**
     * Update the specified blog post in storage.
     *
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $requestData = $this->blogRepository->getDataFromRequest($request);
            $blog        = $this->blogRepository->getDataById($id);
            if ($request->hasFile('featured_image')) {
                if (!empty($blog->featured_image)) UserHelper::deleteImage('blogs', $blog->featured_image);
                $requestData['featured_image'] = basename(UserHelper::uploadImage($request->file('featured_image'), 'blogs'));
            }
            if (!empty($requestData['published_at'])) {
                $requestData['published_at'] = DateHelper::formatDateTime($requestData['published_at']);
            }
            $this->dbObject::beginTransaction();
            $this->blogRepository->updateData($id, $requestData);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Blog post updated successfully.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    /**
     * Remove the specified blog post from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->blogRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Blog post deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
