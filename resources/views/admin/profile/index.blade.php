@component('admin.layouts.content')
    @slot('title',auth()->user()->name)
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">پروفایل </li>
    @endslot
    <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ auth()->user()->image ? Storage::url(auth()->user()->image) : asset('assets/images/user/1.png') }}" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

              <p class="text-muted text-center">@if(auth()->user()->is_superuser == 1) <span class="badge badge-warning">مدیر وبسایت</span> @elseif (auth()->user()->is_staff == 1) <span class="badge badge-primary">کارمند وب سایت</span> @else <span class="badge badge-secondary">کاربر سایت</span> @endif </p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">درباره من</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fa fa-phone mr-1"></i>شماره تماس</strong>

              <p class="text-muted">
                {{ auth()->user()->phone }}
              </p>

              <hr>

              <strong><i class="fa fa-email mr-1"></i>ایمیل</strong>

              <p class="text-muted">
                {{ auth()->user()->email }}
              </p>

              <strong><i class="fa fa-map-marker mr-1"></i> موقعیت</strong>

              <p class="text-muted">{{ auth()->user()->address }}</p>

              <hr>

              <hr>

              <strong><i class="fa fa-file-text-o mr-1"></i> درباره من</strong>

              <p class="text-muted">{{ auth()->user()->bio }}</p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">فعالیت‌ها</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">تنظیمات</a></li>
                <li class="nav-item"><a class="nav-link" href="#toFactorAuth" data-toggle="tab">احراز هویت دو مرحله ای</a></li>
                <li class="nav-item"><a class="nav-link" href="#orders" data-toggle="tab">سفارشات شما</a></li>
                
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  @if(!unCompleteProfile(auth()->user()) || auth()->user()->two_factor_auth_type == 'off')
                    @if(!unCompleteProfile(auth()->user()))
                    <div class="alert alert-warning">
                      <span>لطفا پروفایل خود را تکمیل کنید</span>
                      <ul>
                        @if(auth()->user()->phone == null)
                        <li>لطفا شماره تلفن خود را وارد کنید</li>
                        @endif
                        @if(auth()->user()->address == null)
                        <li>لطفا آدرس خود را وارد کنید</li>
                        @endif
                        @if(auth()->user()->bio == null)
                        <li>لطفا مشخصات خود را را وارد کنید</li>
                        @endif
                        @if(auth()->user()->image == null)
                        <li>لطفا عکس خود را وارد کنید</li>
                        @endif
                      </ul>
                    </div>
                    @endif
                    @if(auth()->user()->two_factor_auth_type == 'off')
                    <div class="alert alert-warning">
                      <span>لطفا شماره تلفن خود را تایید کنید</span>
                    </div>
                    @endif
                  @else
                    <div class="alert alert-success">
                      <span>شما هیچ ماموریتی ندارید</span>
                    </div>
                  @endif
                </div>
                <!-- /.tab-pane -->

                {{-- two factor authuntication:start --}}
                <div class="tab-pane" id="toFactorAuth">
                    @if(auth()->user()->two_factor_auth_type == 'sms')
                      <div class="alert alert-success">
                        <span>شماره تلفن شما تایید شده است</span>
                      </div>
                    @else
                    <form action="{{ route('admin.profile.twoFactorAuth') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <p> در این بخش شماره تلفن شما تایید میشود ، زمانی که شما شماره تلفن خود را وارد کردید یک کد به شماره شما ارسال میشود که اون کد رو دوباره وارد کرده و شماره تلفن خود را تایید میکنید</p>
                      </div>

                      <div class="form-group">
                        <select name="two_factor_auth_type" id="" class="form-control">
                          <option value="sms">SMS</option>
                          <option value="off">خاموش</option>
                        </select>
                        @error('two_factor_auth_type')
                          <span class="invalid-feedback">
                            لطفا انتخاب کنید
                          </span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                        @error('phone')
                          <span class="invalid-feedback">
                            شماره تلفن نا معتبر است
                          </span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <button class="btn btn-primary">ارسال کد</button>
                      </div>
                    </form>
                    @endif
                </div>
                {{-- two factor authuntication:end --}}



                <div class="tab-pane" id="settings">
                  <form class="form-horizontal" action="{{ route('admin.profile.update', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                      <label for="اسم" class="col-sm-2 control-label">اسم</label>

                      <div class="col-sm-10">
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control" id="اسم" placeholder="اسم">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email" class="col-sm-2 control-label">ایمیل</label>

                      <div class="col-sm-10">
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control" id="email" placeholder="ایمیل">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">گذر واژه جدید</label>
  
                        <div class="col-sm-10">
                            <input type="text" name="password" class="form-control" id="password" placeholder="گذر واژه">
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="address" class="col-sm-2 control-label">ادرس</label>

                      <div class="col-sm-10">
                        <input type="text" name="address" value="{{ auth()->user()->address }}" class="form-control" id="address" placeholder="ادرس">
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">شماره تماس</label>
  
                        <div class="col-sm-10">
                            <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-control" id="phone" placeholder="شماره تماس">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bio" class="col-sm-2 control-label">درباره من</label>

                        <div class="col-sm-10">
                            <textarea name="bio" class="form-control" id="bio" placeholder="درباره من">{{ auth()->user()->bio }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">تصویر</label>

                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">انتخاب تصویر</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>


                {{-- orders:start --}}
                <div class="tab-pane" id="orders">
                  @if(auth()->user()->orders()->count())
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>سفارشات</h4>
                        </div>
                        <div class="card-body">
                          <table class="table table-hover">
                              <tbody>
                                  <tr>
                                      <th>شماره سفارش</th>
                                      <th>تاریخ ثبت</th>
                                      <th>وضعیت سفارش</th>
                                      <th>کد رهگیری پستی</th>
                                      <th>اقدامات</th>
                                  </tr>
      
                                  @foreach (auth()->user()->orders as $order)
                                  <tr>
                                      <td>{{ $loop->index }}</td>
                                      <td>{{ $order->created_at }}</td>
                                      
                                      <td>@switch($order->status)
                                        @case('paid')
                                            <span class="badge badge-info mx-3">پرداخت شده</span>
                                            @break
                    
                                        @case('unpaid')
                                            <span class="badge badge-warning mx-3">پرداخت نشده</span>
                                            @break
                    
                                        @case('preparation')
                                            <span class="badge badge-primary mx-3">در حال آماده سازی</span>
                                            @break
                    
                                        @case('posted')
                                            <span class="badge badge-light mx-3">ارسال شده</span>
                                            @break
                    
                                        @case('recieved')
                                            <span class="badge badge-success mx-3">دریافت شده</span>
                                            @break
                                    
                                        @default
                                            
                                    @endswitch</td>
                                      <td>null</td>
                                      <td>

                                        <a class="btn btn-sm btn-success" href="{{ route('admin.orders.show', $order->id) }}"> 
                                          <span> اطلاعت سفارش</span>
                                        </a>
                                          
                                      </td>
                                  </tr>
                                  @endforeach
                                  
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  @else
                  <div class="alert alert-warning">
                    <span>شما هیچ سفارشی ندارید</span>
                  </div>
                  @endif  
                </div>
                {{-- orders:end --}}
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
@endcomponent