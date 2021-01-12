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
    @foreach ($refund->items as $item)
        <tr>
            <td style="text-align: left;padding: 8px">{{ $item->name }}</td>
            <td style="text-align: left;padding: 8px">{{ core()->formatPrice($item->price, $refund->order_currency_code) }}</td>
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
            {{ core()->formatPrice($refund->sub_total, $refund->order_currency_code) }}
        </td>
    </tr>

    @if ($refund->shipping_amount > 0)
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
                {{ __('shop::app.mail.order.shipping-handling') }}
            </td>
            <td style="padding: 5px 8px;">
                {{ core()->formatPrice($refund->shipping_amount, $refund->order_currency_code) }}
            </td>
        </tr>
    @endif

    @if ($refund->tax_amount > 0)
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
                {{ __('shop::app.mail.order.tax') }}
            </td>
            <td style="padding: 5px 8px;">
                {{ core()->formatPrice($refund->tax_amount, $refund->order_currency_code) }}
            </td>
        </tr>
    @endif

    @if ($refund->discount_amount > 0)
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
                {{ __('shop::app.mail.order.discount') }}
            </td>
            <td style="padding: 5px 8px;">
                {{ core()->formatPrice($refund->discount_amount, $refund->order_currency_code) }}
            </td>
        </tr>
    @endif

    @if ($refund->adjustment_refund > 0)
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
                {{ __('shop::app.mail.refund.adjustment-refund') }}
            </td>
            <td style="padding: 5px 8px;">
                {{ core()->formatPrice($refund->adjustment_refund, $refund->order_currency_code) }}
            </td>
        </tr>
    @endif

    @if ($refund->adjustment_fee > 0)
        <tr>
            <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
                {{ __('shop::app.mail.refund.adjustment-fee') }}
            </td>
            <td style="padding: 5px 8px;">
                {{ core()->formatPrice($refund->adjustment_fee, $refund->order_currency_code) }}
            </td>
        </tr>
    @endif

    <tr>
        <td colspan="2" style="text-align: right; padding: 5px 50px 5px 8px;">
            {{ __('shop::app.mail.order.grand-total') }}
        </td>
        <td style="padding: 5px 8px;">
            {{ core()->formatPrice($refund->grand_total, $refund->order_currency_code) }}
        </td>
    </tr>

    </tbody>
</table>
