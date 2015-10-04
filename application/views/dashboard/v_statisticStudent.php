<script>
$(document).ready(function() {
	var oTable = $('#studentbil').dataTable({
    		"aoColumnDefs": [{ bSortable: false, aTargets: [0] } ],
			"iDisplayLength" : 10,
			"bJQueryUI": false,
			"bAutoWidth": true,
			//"sScrollY": "200px",
			"bPaginate": true,
	 		"oLanguage": {  	"sSearch": "Carian :",
		 						"sLengthMenu": "Papar _MENU_ senarai",
		 						"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
								"sInfoEmpty": "Tiada rekod untuk di papar",
								"sZeroRecords": "Tiada rekod yang sepadan ditemui",
								"sInfoFiltered": "Carian daripada _MAX_ rekod",
							    "oPaginate": {
							      "sFirst": "<?=nbs(4)?>",
							      "sPrevious": "<?=nbs(4)?>",
							      "sNext": "<?=nbs(4)?>",
							      "sLast": "<?=nbs(4)?>"
							     }
		 						},
	 							"bScrollCollapse": false,
	 							"aaSorting": [[ 1, 'asc' ]],
						 		"fnDrawCallback": function ( oSettings ) {
									if ( oSettings.bSorted || oSettings.bFiltered )
									{
										for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
										{
											$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
										}
									}
								}
	});

	new FixedHeader( oTable, {
        "offsetTop": 40
    } );

	//bila accordion report buka balik selepas ditutup dia akan panggil balik function fixedheader
	$('#accordion_report1').on('shown', function () {
		new FixedHeader( oTable, {
	        "offsetTop": 40
	    } );
	})

	//bagi mengelakkan fixedheader tu tergantung walaupun accordion dah ditutup, remove dia (tapi ni remove semua ye),
	//kalau ada lebih dari satu, kena pakai index
	$('#accordion_report1').on('hide', function () {
		$("body").children(".fixedHeader").each(function (index) {
            $(this).remove();
        });
   	})
	
});

</script>
<div class="row-fluid">
	
		<!--table student-->
		<table class="table table-striped table-bordered" id="studentbil" style="float: left; width: 100% !important; margin-bottom: 0px;">
			<thead>
				<tr style="background-color: white;">
					<th>Bil</th>
					<th>Kolej</th>
					<?php
					 $exdate  = date('Y', strtotime('-4 year'));
					
					$rangeyear=range($exdate, date("Y"));
                    
                  foreach ($rangeyear as $value) {
                      ?>
                      
                      <th><?= $value ?></th>
                      <?php
                  }
					?>
				</tr>
			</thead>
			<tbody>
				<?php  
				$bill=0;
				$categ='';
				$categories="";
				
				foreach ($dataStatistic as $value) {
					$bill++;
					$codekv=$value->col_type.$value->col_code;
                    
                   $yetake= explode(' ', $value->stu_intake_session);
					
					$categories[$codekv][$yetake[1]]="$value->totalstudent";
                  //  $categories[$codekv][$value->stu_intake_session]="$value->totalstudent";
					$colname[$codekv]=$value->col_name;
				
				?>
				<tr>
					<td><?=$bill?></td>
					<td><?=$value->col_type.$value->col_code."-".$value->col_name?></td>
					
					<?php 
					
					foreach ($rangeyear as  $ye) {
					        echo '';
					    
						?>
						<td><?=empty($categories[$codekv][$ye])?'-':$categories[$codekv][$ye]?></td>
						<?php
					}
                }
					?>
					
				</tr>
				<?php
				
				/* password
				arsort($categories);
				
				$top10=array_slice($categories,0,10);
				$cat='';
				$datagraf='';
				$valpie='';
				foreach ($top10 as $key => $row) {
					
					$cat.="'$key'".',';
					$datagraf.="$row".',';
					
					//datapie
					$valpie.="["."'$key',".$row."],";
				}
				
				
				 $json_top10=json_encode($colname);
				*/
				?>
				
			</tbody>
		</table>
		<!--end of table student-->
	</div>
	<?php /* ?>
	<div class="span6" style="background-color: yellow;">
		<!-- div graph untuk report -->
		<div id="chart_container" align="center">
			<!--end div graph untuk report -->
		</div>
	</div>
</div>

<script>
		var json_top10=null;
		$(document).ready(function() {
		json_top10=<?=$json_top10?>
		
	
			  $('#chart_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Murid Kolej Vokasional'
        },
        tooltip: {
    	    formatter:function() {
                   return '<b>'+ this.point.name +'</b><br/>'+
                        this.series.name +': '+ this.point.y +'<br/>'+
                        json_top10[this.point.name]
                }
    	    
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Murid',
            data: [<?=$valpie?>]
        }]
    });

	
		});
		
	</script>
<? */?>

<script>
	$(document).ready(function()
	{
		$('tspan:contains("Highcharts.com")').hide();
	});
</script>
