@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.cms.shop-notification.add-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.shop-notification.save') }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ url('/admin/shop-notification') }}';"></i>

                        {{ __('admin::app.cms.shop-notification.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.cms.shop-notification.save-btn') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()
                    <div slot="body">
                        <div class="control-group" :class="[errors.has('admin_name') ? 'has-error' : '']">
                            <label for="admin_name" class="required">{{ __('admin::app.cms.shop-notification.admin-name') }}</label>

                            <input type="text" class="control" name="admin_name" v-validate="'required'" value="{{ old('admin_name') }}" data-vv-as="&quot;{{ __('admin::app.cms.shop-notification.admin-name') }}&quot;">

                            <span class="control-error" v-if="errors.has('admin_name')">@{{ errors.first('admin_name') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                            <label for="title" class="required">{{ __('admin::app.cms.shop-notification.title') }}</label>

                            <input type="text" class="control" name="title" v-validate="'required'" value="{{ old('title') }}" data-vv-as="&quot;{{ __('admin::app.cms.shop-notification.title') }}&quot;">

                            <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                            <label for="content" class="required">{{ __('admin::app.cms.shop-notification.content') }}</label>

                            <textarea type="text" class="control" id="content" name="content" v-validate="'required'" value="{{ old('content') }}" data-vv-as="&quot;{{ __('admin::app.cms.shop-notification.content') }}&quot;"></textarea>

                            <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('display_flag') ? 'has-error' : '']">
                            <label>
                                <span style="vertical-align: bottom;">{{ __('admin::app.cms.shop-notification.display-flag') }}</span>
                                <label class="switch" style="margin-left: 15px">
                                    <input type="checkbox" name="display-flag" @if (!$toggle_flag) disabled @endif>
                                    <span class="slider round"></span>
                                </label>
                            </label>
                            @if (!$toggle_flag)
                                <span style="color: red; padding: 20px">（トップページにはすでに通知が表示されています）</span>
                            @endif
                            <span class="control-error" v-if="errors.has('display_flag')">@{{ errors.first('display_flag') }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: 'textarea#content',
                height: 500,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code link',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
                valid_elements : '*[*]',
                branding: false,
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route('admin.tinymce.image.upload', 'cms') }}');
                    var token = '{{ csrf_token() }}';
                    xhr.setRequestHeader("X-CSRF-Token", token);
                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    formData.append('image', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
            });
        });
    </script>
@endpush
