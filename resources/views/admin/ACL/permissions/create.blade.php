@component('admin.layouts.content')
    @slot('title', 'دسترسی جدید')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.permissions.index') }}">دسترسی ها</a>
        </li>
        <li class="breadcrumb-item active">دسترسی جدید</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">دسترسی جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.permissions.store') }}" method="POST" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم دسترسی</label>
                            <input type="text" class="form-control @error('name') invalide @enderror" id="name" name="name" placeholder="اسم دسترسی را وارد کنید">
                            @error('name')
                                <div class="alert alert-danger mt-3">
                                    <span>نام دسترسی مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="label">توضیحات دسترسی</label>
                            <input type="text" class="form-control @error('label') invalide @enderror" id="label" name="label" placeholder="توضیحتات دسترسی را وارد کنید">
                            @error('label')
                                <div class="alert alert-danger mt-3">
                                    <span>توضیحات دسترسی مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcomponent