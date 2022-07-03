@component('admin.layouts.content')
    @slot('title', 'تغییر دسترسی')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.permissions.index') }}">دسترسی ها</a>
        </li>
        <li class="breadcrumb-item active">تغیبر دسترسی</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تغیبر دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم دسترسی</label>
                            <input type="text" value="{{ $permission->name }}" class="form-control @error('name') invalide @enderror" id="name" name="name" placeholder="اسم دسترسی را وارد کنید">
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
                            <input type="text" value="{{ $permission->label }}" class="form-control @error('label') invalide @enderror" id="label" name="label" placeholder="توضیحتات دسترسی را وارد کنید">
                            @error('label')
                                <div class="alert alert-danger mt-3">
                                    <span>توضیحات دسترسی مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">تغییر</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcomponent