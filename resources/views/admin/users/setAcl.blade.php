@component('admin.layouts.content')
    @slot('title', 'دشبورد')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.users.index') }}">کاربران</a>
        </li>
        <li class="breadcrumb-item active">کاربران جدید</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title">کاربر جدید</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.users.setAcl', $user->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم</label>
                            <input type="text" readonly value="{{ $user->name }}" class="form-control" id="name" name="name" placeholder="اسم را وارد کنید">
                            @error('name')
                                <span class="text-danger mx-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="permissions">دسترسی ها</label>
                            <select name="permissions[]" id="permissions" class="form-control select" multiple="multiple">
                                @foreach (App\Models\Permission::all() as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $user->permissions()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="roles">مقام ها</label>
                            <select name="roles[]" id="roles" class="form-control select" multiple="multiple">
                                @foreach (App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, $user->roles()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
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

    @slot('js')
        <script src="{{ asset('plugins/select2/select2.full.js') }}"></script>
        <script>
            // console.log(Swal());
            $('.select').select2()

            function setImage(e){

                const image = document.querySelector('#user_image');
                let file = e.target.files[0];
                const reader = new FileReader();
                
                reader.onload = () => {
                    image.src = reader.result;
                }

                reader.readAsDataURL(file);

            }
        </script>
    @endslot
@endcomponent