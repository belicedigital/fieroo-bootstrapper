@extends('layouts.app')
@section('title', trans('entities.settings'))
@section('title_header', trans('entities.settings'))
@section('content')
<div class="container">
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif

    @if (Session::has('success'))
    @include('admin.partials.success')
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="settingsTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="settings-tab-generals" data-toggle="pill" href="#settings-tab-general" role="tab" aria-controls="settings-tab-general" aria-selected="true">{{ trans('generals.generals') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab-emails" data-toggle="pill" href="#settings-tab-email" role="tab" aria-controls="settings-tab-email" aria-selected="false">{{ trans('generals.email_texts') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="settingsTabContent">
                        <div class="tab-pane fade show active" id="settings-tab-general" role="tabpanel" aria-labelledby="settings-tab-generals">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('save-settings-generals') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <strong>{{trans('forms.select_app_brand')}}</strong>
                                            <input type="file" name="file" class="form-control" value="{{ old('file') }}" accept="image/png, image/gif, image/jpeg, image/bmp">
                                        </div>
                                        <div class="form-group">
                                            <strong>{{trans('forms.select_iva')}}</strong>
                                            <input type="number" step=".01" name="iva" class="form-control" value="{{ $settings->iva }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ trans('generals.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="settings-tab-email" role="tabpanel" aria-labelledby="settings-tab-emails">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('save-settings-emails') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_pending_admit_exhibitor_it') }}</strong>
                                            <textarea name="email_pending_admit_exhibitor_it" class="form-control summernote" rows="10">{!! $settings->email_pending_admit_exhibitor_it !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_pending_admit_exhibitor_en') }}</strong>
                                            <textarea name="email_pending_admit_exhibitor_en" class="form-control summernote" rows="10">{!! $settings->email_pending_admit_exhibitor_en !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_to_admin_pending_notification_admit') }}</strong>
                                            <textarea name="email_to_admin_pending_notification_admit" class="form-control summernote" rows="10">{!! $settings->email_to_admin_pending_notification_admit !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_admit_exhibitor_it') }}</strong>
                                            <textarea name="email_admit_exhibitor_it" class="form-control summernote" rows="10">{!! $settings->email_admit_exhibitor_it !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_admit_exhibitor_en') }}</strong>
                                            <textarea name="email_admit_exhibitor_en" class="form-control summernote" rows="10">{!! $settings->email_admit_exhibitor_en !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_to_admin_notification_admit') }}</strong>
                                            <textarea name="email_to_admin_notification_admit" class="form-control summernote" rows="10">{!! $settings->email_to_admin_notification_admit !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_confirm_order_it') }}</strong>
                                            <textarea name="email_confirm_order_it" class="form-control summernote" rows="10">{!! $settings->email_confirm_order_it !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_confirm_order_en') }}</strong>
                                            <textarea name="email_confirm_order_en" class="form-control summernote" rows="10">{!! $settings->email_confirm_order_en !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_to_admin_notification_confirm_order') }}</strong>
                                            <textarea name="email_to_admin_notification_confirm_order" class="form-control summernote" rows="10">{!! $settings->email_to_admin_notification_confirm_order !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_event_subscription_it') }}</strong>
                                            <textarea name="email_event_subscription_it" class="form-control summernote" rows="10">{!! $settings->email_event_subscription_it !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_event_subscription_en') }}</strong>
                                            <textarea name="email_event_subscription_en" class="form-control summernote" rows="10">{!! $settings->email_event_subscription_en !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_registration_it') }}</strong>
                                            <textarea name="email_registration_it" class="form-control summernote" rows="10">{!! $settings->email_registration_it !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_registration_en') }}</strong>
                                            <textarea name="email_registration_en" class="form-control summernote" rows="10">{!! $settings->email_registration_en !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_remarketing_it') }}</strong>
                                            <textarea name="email_remarketing_it" class="form-control summernote" rows="10">{!! $settings->email_remarketing_it !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <strong>{{ trans('forms.text_email_remarketing_en') }}</strong>
                                            <textarea name="email_remarketing_en" class="form-control summernote" rows="10">{!! $settings->email_remarketing_en !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ trans('generals.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('.summernote').summernote();
        $('.note-btn-group.btn-group.note-insert').hide()
    });
</script>
@endsection
