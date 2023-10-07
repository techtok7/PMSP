<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

@if (session('success'))
    <script>
        toastr.success('{{ session('success') }}')
    </script>
@endif

@if (session('error'))
    <script>
        toastr.error('{{ session('error') }}')
    </script>
@endif

@if (session('errors'))
    <script>
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}')
        @endforeach
    </script>
@endif
