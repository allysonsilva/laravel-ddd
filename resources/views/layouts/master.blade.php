<!DOCTYPE html>
<html lang="pt-br">

    @hasSection('head', true)
    <!-- Head -->
    @head
    @endhead
    <!-- Head -->
    @endif

    <body class="@yield('bodyClass', 'app')">

        <!-- Wrapper -->
        <div class="app-wrapper app-fixed-sidebar @yield('classWrapper')">

            @hasSection('navigation', true)
            <!-- Header -->
            @navigation
            @endnavigation
            <!-- Header -->
            @endif

            <!-- Section -->
            <section>

                @hasSection('left-sidebar', true)
                <!-- Left -->
                @left
                @endleft
                <!-- Left -->
                @endif

                <div class="app-content">
                    <main>
                        <!-- Main content -->
                        @yield('content')
                        <!-- Main content -->
                    </main>
                </div>

            </section>
            <!-- Section -->

        </div>
        <!-- Wrapper -->

        <!-- Footer -->
        @footer
        @endfooter
        <!-- Footer -->

        <!-- Scripts -->
        @scripts
        @endscripts
        <!-- Scripts -->

        <!-- Notifications // Messages -->
        @notifications
        @endnotifications
        <!-- Notifications // Messages -->

    </body>

</html>
