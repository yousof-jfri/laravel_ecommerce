@component('admin.layouts.content')
    @slot('title', 'دشبورد')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.users.index') }}">کاربران</a>
        </li>
        <li class="breadcrumb-item active"> تغییر کاربر</li>
    @endslot


    <div class="row">
        <div class="col-12">
        <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                <h3 class="card-title"> تغییر کاربر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم</label>
                            <input type="text" value="{{ $user->name }}" class="form-control" id="name" name="name" placeholder="اسم را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="email">آدرس ایمیل</label>
                            <input type="email" value="{{ $user->email }}" class="form-control" id="email" name="email" placeholder="ایمیل را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text"  class="form-control" id="password" name="password" placeholder="پسورد را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="phone">phone</label>
                            <input type="text" value="{{ $user->phone }}" class="form-control" id="phone" name="phone" placeholder="شماره موبایل را وارد کنید">
                        </div>
                        <div class="form-group">
                            <label for="type">نوع کاربر</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">کاربر عادی</option>
                                <option value="manager" @if($user->is_superuser) selected @endif >کاربر مدیر</option>
                                <option value="staff" @if($user->is_staff) selected @endif >کاربر کارمند</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">ارسال فایل</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" onchange="setImage(event)" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">انتخاب فایل</label>
                                </div>
                                    <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <img src="{{ !is_null($user->image) ? Storage::url($user->image) : ' ' }}" style="width: 200px;" id="user_image" alt="user_image">
                            </div>
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
        <script>
            // console.log(Swal());

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