<table style="overflow-x: auto; border-collapse: collapse;
                border-spacing: 0; width: 100%;">
    <thead>
    <tr style="background-color: #f2f2f2">
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.SKU') }}</th>
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.product-name') }}</th>
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.price') }}</th>
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.qty') }}</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($shipment->items as $item)
        <tr>
            <td style="text-align: left;padding: 8px">{{ $item->child ? $item->child->sku : $item->sku }}</td>

            <td style="text-align: left;padding: 8px">{{ $item->name }}</td>

            <td style="text-align: left;padding: 8px">{{ core()->formatPrice($item->price, $order->order_currency_code) }}</td>

            <td style="text-align: left;padding: 8px">{{ $item->qty }}</td>

            @if ($html = $item->getOptionDetailHtml())
                <div style="">
                    <label style="margin-top: 10px; font-size: 16px;color: #5E5E5E; display: block;">
                        {{ $html }}
                    </label>
                </div>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
