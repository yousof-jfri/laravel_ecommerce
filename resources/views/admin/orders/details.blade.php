@component('admin.layouts.content')
    @slot('title', 'سفارشات')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">تمام سفارشات</li>
        <li class="breadcrumb-item active">جزییات سفارش</li>
    @endslot
    
    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
        <div class="col-12">
            <h4>
            <i class="fa fa-globe"></i> {{ config('app.name', 'Laravel') }}
            <small class="float-left">{{ $order->created_at }}</small>
            </h4>
        </div>
        <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            از
            <address>
            <strong>{{ config('app.name', 'Laravel') }}</strong><br>
            آدرس<br>
            خیابان<br>
            تلفن : (804) 123-5432<br>
            ایمیل : info@roocket.ir
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            به
            <address>
            <strong>{{ $order->user->name }}</strong><br>
            آدرس خریدار<br>
            {{ $order->user->address }}<br>
            تلفن : {{ $order->user->phone }}<br>
            ایمیل : {{ $order->user->email }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>سفارش #007612</b><br>
            <br>
            <b>کد سفارش :</b> 4F3S8J<br>
            <b>تاریخ پرداخت :</b> 12 آبان 1397<br>
            <b>اکانت :</b> 968-34567
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        @php
            $totalPrice = 0;
        @endphp
        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                    <th>تعداد</th>
                    <th>محصول</th>
                    <th>سریال #</th>
                    <th>توضیحات</th>
                    <th>قیمت کل</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $product)
                        <tr>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->inventory }}</td>
                            <td>{{ Str::limit($product->description, 8, '...') }}</td>
                            <td>{{ $product->price * $product->pivot->quantity }} تومان</td>
                            @php
                                $totalPrice += $product->price * $product->pivot->quantity;
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        <!-- /.col -->
            <div class="col-12 d-flex align-items-center my-3">
        
                <h3>وضعیت سفارش</h3>

                @switch($order->status)
                    @case('paid')
                        <span class="badge badge-info mx-3">پرداخت شده</span>
                        @break

                    @case('unpaid')
                        <span class="badge badge-warning mx-3">پرداخت نشده</span>
                        @break

                    @case('preparation')
                        <span class="badge badge-primary mx-3">در حال آماده سازی</span>
                        @break

                    @case('posted')
                        <span class="badge badge-light mx-3">ارسال شده</span>
                        @break

                    @case('recieved')
                        <span class="badge badge-success mx-3">دریافت شده</span>
                        @break
                
                    @default
                        
                @endswitch
            </div>
        </div>
        <!-- /.row -->

        @if($order->status == 'unpaid')
        <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
            <p class="lead">روش های پرداخت :</p>
            <img src="../../dist/img/credit/visa.png" alt="Visa">
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="../../dist/img/credit/american-express.png" alt="American Express">
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            پرداخت از طریق کلیه کارت های بانکی عضو شتاب امکان پذیر می باشد.
            </p>
        </div>

        @php
            $discount = $totalPrice / 10000000;
        @endphp
        <!-- /.col -->
        <div class="col-6">
            <p class="lead">مهلت پرداخت : 10 دی 1397</p>

            <div class="table-responsive">
            <table class="table">
                <tr>
                <th style="width:50%">مبلغ کل :</th>
                <td>{{ $totalPrice }} تومان</td>
                </tr>
                <tr>
                <th>مالیات (9.3%)</th>
                <td>300,000 تومان</td>
                </tr>
                <tr>
                <th>تخفیف : ({{ $discount }} %)</th>
                <td>{{ ($discount * $totalPrice) / 100 }}</td>
                </tr>
                <tr>
                <th>مبلغ قابل پرداخت:</th>
                <td>{{ $totalPrice - (($discount * $totalPrice) / 100) }} تومان</td>
                </tr>
            </table>
            </div>
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                @if(auth()->user()->is_superuser == 1 || auth()->user()->is_staff == 1)
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت </a>
                @endif

                <form action="{{ route('admin.orders.pay', $order->id) }}" method="POST" id="submitPayment">@csrf</form>
                <button type="button" onclick="document.querySelector('#submitPayment').submit()" class="btn btn-success float-left"><i class="fa fa-credit-card"></i> پرداخت صورتحساب
                </button>
            </div>
        </div>
        @endif

    </div>
    <!-- /.invoice -->
    </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endcomponent