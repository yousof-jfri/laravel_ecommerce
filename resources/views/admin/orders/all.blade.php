@component('admin.layouts.content')
    @slot('title', 'سفارشات')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('admin.') }}">پنل مدیریتی</a></li>
        <li class="breadcrumb-item active">تمام سفارشات</li>
    @endslot


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
                                <th>کاربر</th>
                                <th>کد رهگیری پستی</th>
                                <th>اقدامات</th>
                            </tr>

                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $order->created_at }}</td>
                                
                                <td>
                                    <span class="badge badge-primary">
                                        @switch($order->status)
                                            @case('unpaid')
                                                پرداخت نشده
                                                @break
                                            
                                            @case('paid')
                                                پرداخت شده
                                                @break

                                            @case('preparation')
                                                در حال آماده سازی
                                                @break

                                            @case('posted')
                                                ارسال شده
                                                @break

                                            @case('recieved')
                                                دریافت شده
                                                @break 

                                            @case('canceled')
                                                کنسل شده
                                                @break 
                                            
                                                
                                            @default
                                                
                                        @endswitch
                                    </span>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>null</td>
                                <td>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" id="delete{{$order->id}}">@csrf @method('DELETE')</form>
                                    <button type="button" onclick="deleteOrder('#delete{{$order->id}}')" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>


                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i>
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
            function deleteOrder(id){
            Swal.fire({
                title : 'آیا میخواهید سفارش را پاک کنید؟',
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