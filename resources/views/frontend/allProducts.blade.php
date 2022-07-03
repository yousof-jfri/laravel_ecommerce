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
     <!-- cards:start -->
     <section class="cards">
        <div class="container">
            <div class="cards-row">
                <div class="cards-section">
                    <p>نتیجه یافت شد</p>
                    <div class="input-group">
                        <form action="">
                            <input type="text" placeholder="جستجو کنید" name="search" value="{{ request('search') }}">
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- cards -->
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="product-all-item">
                                <div class="card h-400">
                                    <div class="card-image">
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" data-large="assets/images/products/1.png">
                                    </div>
                                    <div class="card-content">
                                        <p><span>تومان</span> | {{ $product->price }} </p>
                                        <h1><strong>{{ $product->name }}</strong></h1>
                                    </div>
                                    <div class="card-buttons">
                                        <a class="more" href="{{ route('home.productDetails', $product->slug) }}">مشاهده</a>
                                        <button onclick="document.querySelector('#addCart{{$product->id}}').submit()" class="add-to-basket">افزودن به سبد خرید</button>
                                        <form action="{{ route('cart.add', $product->id) }}" id="addCart{{$product->id}}" method="post">@csrf</form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="filter-section">
                    <h4>فیلتر ها</h4>
                    <div class="filter">
                        <form>
                            <h4>دسته بندی ها</h4>
                            <ul>
                                @foreach (App\Models\Category::all() as $category)
                                <li>
                                    <span>{{ $category->name }}</span>
                                    <input type="checkbox" name="data[category][]" value="{{ $category->name }}">
                                </li>
                                    
                                @endforeach
                            </ul>

                            <br>
                            <div class="price">
                                <h4>قیمت</h4>
                                <span>بالاترین قیمت</span>
                                <input name="data[highPrice]" type="text" value="{{ isset(request('data')['highPrice']) ? request('data')['highPrice'] : '' }}">
                                <span>پایین ترین قیمت</span>
                                <input name="data[lowPrice]" type="text" value="{{ isset(request('data')['lowPrice']) ? request('data')['lowPrice'] : 1 }}">
                            </div>
                            <br>
                            <button class="new-comment-btn">فیلتر</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cards:item -->
@endsection