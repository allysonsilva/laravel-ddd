@section('notifications')
    <script>
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
            theme: 'flat'
        };
    </script>

    <!-- **** MESSAGES ALERTS **** -->
    @if (session()->has('error'))
        <script>
            Messenger().post({
                message: "{{ session()->get('error') }}",
                type: 'error',
                showCloseButton: true
            });
        </script>
    @endif

    @if (session()->has('success'))
        <script>
            Messenger().post({
                message: "{{ session()->get('success') }}",
                type: 'success',
                showCloseButton: true
            });
        </script>
    @endif

    @if (session()->has('info'))
        <script>
            Messenger().post({
                message: "{{ session()->get('info') }}",
                type: 'info',
                showCloseButton: true
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
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
        </script>
    @endif
    <!-- **** MESSAGES ALERTS END **** -->
@show
