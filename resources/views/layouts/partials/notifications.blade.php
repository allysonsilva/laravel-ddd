@section('notifications')

    @php
        $cleanMessage = function($message): string {
            return html_entity_decode(strip_tags(trim(preg_replace("/\r|\n/", "", $message))));
        };
    @endphp

    <!-- **** MESSAGES ALERTS **** -->
    <script nonce="3VrLCT9ctX">
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
            theme: 'flat'
        };

        @empty(! $error = session('error'))
            Messenger().post({
                message: "{{ $cleanMessage($error) }}",
                type: 'error',
                showCloseButton: true
            });
        @endempty

        @empty(! $success = session('success'))
            Messenger().post({
                message: "{{ $cleanMessage($success) }}",
                type: 'success',
                showCloseButton: true
            });
        @endempty

        @empty(! $info = session('info'))
            Messenger().post({
                message: "{{ $cleanMessage($info) }}",
                type: 'info',
                showCloseButton: true
            });
        @endempty

        @if ($errors->any())
            @foreach($errors->all() as $message)

                Messenger().post({
                    message: "{{ $cleanMessage($message) }}",
                    type: 'error',
                    showCloseButton: true
                });

            @endforeach
        @endif
    </script>
    <!-- **** MESSAGES ALERTS END **** -->
@show
