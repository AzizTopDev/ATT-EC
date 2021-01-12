@extends('admin::layouts.content')

@section('page_title')
    {{ __('newsletter::app.cms.newsletter.newsletter-edit') }}
@stop

@section('content')
    <div class="content cms-newsletter">
        <form method="POST" action="{{ route('admin.motocle.cms.dm.update', [$template->id]) }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                        {{ __('newsletter::app.cms.newsletter.newsletter-edit') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" name="action" value="save" tabindex="5" class="btn btn-lg btn-primary">
                        {{ __('newsletter::app.cms.newsletter.save_button') }}
                    </button>
                </div>
            </div>
            <div class="page-content">

                <div class="form-container mt-25">
                    @csrf()
                    <div slot="body">
                        <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                            <label for="name" class="required">{{ __('newsletter::app.cms.newsletter.template-name') }}</label>

                            <input type="text" class="control" name="name" v-validate="'required'" maxlength="100" tabindex="1" value="{{ old('name', $template->name) }}" data-vv-as="&quot;{{ __('newsletter::app.cms.newsletter.template-name') }}&quot;">

                            <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('subject') ? 'has-error' : '']">
                            <label for="subject" class="required">{{ __('newsletter::app.cms.newsletter.subject') }}</label>

                            <input type="text" class="control" name="subject" v-validate="'required'" maxlength="100" tabindex="2" value="{{ old('subject', $template->subject) }}" data-vv-as="&quot;{{ __('newsletter::app.cms.newsletter.subject') }}&quot;">

                            <span class="control-error" v-if="errors.has('subject')">@{{ errors.first('subject') }}</span>
                        </div>


                        <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                            <label for="mailContent" class="required">{{ __('newsletter::app.cms.newsletter.mail_content') }}</label>

                            <textarea type="text" class="control" id="content" name="content" tabindex="4" v-validate="'required'" data-vv-as="&quot;{{ __('newsletter::app.cms.newsletter.mail_content') }}&quot;">{{ old('content', $template->content) }}</textarea>

                            <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                        </div>

                        <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                            <label for="email" {{ old('action') == 'test' ? 'class=required' : '' }}>{{ __('newsletter::app.cms.newsletter.test_email_address') }}</label>

                            <div class="row">
                                <div style="width: 45%;">
                                    <input type="text" class="control" name="email" maxlength="150" v-validate="'email'" tabindex="1" style="width:100%" value="{{ old('email') }}" data-vv-as="&quot;{{ __('newsletter::app.cms.newsletter.test_email_address') }}&quot;">
                                </div>
                                <div class="page-action" style="width: 50%;">
                                    <button type="submit" name="action" value="test" tabindex="5" class="btn btn-lg btn-info">
                                        {{ __('newsletter::app.cms.newsletter.test_send_button') }}
                                    </button>
                                </div>
                            </div>

                            <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                        </div>

                        <div class="page-action">
                            <button type="submit" name="action" value="send" tabindex="5" class="btn btn-lg btn-primary">
                                {{ __('newsletter::app.cms.newsletter.send_button') }}
                            </button>
                            <input type="hidden" name="nlClickedAction" id="clicked-action" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    <script src="{{ asset('vendor/motocle/newsletter/assets/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: 'textarea#content',
                height: 500,
                width: "100%",
                plugins: 'image imagetools media save fullscreen code link',
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
                    xhr.open('POST', '{{ route('admin.motocle.cms.dm.upload-image') }}');
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
                relative_urls : false,
                remove_script_host : false,
                convert_urls : true,
            });

            $('button').click(function() {
                $('#clicked-action').val($(this).val())
            })
        });

    </script>

    <script type="text/javascript" src="{{ asset('vendor/motocle/newsletter/assets/js/newsletter.js') }}"></script>
@endpush
