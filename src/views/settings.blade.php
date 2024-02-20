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
                                <a class="nav-link active" id="settings-tab-generals" data-toggle="pill"
                                    href="#settings-tab-general" role="tab" aria-controls="settings-tab-general"
                                    aria-selected="true">{{ trans('generals.generals') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab-emails" data-toggle="pill" href="#settings-tab-email"
                                    role="tab" aria-controls="settings-tab-email"
                                    aria-selected="false">{{ trans('generals.email_texts') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab-subscriptions" data-toggle="pill"
                                    href="#settings-tab-subscription" role="tab"
                                    aria-controls="settings-tab-subscription"
                                    aria-selected="false">{{ trans('generals.subscription_texts') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="settingsTabContent">
                            <div class="tab-pane fade show active" id="settings-tab-general" role="tabpanel"
                                aria-labelledby="settings-tab-generals">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('save-settings-generals') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>{{ trans('forms.select_app_brand') }}</label>
                                                <input type="file" name="file" class="form-control"
                                                    value="{{ old('file') }}"
                                                    accept="image/png, image/gif, image/jpeg, image/bmp">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ trans('forms.select_iva') }}</label>
                                                <input type="number" step=".01" name="iva" class="form-control"
                                                    value="{{ $settings->iva }}">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                                                    {{ trans('generals.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings-tab-email" role="tabpanel"
                                aria-labelledby="settings-tab-emails">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="list-group" id="list-tab" role="tablist">
                                                    <a class="list-group-item list-group-item-action active"
                                                        id="list-pending-list" data-toggle="list" href="#list-pending"
                                                        role="tab"
                                                        aria-controls="pending">{{ trans('forms.pending_email_item') }}</a>
                                                    <a class="list-group-item list-group-item-action" id="list-admit-list"
                                                        data-toggle="list" href="#list-admit" role="tab"
                                                        aria-controls="admit">{{ trans('forms.admit_email_item') }}</a>
                                                    <a class="list-group-item list-group-item-action"
                                                        id="list-confirm-order-list" data-toggle="list"
                                                        href="#list-confirm-order" role="tab"
                                                        aria-controls="confirm-order">{{ trans('forms.confirm_order_email_item') }}</a>
                                                    <a class="list-group-item list-group-item-action"
                                                        id="list-event-subscription-list" data-toggle="list"
                                                        href="#list-event-subscription" role="tab"
                                                        aria-controls="event-subscription">{{ trans('forms.event_subscription_email_item') }}</a>
                                                    <a class="list-group-item list-group-item-action"
                                                        id="list-registration-list" data-toggle="list"
                                                        href="#list-registration" role="tab"
                                                        aria-controls="registration">{{ trans('forms.registration_email_item') }}</a>
                                                    <a class="list-group-item list-group-item-action"
                                                        id="list-marketing-list" data-toggle="list"
                                                        href="#list-marketing" role="tab"
                                                        aria-controls="marketing">{{ trans('forms.marketing_email_item') }}</a>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <form action="{{ route('save-settings-emails') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-success"><i
                                                                class="fas fa-save"></i>
                                                            {{ trans('generals.save') }}</button>
                                                    </div>
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="list-pending"
                                                            role="tabpanel" aria-labelledby="list-pending-list">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_pending_admit_exhibitor_it') }}</label>
                                                                        <textarea name="email_pending_admit_exhibitor_it" class="form-control summernote" rows="10">{!! $settings->email_pending_admit_exhibitor_it !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_pending_admit_exhibitor_en') }}</label>
                                                                        <textarea name="email_pending_admit_exhibitor_en" class="form-control summernote" rows="10">{!! $settings->email_pending_admit_exhibitor_en !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_to_admin_pending_notification_admit') }}</label>
                                                                        <textarea name="email_to_admin_pending_notification_admit" class="form-control summernote" rows="10">{!! $settings->email_to_admin_pending_notification_admit !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="tab-pane fade" id="list-admit" role="tabpanel"
                                                            aria-labelledby="list-admit-list">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_admit_exhibitor_it') }}</label>
                                                                        <textarea name="email_admit_exhibitor_it" class="form-control summernote" rows="10">{!! $settings->email_admit_exhibitor_it !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_admit_exhibitor_en') }}</label>
                                                                        <textarea name="email_admit_exhibitor_en" class="form-control summernote" rows="10">{!! $settings->email_admit_exhibitor_en !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_to_admin_notification_admit') }}</label>
                                                                        <textarea name="email_to_admin_notification_admit" class="form-control summernote" rows="10">{!! $settings->email_to_admin_notification_admit !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="list-confirm-order"
                                                            role="tabpanel" aria-labelledby="list-confirm-order-list">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_confirm_order_it') }}</label>
                                                                        <textarea name="email_confirm_order_it" class="form-control summernote" rows="10">{!! $settings->email_confirm_order_it !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_confirm_order_en') }}</label>
                                                                        <textarea name="email_confirm_order_en" class="form-control summernote" rows="10">{!! $settings->email_confirm_order_en !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_to_admin_notification_confirm_order') }}</label>
                                                                        <textarea name="email_to_admin_notification_confirm_order" class="form-control summernote" rows="10">{!! $settings->email_to_admin_notification_confirm_order !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="list-event-subscription"
                                                            role="tabpanel"
                                                            aria-labelledby="list-event-subscription-list">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_event_subscription_it') }}</label>
                                                                        <textarea name="email_event_subscription_it" class="form-control summernote" rows="10">{!! $settings->email_event_subscription_it !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_event_subscription_en') }}</label>
                                                                        <textarea name="email_event_subscription_en" class="form-control summernote" rows="10">{!! $settings->email_event_subscription_en !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="list-registration" role="tabpanel"
                                                            aria-labelledby="list-registration-list">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_registration_it') }}</label>
                                                                        <textarea name="email_registration_it" class="form-control summernote" rows="10">{!! $settings->email_registration_it !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_registration_en') }}</label>
                                                                        <textarea name="email_registration_en" class="form-control summernote" rows="10">{!! $settings->email_registration_en !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="list-marketing" role="tabpanel"
                                                            aria-labelledby="list-marketing-list">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_remarketing_it') }}</label>
                                                                        <textarea name="email_remarketing_it" class="form-control summernote" rows="10">{!! $settings->email_remarketing_it !!}</textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>{{ trans('forms.text_email_remarketing_en') }}</label>
                                                                        <textarea name="email_remarketing_en" class="form-control summernote" rows="10">{!! $settings->email_remarketing_en !!}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings-tab-subscription" role="tabpanel"
                                aria-labelledby="settings-tab-subscriptions">
                                <input type="hidden" name="auth-email" value="{{ $email }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive p-3">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('tables.type') }}</th>
                                                        <th>{{ trans('tables.status') }}</th>
                                                        <th>{{ trans('tables.trial_ends_at') }}</th>
                                                        <th>{{ trans('tables.ends_at') }}</th>
                                                        <th>{{ trans('tables.created_at') }}</th>
                                                        <th>{{ trans('tables.updated_a') }}</th>
                                                        <th class="no-sort">{{ trans('tables.actions') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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
        $(document).ready(function() {
            $('.summernote').summernote();
            $('.note-btn-group.btn-group.note-insert').hide()

            $('table').DataTable({
                processing: true,
                serverSide: true,
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": false,
                ajax: {
                    url: "https://manager-fieroo.belicedigital.com/api/stripe/" + $(
                            'input[name="auth-email"]').val() +
                        "/subscriptions",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    contetType: false,
                    processData: false,
                    dataSrc: 'subscriptions',
                },
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip()
                    $('form button').on('click', function(e) {
                        var $this = $(this);
                        e.preventDefault();
                        Swal.fire({
                            title: "{!! trans('generals.confirm_remove') !!}",
                            showCancelButton: true,
                            confirmButtonText: "{{ trans('generals.confirm') }}",
                            cancelButtonText: "{{ trans('generals.cancel') }}",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $this.closest('form').submit();
                            }
                        })
                    });
                },
                // createdRow: function(row, data, index) {
                //     // $(row).attr({
                //     //     'data-id': data['id']
                //     // })
                // },
                columns: [{
                        data: 'type'
                    },
                    {
                        data: 'stripe_status'
                    },
                    {
                        data: 'trial_ends_at'
                    },
                    {
                        data: 'ends_at'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let destroy_href =
                                'https://manager-fieroo.belicedigital.com/api/stripe/cancel-subscription';
                            let subscription_id = row['id']
                            let subscription_type = row['type']
                            return `
                                <div class="btn-group" role="group">
                                    <form action=${destroy_href} method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value=${subscription_id}>
                                        <input type="hidden" name="type" value=${subscription_type}>
                                        <button data-toggle="tooltip" data-placement="top" title="{{ trans('generals.cancel') }}" class="btn btn-default" type="submit"><i class="fa fa-times"></i></button>
                                    </form>
                                </div>
                                `
                        }
                    }
                ],
                columnDefs: [{
                    orderable: false,
                    targets: "no-sort"
                }],
                "oLanguage": {
                    "sSearch": "{{ trans('generals.search') }}",
                    "oPaginate": {
                        "sFirst": "{{ trans('generals.start') }}", // This is the link to the first page
                        "sPrevious": "«", // This is the link to the previous page
                        "sNext": "»", // This is the link to the next page
                        "sLast": "{{ trans('generals.end') }}" // This is the link to the last page
                    }
                }
            });

        });
    </script>
@endsection
