<header class="foxapp-header">
    <nav class="navbar navbar-expand-lg navbar-light" id="foxapp_menu">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="{{asset('fox/img/fox-logo.png')}}" class="img-fluid" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu"
                aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_menu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link anchor active" href="#slide">Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#main_features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#screenshots">Screenshots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#team">Team</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            News
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item anchor" href="#recent_news">Recent News</a>
                            <a class="dropdown-item anchor" href="news-without-sidebar.html">News One</a>
                            <a class="dropdown-item anchor" href="news-with-sidebar.html">News Two</a>
                            <a class="dropdown-item anchor" href="news-with-sidebar-one-col.html">News Three</a>
                            <a class="dropdown-item anchor" href="news-single.html">Single News</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#git_in_touch">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="{{url('login')}}">Sign in/Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>