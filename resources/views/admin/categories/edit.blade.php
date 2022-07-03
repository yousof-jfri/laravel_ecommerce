@component('admin.layouts.content')
    @slot('title', 'تغییر بندی جدید')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.categories.index') }}">دسته بندی ها</a>
        </li>
        <li class="breadcrumb-item active">تغییر دسته بندی  </li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تغییر بندی جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم دسته بندی</label>
                            <input type="text" value="{{ $category->name}}" class="form-control @error('name') invalide @enderror" id="name" name="name" placeholder="اسم دسته بندی را وارد کنید">
                            @error('name')
                                <div class="alert alert-danger mt-3">
                                    <span>نام دسته بندی مناسب نیست</span>
                                </div>
                            @enderror
                        </div>

                        @php
                            $parent = $category->parent ? $category->parent : null
                        @endphp

                        <div class="form-group">
                            <label for="parent_id">دسته پدر</label>
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="">انتخاب کنید</option>
                                @foreach (App\Models\Category::all() as $category2)
                                    <option value="{{ $category2->id }}" @if($category2->id == ($parent != null ? $parent->id : 0 )) selected @endif >{{ $category2->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="alert alert-danger mt-3">
                                    <span>دسته پدر</span>
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