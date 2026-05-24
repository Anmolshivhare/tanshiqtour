<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EnquiryDataTable;
use App\Enums\EnquiryStatus;
use App\Repositories\EnquiryRepository;
use App\Helpers\UserHelper;
use DB;
use Exception;

class EnquiryController extends WebController
{
    protected $enquiryRepository;
    protected $dbObject;

    public function __construct(EnquiryRepository $enquiryRepository)
    {
        $this->enquiryRepository = $enquiryRepository;
        $this->indexRouteName    = 'admin.enquiries.index';
        $this->dbObject          = DB::class;
        $this->middleware(['permission:enquiry-list'],   ['only' => ['index']]);
        $this->middleware(['permission:enquiry-show'],   ['only' => ['show']]);
        $this->middleware(['permission:enquiry-delete'], ['only' => ['destroy']]);
        $this->middleware(['permission:enquiry-reply'],  ['only' => ['reply']]);
    }

    public function index(EnquiryDataTable $dataTable)
    {
        return $dataTable->render('admin.enquiries.index');
    }

    public function show($id)
    {
        $enquiry = $this->enquiryRepository->getDataById(decrypt($id));
        // Auto-mark as read when opened
        if ($enquiry && $enquiry->status === EnquiryStatus::New) {
            $enquiry->update(['status' => EnquiryStatus::Read->value]);
        }
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function reply(\Illuminate\Http\Request $request, $id)
    {
        try {
            $this->dbObject::beginTransaction();
            $this->enquiryRepository->updateData(decrypt($id), [
                'status'     => EnquiryStatus::Replied->value,
                'replied_at' => now(),
                'replied_by' => UserHelper::getLoggedInUser()?->id,
            ]);
            $this->dbObject::commit();
            return $this->successResponse($this->indexRouteName, 'Enquiry marked as replied.');
        } catch (Exception $exception) {
            $this->dbObject::rollBack();
            return $this->errorResponse($exception);
        }
    }

    public function destroy($id)
    {
        try {
            $this->enquiryRepository->deleteDataById(decrypt($id));
            return $this->successAjaxResponse($this->indexRouteName, 'Enquiry deleted successfully.');
        } catch (Exception $exception) {
            return $this->errorAjaxResponse($exception);
        }
    }
}
