<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSuperAdminEnquiryRequest;
use App\Models\SuperAdminEnquiry;
use App\Repositories\SuperAdminEnquiryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminEnquiryController extends AppBaseController
{
    /** @var SuperAdminEnquiryRepository */
    private $superAdminEnquiryRepository;

    public function __construct(SuperAdminEnquiryRepository $repo)
    {
        $this->superAdminEnquiryRepository = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $data['statusArr'] = SuperAdminEnquiry::STATUS_ARR;

        return view('super_admin.enquiries.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSuperAdminEnquiryRequest $request): JsonResponse
    {
        $input = $request->all();
        $this->superAdminEnquiryRepository->store($input);

        return $this->sendSuccess(__('messages.landing.enquiry').' '.__('messages.common.send_successfully'));
    }

    public function show(SuperAdminEnquiry $enquiry): View
    {
        if ($enquiry->status == SuperAdminEnquiry::UNREAD) {
            $enquiry->update(['status' => SuperAdminEnquiry::READ]);
        }

        return view('super_admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Display the specified resource.
     */
    public function destroy(SuperAdminEnquiry $enquiry): JsonResponse
    {
        $enquiry->delete();

        return $this->sendSuccess(__('messages.flash.enquiry_deleted'));
    }
}
