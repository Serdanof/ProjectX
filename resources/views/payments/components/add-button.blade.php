<div class="dropdown d-flex align-items-center me-4 me-md-2" wire:ignore>
    <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
            id="apptmentFilterBtn"
            data-bs-auto-close="outside"
            data-bs-toggle="dropdown" aria-expanded="false">
        <p class="text-center">
            <i class='fas fa-filter'></i>
        </p>
    </button>
    <div class="dropdown-menu py-0" aria-labelledby="apptmentFilterBtn">
        <div class="text-start border-bottom py-4 px-7">
            <h3 class="text-gray-900 mb-0">{{__('messages.common.filter_options')}}</h3>
        </div>
        <div class="p-5">
            <div class="mb-5">
                <label for="filterBtn" class="form-label">{{__('messages.sms.date')}}:</label>
                <input type="text" class="form-control form-control-solid flatpickr-input"  placeholder="Pick date range" id="paymentDateFilter"/>
            </div>
        </div>
    </div>
</div>

<div class="my-3 my-sm-3">
    <a type="button" class="btn btn-outline-success me-2" data-turbo="false" id="adminPaymentExcelExport">
        <i class="fas fa-file-excel me-1"></i> {{__('messages.invoice.excel_export')}}
    </a>
</div>
<div class="my-3 my-sm-3">
    <a type="button" class="btn btn-outline-info me-2" data-turbo="false" id="adminPaymentPdfExport">
        <i class="fas fa-file-pdf me-1"></i> {{__('messages.pdf_export')}}
    </a>
</div>
<div class="my-3 my-sm-3">
    <a class="btn btn-primary addPayment">
        {{ __('messages.payment.add_payment') }}
    </a>
</div>
