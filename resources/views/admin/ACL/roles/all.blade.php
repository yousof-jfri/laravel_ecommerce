@component('admin.layouts.content')
    @slot('title', 'مقام ها')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">مقام ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>مقام ها</h4>
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">مقام جدید</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>اسم</th>
                                <th>توضیحات</th>
                                <th>اقدامات</th>
                            </tr>

                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $role->name }} </td>
                                <td>{{ $role->label }}</td>
                                
                                <td>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" id="delete{{ $loop->index }}">@csrf @method('DELETE')</form>
                                    <button type="button" onclick="deleteCategory('#delete{{ $loop->index }}')" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
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

    
    

    @slot('js')

        

        <script>
            function deleteCategory(id){
            Swal.fire({
                title : 'آیا میخواهید این مقام را پاک کنید؟',
                showCancelButton: true,
                confirmButtonText: 'بله ، پاکش کن',
                cancelButtonText: 'خیر',
                cancelButtonColor: 'tomato'
            }).then((result) => {
                if(result.isConfirmed){
                    document.querySelector(id).submit()
                }
            })
            }
        </script>
        
    @endslot
@endcomponent