@component('email::emails.layouts.master')
    <div>
        {!! DbView::make($content)->field('content')->with([
            'customer_name' => $last_name . ' ' . $first_name,
            ])->render() !!}
    </div>
@endcomponent
