<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <a href="index.html" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-primary"><span class="text-dark">SPA</span> Center</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <div class="navbar-nav m-auto py-0">
                <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="/about" class="nav-item nav-link {{  request()->is('about') ? 'active' : '' }}">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->is('product*') ? 'active' : '' }}" data-toggle="dropdown">Category</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        @foreach ($categories as $category)
                            <a href="/product/{{ $category->slug }}" class="dropdown-item">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="/contact" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary d-none d-lg-block">Book Now</a>
        </div>
    </nav>
</div>
<!-- Navbar End -->