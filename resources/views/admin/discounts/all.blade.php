@component('admin.layouts.content')
    @slot('title', 'کد های تخفیف')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">کد های تخفیف</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>کد های تخفیف</h4>
                    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">ایجاد تخفیف جدید</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>شماره</th>
                                <th>کد</th>
                                <th>درصد</th>
                                <th>مربوط به کاربر</th>
                                <th>مربوط به محصول</th>
                                <th>مربوط به دسته بندی</th>
                                <th>تاریخ انقضا</th>
                                <th>اقدامات</th>
                            </tr>

                            @foreach ($discounts as $discount)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $discount->code }}</td>
                                
                                <td>{{ $discount->percent . '%' }}</td>
                                <td> {{ $discount->user ?? 'همه کاربر ها' }} </td>
                                <td>{{ count($discount->products) > 0 ? $discount->products->pluck('name')->join(', ') : 'همه محصولات'  }}</td>
                                <td>{{ count($discount->categories) > 0 ? $discount->categories->pluck('name')->join(', ') : 'همه دسته بندی ها'  }}</td>
                                <td>{{ $discount->expired_at }}</td>
                                <td>
                                    <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" id="delete{{$discount->id}}">@csrf @method('DELETE')</form>
                                    <form action="{{ route('admin.discounts.edit', $discount->id) }}" method="GET" id="approve{{$discount->id}}">@csrf</form>
                                    
                                    <button type="button" onclick="deleteCategory('#delete{{$discount->id}}')" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    
                                    <button onclick="document.querySelector('#approve{{$discount->id}}').submit()" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $discounts->links() }}
                </div>
            </div>
        </div>
    </div>

    
    

    @slot('js')

        

        <script>
            function deleteCategory(id){
            Swal.fire({
                title : 'آیا میخواهید این نظر را پاک کنید؟',
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