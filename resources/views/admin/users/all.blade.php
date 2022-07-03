@component('admin.layouts.content')
    @slot('title', 'دشبورد')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">کاربران</li>
    @endslot

    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">تمام کاربران</h3>

              <div class="card-tools d-flex">
                <form>
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="جستجو">
      
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                @can('add-user')
                  <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm mr-5">کاربر جدید</a>
                @endcan
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody><tr>
                  <th>شماره</th>
                  <th>کاربر</th>
                  <th>نوع کاربر</th>
                  <th>تاریخ</th>
                  <th>اقدامات</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td> @if($user->is_superuser) <span class="badge badge-warning">مدیر سایت</span> @elseif ($user->is_staff) <span class="badge badge-info">کارمند سایت</span> @else <span class="badge badge-dark">کاربر عادی</span> @endif </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" id="delete" method="post"> @csrf @method('DELETE') </form>

                            @can('delete-user')
                              <button type="submit" class="btn btn-danger btn-sm" onclick="document.querySelector('#delete').submit()">
                                <i class="fa fa-trash"></i>
                            </button>
                            @endcan
                            
                            @can('edit-user')
                              <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white">
                                <i class="fa fa-edit"></i>
                              </a>
                            @endcan
                            
                            @can('set-permission-role-to-user')
                              <a href="{{ route('admin.users.addAcl', $user->id) }}" class="btn btn-primary btn-sm text-white">
                                <i class="fa fa-shield"></i>
                              </a>
                            @endcan
                            
                        </td>
                    </tr>
                @endforeach
              </tbody></table>
            </div>
            <div class="card-footer">
              {{ $users->links() }}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    
@endcomponent