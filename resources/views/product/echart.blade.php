<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Product', 'Total Product type'],
                <?php echo $graphData; ?>
            ]);
            var options = {
                title: 'Product Details'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <center>
        <div id="piechart" style="width:300px; height: 260px;" class="mt-2"></div>
    </center>

</body>

</html>
