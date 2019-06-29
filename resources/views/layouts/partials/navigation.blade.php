<nav class="navbar @section('classNavTop') navbar-default navbar-expand fixed-top app-top-header @show">
    <div class="container-fluid">
        <div class="app-navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}"></a>
        </div>

        <div class="page-title">
            <span>@section('pageTitle') {{ config('app.name') }} @show</span>
        </div>

        <div class="app-right-navbar">
            <ul class="nav navbar-nav float-right app-user-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img src="{{ asset('images/avatar.png') }}" alt="Avatar">
                        <span class="user-name">{{ optional(auth()->user())->name ?? 'Profile Name' }}</span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <div class="user-info">
                            <div class="user-name">{{ optional(auth()->user())->name ?? 'Profile Name' }}</div>
                            <div class="user-position online">Available</div>
                        </div>
                        <a class="dropdown-item" href="#">
                            <span class="icon mdi mdi-face"></span> Account
                        </a>
                        <a class="dropdown-item" href="#">
                            <span class="icon mdi mdi-settings"></span> Settings
                        </a>
                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <span class="icon mdi mdi-power"></span> Logout
                        </a>
                        <form id="logout-form" action="#" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>

            <ul class="nav navbar-nav float-right app-icons-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="icon mdi mdi-apps"></span></a>
                    <ul class="dropdown-menu app-connections">
                        <li>
                            <div class="list">
                                <div class="content">
                                    <div class="row">
                                        <div class="col"><a class="connection-item" href="#"><img src="{{ asset('images/github.png') }}" alt="Github"><span>GitHub</span></a></div>
                                        <div class="col"><a class="connection-item" href="#"><img src="{{ asset('images/bitbucket.png') }}" alt="Bitbucket"><span>Bitbucket</span></a></div>
                                        <div class="col"><a class="connection-item" href="#"><img src="{{ asset('images/slack.png') }}" alt="Slack"><span>Slack</span></a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><a class="connection-item" href="#"><img src="{{ asset('images/dribbble.png') }}" alt="Dribbble"><span>Dribbble</span></a></div>
                                        <div class="col"><a class="connection-item" href="#"><img src="{{ asset('images/mail_chimp.png') }}" alt="Mail Chimp"><span>Mail Chimp</span></a></div>
                                        <div class="col"><a class="connection-item" href="#"><img src="{{ asset('images/dropbox.png') }}" alt="Dropbox"><span>Dropbox</span></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer">
                                <a href="#">More</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
