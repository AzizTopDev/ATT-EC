@component('email::emails.layouts.master')
    <div>
        {!! $content !!}
    </div>
    <div style="color: #939598; margin-top: 50px; border-top: 1px solid #ccc; padding: 5px 0; font-size: 13px; line-height: 1.3;">
        このメールは、メーリングリストへの参加をリクエストしたメンバーに送信されています。<br />
        メールの受信を希望しない場合は、登録を<a href="{{ route('shop.unsubscribe', $token) }}">解除</a>できます。
    </div>
@endcomponent
