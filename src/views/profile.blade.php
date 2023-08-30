@extends('layouts.app')
@section('title', trans('entities.profile'))
@section('title_header', trans('entities.profile'))
@section('buttons')
<button id="spinner" class="btn btn-primary d-none">
    <span class="spinner-border spinner-border-sm"></span>
</button>
@if(auth()->user()->roles->first()->name == 'espositore')
<a onclick="saveData(this);" href="javascript:void(0);" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.save')}}"><i class="fas fa-save"></i></a>
@else
<a onclick="updatePsw(this);" href="javascript:void(0);" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.save')}}"><i class="fas fa-save"></i></a>
@endif
@endsection
@section('content')
<div class="container-fluid">
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif
    
    @if (Session::has('success'))
    @include('admin.partials.success')
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->roles->first()->name == 'espositore')
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header"><h5 class="card-title">{{trans('generals.generals')}}</h5></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <strong>{{trans('forms.email')}}</strong>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$userData->email}}" required>
                                    </div>

                                    <div class="form-group">
                                        <strong>{{trans('forms.exhibitor_form.exhibitor.company.name')}} *</strong>
                                        <input type="text" name="company" class="form-control w-100" value="{{$userData->company}}" required>
                                    </div>

                                    <div class="row form-inline mb-3">
                                        <div class="form-group col-md-8">
                                            <strong>{{trans('forms.exhibitor_form.exhibitor.company.address')}} *</strong>
                                            <input type="text" name="address" class="form-control w-100" value="{{$userData->address}}" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>{{trans('forms.exhibitor_form.exhibitor.company.civic_number')}} *</strong>
                                            <input type="text" name="civic_number" class="form-control w-100" value="{{$userData->civic_number}}" required>
                                        </div>
                                    </div>
                                    <div class="row form-inline mb-3">
                                        <div class="form-group col-md-6">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.city')}} *</strong>
                                            <input type="text" name="city" class="form-control w-100" value="{{$userData->city}}" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.postal_code')}} *</strong>
                                            <input type="text" name="cap" class="form-control w-100" value="{{$userData->cap}}" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.province')}} *</strong>
                                            <input type="text" name="province" class="form-control w-100" value="{{$userData->province}}" required>
                                        </div>
                                    </div>
                                    <div class="row form-inline mb-3">
                                        <div class="form-group col-md-3">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.phone')}} *</strong>
                                            <input type="text" name="phone" class="form-control w-100" value="{{$userData->phone}}" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.fax')}}</strong>
                                            <input type="text" name="fax" class="form-control w-100" value="{{$userData->fax}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.web')}}</strong>
                                            <input type="text" name="web" class="form-control w-100" value="{{$userData->web}}">
                                        </div>
                                    </div>
                                    <div class="row form-inline mb-3">
                                        <div class="form-group col-md-6">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.responsible')}} *</strong>
                                            <input type="text" name="responsible" class="form-control w-100" value="{{$userData->responsible}}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.responsible_phone')}} *</strong>
                                            <input type="text" name="phone_responsible" class="form-control w-100" value="{{$userData->phone_responsible}}" required>
                                        </div>
                                    </div>
                                    <div class="row form-inline">
                                        <div class="form-group col-md-4">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.fiscal_code')}}</strong>
                                            <input type="text" name="fiscal_code" class="form-control w-100" value="{{$userData->fiscal_code}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.vat_number')}} *</strong>
                                            <input type="text" name="vat_number" class="form-control w-100" value="{{$userData->vat_number}}" required>
                                        </div>
                                        <div class="form-group col-md-4 {{ App::getLocale() == 'en' ? 'd-none' : '' }}">
                                            <strong>{{__('forms.exhibitor_form.exhibitor.company.uni_code')}} *</strong>
                                            <input type="text" name="uni_code" class="form-control w-100" value="{{$userData->uni_code}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header"><h5 class="card-title">{{trans('generals.change_password')}}</h5></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <strong>{{trans('generals.current_password')}}</strong>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <strong>{{trans('generals.new_password')}}</strong>
                                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <strong>{{trans('generals.confirm_password')}}</strong>
                                        <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->roles->first()->name == 'espositore')
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header"><h5 class="card-title">{{trans('forms.exhibitor_form.label_diff_billing_section')}}</h5></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="diff_billing">{{__('forms.exhibitor_form.diff_billing')}}</label>
                                        <select class="form-control" id="diff_billing" name="diff_billing">
                                            <option value="no" {{$userData->diff_billing == 0 ? 'selected' : ''}}>{{__('generals.no')}}</option>
                                            <option value="yes" {{$userData->diff_billing == 1 ? 'selected' : ''}}>{{__('generals.yes')}}</option>
                                        </select>
                                    </div>
                                    <div class="{{$userData->diff_billing == 0 ? 'd-none' : ''}}" data-billing>
                                        <div class="row form-inline my-3">
                                            <div class="form-group col-md-12">
                                                <strong>{{__('forms.exhibitor_form.data_billing.heading')}}</strong>
                                                <input type="text" name="receiver" class="form-control w-100" value="{{$userData->receiver}}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-8">
                                                <strong>{{__('forms.exhibitor_form.data_billing.address')}}</strong>
                                                <input type="text" name="receiver_address" class="form-control w-100" value="{{$userData->receiver_address}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <strong>{{__('forms.exhibitor_form.data_billing.civic_number')}}</strong>
                                                <input type="text" name="receiver_civic_number" class="form-control w-100" value="{{$userData->receiver_civic_number}}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <strong>{{__('forms.exhibitor_form.data_billing.city')}}</strong>
                                                <input type="text" name="receiver_city" class="form-control w-100" value="{{$userData->receiver_city}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <strong>{{__('forms.exhibitor_form.data_billing.postal_code')}}</strong>
                                                <input type="text" name="receiver_cap" class="form-control w-100" value="{{$userData->receiver_cap}}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <strong>{{__('forms.exhibitor_form.data_billing.province')}}</strong>
                                                <input type="text" name="receiver_province" class="form-control w-100" value="{{$userData->receiver_province}}">
                                            </div>
                                        </div>
                                        <div class="row form-inline">
                                            <div class="form-group col-md-4">
                                                <strong>{{__('forms.exhibitor_form.data_billing.fiscal_code')}}</strong>
                                                <input type="text" name="receiver_fiscal_code" class="form-control w-100" value="{{$userData->receiver_fiscal_code}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <strong>{{__('forms.exhibitor_form.data_billing.vat_number')}} *</strong>
                                                <input type="text" name="receiver_vat_number" class="form-control w-100" value="{{$userData->receiver_vat_number}}">
                                            </div>
                                            <div class="form-group col-md-4 {{ App::getLocale() == 'en' ? 'd-none' : '' }}">
                                                <strong>{{__('forms.exhibitor_form.data_billing.uni_code')}} *</strong>
                                                <input type="text" name="receiver_uni_code" class="form-control w-100" value="{{$userData->receiver_uni_code}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const updatePsw = (el) => {
        $(el).toggleClass('d-none');
        $('#spinner').toggleClass('d-none');
        common_request.post('/admin/profile/change-password', {
            password: $('input[name="password"]').val(),
            new_password: $('input[name="new_password"]').val()
        })
        .then(response => {
            $(el).toggleClass('d-none');
            $('#spinner').toggleClass('d-none');
            let data = response.data
            if(data.status) {
                toastr.success(data.message)
            } else {
                toastr.error(data.message)
            }
        })
        .catch(error => {
            $(el).toggleClass('d-none');
            $('#spinner').toggleClass('d-none');
            toastr.error(error)
            console.log(error)
        })
    }
    const saveData = (el) => {
        $(el).toggleClass('d-none');
        $('#spinner').toggleClass('d-none');
        let selected_lang = "{{App::getLocale()}}"
        common_request.post('/admin/profile/save-data', {
            email: $('input[name="email"]').val(),
            company: $('input[name="company"]').val(),
            address: $('input[name="address"]').val(),
            civic_number: $('input[name="civic_number"]').val(),
            city: $('input[name="city"]').val(),
            cap: $('input[name="cap"]').val(),
            province: $('input[name="province"]').val(),
            phone: $('input[name="phone"]').val(),
            fax: $('input[name="fax"]').val(),
            web: $('input[name="web"]').val(),
            responsible: $('input[name="responsible"]').val(),
            phone_responsible: $('input[name="phone_responsible"]').val(),
            fiscal_code: $('input[name="fiscal_code"]').val(),
            vat_number: $('input[name="vat_number"]').val(),
            uni_code: $('input[name="uni_code"]').val(),
            diff_billing: $('#diff_billing').val() == 'yes' ? 1 : 0,
            receiver: $('input[name="receiver"]').val(),
            receiver_address: $('input[name="receiver_address"]').val(),
            receiver_civic_number: $('input[name="receiver_civic_number"]').val(),
            receiver_city: $('input[name="receiver_city"]').val(),
            receiver_cap: $('input[name="receiver_cap"]').val(),
            receiver_province: $('input[name="receiver_province"]').val(),
            receiver_fiscal_code: $('input[name="receiver_fiscal_code"]').val(),
            receiver_vat_number: $('input[name="receiver_vat_number"]').val(),
            receiver_uni_code: $('input[name="receiver_uni_code"]').val(),
            password: $('input[name="password"]').val(),
            new_password: $('input[name="new_password"]').val()
        })
        .then(response => {
            $(el).toggleClass('d-none');
            $('#spinner').toggleClass('d-none');
            let data = response.data
            if(data.status) {
                toastr.success(data.message)
            } else {
                toastr.error(data.message)
            }
        })
        .catch(error => {
            $(el).toggleClass('d-none');
            $('#spinner').toggleClass('d-none');
            toastr.error(error)
            console.log(error)
        })
    }
    $(document).ready(function() {
        let selected_lang = "{{App::getLocale()}}"
        if(selected_lang.trim() == 'it') {
            $('input[name="uni_code"]').attr('required', true)
        } else {
            $('input[name="uni_code"]').removeAttr('required')
        }

        $('#diff_billing').on('change', function() {
            let selected_lang = "{{App::getLocale()}}"
            $('[data-billing]').toggleClass('d-none');
            if($(this).val() == 'yes') {
                $('input[name="receiver_vat_number"]').attr('required', true)
                if(selected_lang.trim() == 'it') {
                    $('input[name="receiver_uni_code"]').attr('required', true)
                }
            } else {
                $('input[name="receiver_vat_number"]').removeAttr('required')
                if(selected_lang.trim() == 'it') {
                    $('input[name="receiver_uni_code"]').removeAttr('required')
                }
            }
        });
    });
</script>
@endsection
