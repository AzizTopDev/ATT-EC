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
                'shipment_carrier' => $shipment->carrier_title,
                'shipment_tracking_number' => $shipment->track_number,
                'shipment_details' => View::make('email::emails.order.partials.shipment-details', ['shipment' => $shipment, 'order' => $order]),
            ])->render() !!}
    </div>
@endcomponent
