<?php $__env->startSection('title', translate('Dashboard')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" src="<?php echo e(asset('public/assets/admin')); ?>/vendor/apex/apexcharts.css"></link>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
        <div class="content container-fluid">
            <div>
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h1 class="page-header-title c1"><?php echo e(translate('welcome')); ?>, <?php echo e(auth('admin')->user()->f_name); ?>.</h1>
                        <p class="text-dark font-weight-semibold"><?php echo e(translate('Monitor_your_business_analytics_and_statistics')); ?></p>
                    </div>
                </div>
            </div>
            <?php if(Helpers::module_permission_check(MANAGEMENT_SECTION['dashboard_management'])): ?>

            <div class="card card-body mb-3">
                <div class="row justify-content-between align-items-center g-2 mb-3">
                    <div class="col-auto">
                        <h4 class="d-flex align-items-center gap-10 mb-0">
                            <img width="20" class="avatar-img rounded-0" src="<?php echo e(asset('public/assets/admin/img/icons/business_analytics.png')); ?>" alt="Business Analytics">
                            <?php echo e(translate('Business_Analytics')); ?>

                        </h4>
                    </div>
                    <div class="col-auto">
                        <select class="custom-select min-w200" name="statistics_type" onchange="order_stats_update(this.value)">
                            <option value="overall" <?php echo e(session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''); ?>>
                                <?php echo e(translate('Overall Statistics')); ?>

                            </option>
                            <option value="today" <?php echo e(session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''); ?>>
                                <?php echo e(translate("Today")."'s"); ?> <?php echo e(translate("Statistics")); ?>

                            </option>
                            <option value="this_month" <?php echo e(session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''); ?>>
                                <?php echo e(translate("This Month")."'s"); ?> <?php echo e(translate("Statistics")); ?>

                            </option>
                        </select>
                    </div>
                </div>
                <div class="row g-2" id="order_stats">
                    <?php echo $__env->make('admin-views.partials._dashboard-order-stats',['data'=>$data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <div class="grid-chart mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                            <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                <img width="20" class="avatar-img rounded-0" src="<?php echo e(asset('public/assets/admin/img/icons/earning_statistics.png')); ?>" alt="">
                                <?php echo e(translate('order_statistics')); ?>

                            </h4>

                            <ul class="option-select-btn">
                                <li>
                                    <label>
                                        <input type="radio" name="statistics" hidden checked>
                                        <span data-order-type="yearOrder"
                                              onclick="orderStatisticsUpdate(this)"><?php echo e(translate('This_Year')); ?></span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio" name="statistics" hidden="">
                                        <span data-order-type="MonthOrder"
                                              onclick="orderStatisticsUpdate(this)"><?php echo e(translate('This_Month')); ?></span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio" name="statistics" hidden="">
                                        <span data-order-type="WeekOrder"
                                              onclick="orderStatisticsUpdate(this)"><?php echo e(translate('This Week')); ?></span>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div id="updatingOrderData" class="custom-chart mt-2">
                            <div id="order-statistics-line-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="card h-100 order-last order-lg-0">
                    <div class="card-header">
                        <h4 class="d-flex text-capitalize mb-0">
                            <?php echo e(translate('order_status_statistics')); ?>

                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mt-2">
                            <div>
                                <div class="position-relative pie-chart">
                                    <div id="dognut-pie"></div>
                                    <div class="total--orders">
                                        <h3><?php echo e($donut['pending'] + $donut['ongoing'] + $donut['delivered']+ $donut['canceled']+ $donut['returned']+ $donut['failed']); ?> </h3>
                                        <span><?php echo e(translate('orders')); ?></span>
                                    </div>
                                </div>
                                <div class="apex-legends">
                                    <div class="before-bg-pending">
                                        <span><?php echo e(translate('pending')); ?> (<?php echo e($donut['pending']); ?>)</span>
                                    </div>
                                    <div class="before-bg-ongoing">
                                        <span><?php echo e(translate('ongoing')); ?> (<?php echo e($donut['ongoing']); ?>)</span>
                                    </div>
                                    <div class="before-bg-delivered">
                                        <span><?php echo e(translate('delivered')); ?> (<?php echo e($donut['delivered']); ?>)</span>
                                    </div>
                                    <div class="before-bg-17202A">
                                        <span><?php echo e(translate('canceled')); ?> (<?php echo e($donut['canceled']); ?>)</span>
                                    </div>
                                    <div class="before-bg-21618C">
                                        <span><?php echo e(translate('returned')); ?> (<?php echo e($donut['returned']); ?>)</span>
                                    </div>
                                    <div class="before-bg-27AE60">
                                        <span><?php echo e(translate('failed_to_deliver')); ?> (<?php echo e($donut['failed']); ?>)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card h100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                            <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                <img width="20" class="avatar-img rounded-0" src="<?php echo e(asset('public/assets/admin/img/icons/earning_statistics.png')); ?>" alt="">
                                <?php echo e(translate('earning_statistics')); ?>

                            </h4>
                            <ul class="option-select-btn">
                                <li>
                                    <label>
                                        <input type="radio" name="statistics2" hidden="" checked="">
                                        <span data-earn-type="yearEarn"
                                              onclick="earningStatisticsUpdate(this)"><?php echo e(translate('This_Year')); ?></span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio" name="statistics2" hidden="">
                                        <span data-earn-type="MonthEarn"
                                              onclick="earningStatisticsUpdate(this)"><?php echo e(translate('This_Month')); ?></span>
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="radio" name="statistics2" hidden="">
                                        <span data-earn-type="WeekEarn"
                                              onclick="earningStatisticsUpdate(this)"><?php echo e(translate('This Week')); ?></span>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <div id="updatingData" class="custom-chart mt-2">
                            <div id="line-adwords"></div>
                        </div>
                    </div>
                </div>

                <div class="card h100 recent-orders">
                    <div class="card-header d-flex justify-content-between gap-10">
                        <h5 class="mb-0"><?php echo e(translate('recent_Orders')); ?></h5>
                        <a href="<?php echo e(route('admin.orders.list', ['status' => 'all'])); ?>" class="btn-link"><?php echo e(translate('View_All')); ?></a>
                    </div>
                    <div class="card-body">
                        <ul class="common-list">
                            <?php $__currentLoopData = $data['recent_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="pt-0 d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                    <div class="order-info ">
                                        <h5><a href="<?php echo e(route('admin.orders.details', ['id' => $recent->id])); ?>" class="text-dark" ><?php echo e(translate('Order')); ?># <?php echo e($recent->id); ?></a></h5>
                                        <p><?php echo e(\Illuminate\Support\Carbon::parse($recent->created_at)->format('d-m-y, h:m A')); ?></p>
                                    </div>
                                    <?php if($recent['order_status'] == 'pending'): ?>
                                        <span
                                            class="status text-primary"><?php echo e(translate($recent['order_status'])); ?></span>
                                    <?php elseif($recent['order_status'] == 'delivered'): ?>
                                        <span
                                            class="status text-success"><?php echo e(translate($recent['order_status'])); ?></span>
                                    <?php elseif($recent['order_status'] == 'confirmed' || $recent['order_status'] == 'processing' || $recent['order_status'] == 'out_for_delivery'): ?>
                                        <span
                                            class="status text-warning"><?php echo e(translate($recent['order_status'])); ?></span>
                                    <?php elseif($recent['order_status'] == 'canceled' || $recent['order_status'] == 'failed'): ?>
                                        <?php if($recent['order_status'] == 'failed'): ?>
                                            <span
                                                class="status text-warning"><?php echo e(translate('failed_to_deliver')); ?></span>
                                        <?php else: ?>
                                            <span
                                                class="status text-warning"><?php echo e(translate($recent['order_status'])); ?></span>
                                        <?php endif; ?>

                                    <?php elseif($recent['order_status'] == 'cooking'): ?>
                                        <span
                                            class="status text-info"><?php echo e(translate($recent['order_status'])); ?></span>
                                    <?php elseif($recent['order_status'] == 'completed'): ?>
                                        <span
                                            class="status text-success"><?php echo e(translate($recent['order_status'])); ?></span>
                                    <?php else: ?>
                                        <span
                                            class="status text-primary"><?php echo e(translate($recent['order_status'])); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php echo $__env->make('admin-views.partials._top-selling-products',['top_sell'=>$data['top_sell']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php echo $__env->make('admin-views.partials._most-rated-products',['most_rated_products'=>$data['most_rated_products']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php echo $__env->make('admin-views.partials._top-customer',['top_customer'=>$data['top_customer']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php $__env->stopSection(); ?>

        <?php $__env->startPush('script'); ?>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/apex/apexcharts.min.js"></script>
        <?php $__env->stopPush(); ?>


        <?php $__env->startPush('script_2'); ?>
            <script>
                var OSDCoptions = {
                    chart: {
                        height: 328,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false,
                        },
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    colors: ['rgba(255, 111, 112, 0.5)', '#107980'],
                    series: [{
                        name: "Order",
                            data: [
                                <?php echo e($order_statistics_chart[1]); ?>, <?php echo e($order_statistics_chart[2]); ?>, <?php echo e($order_statistics_chart[3]); ?>, <?php echo e($order_statistics_chart[4]); ?>,
                                <?php echo e($order_statistics_chart[5]); ?>, <?php echo e($order_statistics_chart[6]); ?>, <?php echo e($order_statistics_chart[7]); ?>, <?php echo e($order_statistics_chart[8]); ?>,
                                <?php echo e($order_statistics_chart[9]); ?>, <?php echo e($order_statistics_chart[10]); ?>, <?php echo e($order_statistics_chart[11]); ?>, <?php echo e($order_statistics_chart[12]); ?>

                            ]
                        },
                    ],
                    markers: {
                        size: 2,
                        strokeWidth: 0,
                        hover: {
                            size: 5
                        }
                    },
                    grid: {
                        show: true,
                        padding: {
                            bottom: 0
                        },
                        borderColor: "rgba(180, 208, 224, 0.5)",
                        strokeDashArray: 7,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    xaxis: {
                        tooltip: {
                            enabled: false
                        }
                    },
                    legend: {
                        show: false,
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: 10
                    }
                }

                var chartLine = new ApexCharts(document.querySelector('#order-statistics-line-chart'), OSDCoptions);
                chartLine.render();
            </script>

            <script>
                var options = {
                    series: [<?php echo e($donut['ongoing']); ?>, <?php echo e($donut['delivered']); ?>, <?php echo e($donut['pending']); ?>, <?php echo e($donut['canceled']); ?>, <?php echo e($donut['returned']); ?>, <?php echo e($donut['failed']); ?>],
                    chart: {
                        width: 256,
                        type: 'donut',
                    },
                    labels: ['<?php echo e(translate('ongoing')); ?>', '<?php echo e(translate('delivered')); ?>', '<?php echo e(translate('pending')); ?>', '<?php echo e(translate('canceled')); ?>', '<?php echo e(translate('returned')); ?>', '<?php echo e(translate('failed_to_deliver')); ?>'],
                    dataLabels: {
                        enabled: false,
                        style: {
                            colors: ['#803838', '#27AE60', '#FF6F70', '#17202A', '#21618C', '#FF0000']
                        }
                    },
                    responsive: [{
                        breakpoint: 1650,
                        options: {
                            chart: {
                                width: 250
                            },
                        }
                    }],
                    colors: ['#803838', '#27AE60', '#FF6F70', '#17202A', '#21618C', '#FF0000'],
                    fill: {
                        colors: ['#803838', '#27AE60', '#FF6F70', '#17202A', '#21618C', '#FF0000']
                    },
                    legend: {
                        show: false
                    },
                };

                var chart = new ApexCharts(document.querySelector("#dognut-pie"), options);
                chart.render();

            </script>

            <script>
                var earningOptions = {
                    chart: {
                        height: 328,
                        type: 'line',
                        zoom: {
                        enabled: false
                        },
                        toolbar: {
                            show: false,
                        },
                    },
                    stroke: {
                        curve: 'straight',
                        width: 3
                    },
                    colors: ['rgba(255, 111, 112, 0.5)', '#107980'],
                    series: [{
                        name: "Earning",
                        data: [<?php echo e($earning[1]); ?>, <?php echo e($earning[2]); ?>, <?php echo e($earning[3]); ?>, <?php echo e($earning[4]); ?>, <?php echo e($earning[5]); ?>, <?php echo e($earning[6]); ?>,
                            <?php echo e($earning[7]); ?>, <?php echo e($earning[8]); ?>, <?php echo e($earning[9]); ?>, <?php echo e($earning[10]); ?>, <?php echo e($earning[11]); ?>, <?php echo e($earning[12]); ?>],
                        },
                    ],
                    markers: {
                        size: 2,
                        strokeWidth: 0,
                        hover: {
                            size: 5
                        }
                    },
                    grid: {
                        show: true,
                        padding: {
                            bottom: 0
                        },
                        borderColor: "rgba(180, 208, 224, 0.5)",
                        strokeDashArray: 7,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    xaxis: {
                        tooltip: {
                            enabled: false
                        }
                    },
                    legend: {
                        show: false,
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: 10
                    }
                }

                var chartLine = new ApexCharts(document.querySelector('#line-adwords'), earningOptions);
                chartLine.render();
            </script>

            <script>
                function order_stats_update(type) {
                    console.log(type)
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "<?php echo e(route('admin.order-stats')); ?>",
                        type: "post",
                        data: {
                            statistics_type: type,
                        },
                        beforeSend: function () {
                            $('#loading').show()
                        },
                        success: function (data) {
                            $('#order_stats').html(data.view)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        },
                        complete: function () {
                            $('#loading').hide()
                        }
                    });
                }
            </script>

            <script>
                Chart.plugins.unregister(ChartDataLabels);

                $('.js-chart').each(function () {
                    $.HSCore.components.HSChartJS.init($(this));
                });

                var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

            </script>
            <script>
                function orderStatisticsUpdate(t) {
                    let value = $(t).attr('data-order-type');
                    console.log(value);

                    $.ajax({
                        url: '<?php echo e(route('admin.order-statistics')); ?>',
                        type: 'GET',
                        data: {
                            type: value
                        },
                        beforeSend: function () {
                            $('#loading').show()
                        },
                        success: function (response_data) {
                            document.getElementById("order-statistics-line-chart").remove();
                            let graph = document.createElement('div');
                            graph.setAttribute("id", "order-statistics-line-chart");
                            document.getElementById("updatingOrderData").appendChild(graph);

                            var options = {
                                series: [{
                                    name: "Orders",
                                    data: response_data.orders,
                                }],
                                chart: {
                                    height: 316,
                                    type: 'line',
                                    zoom: {
                                        enabled: false
                                    },
                                    toolbar: {
                                        show: false,
                                    },
                                    markers: {
                                        size: 5,
                                    }
                                },
                                dataLabels: {
                                    enabled: false,
                                },
                                colors: ['rgba(255, 111, 112, 0.5)', '#107980'],
                                stroke: {
                                    curve: 'smooth',
                                    width: 3,
                                },
                                xaxis: {
                                    categories: response_data.orders_label,
                                },
                                grid: {
                                    show: true,
                                    padding: {
                                        bottom: 0
                                    },
                                    borderColor: "rgba(180, 208, 224, 0.5)",
                                    strokeDashArray: 7,
                                    xaxis: {
                                        lines: {
                                            show: true
                                        }
                                    }
                                },
                                yaxis: {
                                    tickAmount: 4,
                                }
                            };

                            var chart = new ApexCharts(document.querySelector("#order-statistics-line-chart"), options);
                            chart.render();
                        },
                        complete: function () {
                            $('#loading').hide()
                        }
                    });
                }

                function earningStatisticsUpdate(t) {
                    let value = $(t).attr('data-earn-type');
                    $.ajax({
                        url: '<?php echo e(route('admin.earning-statistics')); ?>',
                        type: 'GET',
                        data: {
                            type: value
                        },
                        beforeSend: function () {
                            $('#loading').show()
                        },
                        success: function (response_data) {
                            console.log(response_data)
                            document.getElementById("line-adwords").remove();
                            let graph = document.createElement('div');
                            graph.setAttribute("id", "line-adwords");
                            document.getElementById("updatingData").appendChild(graph);

                            var optionsLine = {
                                chart: {
                                    height: 328,
                                    type: 'line',
                                    zoom: {
                                        enabled: false
                                    },
                                    toolbar: {
                                        show: false,
                                    },
                                },
                                stroke: {
                                    curve: 'straight',
                                    width: 2
                                },
                                colors: ['rgba(255, 111, 112, 0.5)', '#107980'],
                                series: [{
                                    name: "Earning",
                                    data: response_data.earning,
                                }],
                                markers: {
                                    size: 6,
                                    strokeWidth: 0,
                                    hover: {
                                        size: 9
                                    }
                                },
                                grid: {
                                    show: true,
                                    padding: {
                                        bottom: 0
                                    },
                                    borderColor: "rgba(180, 208, 224, 0.5)",
                                    strokeDashArray: 7,
                                    xaxis: {
                                        lines: {
                                            show: true
                                        }
                                    }
                                },
                                labels: response_data.earning_label,
                                xaxis: {
                                    tooltip: {
                                        enabled: false
                                    }
                                },
                                legend: {
                                    position: 'top',
                                    horizontalAlign: 'right',
                                    offsetY: -20
                                }
                            }
                            var chartLine = new ApexCharts(document.querySelector('#line-adwords'), optionsLine);
                            chartLine.render();
                        },
                        complete: function () {
                            $('#loading').hide()
                        }
                    });
                }
            </script>

        <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chicksnook.net/foodAppBackEnd/foodAppBackEnd/resources/views/admin-views/dashboard.blade.php ENDPATH**/ ?>