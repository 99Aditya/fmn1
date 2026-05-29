@extends('admin.layout.index')
@section('title', 'Dashboard')
@section('content')

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">

                    <div class="page-body">
                        <div class="row">
                            <!-- task, page, download counter  start -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-yellow update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white">0</h4>
                                                <h6 class="text-white m-b-0">Total Users</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-1" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i
                                                class="feather icon-clock text-white f-14 m-r-10"></i>Updated
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white">5</h4>
                                                <h6 class="text-white m-b-0">Total Posts</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-2" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i
                                                class="feather icon-clock text-white f-14 m-r-10"></i>Updated
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ecommerce"> Ecommerce </div>
                    <div class="page-body">
                        <div class="row">
                            <!-- task, page, download counter  start -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-yellow update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white">0</h4>
                                                <h6 class="text-white m-b-0">Total Brands</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-3" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i
                                                class="feather icon-clock text-white f-14 m-r-10"></i>Updated
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                                <h4 class="text-white">0</h4>
                                                <h6 class="text-white m-b-0">Total Products</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <canvas id="update-chart-4" height="50"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i
                                                class="feather icon-clock text-white f-14 m-r-10"></i>Updated
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-pink update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                            <h4 class="text-white">0</h4>
                                            <h6 class="text-white m-b-0">Task Orders</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                            <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                            <canvas id="update-chart-3" height="62" width="98" style="display: block; height: 50px; width: 79px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Updated</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-c-lite-green update-card">
                                    <div class="card-block">
                                        <div class="row align-items-end">
                                            <div class="col-8">
                                            <h4 class="text-white">0</h4>
                                            <h6 class="text-white m-b-0">Total Categorys</h6>
                                            </div>
                                            <div class="col-4 text-right">
                                            <iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                            <canvas id="update-chart-4" height="62" width="98" style="display: block; height: 50px; width: 79px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Updated</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

@endsection
