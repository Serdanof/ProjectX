<div class="my-3 my-sm-3">
    <a href="{{ route('client.quotesExcel') }}" type="button" class="btn btn-outline-success me-2" data-turbo="false">
        <i class="fas fa-file-excel me-1"></i> {{__('messages.quote.excel_export')}}
    </a>
</div>
<div class="my-3 my-sm-3">
    <a href="{{ route('client.export.quotes.pdf') }}" type="button" class="btn btn-outline-info me-2"
       data-turbo="false">
        <i class="fas fa-file-pdf me-1"></i> {{__('messages.pdf_export')}}
    </a>
</div>
<div class="my-3 my-sm-3">
    <a href="{{ route('client.quotes.create') }}"
       class="btn btn-primary" data-turbo="false">{{__('messages.quote.new_quote')}}</a>
</div>
