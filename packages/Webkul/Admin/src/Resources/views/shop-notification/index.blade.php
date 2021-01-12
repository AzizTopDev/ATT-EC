@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.cms.shop-notification.page-title') }}
@stop

@section('content')
    <div class="content" style="height: 100%;">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.cms.shop-notification.page-title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.shop-notification.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.cms.shop-notification.create-btn') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('notification', 'Webkul\Admin\DataGrids\ShopNotificationDataGrid')
            {!! $notification->render() !!}
        </div>

    </div>
@stop
