@extends('admin::layouts.content')

@section('page_title')
    {{ __('email::app.cms.email.page-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('motocle.cms.email.admin.update', [$email->id]) }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('email::app.cms.email.emails') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" tabindex="5" class="btn btn-lg btn-primary">
                        {{ __('email::app.cms.email.add-button') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()
                    <div slot="body">
                        <div class="control-group">
                            <strong>{{ $email->type_label }}</strong>
                        </div>

                        <div class="control-group" :class="[errors.has('senderName') ? 'has-error' : '']">
                            <label for="senderName" class="required">{{ __('email::app.cms.email.sender-name') }}</label>

                            <input type="text" class="control" name="senderName" v-validate="'required'" maxlength="100" tabindex="1" value="{{ old('senderName', $email->sender_name) }}" data-vv-as="&quot;{{ __('email::app.cms.email.sender-name') }}&quot;">

                            <span class="control-error" v-if="errors.has('senderName')">@{{ errors.first('senderName') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('senderEmail') ? 'has-error' : '']">
                            <label for="senderEmail" class="required">{{ __('email::app.cms.email.sender-email') }}</label>

                            <input type="text" class="control" name="senderEmail" v-validate="'required|email'" maxlength="150" tabindex="2" value="{{ old('senderEmail', $email->sender_email) }}" data-vv-as="&quot;{{ __('email::app.cms.email.sender-email') }}&quot;">

                            <span class="control-error" v-if="errors.has('senderEmail')">@{{ errors.first('senderEmail') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('subject') ? 'has-error' : '']">
                            <label for="subject" class="required">{{ __('email::app.cms.email.subject') }}</label>

                            <input type="text" class="control" name="subject" v-validate="'required'" maxlength="100" tabindex="3" value="{{ old('subject', $email->subject) }}" data-vv-as="&quot;{{ __('email::app.cms.email.subject') }}&quot;">

                            <span class="control-error" v-if="errors.has('subject')">@{{ errors.first('subject') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('mailContent') ? 'has-error' : '']">
                            <label for="mailContent" class="required">{{ __('email::app.cms.email.email-content') }}</label>

                            <textarea type="text" class="control" id="content" name="mailContent" tabindex="4" v-validate="'required'" data-vv-as="&quot;{{ __('email::app.cms.email.email-content') }}&quot;">{{ old('mailContent', $email->content) }}</textarea>
                            <span class="control-error" v-if="errors.has('mailContent')">@{{ errors.first('mailContent') }}</span>

                            @if (count($email->variables) > 0)
                                <br />
                                <strong>{{ __('email::app.cms.email.available-variables') }}</strong>
                                <p style="line-height: 2; margin-top: 10px;">
                                    @foreach ($email->variables as $variable)
                                        <pre>{{ '{' . $variable . '}' }}</pre>
                                    @endforeach
                                </p>
                            @endif
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
                toolbar1: 'bold italic strikethrough forecolor backcolor | link | image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
                valid_elements : '*[*]',
                forced_root_block : '',
                force_br_newlines : true,
                convert_newlines_to_brs : true,
                branding: false,
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{--{{ route('admin.tinymce.image.upload', 'email') }}--}}');
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