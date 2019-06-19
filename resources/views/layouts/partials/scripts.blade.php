<script src="{{ mix('/js/bootstrap.js') }}"></script>
<script src="{{ mix('/js/libs.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>

<script>
    ;(function($) {
        $(document).ready(function() {
            App.init();
        });
    })(jQuery);
</script>

@stack('scripts')
