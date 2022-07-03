@extends('layouts.app')

@section('customecss')
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
@endsection


@section('js')
    <script>
        let baseUrl = 'http://127.0.0.1:8000';
        function updateQuantity(event, id, loadingId){
            let loading = document.querySelector('#sh-cart-loading'+loadingId);

            // add updating text to the cart
            loading.style.display = 'block';

            let quantity = event.target.value;
            let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN" : csrfToken,
                    "Content-Type" : 'application/json', 
                }
            })

            $.ajax({
                type: 'Patch',
                url: baseUrl+`/cart/quantity/update/${quantity}/${id}`,
                data: 'hello',

                success: function(data){
                    console.log(data)
                    loading.style.display = 'none';
                }
            })
        }

        function deleteCart(event, id, loadingId){
            let loading = document.querySelector('#sh-cart-loading'+loadingId);

            // add updating text to the cart
            loading.style.display = 'block';

            let csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN" : csrfToken,
                    "Content-Type" : 'application/json', 
                }
            })

            $.ajax({
                type: 'delete',
                url: baseUrl+`/cart/delete/${id}`,
                data: '',

                success: function(data){
                    event.target.parentElement.parentElement.remove()
                    console.log(data)
                    loading.style.display = 'none';
                }
            })
        }
    </script>
@endsection

@section('content')
<!-- shopping basket:start -->
<section class="shopping-cart">
    <div class="container">
        <div class="title-section">
            <h1>({{ Cart::all()->sum(function($cart){return $cart['quantity'];}) }})سبد خرید شما</h1>
        </div>
        @php
            $totalPrice = 0;
        @endphp
        <div class="sh-row">
            <div class="card-row">
                <!-- cards:start -->
                @foreach (Cart::all() as $cart)
                @php
                    $product = $cart['product']
                @endphp
                <div class="sh-cart-item">
                    <div class="loading" id="sh-cart-loading{{$loop->index}}">
                        <h1>لطفا کمی صبر کنید</h1>
                    </div>
                    <div class="sh-item-image">
                        <img src="{{ Storage::url($product->image) }}" alt="">
                    </div>
                    <div class="sh-item-desc">
                        <h3>{{ $product->name }}</h3>
                        <span class="green">{{ $product->inventory > 0 ? 'موجود میباشد' : 'این محصول تمام شده' }}</span>
                        <br>
                        <select name="quantity" onchange="updateQuantity(event, '{{ $cart['id'] }}', '{{$loop->index}}')">
                            @for ($i = 1; $i <= $product->inventory; $i++)
                                <option value="{{ $i }}" {{ $i == $cart['quantity'] ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <br>
                        <span class="deliver">تحویل بین 3 تا 4 روز دیگر</span>
                        <br>
                        {{-- <span class="green">درصد تخفیف %17</span> --}}
                    </div>
                    <hr>
                    <div class="sh-item-action">
                        <p>{{ $product->price }}</p>
                        @php
                            $totalPrice += $product->price * $cart['quantity'];
                        @endphp
                        <span>تومان</span>
                        <button class="remove-from-sh" type="button" onclick="deleteCart(event, '{{ $product->id }}', '{{ $loop->index }}')">حذف از سبد خرید</button>
                        <a class="sh-show-pr">مشاهده</a>
                    </div>
                </div>
                @endforeach

                <!-- cards:end -->
            </div>
            <div class="sh-carts-description">
                <h4>تعداد محصولات : {{ Cart::all()->sum(function($cart){ return $cart['quantity']; }) }}</h4>
                <br>
                <h4><strong>اطلاعات قیمت</strong></h4>
                <p> قیمت کل : {{  $totalPrice }} تومان</p>
                <p class="green">تخفیف : %30</p>
                <br>
                <hr>
                <br>
                <p> قیمت کلی: {{  $totalPrice }} تومان</p>
                <br>
                <button class="place-order" onclick="document.querySelector('#submitPayment').submit()">پرداخت</button>
                <form action="{{ route('cart.payment') }}" method="post" id="submitPayment">@csrf</form>
            </div>
        </div>
        
    </div>
</section>
<!-- shopping basket:end -->
@endsection