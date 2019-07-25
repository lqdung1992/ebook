<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Admin - Dashboard HTML Template</title>
        <base href="{{asset('')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <!-- https://fonts.google.com/specimen/Roboto -->
    <link rel="stylesheet" href="backend/css/fontawesome.min.css">
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="backend/css/bootstrap.min.css">
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="backend/css/templatemo-style.css">
    <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
</head>

<body id="reportsPage">
    <div class="" id="home">
        @include('admin.layout.header')

        @yield('content')

        @include('admin.layout.footer')
    </div>

    <script src="backend/js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="backend/js/moment.min.js"></script>
    <!-- https://momentjs.com/ -->
    <script src="backend/js/Chart.min.js"></script>
    <!-- http://www.chartjs.org/docs/latest/ -->
    <script src="backend/js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script src="backend/js/tooplate-scripts.js"></script>
    <script>
        Chart.defaults.global.defaultFontColor = 'white';
        let ctxLine,
            ctxBar,
            ctxPie,
            optionsLine,
            optionsBar,
            optionsPie,
            configLine,
            configBar,
            configPie,
            lineChart;
        barChart, pieChart;
        // DOM is ready
        $(function () {
            drawLineChart(); // Line Chart
            drawBarChart(); // Bar Chart
            drawPieChart(); // Pie Chart

            $(window).resize(function () {
                updateLineChart();
                updateBarChart();                
            });
        })
    </script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    @yield('script')
</body>

</html>