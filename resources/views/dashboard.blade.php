@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                  <i class="fa fa-users"></i>
              </div>
              <p class="card-category">Total Clientes Registrados</p>
              <h3 class="card-title">{{$total_clients ?? 0}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">receipt</i>
              </div>
              <p class="card-category">Total Boletos vendidos</p>
              <h3 class="card-title">{{$tickets ?? 0}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="fa fa-user"></i>
              </div>
              <p class="card-category">Cliente más frecuente</p>
              <h3 class="card-title">{{$client ?? ''}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
              </div>
            </div>
          </div>
        </div>
        <!--div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">airplanemode_active</i>
              </div>
              <p class="card-category">Destino más frecuente</p>
              <h3 class="card-title">{$airport ?? ''}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
              </div>
            </div>
          </div>
        </div-->
      </div >

      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-danger row">
              <h4 class="card-title col-8">Destinos mas frecuentes</h4>
              <!--p class="card-category">New employees on 15th September, 2016</p-->

              <a href="{{ url('report/visited/airports')}}" target="_blank"  class="col-4">
                <button class="btn btn-warning btn-fab btn-round btn-md"
                        data-toggle="tooltip" data-placement="bottom" title="Exportar">
                  <i class="material-icons">picture_as_pdf</i>
                </button>
              </a>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-danger">
                <th>Total de Vuelos</th>
                <th>Nombre</th>
                <th>País</th>
                </thead>
                <tbody>
                <tr>
                @foreach($destinations as $destination)
                  <tr>
                    <td>{{$destination['count']}}</td>
                    <td>{{$destination['airport_arrival']['name']}}</td>
                    <td>{{$destination['airport_arrival']['country']['name']}}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="card card-chart">
            <div class="card-header card-header-success">
              <div class="ct-chart" id="dailySalesChart" data-sales="{{ implode(',',$weekly_sales)  }}"></div>
            </div>
            <div class="card-body">
              <h4 class="card-title">Boletos Vendidos (Ultimos 7 dias) </h4>
              <p class="card-category">
               <!-- <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales. --></p>
            </div>
          <!-- <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> updated 4 minutes ago
              </div>
            </div>-->
          </div>
        </div>

        <!-- <div class="col-md-6">
         <div class="card card-chart">
           <div class="card-header card-header-warning">
             <div class="ct-chart" id="websiteViewsChart"></div>
           </div>
           <div class="card-body">
             <h4 class="card-title">Email Subscriptions</h4>
             <p class="card-category">Last Campaign Performance</p>
            </div>
          <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i> campaign sent 2 days ago
              </div>
            </div>
          </div>
        </div>-->
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush
