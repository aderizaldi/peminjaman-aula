<div>
    <!-- Toastr Notification -->
    @script
    <script>
        $wire.on('show-toast', (event) => {
            toastr[event[0].status](event[0].message, '', {
                "closeButton": true
                , "debug": false
                , "newestOnTop": false
                , "progressBar": false
                , "positionClass": "toast-top-right"
                , "preventDuplicates": false
                , "onclick": null
                , "showDuration": "300"
                , "hideDuration": "1000"
                , "timeOut": "5000"
                , "extendedTimeOut": "1000"
                , "showEasing": "swing"
                , "hideEasing": "linear"
                , "showMethod": "fadeIn"
                , "hideMethod": "fadeOut"
            , });
        });

    </script>
    @endscript

    @if(session()->has('showToast'))
    @script
    <script>
        let notif = @js(session('showToast'));
        $nextTick(() => {
            $wire.$dispatch('showToast', {
                'status': notif.status
                , 'message': notif.message
            });
        });

    </script>
    @endscript
    @endif
</div>
