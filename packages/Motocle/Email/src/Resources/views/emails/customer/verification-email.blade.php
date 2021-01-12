@component('email::emails.layouts.master')
    <div>
        {!! DbView::make($content)->field('content')->with([
            'customer_name' => $user_name,
            'email_verification_url' => route('customer.verify', $token),
            ])->render() !!}
    </div>
@endcomponent
