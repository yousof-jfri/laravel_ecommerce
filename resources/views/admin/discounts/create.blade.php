@component('admin.layouts.content')
    @slot('title', 'ایجاد کد تخفیف')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.discounts.index') }}">کد های تخفیف</a>
        </li>
        <li class="breadcrumb-item active">کد تخفیف جدید</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">فرم کد تخفیف جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.discounts.store') }}" method="POST" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="code">کد تخفیف</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="کد تخفیف را وارد کنید">
                            @error('code')
                                <span class="text-danger mx-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="percent">درصد</label>
                            <input type="number" name="percent" id="percent" class="form-control">
                            @error('code')
                                <span class="text-danger mx-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="users">کاربر ها</label>
                            <select name="users[]" id="users" class="form-control select" multiple="multiple">
                                @foreach (App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="products">محصول ها</label>
                            <select name="products[]" id="products" class="form-control select" multiple="multiple">
                                @foreach (App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="categories">دسته بندی ها</label>
                            <select name="categories[]" id="categories" class="form-control select" multiple="multiple">
                                @foreach (App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expired_at">مهلت استفاده را وارد کنید</label>
                            <input type="datetime-local" class="form-control" id="expired_at" name="expired_at" placeholder="مهلت استفاده را وارد کنید">
                            @error('expired_at')
                                <span class="text-danger mx-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ایجاد کد تخفیف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @slot('js')
        <script src="{{ asset('plugins/select2/select2.full.js') }}"></script>
        <script>
            // console.log(Swal());
            $('.select').select2()
        </script>
    @endslot
@endcomponent