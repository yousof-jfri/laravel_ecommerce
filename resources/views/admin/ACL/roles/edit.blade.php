@component('admin.layouts.content')
    @slot('title', 'مقام تغییر')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.roles.index') }}">مقام ها</a>
        </li>
        <li class="breadcrumb-item active">مقام تغییر</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">مقام تغییر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" role="form">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم مقام</label>
                            <input type="text" value="{{ $role->name }}" class="form-control @error('name') invalide @enderror" id="name" name="name" placeholder="اسم مقام را وارد کنید">
                            @error('name')
                                <div class="alert alert-danger mt-3">
                                    <span>نام مقام مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="label">توضیحات مقام</label>
                            <input type="text" value="{{ $role->label }}" class="form-control @error('label') invalide @enderror" id="label" name="label" placeholder="توضیحتات مقام را وارد کنید">
                            @error('label')
                                <div class="alert alert-danger mt-3">
                                    <span>توضیحات مقام مناسب نیست</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="permissions">دسترسی های مقام</label>
                            <select name="permissions[]" multiple="multiple" id="permissions" class="form-control select">
                                <option value="">انتخاب کنید</option>
                                @foreach (App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }} - {{ $permission->label }}</option>
                                @endforeach
                            </select>
                            @error('permissions')
                                <div class="alert alert-danger mt-3">
                                    <span>توضیحات مقام مناسب نیست</span>
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

    @slot('js')
        <script src="{{ asset('plugins/select2/select2.full.js') }}"></script>

        <script>
            $(function(){
                $('.select').select2()
            })
        </script>
    @endslot
@endcomponent