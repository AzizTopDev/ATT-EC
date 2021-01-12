@extends('admin::layouts.content')

@section('page_title')
    {{ __('newsletter::app.cms.newsletter.history') }}
@stop

@section('content')
    <div class="content cms-newsletter">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                    {{ __('newsletter::app.cms.newsletter.history') }}
                </h1>
            </div>
        </div>
        <div class="page-content">
            <div class="mt-25 nl-view">
                <div slot="body">
                    <p>
                        <span>{{ __('newsletter::app.cms.newsletter.template-name') }}</span>
                        {{ $newsletter->name }}
                    </p>
                    <p>
                        <span>{{ __('newsletter::app.cms.newsletter.subject') }}</span>
                        {{ $newsletter->subject }}
                    </p>
                    <p>
                        <span>{{ __('newsletter::app.cms.newsletter.mail_content') }}</span>
                        {!! $newsletter->content !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
