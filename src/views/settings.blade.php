@extends('layouts/layoutMaster')

@section('title', 'Account settings - Account')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-body">
                        <ul class="nav nav-pills ps-4 mb-4" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-tab-general" aria-controls="settings-tab-general"
                                    aria-selected="true">{{ trans('generals.generals') }}</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-tab-email" aria-controls="settings-tab-email"
                                    aria-selected="false">{{ trans('generals.email_texts') }}</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-tab-subscription" aria-controls="settings-tab-subscription"
                                    aria-selected="false">{{ trans('generals.subscription_texts') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="settings-tab-general" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('save-settings-generals') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>{{ trans('forms.select_app_brand') }}</label>
                                                <input type="file" name="file" class="form-control account-file-input"
                                                    accept="image/png, image/gif, image/jpeg, image/bmp"
                                                    value="{{ old('file') }}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="iva"
                                                    class="form-label">{{ trans('forms.select_iva') }}</label>
                                                <input class="form-control" step=".01" type="number" id="iva"
                                                    name="iva" value="{{ $settings->iva }}" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary me-2 mt-2"><i
                                                        class="fas"></i>
                                                    {{ trans('generals.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings-tab-email" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="list-group" id="list-tab" role="tablist">
                                                    <button type="button"
                                                        class="list-group-item list-group-item-action active"
                                                        id="list-pending-list" data-toggle="list" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#list-pending"
                                                        aria-controls="list-pending">{{ trans('forms.pending_email_item') }}</button>
                                                    <button type="button" class="list-group-item list-group-item-action"
                                                        id="list-admit-list" data-toggle="list" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#list-admit"
                                                        aria-controls="admit">{{ trans('forms.admit_email_item') }}</button>
                                                    <button type="button" class="list-group-item list-group-item-action"
                                                        id="list-confirm-order-list" data-toggle="list"
                                                        href="#list-confirm-order" role="tab" data-bs-toggle="tab"
                                                        data-bs-target="#list-confirm-order"
                                                        aria-controls="confirm-order">{{ trans('forms.confirm_order_email_item') }}</button>
                                                    <button type="button" class="list-group-item list-group-item-action"
                                                        id="list-event-subscription-list" data-toggle="list"
                                                        href="#list-event-subscription" role="tab" data-bs-toggle="tab"
                                                        data-bs-target="#list-event-subscription"
                                                        aria-controls="event-subscription">{{ trans('forms.event_subscription_email_item') }}</button>
                                                    <button type="button" class="list-group-item list-group-item-action"
                                                        id="list-registration-list" data-toggle="list"
                                                        href="#list-registration" role="tab" data-bs-toggle="tab"
                                                        data-bs-target="#list-registration"
                                                        aria-controls="registration">{{ trans('forms.registration_email_item') }}</button>
                                                    <button type="button" class="list-group-item list-group-item-action"
                                                        id="list-marketing-list" data-toggle="list"
                                                        href="#list-marketing" role="tab" data-bs-toggle="tab"
                                                        data-bs-target="#list-marketing"
                                                        aria-controls="marketing">{{ trans('forms.marketing_email_item') }}</button>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <form action="{{ route('save-settings-emails') }}" method="POST"
                                                    id="save-settings-emails">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="tab-content" id="nav-tabContent">
                                                            <div class="tab-pane fade show active" id="list-pending"
                                                                role="tabpanel" aria-labelledby="list-pending-list">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_pending_admit_exhibitor_it') }}</label>
                                                                            <div name="email_pending_admit_exhibitor_it"
                                                                                class = "summernote"
                                                                                id="email_pending_admit_exhibitor_it">
                                                                                {!! $settings->email_pending_admit_exhibitor_it !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_pending_admit_exhibitor_en') }}</label>
                                                                            <div name="email_pending_admit_exhibitor_en"
                                                                                class="form-control summernote"
                                                                                id="email_pending_admit_exhibitor_en">
                                                                                {!! $settings->email_pending_admit_exhibitor_en !!}</div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_to_admin_pending_notification_admit') }}</label>
                                                                            <div name="email_to_admin_pending_notification_admit"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_to_admin_pending_notification_admit !!}
                                                                            </div>
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
                                                                            <div name="email_admit_exhibitor_it"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_admit_exhibitor_it !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_admit_exhibitor_en') }}</label>
                                                                            <div name="email_admit_exhibitor_en"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_admit_exhibitor_en !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_to_admin_notification_admit') }}</label>
                                                                            <div name="email_to_admin_notification_admit"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_to_admin_notification_admit !!}
                                                                            </div>
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
                                                                            <div name="email_confirm_order_it"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_confirm_order_it !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_confirm_order_en') }}</label>
                                                                            <div name="email_confirm_order_en"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_confirm_order_en !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_to_admin_notification_confirm_order') }}</label>
                                                                            <div name="email_to_admin_notification_confirm_order"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_to_admin_notification_confirm_order !!}
                                                                            </div>
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
                                                                            <div name="email_event_subscription_it"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_event_subscription_it !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_event_subscription_en') }}</label>
                                                                            <div name="email_event_subscription_en"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_event_subscription_en !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="list-registration"
                                                                role="tabpanel" aria-labelledby="list-registration-list">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_registration_it') }}</label>
                                                                            <div name="email_registration_it"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_registration_it !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_registration_en') }}</label>
                                                                            <div name="email_registration_en"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_registration_en !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="list-marketing"
                                                                role="tabpanel" aria-labelledby="list-marketing-list">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_remarketing_it') }}</label>
                                                                            <div name="email_remarketing_it"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_remarketing_it !!}
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{ trans('forms.text_email_remarketing_en') }}</label>
                                                                            <div name="email_remarketing_en"
                                                                                class="form-control summernote"
                                                                                rows="10">{!! $settings->email_remarketing_en !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary me-2 mt-2"><i
                                                                class="fas"></i>
                                                            {{ trans('generals.save') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings-tab-subscription" role="tabpanel">
                                <input type="hidden" name="auth-email" value="{{ $email }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive p-3">
                                            <table class="datatables-basic table table-hover text-nowrap">
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

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script>
        function createEditor(id) {
            const quill = new Quill(id, {
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                    ],
                },
                theme: 'snow', // or 'bubble'
            });
            return quill;
        }
        const editors = document.querySelectorAll('.summernote');
        const quills = [];
        editors.forEach(editor => {
            quills.push(createEditor(editor));
        });

        // send quill data to textarea
        const form = document.getElementById('save-settings-emails');
        form.addEventListener('formdata', (event) => {
            quills.forEach((quill, i) => {
                event.formData.append(editors[i].getAttribute('name'), JSON.stringify(quill.getContents()));
            });
        });

        let oldValue = {!! json_encode($settings->email_pending_admit_exhibitor_it) !!};
        oldValue = JSON.parse(oldValue);
        quills[0].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_pending_admit_exhibitor_en) !!};
        oldValue = JSON.parse(oldValue);
        quills[1].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_to_admin_pending_notification_admit) !!};
        oldValue = JSON.parse(oldValue);
        quills[2].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_admit_exhibitor_it) !!};
        oldValue = JSON.parse(oldValue);
        quills[3].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_admit_exhibitor_en) !!};
        oldValue = JSON.parse(oldValue);
        quills[4].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_to_admin_notification_admit) !!};
        oldValue = JSON.parse(oldValue);
        quills[5].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_confirm_order_it) !!};
        oldValue = JSON.parse(oldValue);
        quills[6].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_confirm_order_en) !!};
        oldValue = JSON.parse(oldValue);
        quills[7].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_to_admin_notification_confirm_order) !!};
        oldValue = JSON.parse(oldValue);
        quills[8].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_event_subscription_it) !!};
        oldValue = JSON.parse(oldValue);
        quills[9].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_event_subscription_en) !!};
        oldValue = JSON.parse(oldValue);
        quills[10].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_registration_it) !!};
        oldValue = JSON.parse(oldValue);
        quills[11].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_registration_en) !!};
        oldValue = JSON.parse(oldValue);
        quills[12].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_remarketing_it) !!};
        oldValue = JSON.parse(oldValue);
        quills[13].setContents(oldValue);

        oldValue = {!! json_encode($settings->email_remarketing_en) !!};
        oldValue = JSON.parse(oldValue);
        quills[14].setContents(oldValue);

        $(document).ready(function() {
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
                    $('form button[data-type="subscription-form"]').on('click', function(e) {
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
                                        <button data-type="subscription-form" data-toggle="tooltip" data-placement="top" title="{{ trans('generals.cancel') }}" class="btn btn-default" type="submit"><i class="fa fa-times"></i></button>
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
