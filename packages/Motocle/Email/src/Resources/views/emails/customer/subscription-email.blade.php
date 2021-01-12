@component('email::emails.layouts.master')
    <div>
        {!! DbView::make($content)->field('content')->with([
            'unsubscribe_url' => route('shop.unsubscribe', $token),
            ])->render() !!}
    </div>
@endcomponent
