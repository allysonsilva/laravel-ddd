<!DOCTYPE html>
<html lang="pt-br">
    <!-- Head -->
    @head
    @endhead
    <!-- Head -->

    <body class="@yield('bodyClass', 'app')">

        <!-- Wrapper -->
        <div class="app-wrapper app-fixed-sidebar @yield('classWrapper')">

            <!-- Header -->
            @navigation
            @endnavigation
            <!-- Header -->

            <!-- Section -->
            <section>

                <!-- Left -->
                @leftSidebar
                @endleftSidebar
                <!-- Left -->

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
