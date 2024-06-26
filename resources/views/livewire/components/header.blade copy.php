<div>
    <header class="header-wrapper">
        <div class="header-middle d-none d-xl-block">
            <div class="container custom-container">
                <div class="row align-items-center justify-content-between align-items-center navbar-parent">
                    <div class="col-auto">
                        <div class="header-logo-area">
                            <a href="/">
                                <img class="logo-main" src="{{ asset('contents/frontend') }}/assets/images/logo.png" width="182" height="31" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-auto d-flex justify-content-end align-items-center">

                        <form class="header-search-box d-none d-md-block" wire:submit.prevent="submitSearchPage">
                            <input wire:model="searchQuery" wire:keyup="search_product" class="form-control" type="text" id="search" placeholder="Search Products" />

                            <button type="submit" class="btn-src">
                                <i class="icon-magnifier"></i>
                            </button>
                        </form>

                        {{-- <a href="{{ route('offer_products') }}" class="header-action-account single-nav"><i class="fa fa-gift fa-2x" aria-hidden="true"></i><span class="align-middle">Offers</span></a> --}}
                        @if (Auth::check())
                            <a href="/profile" class="header-action-account single-nav"><i class="fa fa-user fa-2x" aria-hidden="true"></i> <span class="align-middle pr-2">Profile</span></a>
                        @else
                            <a href="/login" class="header-action-account single-nav">Login / SignUp</a>
                        @endif

                        @livewire('components.cart-count')
                    </div>
                    @if ($search_products)
                        <div class="search_result">
                            <div class="list-group list-group-flush">
                                @foreach ($search_products as $item)
                                    @php
                                        $data = [
                                            "id" => $item->id,
                                            "product_name" => str_replace(' ', '-', strtolower($item->product_name))
                                        ];
                                    @endphp
                                    <a href="{{ route('product_details', $data) }}" class="list-group-item list-group-item-action">
                                        <img src="{{ env('PHOTO_URL') . '/' . $item->related_images[0]['image'] }}" width="80" height="80" alt="Image-Ctgcomputer">
                                        {{ $item->product_name }}
                                    </a>
                                @endforeach
                                    <a href="{{ route('search_product', $searchQuery) }}" class="my-5 list-group-item list-group-item-action active text-center">View more</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="header-middle d-xl-none">
            <div class="container">
                <div class="row align-items-center justify-content-between align-items-center">
                    <div class="col-auto">
                        <div class="header-logo-area">
                            <a href="/">
                                <img class="logo-main" src="{{ asset('contents/frontend') }}/assets/images/logo.png" width="182" height="31" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-action d-flex justify-content-end align-items-center">
                            <button class="btn-search-menu d-xl-none me-lg-4 me-xl-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#AsideOffcanvasSearch" aria-controls="AsideOffcanvasSearch">
                                <i class="search-icon icon-magnifier"></i>
                            </button>
                            <a href="/login" class="header-action-account d-none d-xl-block">Login / SignUp</a>
                            <a href="/login" class="header-action-user me-lg-4 me-xl-0 d-xl-none">
                                <i class="icon icon-user"></i>
                            </a>
                            <a href="/cart" class="header-action-cart">
                                <i class="cart-icon icon-handbag"></i>
                                <span class="cart-count">{{ $cart_count }}</span>
                            </a>
                            {{-- @livewire('components.cart-count') --}}
                            <button class="btn-menu d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-two-area d-none d-xl-block">
            <div class="container-fluid  custom-container">
                <div class="row align-items-top justify-content-between">

                    <div class="col-12 d-none d-lg-block ps-0">
                        <div class="header-navigation header-navigation-light ps-0">
                            <ul class="main-nav justify-content-center">
                                @foreach ($categories as $category)
                                <li class="main-nav-item">
                                    @php
                                        $data = [
                                            "id" => $category->id,
                                            "category_name" => str_replace(' ', '-', strtolower($category->name))
                                        ];
                                    @endphp

                                    {{-- <a class="main-nav-link" href="{{ route('category_product', $data) }}" >
                                        {{ $category->name }}
                                    </a> --}}
                                    <a class="main-nav-link" href="{{ route('category_product', $data) }}" >
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach

                                <li class="main-nav-item"><a class="main-nav-link" href="/contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <aside class="aside-side-menu-wrapper off-canvas-area offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
            <div class="sidemenu-top">
            </div>
            <div class="offcanvas-header" data-bs-dismiss="offcanvas">
                <h5>Menu</h5>
                <button type="button" class="btn-close">×</button>
            </div>
            <div class="offcanvas-body">
                <!-- Start Mobile Menu Wrapper -->
                <div class="res-mobile-menu">
                    <nav id="offcanvasNav" class="offcanvas-menu">

                        <ul>
                            <li><h5>All categories</h5></li>
                            @foreach ($categories as $category)
                            <li>
                                @php
                                    $data = [
                                        "id" => $category->id,
                                        "category_name" => str_replace(' ', '-', strtolower($category->name))
                                    ];
                                @endphp
                                {{-- <a class="main-nav-link" href="{{ route('category_product', $data) }}" >
                                    {{ $category->name }}
                                </a> --}}
                                <a class="main-nav-link" href="#" >
                                    {{ $category->name }}
                                </a>
                            </li>
                            @endforeach
                            <li class="main-nav-item"><a class="main-nav-link" href="/cart">Cart</a></li>
                            <li class="main-nav-item"><a class="main-nav-link" href="/contact">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- End Mobile Menu Wrapper -->
            </div>
        </aside>
    </header>
</div>
