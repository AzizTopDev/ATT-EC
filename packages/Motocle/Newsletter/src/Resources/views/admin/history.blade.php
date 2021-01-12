@extends('admin::layouts.content')

@section('page_title')
    {{ __('newsletter::app.cms.newsletter.history') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('newsletter::app.cms.newsletter.history') }}</h1>
            </div>
        </div>

        <div class="page-content">
            @inject('cmsGrid', 'Motocle\Newsletter\DataGrids\NewsletterHistoryDataGrid')

            {!! $cmsGrid->render() !!}
        </div>
    </div>
@stop
