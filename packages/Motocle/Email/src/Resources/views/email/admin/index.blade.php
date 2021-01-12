@extends('admin::layouts.content')

@section('page_title')
    {{ __('email::app.cms.email.page-title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('email::app.cms.email.emails') }}</h1>
            </div>
        </div>

        <div class="page-content">
            @inject('cmsGrid', 'Motocle\Email\DataGrids\CMSSystemEmailDataGrid')

            {!! $cmsGrid->render() !!}
        </div>
    </div>
@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => $cmsGrid])
@endpush
