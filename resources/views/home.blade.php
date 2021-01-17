@extends('layouts.template.app')
@section('title', 'Keuangan')

@section('contents')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- *************************************************************** -->
        <!-- Start First Cards -->
        <!-- *************************************************************** -->
        <div class="card-group">
            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{$partner}}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Partner</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup class="set-doller">
                                    $</sup>{{$payment_sales}}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Sales Payment
                            </h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                        </div>
                    </div>
                </div>

            </div>



            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup class="set-doller">
                                    $</sup>{{$payment_purchase}}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Purchase Payment
                            </h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- *************************************************************** -->
        <!-- End First Cards -->
        <!-- *************************************************************** -->
        <!-- *************************************************************** -->
        <!-- Start Sales Charts Section -->
        <!-- *************************************************************** -->
        <div class="container-fluid">
            <!-- *************************************************************** -->
            <!-- Start First Cards -->
            <!-- *************************************************************** -->
            <div class="card-group">
                <div class="card border-right">
                    <div class="card-body">
                        <h4 class="card-title">Invoices Sale</h4>
                        <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                        <ul class="list-style-none mb-0">
                            <li>
                                <i class="fas fa-circle text-primary font-10 mr-2"></i>
                                <span class="text-muted">Done</span>
                                <span class="text-dark float-right font-weight-medium">${{$sales_done}}</span>
                            </li>
                            <li class="mt-3">
                                <i class="fas fa-circle text-danger font-10 mr-2"></i>
                                <span class="text-muted">Confirm</span>
                                <span class="text-dark float-right font-weight-medium">${{$sales_confirm}}</span>
                            </li>
                            <li class="mt-3">
                                <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                                <span class="text-muted">Draft</span>
                                <span class="text-dark float-right font-weight-medium">${{$sales_draft}}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card border-right">
                    <div class="card-body">
                        <h4 class="card-title">Invoices Purchase</h4>
                        <div id="campaign-v3" class="mt-2" style="height:283px; width:100%;"></div>
                        <ul class="list-style-none mb-0">
                            <li>
                                <i class="fas fa-circle text-primary font-10 mr-2"></i>
                                <span class="text-muted">Done</span>
                                <span class="text-dark float-right font-weight-medium">${{$purchase_done}}</span>
                            </li>
                            <li class="mt-3">
                                <i class="fas fa-circle text-danger font-10 mr-2"></i>
                                <span class="text-muted">Confirm</span>
                                <span class="text-dark float-right font-weight-medium">${{$purchase_confirm}}</span>
                            </li>
                            <li class="mt-3">
                                <i class="fas fa-circle text-cyan font-10 mr-2"></i>
                                <span class="text-muted">Draft</span>
                                <span class="text-dark float-right font-weight-medium">${{$purchase_draft}}</span>
                            </li>
                        </ul>
                    </div>

                </div>



            </div>
         
            <!-- *************************************************************** -->
            <!-- End Sales Charts Section -->
            <!-- *************************************************************** -->
            <!-- *************************************************************** -->
            <!-- Start Location and Earnings Charts Section -->
            <!-- *************************************************************** -->
            <!-- <div class="row">
                <div class="col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <h4 class="card-title mb-0">Earning Statistics</h4>
                                <div class="ml-auto">
                                    <div class="dropdown sub-dropdown">
                                        <button class="btn btn-link text-muted dropdown-toggle" type="button" id="dd1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                            <a class="dropdown-item" href="#">Insert</a>
                                            <a class="dropdown-item" href="#">Update</a>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-4 mb-5">
                                <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                            </div>
                            <ul class="list-inline text-center mt-4 mb-0">
                                <li class="list-inline-item text-muted font-italic">Earnings for this month</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div> -->
            <!-- *************************************************************** -->
            <!-- End Location and Earnings Charts Section -->
            <!-- *************************************************************** -->

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    @endsection

    @section('scripts')
    <script src="{{ asset('extra-libs/jvector/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('extra-libs/jvector/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.min.js')}}"></script>
    <script>
        $(function () {

        // ==============================================================
        // Campaign
        // ==============================================================
        var chart1 = c3.generate({
            bindto: '#campaign-v2',
            data: {
                columns: [
                    ['Done', {{$sales_done}}],
                    ['Confirm', {{$sales_confirm}}],
                    ['Draft', {{$sales_draft}}],
                ],

                type: 'donut',
                tooltip: {
                    show: true
                }
            },
            donut: {
                label: {
                    show: false
                },
                title: 'Sales',
                width: 18
            },

            legend: {
                hide: true
            },
            color: {
                pattern: [
                    'blue',
                    'red',
                    'cyan',
                ]
            }
        });

        d3.select('#campaign-v3 .c3-chart-arcs-title').style('font-family', 'Rubik');

        var chart1 = c3.generate({
            bindto: '#campaign-v3',
            data: {
                columns: [
                    ['Done', {{$purchase_done}}],
                    ['Confirm', {{$purchase_confirm}}],
                    ['Draft', {{$purchase_draft}}],
                ],

                type: 'donut',
                tooltip: {
                    show: true
                }
            },
            donut: {
                label: {
                    show: false
                },
                title: 'Purchase',
                width: 18
            },

            legend: {
                hide: true
            },
            color: {
                pattern: [
                    'blue',
                    'red',
                    'cyan',
                ]
            }
        });

        d3.select('#campaign-v3 .c3-chart-arcs-title').style('font-family', 'Rubik');

      

        // Offset x1 a tiny amount so that the straight stroke gets a bounding box
        chart.on('draw', function (ctx) {
            if (ctx.type === 'area') {
                ctx.element.attr({
                    x1: ctx.x1 + 0.001
                });
            }
        });

        // Create the gradient definition on created event (always after chart re-render)
        chart.on('created', function (ctx) {
            var defs = ctx.svg.elem('defs');
            defs.elem('linearGradient', {
                id: 'gradient',
                x1: 0,
                y1: 1,
                x2: 0,
                y2: 0
            }).elem('stop', {
                offset: 0,
                'stop-color': 'rgba(255, 255, 255, 1)'
            }).parent().elem('stop', {
                offset: 1,
                'stop-color': 'rgba(80, 153, 255, 1)'
            });
        });

        $(window).on('resize', function () {
            chart.update();
        });
        })
    </script>
    @endsection
