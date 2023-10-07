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
                    <h1 class="m-0">Availability</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Availability</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('availabilities.store') }}" method="post">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-primary"
                            style="transition: all 0.15s ease 0s; height: inherit; width: inherit;">
                            <div class="card-header">
                                <h3 class="card-title">Add Availability</h3>
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
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>Single date
                                                </option>
                                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>Multiple
                                                    dates
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4" id="waraper_start_date">
                                        <div class="form-group">
                                            <label id="label_start_date">Date</label>
                                            <input type="date" name="start_date" id="start_date"
                                                value="{{ old('start_date', date('Y-m-d')) }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-2" id="waraper_end_date" style="display: none;">
                                        <div class="form-group">
                                            <label id="label_end_date">End Date</label>
                                            <input type="date" name="end_date"
                                                id="end_date"value="{{ old('end_date', date('Y-m-d')) }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label id="label_start_time">Start time</label>
                                            <select class="form-control times" id="start_time" name="start_time">
                                                <option value="">--Select--</option>
                                                @foreach (config('constants.times') as $time)
                                                    <option value="{{ $time }}"
                                                        {{ old('start_time') == $time ? 'selected' : '' }}>
                                                        {{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label id="label_end_time">End time</label>
                                            <select class="form-control times" name="end_time" id="end_time">
                                                <option value="">--Select--</option>
                                                @foreach (config('constants.times') as $time)
                                                    <option value="{{ $time }}"
                                                        {{ old('end_time') == $time ? 'selected' : '' }}>
                                                        {{ $time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Days</label>
                                            <select class="select2" multiple="multiple" data-placeholder="Select a State"
                                                style="width: 100%;" name="days[]">
                                                <option value="monday"
                                                    {{ in_array('monday', old('days', [])) ? 'selected' : '' }}>
                                                    Monday
                                                </option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var wrapperStartDate = $('#waraper_start_date');
        var wrapperEndDate = $('#waraper_end_date');
        var labelStartDate = $('#label_start_date');

        $(document).ready(function() {
            $('#type').on('change', function() {
                if (this.value == 1) {
                    wrapperEndDate.fadeOut();
                    wrapperStartDate.removeClass('col-2').addClass('col-4');
                    labelStartDate.text('Date');
                } else {
                    wrapperStartDate.removeClass('col-4').addClass('col-2');
                    wrapperEndDate.fadeIn();
                    labelStartDate.text('Start Date');
                }
            });

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
                        var isBatch = row?.availability_batch ? true : false;

                        var html = '';

                        if (isBatch)
                            html += 'View Batch';

                        return html;
                    }
                }],
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
    </script>
@endpush
