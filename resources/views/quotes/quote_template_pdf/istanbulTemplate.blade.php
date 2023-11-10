<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" href="{{ asset('web/media/logos/favicon.ico') }}" type="image/png">
    <title>{{ __('messages.quote.quote_pdf') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/invoice-pdf.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: DejaVu Sans, Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
        }

        @if (getCurrencySymbol($quote->tenant_id) == '€')
            .euroCurrency {
                font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
            }
        @endif
    </style>
</head>

<body>
    @php $styleCss = 'style'; @endphp
    <table width="100%">
        <tr>
            <td>
                <div class="main-heading p-3"
                    {{ $styleCss }}="font-size: 40px;background: {{ $quote_template_color }}
            ; color: white">
                    {{ __('messages.quote.quote_name') }}</div>
                <div class="logo">
                    <img width="100px" src="{{ getLogoUrl($quote->tenant_id) }}" alt="">
                </div>
                {{ html_entity_decode(getAppName($quote->tenant_id)) }}<br>
                <b>{{ __('messages.common.address') . ':' }}&nbsp;</b>{{ $setting['company_address'] }}<br>
                <b>{{ __('messages.user.phone') . ':' }}&nbsp;</b>{{ $setting['company_phone'] }}
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <thead>
            <tr>
                <td class="vertical-align-top">
                    <strong class="to-font-size">{{ __('messages.common.to') }}</strong><br>
                    <b>{{ __('messages.common.name') . ':' }}&nbsp;</b>{{ $client->user->full_name }}
                    <br>
                    <b>{{ __('messages.common.email') . ':' }}&nbsp;</b>{{ $client->user->email }}<br>
                    @if (!empty($client->address))
                        <b>{{ __('messages.common.address') . ':' }}&nbsp;</b>{{ $client->address }}<br>
                    @endif
                    <strong>{{ __('messages.quote.quote_id') . ':' }}&nbsp;</strong>#{{ $quote->quote_id }}<br>
                    <strong>{{ __('messages.quote.quote_date') . ':' }}
                        &nbsp;</strong>{{ \Carbon\Carbon::parse($quote->quote_date)->translatedFormat(currentDateFormat()) }}<br>
                    <strong>{{ __('messages.quote.due_date') . ':' }}
                        &nbsp;</strong>
                    {{ \Carbon\Carbon::parse($quote->due_date)->translatedFormat(currentDateFormat()) }}
                </td>
            </tr>
        </thead>
    </table>
    <table width="100%">
        <tr class="invoice-items">
            <td colspan="2">
                <table class="items-table">
                    <thead {{ $styleCss }}="border-top: 2px solid;border-bottom: 2px solid;">
                        <tr class="tu">
                            <th>#</th>
                            <th>{{ __('messages.product.product') }}</th>
                            <th class="number-align">{{ __('messages.invoice.qty') }}</th>
                            <th class="number-align">{{ __('messages.product.unit_price') }}</th>
                            <th class="number-align">{{ __('messages.invoice.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody {{ $styleCss }}="border-bottom: 2px solid">
                        @if (isset($quote) && !empty($quote))
                            @foreach ($quote->quoteItems as $key => $quoteItems)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ isset($quoteItems->product->name) ? $quoteItems->product->name : $quoteItems->product_name ?? __('messages.common.n/a') }}
                                        @if (
                                            !empty($quoteItems->product->description) &&
                                                (isset($setting['show_product_description']) && $setting['show_product_description'] == 1))
                                            <br><span
                                                style="font-size: 12px; word-break: break-all">{{ $quoteItems->product->description }}</span>
                                        @endif
                                    </td>
                                    <td class="number-align">{{ $quoteItems->quantity }}</td>
                                    <td class="number-align"><b
                                            class="euroCurrency">{{ isset($quoteItems->price) ? getCurrencyAmount($quoteItems->price, true) : __('messages.common.n/a') }}</b>
                                    </td>
                                    <td class="number-align"><b
                                            class="euroCurrency">{{ isset($quoteItems->total) ? getCurrencyAmount($quoteItems->total, true) : __('messages.common.n/a') }}</b>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <table class="invoice-footer">
                    <tr>
                        <td class="font-weight-bold tu">{{ __('messages.quote.amount') . ':' }}</td>
                        <td class="text-nowrap">
                            <b class="euroCurrency">{{ getCurrencyAmount($quote->amount, true) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold tu">{{ __('messages.quote.discount') . ':' }}</td>
                        <td class="text-nowrap">
                            @if ($quote->discount == 0)
                                <span>{{ __('messages.common.n/a') }}</span>
                            @else
                                @if (isset($quote) && $quote->discount_type == \App\Models\Quote::FIXED)
                                    <b
                                        class="euroCurrency">{{ isset($quote->discount) ? getCurrencyAmount($quote->discount, true) : __('messages.common.n/a') }}</b>
                                @else
                                    {{ $quote->discount }}<span
                                        {{ $styleCss }}="font-family: DejaVu Sans">&#37;</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold tu">{{ __('messages.quote.total') . ':' }}</td>
                        <td class="text-nowrap">
                            <b class="euroCurrency">{{ getCurrencyAmount($quote->final_amount, true) }}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td>
                            <strong>{{ __('messages.client.notes') }}:</strong>
                            <p class="font-color-gray">{!! nl2br($quote->note ?? __('messages.common.n/a')) !!}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{ __('messages.invoice.terms') }}:</strong><br>
                            <p class="font-color-gray">{!! nl2br($quote->term ?? __('messages.common.n/a')) !!}</p>
                        </td>
                    </tr>
                </table>
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="vertical-align-bottom">
                <strong>{{ __('messages.common.regards') . ':' }}</strong><br>
                <br>{{ getAppName($quote->tenant_id) }}
            </td>
        </tr>
    </table>
</body>

</html>
