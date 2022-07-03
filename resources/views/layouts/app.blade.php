<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- custom css -->
    @yield('customecss')


    <!-- fontawsome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">

    <!-- swiper -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">

    <!-- font vazir -->
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">

    
</head>
<body>
<form id="logout" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<!-- header:start -->
<header class="header">
    <div class="container">
        <div class="row justify-between items-center">
            <div class="brand-name">
                <a href="index.html">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="{{ Route::currentRouteName() == 'home' ? '#home' : route('home') }}">خانه</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'home' ? '#about' : route('home') }}">درباره</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'home' ? '#products' : route('home') }}">محصولات</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'home' ? '#discount' : route('home') }}">تخفیفات ویژه</a></li>
                    <li>
                        <a id="category-list">دسته بنی ها</a>
                        <div class="categories" id="categories">
                            <div class="row">
                                @foreach (App\Models\Category::where('parent_id', 0)->get() as $category)
                                <div class="category-item">
                                    <h4>{{ $category->name }}</h2>
                                    <ul class="sub-cat">
                                        @foreach ($category->childs as $subCategory)
                                            <li>
                                                <a href="">{{ $subCategory->name }}</a>
                                            </li>
                                            @foreach ($subCategory->childs as $subSubCategory)
                                            <li>
                                                <a href="">{{ $subSubCategory->name }}</a>
                                            </li>
                                            @endforeach
                                        @endforeach
                                       
                                    </ul>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </li>
                    @auth
                        <li><a href="{{ route('admin.profile') }}">پروفایل من</a></li>
                    @endauth
                    
                    @guest
                    <li>
                        <a href="{{ route('login') }}" class="auth">
                            <span>ثبت نام  |  ورود</span>
                            <i class="fa fa-sign-in-alt txt-sm"></i>
                        </a>
                    </li>
                    @endguest

                    @auth
                        <li>
                            <a href="#" onclick="document.querySelector('#logout').submit()" class="auth">
                                <span>خروج</span>
                                <i class="fa fa-sign-out-alt txt-sm"></i>
                            </a>
                        </li>
                    @endauth
                    
                    <li>
                        <a href="{{ route('home.shoppingCart') }}" class="shopping-basket">
                            <span class="txt-xs">{{ Cart::all()->sum(function($cart){ return $cart['quantity']; }) }}</span>
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- header:end -->

@yield('content')


<!-- footer:start -->
<section>
    <div class="footer">
        <div class="footer-header">
            <h3>WWW.ECCOMERCE-PROJECT.COM</h3>
        </div>
        <br>
        <hr>
        <br>
        <div class="footer-row">
            <div class="footer-item">
                <h1>بخش ها سایت</h1>
                <ul>
                    <li>
                        <a href="">خانه</a>
                    </li>                    
                    <li>
                        <a href="">محصولات</a>
                    </li>                    
                    <li>
                        <a href="">محصولات تخفیف خورده</a>
                    </li>
                </ul>
            </div>
            <div class="footer-item">
                <h1>بخش ها سایت</h1>
                <ul>
                    <li>
                        <a href="#home">خانه</a>
                    </li>                    
                    <li>
                        <a href="#products">محصولات</a>
                    </li>                    
                    <li>
                        <a href="#discount">محصولات تخفیف خورده</a>
                    </li>
                </ul>
            </div>
            <div class="footer-item">
                <h1>ما را دنبال کنید</h1>
                <ul>
                    <li>
                        <a href="">@eccomerce</a>
                        <span>انستاگرام</span>
                        <i class="fab fa-instagram"></i>
                    </li>                    
                    <li>
                        <a href="">@eccomerce</a>
                        <span>فیس بوک</span>
                        <i class="fab fa-facebook"></i>
                    </li>                    
                    <li>
                        <a href="">@eccomerce</a>
                        <span>تلگرام</span>
                        <i class="fab fa-telegram"></i>
                    </li>
                </ul>
            </div>
            <div class="footer-item">
                <h1>Eccomerce</h1>
                <p>شرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود</p>
            </div>
        </div>
        <br>
        <div class="footer-footer">
            <span>created by </span>
            <a href="">yousof jafari</a>
        </div>
    </div>
</section>
<!-- footer:end -->



<!-- jquery -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<!-- costum js -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- swiper -->
<script src="{{ asset('assets/js/swiper.min.js') }}"></script>

<script src="{{ asset('assets/js/ext-component-swiper.js') }}"></script>

<script src="{{ asset('dist/js/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

@yield('js')
</body>
</html>