<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->
	
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
	<div class="row">
		<div class="col-md-6">
			<h1 style="margin:0;"><?php echo (isset($session_login['user_name'])?$session_login['user_name']:'-');?></h1>
			<div class="text-muted">LAST LOGIN : <?php echo (isset($session_login['last_login'])?$session_login['last_login']:'-');?></div>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-muted">Total Penjualan</div>
					<h3 style="margin:5px 0 0;">1.530.000</h3>
				</div>
				<div class="panel-footer">
					<small>7 hari terakhir</small>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-muted">Total Pengeluaran</div>
					<h3 style="margin:5px 0 0;">580.000</h3>
				</div>
				<div class="panel-footer">
					<small>7 hari terakhir</small>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-muted">Barang Masuk</div>
					<h3 style="margin:5px 0 0;">100</h3>
				</div>
				<div class="panel-footer">
					<small>7 hari terakhir</small>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="text-muted">Total Produk</div>
					<h3 style="margin:5px 0 0;">512</h3>
				</div>
				<div class="panel-footer">
					<small>7 hari terakhir</small>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-heading"><strong>Traffic Summary</strong></div>
				<div class="panel-body">
					<div id="traffic" style="height:300px;"></div>
				</div>
			</div>
		</div>
	</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
	Highcharts.chart('traffic', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
        }
    },
    legend:{
    	enabled:false
    },
    credits:false,
    series: [{
        name: 'Web',
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    }]
});
</script>
	<?php /*
	<div class="col-md-12">

	  <div class="box box-success">
		<div class="box-body"> 
			<div class="pull-left">
				<h4 class="card-title">Selamat datang, <?php echo (isset($session_login['user_name'])?$session_login['user_name']:'-');?></h4>
			</div>
			<div class="pull-right"> 
				<div class="heading-elements">
				  <span class="badge badge-default badge-warning">Last Login</span>
				  <span class="badge badge-default badge-success"><?php echo (isset($session_login['last_login'])?$session_login['last_login']:'-');?></span> 
				</div>
			</div>
                  
                <!-- project-info -->
                <div id="project-info" class="card-body row" style="height: 400px;">
                  <div class="project-info-count col-lg-12 col-md-12"> 
					  <?php 
						if(trim($status)!='' AND trim($message)!=''){
					  ?>
						  <div class="alert alert-<?php echo ($status==200)?'success':'danger'; ?> alert-dismissible mb-2" role="alert"> 
							<small><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></small>   
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button> 

						  </div>
					  <?php
						}
					  ?> 
				  </div> 
                </div>

             
			</div>
		</div>
	</div>
 
      */?>
 