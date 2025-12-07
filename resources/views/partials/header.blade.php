<?php
if (Auth::check() && Auth::user()->order) {
    $cartBadgeCount = Auth::user()->order->products->count();
}
?>

<header>

    <nav>
        <!-- Menu Responsive -->
        <nav class="hamburgerNav ">
            <div class="dropdown">
                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="background: none; border: none;">
                    <i class="bi bi-list text-white"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end fs-3 ">
                    <li><a class="dropdown-item" href="/">Home</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-header fs-4">Categorie</li>
                    @foreach ($cats as $cat)
                        <li><a class="dropdown-item"
                                href="{{route("products.filtered", $cat)}}">{{ ucfirst($cat->value) }}</a></li>
                    @endforeach
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li><a class="dropdown-item" href="{{ route("products.discounted") }}">Occasioni</a></li>
                    <li><a class="dropdown-item" href="{{route("chiSiamo")}}">Chi siamo</a></li>
                    <li><a class="dropdown-item" href="{{route("contatti")}}">Contatti</a></li>
                </ul>
            </div>
        </nav>



        <!-- Menu Desktop -->
        <ul class="navBar cleanList desktopNav">
            <li>
                <a href="/" class="navLink">
                    Home
                </a>
            </li>
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Categorie
                </a>
                <ul class="dropdown-menu">
                    @foreach ($cats as $cat)
                        <li><a class="dropdown-item"
                                href="{{route("products.filtered", $cat)}}">{{ ucfirst($cat->value) }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="{{ route("cerca") }}" class="navLink">
                    Ricerca prodotti
                </a>
            </li>
            <li>
                <a href="{{ route("products.discounted") }}" class="navLink">
                    Occasioni
                </a>
            </li>
            <li>
                <a href="{{route("chiSiamo")}}" class="navLink">
                    Chi siamo
                </a>
            </li>
            <li>
                <a href="{{route("contatti")}}" class="navLink">
                    Contatti
                </a>
            </li>
        </ul>
    </nav>

    <div class="headLogo">
        <img src="{{ asset("storage/logo.png") }}" alt="logo" width="250">
    </div>

    <div class="tools">
        <ul class="toolsLinks cleanList">
            <li>
                @if (Auth::check())
                    <a href="{{route("user.details")}}">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @else
                    <a href="{{ route("login") }}" class="btn btn-primary fs-3">
                        Accedi
                    </a>
                @endif
            </li>
            <li>
                <a href="{{route("user.orders")}}">
                    <i class="bi bi-card-checklist"></i>
                </a>
            </li>
            <li>
                <a href="{{route("user.cart")}}" class="position-relative">
                    @if(isset($cartBadgeCount) && $cartBadgeCount > 0)
                    <span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger" style="top:20px">
                        {{$cartBadgeCount}}
                        <span class="visually-hidden">prodotti nel carrello</span>
                    </span>
                    @endif
                    <i class="bi bi-cart2"></i>
                </a>
            </li>
        </ul>
    </div>

</header>