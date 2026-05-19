<?php

namespace App\Repositories;

use App\Enums\EnquiryStatus;
use App\Models\Enquiry;

class EnquiryRepository extends BaseRepository
{
    public function __construct(Enquiry $model)
    {
        parent::__construct($model);
    }

    public function getDataFromRequest($request): array
    {
        return $request->only([
            'name',
            'email',
            'phone',
            'subject',
            'message',
            'tour_id',
            'status',
        ]);
    }

    public function getUnread()
    {
        return $this->model->where('status', EnquiryStatus::New)->get();
    }

    public function markAsRead(int $id): void
    {
        $enquiry = $this->model->find($id);
        if ($enquiry && $enquiry->status === EnquiryStatus::New) {
            $enquiry->update(['status' => EnquiryStatus::Read->value]);
        }
    }
}
