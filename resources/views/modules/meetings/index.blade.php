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
                                    <div class="col-4" id="waraper_start_date">
                                        <div class="form-group">
                                            <label>Duration</label>
                                            <select class="form-control" id="duration" name="duration" disabled>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <select name="date" id="date" class="form-control" disabled>
                                                <option value="">--Select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Time</label>
                                            <select class="form-control" id="time" name="time" disabled>
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

        function generateTimeIntervals(start_time, end_time, interval_minutes) {
            const intervals = [];
            const startTime = new Date(`1970-01-01T${start_time}`);
            const endTime = new Date(`1970-01-01T${end_time}`);

            if (startTime >= endTime) {
                return intervals;
            }

            let currentTime = startTime;

            while (currentTime < endTime) {
                const formattedStartTime = currentTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const intervalEndTime = new Date(currentTime.getTime() + interval_minutes * 60000);

                if (intervalEndTime > endTime) {
                    break;
                }

                const formattedEndTime = intervalEndTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                intervals.push(`${formattedStartTime} to ${formattedEndTime}`);

                if (interval_minutes > 30) {
                    const nextIntervalStartTime = new Date(currentTime.getTime() + 30 * 60000);
                    currentTime = nextIntervalStartTime;
                } else {
                    currentTime = intervalEndTime;
                }
            }

            return intervals;
        }

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
                        console.log("Complated");
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
                var $date = $("#date");
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

            $("#date").change(function() {
                var date = $(this).val();
                var duration = $("#duration").val();
                var userIds = $("#users").val();

                $.ajax({
                    url: "{{ route('meetings.times') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_ids: userIds,
                        duration: duration,
                        date: date
                    },
                    success: function(res) {
                        console.log(res);
                        var timeIntervals = generateTimeIntervals(res.times[0].start_time, res
                            .times[0].end_time,
                            parseInt(duration));

                        if (timeIntervals.length > 0) {
                            $('#time').prop('disabled', false);
                        }

                        var $time = $("#time");
                        $time.empty();

                        $time.append(`<option value="">--Select--</option>`);
                        for (var i = 0; i < timeIntervals.length; i++) {
                            $time.append(
                                `<option value="${timeIntervals[i]}">${timeIntervals[i]}</option>`
                            );
                        }
                    }
                });
            })

            // $(document).on('change', '.times', function() {
            //     var startTime = $('#start_time').val();
            //     var endTime = $('#end_time').val();

            //     if (startTime != '' && endTime != '') {
            //         if (startTime > endTime) {
            //             alert('Start time must be less than end time');
            //             $(this).val('');
            //         }
            //     }
            // });
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
