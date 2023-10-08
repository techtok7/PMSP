@extends('layouts.app')

@section('content')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff !important;
            border: #007bff !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Meetings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Meetings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form
                action="{{ isset($availability) ? route('availabilities.update', $availability->id) : route('availabilities.store') }}"
                method="post">
                @if (isset($availability))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-primary"
                            style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ isset($availability) ? 'Edit' : 'Add' }} Availability
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Participants</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select a State"
                                                style="width: 100%;" name="users[]" id="users">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3" id="waraper_start_date">
                                        <div class="form-group">
                                            <label id="label_start_date">Date</label>
                                            <select class="form-control" id="duration" name="duration" disabled>
                                                <option value="">--Select--</option>
                                                <option value="30">30 Minutes</option>
                                                <option value="60">60 Minutes</option>
                                                <option value="120">120 Minutes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label id="label_start_date">Date</label>
                                            <select name="date" id="date" class="form-control" disabled>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label id="label_start_time">Start time</label>
                                            <select class="form-control times" id="start_time" name="start_time" disabled>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label id="label_end_time">End time</label>
                                            <select class="form-control times" name="end_time" id="end_time" disabled>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($availability) ? 'Update' : 'Add' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if (!isset($availability))
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-primary"
                            style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                            <div class="card-header">
                                <h3 class="card-title">All Availabilities</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">
                                <table id="mytable">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var duration = $('#duration');
        $(document).ready(function() {
            $('#users').on('change', function() {
                var userIds = $(this).val();

                $.ajax({
                    url: "{{ route('meetings.duration') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_ids: userIds
                    },
                    success: function(res) {
                        var minimum_duration = res.minimum_duration;
                        var maximum_duration = res.maximum_duration;

                        duration.empty();

                        var flag = false;

                        duration.append(`<option value="">--Select--</option>`);
                        for (var i = minimum_duration; i <= maximum_duration; i += 30) {
                            duration.append(`<option value="${i}">${i} Minutes</option>`);
                            flag = true;
                        }

                        duration.prop('disabled', !flag);
                    }
                });
            });

            $("#duration").change(function() {
                var $date = $(this);
                var value = $(this).val();

                if (value != '') {
                    $('#date').prop('disabled', false);
                } else {
                    $('#date').prop('disabled', true);
                }

                var userIds = $("#users").val();

                $.ajax({
                    url: "{{ route('meetings.dates') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_ids: userIds,
                        minutes: value
                    },
                    success: function(res) {
                        console.log(res);
                        $date.empty();

                        $date.append(`<option value="">--Select--</option>`);
                        var dates = res.dates;
                        console.log(dates);
                        for (var i = 0; i < dates.length; i++) {
                            console.log(dates[i]);
                            $date.append(`<option value="${dates[i]}">${dates[i]}</option>`);
                        }
                    }
                });
            });

            $(document).on('change', '.times', function() {
                var startTime = $('#start_time').val();
                var endTime = $('#end_time').val();

                if (startTime != '' && endTime != '') {
                    if (startTime > endTime) {
                        alert('Start time must be less than end time');
                        $(this).val('');
                    }
                }
            });
        });
    </script>
    @if (!isset($availability))
        <script>
            $(document).ready(function() {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('availabilities.datatable') }}",
                    columns: [{
                        data: 'date',
                        name: 'date',
                        title: 'Date'
                    }, {
                        data: 'start_time',
                        name: 'start_time',
                        title: 'Start Time'
                    }, {
                        data: 'end_time',
                        name: 'end_time',
                        title: 'End Time'
                    }, {
                        data: 'day',
                        name: 'day',
                        title: 'Day',
                        render: function(data, type, row) {
                            return ucfirst(data);
                        }
                    }, {
                        data: 'id',
                        name: 'id',
                        title: 'Action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {

                            var html = '';
                            html += `
                            <a href="{{ route('availabilities.edit', ':id') }}" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                        `.replace(':id', data);

                            html += `
                            <a href="{{ route('availabilities.destroy', ':id') }}" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this availability?')"><i class="fa fa-trash"></i></a>
                        `.replace(':id', data);

                            /*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    html += `
                        <a href="{{ route('availabilities.show', ':id') }}" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                    `.replace(':id', data);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    */



                            return html;
                        }
                    }, {
                        data: 'id',
                        name: 'id',
                        title: 'Batch',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            var isBatch = row?.availability_batch ? true : false;
                            var html = '';
                            if (isBatch)
                                html += `
                                <a href="{{ route('availability-batches.show', ':id') }}" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                            `.replace(':id', data);

                            return html;
                        }
                    }],
                });
            });
        </script>
    @endif
@endpush
