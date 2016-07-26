<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?><!DOCTYPE html>
<!--load jQuery library-->
<script type="text/javascript">$("#total_ira").maskMoney({prefix:'', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});</script>
<script type="text/javascript">$("#total_budget_lswdo").maskMoney({prefix:'', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});</script>
<script type="text/javascript">$("#budget_previous_year").maskMoney({prefix:'', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});</script>
<script type="text/javascript">$("#budget_present_year").maskMoney({prefix:'', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});</script>
<script type="text/javascript">$("#utilization").maskMoney({prefix:'', allowNegative: true, thousands:',', decimal:'.', affixesStay: true});</script>
<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/jquery.min.js'); ?>"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap/bootstrap.min.js'); ?>"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/plugins.js'); ?>"></script>

<!-- ================================================
Bootstrap Select
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap-select/bootstrap-select.js'); ?>"></script>

<!-- ================================================
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap-toggle/bootstrap-toggle.min.js'); ?>"></script>

<!-- ================================================
Bootstrap WYSIHTML5
================================================ -->
<!-- main file -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap-wysihtml5/wysihtml5-0.3.0.min.js'); ?>"></script>
<!-- bootstrap file -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js'); ?>"></script>

<!-- ================================================
Summernote
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/summernote/summernote.min.js'); ?>"></script>

<!-- HIGH CHARTS-->


<script type="text/javascript" src="<?php echo base_url('assets/js/highcharts.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/modules/exporting.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/modules/export-csv.js'); ?>"></script>

<!-- ================================================
/modules/exporting.js
Flot Chart
================================================ -->
<!-- main file -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/flot-chart/flot-chart.js'); ?>"></script>
<!-- time.js -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/flot-chart/flot-chart-time.js'); ?>"></script>
<!-- stack.js -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/flot-chart/flot-chart-stack.js'); ?>"></script>
<!-- pie.js -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/flot-chart/flot-chart-pie.js'); ?>"></script>
<!-- demo codes -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/flot-chart/flot-chart-plugin.js'); ?>"></script>

<!-- ================================================
Chartist
================================================ -->
<!-- main file -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/chartist/chartist.js'); ?>"></script>
<!-- demo codes -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/chartist/chartist-plugin.js'); ?>"></script>

<!-- ================================================
Easy Pie Chart
================================================ -->
<!-- main file -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/easypiechart/easypiechart.js'); ?>"></script>
<!-- demo codes -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/easypiechart/easypiechart-plugin.js'); ?>"></script>

<!-- ================================================
Sparkline
================================================ -->
<!-- main file -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/sparkline/sparkline.js'); ?>"></script>
<!-- demo codes -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/sparkline/sparkline-plugin.js'); ?>"></script>

<!-- ================================================
Rickshaw
================================================ -->
<!-- d3 -->
<script src="<?php echo base_url('assets/bootstrap/js/rickshaw/d3.v3.js'); ?>"></script>
<!-- main file -->
<script src="<?php echo base_url('assets/bootstrap/js/rickshaw/rickshaw.js'); ?>"></script>
<!-- demo codes -->
<script src="<?php echo base_url('assets/bootstrap/js/rickshaw/rickshaw-plugin.js'); ?>"></script>

<!-- ================================================
Data Tables
================================================ -->
<script src="<?php echo base_url('assets/bootstrap/js/datatables/datatables.min.js'); ?>"></script>

<!-- ================================================
Sweet Alert
================================================ -->
<script src="<?php echo base_url('assets/bootstrap/js/sweet-alert/sweet-alert.min.js'); ?>"></script>

<!-- ================================================
Kode Alert
================================================ -->
<script src="<?php echo base_url('assets/bootstrap/js/kode-alert/main.js'); ?>"></script>

<!-- ================================================
Gmaps
================================================ -->
<!-- google maps api -->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<!-- main file -->
<script src="js/gmaps/gmaps.js"></script>
<!-- demo codes -->
<script src="<?php echo base_url('assets/bootstrap/js/gmaps/gmaps-plugin.js'); ?>"></script>

<!-- ================================================
jQuery UI
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/jquery-ui/jquery-ui.min.js'); ?>"></script>

<!-- ================================================
Moment.js
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/moment/moment.min.js'); ?>"></script>

<!-- ================================================
Full Calendar
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/full-calendar/fullcalendar.js'); ?>"></script>

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/date-range-picker/daterangepicker.js'); ?>"></script>


<!-- Basic Date Range Picker -->
<script type="text/javascript">
$(document).ready(function() {
  $('#date-range-picker').daterangepicker(null, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
});
</script>

<!-- Basic Single Date Picker -->
<script type="text/javascript">
$(document).ready(function() {
  $('#date-picker').daterangepicker({ singleDatePicker: true }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
});
</script>

<!-- Date Range and Time Picker -->
<script type="text/javascript">
$(document).ready(function() {
  $('#date-range-and-time-picker').daterangepicker({
    timePicker: true,
    timePickerIncrement: 30,
    format: 'MM/DD/YYYY h:mm A'
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
});
</script>


<!-- Today Activity -->
<script>
// set up our data series with 50 random data points

var seriesData = [ [], [], [] ];
var random = new Rickshaw.Fixtures.RandomData(20);

for (var i = 0; i < 50; i++) {
  random.addData(seriesData);
}

// instantiate our graph!

var graph = new Rickshaw.Graph( {
  element: document.getElementById("todayactivity"),
  renderer: 'area',
  series: [
    {
      color: "#9A80B9",
      data: seriesData[0],
      name: 'London'
    }, {
      color: "#CDC0DC",
      data: seriesData[1],
      name: 'Tokyo'
    }
  ]
} );

graph.render();

var hoverDetail = new Rickshaw.Graph.HoverDetail( {
  graph: graph,
  formatter: function(series, x, y) {
    var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
    var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
    var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
    return content;
  }
} );
</script>

<script>
$(document).ready(function() {
    $('#example0').DataTable();
} );
</script>



<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 2 }
        ],
        "order": [[ 2, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
 
    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'asc' ] ).draw();
        }
    } );
} );
</script>
<!-- carla-->
<!---->

<script type="text/javascript" src="js/date-range-picker/daterangepicker.js"></script>
<!-- Basic Date Range Picker -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#date-range-picker').daterangepicker(null, function(start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
</script>


<!-- carla-->
</body>
</html>
<?php // jfsbaldo merged 020520161408
//YouGene v2
// josef footer comment
?>