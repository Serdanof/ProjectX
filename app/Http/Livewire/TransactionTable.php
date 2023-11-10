<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class TransactionTable extends LivewireTableComponent
{
    protected $model = Payment::class;

    protected string $tableName = 'payments';

    // for table header button
    public bool $showButtonOnHeader = true;

    public string $buttonComponent = 'transactions.components.export-button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setQueryStringStatus(false);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('payment_mode')) {
                return [
                    'class' => 'text-center w-12',
                ];
            }
            if ($column->isField('amount')) {
                return [
                    'class' => 'd-flex justify-content-end',
                ];
            }
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });
        $this->setTdAttributes(function (Column $column) {
            if ($column->getField() === 'payment_mode') {
                return [
                    'class' => 'text-center',
                ];
            }
            if ($column->getField() === 'amount') {
                return [
                    'class' => 'text-end',
                ];
            }
            if ($column->getField() === 'id') {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.payment.transaction_id'), 'transaction_id')
                ->searchable()
                ->view('transactions.components.transactions-id'),
            Column::make(__('messages.invoice.invoice_id'), 'invoice.invoice_id')
                ->searchable(function (Builder $query, $invoiceID) {
                    return $query->orWhere('invoices.invoice_id', 'like', '%'.trim($invoiceID).'%');
                })
                ->format(function ($value, $row, Column $column) {
                    return view('transactions.components.invoice-id-payment-date')
                        ->withValue([
                            'invoice-id-route' => route('invoices.show', $row->invoice->id),
                            'invoice-id' => $row->invoice->invoice_id,
                        ]);
                }),
            Column::make(__('messages.invoice.client'), 'invoice.client.user.first_name')
                //                ->sortable()
                ->searchable()
                ->view('transactions.components.client-name'),
            Column::make('Last Name', 'invoice.client.user.last_name')
                ->sortable()
                ->searchable()
                ->hideif('admin'),
            Column::make(__('messages.payment.payment_date'), 'payment_date')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return view('transactions.components.invoice-id-payment-date')
                        ->withValue([
                            'payment-date' => $row->payment_date,
                        ]);
                }),
            Column::make(__('messages.invoice.amount'), 'amount')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row, Column $column) {
                    return getinvoiceCurrencyAmount($row->amount, $row->invoice->currency_id, true);
                }),
            Column::make(__('messages.subscription_plans.payment_approved'), 'id')
                ->searchable()
                ->view('transactions.components.transaction-approved'),
            Column::make(__('messages.invoice.payment_method'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.payment-mode'),
            Column::make(__('messages.common.status'), 'payment_mode')
                ->searchable()
                ->view('transactions.components.transaction-status'),
            Column::make(__('messages.common.attachment'), 'id')
                ->searchable()
                ->view('transactions.components.transaction-attachment'),
        ];
    }

    public function builder(): Builder
    {
        return Payment::with('invoice.client.user')->select('payments.*');
    }

    public function filters(): array
    {
        $paymentMethod = Payment::PAYMENT_MODE;
        $paymentApprove = Payment::PAYMENT_APPROVE;

        return [
            SelectFilter::make(__('messages.payment.payment_method').':')
                ->options($paymentMethod)
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('payment_mode', $value);
                }),
            SelectFilter::make(__('messages.subscription_plans.payment_approved').':')
                ->options($paymentApprove)
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('is_approved', $value);
                }),
        ];
    }

    public function resetPageTable()
    {
        $this->customResetPage('page');
    }
}
