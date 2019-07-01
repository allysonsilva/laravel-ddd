@section('notifications')
    <!-- **** MESSAGES ALERTS **** -->
    <script nonce="3VrLCT9ctX">
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
            theme: 'flat'
        };

        @if (session()->has('error'))
            Messenger().post({
                message: "{{ session()->get('error') }}",
                type: 'error',
                showCloseButton: true
            });
        @endif

        @if (session()->has('success'))
            Messenger().post({
                message: "{{ session()->get('success') }}",
                type: 'success',
                showCloseButton: true
            });
        @endif

        @if (session()->has('info'))
            Messenger().post({
                message: "{{ session()->get('info') }}",
                type: 'info',
                showCloseButton: true
            });
        @endif

        @if ($errors->any())
            @foreach($errors->all() as $message)
                @php
                    $message = html_entity_decode(strip_tags(trim(preg_replace("/\r|\n/", "", $message))));
                @endphp

                Messenger().post({
                    message: "{{ $message }}",
                    type: 'error',
                    showCloseButton: true
                });
            @endforeach
        @endif
    </script>
    <!-- **** MESSAGES ALERTS END **** -->
@show
