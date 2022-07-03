@component('admin.layouts.content')
    @slot('title', 'دشبورد')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.orders.index') }}">سفارشات</a>
        </li>
        <li class="breadcrumb-item active">تغییر سفارش</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">تغییر سفارش</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" role="form">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id">کد سفارش</label>
                            <input type="text" readonly value="{{ $order->id }}" class="form-control" id="id">
                        </div>

                        <div class="form-group">
                            <label for="price">هزینه</label>
                            <input type="text" readonly value="{{ $order->price }} تومان" class="form-control" id="price">
                        </div>

                        <div class="form-group">
                            <label for="status">وضعیت سفارش</label>
                            <select name="status" id="status" class="form-control">
                                @php
                                    $statuses = [['paid', 'پرداخت شده'], ['unpaid', 'پرداخت نشده'], ['preparation', 'در حال آماده سازی'], ['recieved', 'دریافت شده'], ['posted', 'ارسال شده'], ['canceled', 'کنسل شده']];
                                @endphp

                                @foreach ($statuses as $status)
                                    <option value="{{ $status[0] }}" {{ $order->status == $status[0] ? 'selected' : '' }}>{{ $status[1] }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tracking-serial">کد پیگیری</label>
                            <input type="text" value="{{ $order->tracking_serial }}" name="tracking-serial" class="form-control" id="tracking-serial">
                            @error('tracking-serial')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">ویرایش</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcomponent