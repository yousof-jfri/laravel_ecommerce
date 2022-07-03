@component('admin.layouts.content')
    @slot('title', 'نظرات')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">ویژه گی  ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>ویژه گی  ها</h4>
                    @can('add-attribute')
                        <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary btn-sm">ویژه گی جدید</a>
                    @endcan
                    
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>ویژه گی</th>
                                <th>اقدامات</th>
                            </tr>

                            @foreach ($attributes as $attribute)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $attribute->name }}</td>
                                <td>
                                    <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" id="delete{{$attribute->id}}">@csrf @method('DELETE')</form>
                                    
                                    @can('delete-attribute')
                                        <button type="button" onclick="deleteCategory('#delete{{$attribute->id}}')" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endcan
                                    
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
                title : 'آیا میخواهید این ویژه گی را پاک کنید؟',
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