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
                'refund_details' => View::make('email::emails.order.partials.refund-details', ['refund' => $refund]),
                'refund_sub_total_amount' => core()->formatPrice($refund->sub_total, $refund->order_currency_code),
                'refund_shipping_amount' => core()->formatPrice($refund->shipping_amount, $refund->order_currency_code),
                'refund_tax_amount' => core()->formatPrice($refund->tax_amount, $refund->order_currency_code),
                'refund_discount_amount' => core()->formatPrice($refund->discount_amount, $refund->order_currency_code),
                'refund_adjustment_amount' => core()->formatPrice($refund->adjustment_refund, $refund->order_currency_code),
                'refund_adjustment_fee_amount' => core()->formatPrice($refund->adjustment_fee, $refund->order_currency_code),
                'refund_grand_total_amount' => core()->formatPrice($refund->grand_total, $refund->order_currency_code),
            ])->render() !!}
    </div>
@endcomponent
