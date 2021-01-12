@component('email::emails.layouts.master')
    <div>
        {!! DbView::make($content)->field('content')->with([
            'customer_name' => $user_name,
            'password_reset_url' => route('customer.reset-password.create', $token),
            ])->render() !!}
    </div>
@endcomponent
