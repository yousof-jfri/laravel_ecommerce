@component('admin.layouts.content')
    @slot('title', 'دسته بندی جدید')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.attributes.index') }}">ویژه گی  ها</a>
        </li>
        <li class="breadcrumb-item active">ویژه گی  جدید</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ویژه گی  جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.attributes.store') }}" method="POST" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم ویژه گی</label>
                            <input type="text" class="form-control @error('name') invalide @enderror" id="name" name="name" placeholder="اسم ویژه گی را وارد کنید">
                            @error('name')
                                <div class="alert alert-danger mt-3">
                                    <span>نام ویژه گی مناسب نیست</span>
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