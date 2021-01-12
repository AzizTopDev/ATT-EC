@component('email::emails.layouts.master')
    <div>
        {!! DbView::make($content)->field('content')->with([
                'customer_name' => $order->customer_full_name,
                'order_number' => $order->id,
                'order_date_time' => $order->created_at->format('Y/m/d h:i a'),
                'shipping_address' => View::make('email::emails.order.partials.address', ['address' => $order->shipping_address]),
                'billing_address' => View::make('email::emails.order.partials.address', ['address' => $order->billing_address]),
                'shipping_method' => $order->shipping_title,
                'payment_method' => core()->getConfigData('sales.paymentmethods.' . $order->payment->method . '.title'),
                'invoice_number' => $invoice->id,
                'invoice_details' => View::make('email::emails.order.partials.invoice-details', ['invoice' => $invoice]),
                'invoice_sub_total_amount' => core()->formatPrice($invoice->sub_total, $invoice->order_currency_code),
                'invoice_shipping_amount' => core()->formatPrice($invoice->shipping_amount, $invoice->order_currency_code),
                'invoice_tax_amount' => core()->formatPrice($invoice->tax_amount, $invoice->order_currency_code),
                'invoice_discount_amount' => core()->formatPrice($invoice->discount_amount, $invoice->order_currency_code),
                'invoice_grand_total_amount' => core()->formatPrice($invoice->grand_total, $invoice->order_currency_code),
            ])->render() !!}
    </div>
@endcomponent
