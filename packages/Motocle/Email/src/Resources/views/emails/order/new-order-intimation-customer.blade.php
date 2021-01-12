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
                'order_details' => View::make('email::emails.order.partials.order-details', ['order' => $order]),
                'sub_total_amount' => core()->formatPrice($order->sub_total, $order->order_currency_code),
                'shipping_amount' => core()->formatPrice($order->shipping_amount, $order->order_currency_code),
                'tax_amount' => core()->formatPrice($order->tax_amount, $order->order_currency_code),
                'discount_amount' => core()->formatPrice($order->discount_amount, $order->order_currency_code),
                'grand_total_amount' => core()->formatPrice($order->grand_total, $order->order_currency_code),
            ])->render() !!}
    </div>
@endcomponent
