<table style="overflow-x: auto; border-collapse: collapse;
                border-spacing: 0; width: 100%;">
    <thead>
    <tr style="background-color: #f2f2f2">
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.product-name') }}</th>
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.price') }}</th>
        <th style="text-align: left;padding: 8px">{{ __('shop::app.customer.account.order.view.qty') }}</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($invoice->items as $item)
        <tr>
            <td style="text-align: left;padding: 8px">{{ $item->name }}</td>
            <td style="text-align: left;padding: 8px">{{ core()->formatPrice($item->price, $invoice->order_currency_code) }}</td>
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
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
            {{ __('shop::app.mail.order.subtotal') }}
        </td>
        <td style="padding: 5px 8px;">
            {{ core()->formatPrice($invoice->sub_total, $invoice->order_currency_code) }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
            {{ __('shop::app.mail.order.shipping-handling') }}
        </td>
        <td style="padding: 5px 8px;">
            {{ core()->formatPrice($invoice->shipping_amount, $invoice->order_currency_code) }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
            {{ __('shop::app.mail.order.tax') }}
        </td>
        <td style="padding: 5px 8px;">
            {{ core()->formatPrice($invoice->tax_amount, $invoice->order_currency_code) }}
        </td>
    </tr>

    @if ($invoice->discount_amount > 0)
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
                {{ __('shop::app.mail.order.discount') }}
            </td>
            <td style="padding: 5px 8px;">
                {{ core()->formatPrice($invoice->discount_amount, $invoice->order_currency_code) }}
            </td>
        </tr>
    @endif

    <tr>
        <td colspan="2" style="font-weight: bold; text-align: right; padding: 5px 50px 5px 8px;">
            {{ __('shop::app.mail.order.grand-total') }}
        </td>
        <td style="font-weight: bold; padding: 5px 8px;">
            {{ core()->formatPrice($invoice->grand_total, $invoice->order_currency_code) }}
        </td>
    </tr>
    </tbody>
</table>
