@component('email::emails.layouts.master')
    <div>
        {!! DbView::make($content)->field('content')->with([
            'user_name' => $user_name,
            'password_reset_url' => route('admin.reset-password.create', ['token' => $token, 'email' => $email]),
        ])->render() !!}
    </div>
@endcomponent