@extends('admin::layouts.content')

@section('page_title')
    {{ __('newsletter::app.cms.newsletter.templates') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('newsletter::app.cms.newsletter.templates') }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.motocle.cms.dm.create') }}" class="btn btn-lg btn-primary">
                    {{ __('newsletter::app.cms.newsletter.add-newsletter-button') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('cmsGrid', 'Motocle\Newsletter\DataGrids\NewsletterDataGrid')

            {!! $cmsGrid->render() !!}
        </div>
    </div>
@stop
