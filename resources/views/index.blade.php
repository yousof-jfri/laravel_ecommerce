@extends('layouts.app')

@section('customecss')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
@endsection

@section('js')
    

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
<!-- home:start -->
<section class="home-section" id="home">
    <!-- shap -->
    <div class="shape-01"></div>
    <div class="shape-02"></div>
    <div class="container">
        <div class="row items-center">
            <div class="home-content">
                <h4>بهترین ها در </h4>
                <h1> {{ config('app.name', 'Laravel') }} </h1>
                <form action="{{ route('home.all') }}">
                    <div class="search-container">
                        <input type="text" name="search" placeholder="جستجوی محصولات">
                        <button type="submit" class="search-btn">جستجو </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- scroll down -->
    <a href="#about" class="scroll-down">
        <img src="assets/project_content/icons/scroll-down.png" alt="">
    </a>
</section>
<!-- home:end -->

<!-- About section:start -->
<section class="about-section" id="about">
    <div class="container">
        <div class="row">
            <!-- right side -->
            <div class="about-content">
                <div class="section-title">
                    <h1>درباره سایت</h1>
                </div>
                <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>
            </div>

            <!-- left side -->
            <div class="about-img">
                <div class="img-box">
                    <img src="assets/images/about.png" alt="about Eccomerce Project">
                    <div class="shape-03"></div>
                </div>
            </div>
        </div>

        <div class="stats">
            <div class="row">
                <div class="stats-box">
                    <div class="shape-04"></div>
                    <h2>30304</h2>
                    <h5>سفارش تا حالا</h5>
                </div>
                <div class="stats-box">
                    <div class="shape-04"></div>
                    <h2>214</h2>
                    <h5>کارمند متخصص</h5>
                </div>
                <div class="stats-box">
                    <div class="shape-04"></div>
                    <h2>18400</h2>
                    <h5>مشتری راضی</h5>
                </div>
                <div class="stats-box">
                    <div class="shape-04"></div>
                    <h2>26</h2>
                    <h5>شعبه مختلف</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About section:end -->

 <!-- products_2:start -->
    <section class="product_02" id="products">
        <div class="container">
            <div class="about-content">
                <div class="section-title">
                    <h1>محصولات بیشتر</h1>
                    <a href="{{ route('home.all') }}">
                        <i class="fa fa-arrow-left"></i>
                        <span>مشاهده همه</span>
                    </a>
                </div>
            </div>
            <div class="row">
                <!-- product items:start -->
                @foreach ($products as $product)
                <div class="product-item">
                    <div class="card">
                        <div class="card-image">
                            <img src="{{ Storage::url($product->image) }}" alt="" data-large="assets/images/products/1.png">
                        </div>
                        <div class="card-content">
                            <p><span>تومان</span> | {{ $product->price }} </p>
                            <h1><strong>{{ $product->name }}</strong></h1>
                            <p>{{ Str::limit($product->description, 30, '...') }}</p>
                        </div>
                        <div class="card-buttons">
                            <a class="more" href="{{ route('home.productDetails', $product->slug) }}">مشاهده</a>
                            <button onclick="document.querySelector('#addCart{{$product->id}}').submit()" class="add-to-basket">افزودن به سبد خرید</button>
                            <form action="{{ route('cart.add', $product->id) }}" id="addCart{{$product->id}}" method="post">@csrf</form>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- product items:end -->
            </div>
            <div>

            </div>
        </div>  
    </section>
    <!-- products_2:end -->

@endsection