<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Product Type', 'Product sales'],
                <?php echo $chartData; ?>
            ]);

            var options = {
                chart: {
                    title: 'Product Details',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
</head>

<body>
    <center>
        <div id="columnchart_material" style="width: 300px; height: 260px;" class="mt-2"></div>
    </center>

</body>

</html>
