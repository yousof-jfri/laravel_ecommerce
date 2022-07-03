@extends('layouts.app')

@section('customecss')
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/js/plugins/sweetalert2/dist/sweetalert2.all.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('dist/js/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    @if(Session::has('message'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ Session::get('message') }}'
            })
        </script>
    @endif
    
@endsection

@section('content')
{{Session::get('message')}}
        <!-- product:start -->
        <section class="product">
            <div class="container">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ Storage::url($product->image) }}" alt="">
                    </div>
                    <div class="product-text">
                        <div class="title-section">
                            <h1><strong>{{ $product->name }}</strong></h1>
                        </div>
                        <div class="price">
                            <span>قیمت</span>
                            {{-- <del>25000000</del> --}}
                            <span>{{ $product->price }}</span>
                            <span>تومان</span>
                        </div>
                        
                        <div class="description">
                            <h3>توضیحات</h3>
                            {{ $product->description }}
                        </div>
    
                        <div class="attr-cate">
                            <div class="category-product">
                                <h1>دسته بندی ها</h1>
                                <div class="all-cate">
                                    @foreach ($product->categories as $category)
                                        <span class="category">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="attributes">
                                <h1>ویژه گی ها</h1>
                                <ul class="attributes">
                                    @foreach ($attributes as $attr)
                                    <li class="attribute">
                                        <ul class="attr-value">
                                            @foreach ($attr['value'] as $value)
                                                <li>{{ $value }}</li>
                                            @endforeach
                                        </ul>
                                        <h3>{{ $attr['name'] }}</h3>
                                    </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
    
    
                        <br>
                        <hr>
                        <br>
                        <div>
                            <button onclick="document.querySelector('#addCart{{$product->id}}').submit()" class="add-to-cart">
                                <span>افزودن به سبد خرید</span>
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                            <form action="{{ route('cart.add', $product->id) }}" id="addCart{{$product->id}}" method="post">@csrf</form>
                            <button class="add-to-cart">
                                <i class="fa fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product:end -->
    
        <!-- comments:start -->
        <section class="comments">
            <div class="container">
                <div class="title-comment">
                    <i class="fa fa-comments"></i>
                    <h1>نظرات</h1>
                </div>
                @auth
                <div>
                    <button class="new-comment-btn" id="newCommentBtn" onclick="newComment('{{ route('home.newComment') }}', '{{ $product->id }}')">ثبت نظر جدید</button>
                </div>
                @endauth
                @guest
                    <span>برای نظر دادن ابتدا وارد سایت شوید</span>
                @endguest
                <!-- new comment box:start -->
                <div id="newComment"></div>
                <!-- new comment box:end -->
                
                <div class="comments-card">
                    <div class="comment-count">
                        <h4>({{ count($product->comments) }})نظرات</h4>
                    </div>
                    <!-- comments -->
                    @include('frontend.components.comments', ['comments' => $product->comments()->where('approved', 1)->where('parent_id', 0)->get()])
                </div>
            </div>
        </section>
        <!-- comments:end -->
    
    
        <!-- similar:products -->
        <section class="similar-products">
            <div class="container">
                <h1>محصولات مشابه</h1>
                <div class="product-card">
                    <div class="swiper swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($similarProduct as $product)
                            <div class="swiper-slide">
                                <div class="card">
                                    <div class="card-image">
                                        <img src="{{ Storage::url($product->image) }}" alt="">
                                    </div>
                                    <div class="card-content">
                                        <p><span>تومان</span> | {{ $product->price }} </p>
                                        <h1><strong>{{ $product->name }}</strong></h1>
                                    </div>
                                    <div class="card-buttons">
                                        <a href="{{ route('home.productDetails', $product->slug) }}" class="more">مشاهده</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
    
                </div>
            </div>
    
            
        </section>
@endsection