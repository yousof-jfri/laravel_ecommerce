@component('admin.layouts.content')
    @slot('title', 'دشبورد')
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">پنل مدیریتی</a></li>
        {{-- <li class="breadcrumb-item active">داشبورد ورژن 2</li> --}}
    @endslot

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fa fa-shopping-basket"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">محصولات</span>
              <span class="info-box-number">
                {{ $products->count() }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">درامد سایت</span>
              <span class="info-box-number">{{ $recievedOrders->sum(function($order) { return $order->price; }) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">فروش های سایت</span>
              <span class="info-box-number">{{ $recievedOrders->sum(function($order) { return $order->products()->count(); }) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">اعضای سایت</span>
              <span class="info-box-number">{{ $users->count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-lg-6">
            <div class="card">
              <div class="card-header no-border">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">فروش</h3>
                  <a href="javascript:void(0);">مشاهده گزارش</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">تومان ۱۸,۲۳۰.۰۰</span>
                    <span>فروش در طول زمان</span>
                  </p>
                  <p class="mr-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fa fa-arrow-up"></i> ۳۳.۱%
                    </span>
                    <span class="text-muted">از ماه گذشته</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                  <canvas id="sales-chart" height="200" width="487" style="display: block; width: 487px; height: 200px;" class="chartjs-render-monitor"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="ml-2">
                    <i class="fa fa-square text-primary"></i> امسال
                  </span>

                  <span>
                    <i class="fa fa-square text-gray"></i> سال گذشته
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
      </div>

      @slot('js')
      <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
      @endslot
@endcomponent