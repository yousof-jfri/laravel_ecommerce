@component('admin.layouts.content')
    @slot('title',auth()->user()->name)
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">احراز هویت دو مرحله ای </li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <p>ما یک کد 6 رقمی را به شماره شما ارسال کردیم</p>
                    <p>لطفا این کد را وارد کنید</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.verifyPhoneNumber') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="code">کد</label>
                            <input type="text" id="code" name="code" placeholder="لطفا کد را وارد کنید" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endcomponent