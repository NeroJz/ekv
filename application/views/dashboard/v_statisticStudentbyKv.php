<style type="text/css" media="print" >
#btn_cetak
{
	display: none !important;
	position: absolute;
}
</style>

<script>
$(document).ready(function()
{
	
	$('#studentsijil').dataTable({
		"aoColumnDefs": [{ bSortable: false, aTargets: [0] } ],
		//"sScrollY": "200px",
		"bPaginate": true,
		"oLanguage":{   "sSearch": "Carian :",
						"sLengthMenu": "Papar _MENU_ senarai",
						"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
						"sInfoEmpty": "Tiada rekod untuk di papar",
						"sZeroRecords": "Tiada rekod yang sepadan ditemui",
						"sInfoFiltered": "Carian daripada _MAX_ rekod",
						"oPaginate": {
										"sFirst": "Pertama",
										"sLast": "Terakhir",
										"sNext": "Seterus",
										"sPrevious": "Sebelum"
									}
					},
		"aaSorting": [[ 1, 'asc' ]],
		"fnDrawCallback": function ( oSettings )
		{
			if ( oSettings.bSorted || oSettings.bFiltered )
			{
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		}
	});

	$('#studentcourse').dataTable({
		"aoColumnDefs": [{ bSortable: false, aTargets: [0] } ],
		//"sScrollY": "200px",
		"bPaginate": true,
		"oLanguage": {	"sSearch": "Carian :",
						"sLengthMenu": "Papar _MENU_ senarai",
						"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
						"sInfoEmpty": "Tiada rekod untuk di papar",
						"sZeroRecords": "Tiada rekod yang sepadan ditemui",
						"sInfoFiltered": "Carian daripada _MAX_ rekod",
						"oPaginate": {
										"sFirst": "Pertama",
										"sLast": "Terakhir",
										"sNext": "Seterus",
										"sPrevious": "Sebelum"
									 }
					 },
		"aaSorting": [[ 1, 'asc' ]],
		"fnDrawCallback": function ( oSettings )
		{
			if ( oSettings.bSorted || oSettings.bFiltered )
			{
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		}
	});
});

function printit()
{
	document.getElementById('btn_cetak').style.display = 'none';
	//window.print()
	setTimeout("document.getElementById('btn_cetak').style.display = 'block';", 5000);
	
	var DocumentContainer = document.getElementById('panelReportStudent');
	var WindowObject = window.open('', "PrintWindow", '');
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
	
}

</script>

<div class="row-fluid">
	<button class="btn btn-primary pull-right" id="btn_cetak" onclick="printit()" media="all"> Cetak </button></br></br>
	<div class="spa12" style="background-color: yellow;">
		<!-- div graph untuk report -->
		<div id="chart_container" align="center">
			<!--end div graph untuk report -->
		</div>
	</div>
</div>

<?php  
	$bill = 0;
	$categ = '';
	$categories = "";
	$countcourse=count($dataStatistic);
	$semgraf[1]='';
	$semgraf[2]='';
	$semgraf[3]='';
	$semgraf[4]='';
	//$semgraf[5]='';
	//$semgraf[6]='';
	//$semgraf[7]='';
	//$semgraf[8]='';
	
	foreach ($dataStatistic as $value)
	{
		$bill++;
		//$codekv=$value->col_type.$value->col_code;
		$codecoures[$bill]=$value->cou_course_code."-".$value->cou_name;
		$kvc[$bill]=$value->cou_course_code;
		$codekv=$value->cou_course_code;
		$colname[$codekv]=$value->cou_name;
		$totalsijil[$kvc[$bill]]=0;
		$totaldip[$kvc[$bill]]=0;
		
		foreach($value->semstudent as $woe)
		{
			$semstudent[$codekv][$woe->stu_current_sem]=$woe->semstudent;
			$sems=$woe->stu_current_sem;
			
			if($sems <= 4)
			{
				$totalsijil[$kvc[$bill]]+=$woe->semstudent;
			}
			
			//if($sems > 4)
			//{
			//	$totaldip[$kvc[$bill]]+=$woe->semstudent;
			//}
		}
		
		$nilasem='';
		
		for($semg=1; $semg<=4; $semg++) //for($semg=1; $semg<=8; $semg++)
		{
			$catgraf[]=$codekv;
			$nilasem=empty($semstudent[$value->cou_course_code][$semg])?"0":$semstudent[$codekv][$semg];
			$semgraf[$semg].=$nilasem.',';
		}
	}
			
	$catgrafuniq=array_unique($catgraf);
	$catuniq='';
	
	foreach($catgrafuniq as $rowcat)
	{
		$catuniq.="'$rowcat'".',';
	}
	
	$json_top10=json_encode($colname);
?>
 
<div class="row-fluid">
	<div class="span12">
	<!--table student-->
 		<br/>
		<h4>Jumlah Murid Mengikut Kursus Dan Semester</h4>
			<table class="table table-striped table-bordered" id="studentsijil" style="float: left; margin-bottom: 0px;">
				<thead>
					<tr>
						<th>Bil</th>
						<th>Kursus</th>
						<th>Semester 1</th>
						<th>Semester 2</th>
						<th>Semester 3</th>
						<th>Semester 4</th>
						<th>Murid</th>						
					</tr>
				</thead>
				<tbody>
				<?php  
					for($ccc=1; $ccc<=$countcourse; $ccc++){ 
				?>
						<tr>
							<td><?=$ccc?></td>
							<td><?=$codecoures[$ccc]?></td>
							<?php for($s=1; $s<=4; $s++){ ?>
							<td><?=empty($semstudent[$kvc[$ccc]][$s])?'-':$semstudent[$kvc[$ccc]][$s] ?></td>
							<?php } ?>
							<td><?=$totalsijil[$kvc[$ccc]]?></td>
						</tr>
				<?php
					}
				?>
				</tbody>
			</table>
	<!--end of table student-->
    </div>
    <?php /* // This table is tempry hidden 
	<div class="span6">
    <!--table student-->    
	<h4>Diploma</h4>
		<table class="table table-striped table-bordered" id="studentcourse" style="float: left; margin-bottom: 0px;">
			<thead>
				<tr>
					<th>Bil</th>
					<th>Kursus</th>
					<th>Semester 5</th>
					<th>Semester 6</th>
					<th>Semester 7</th>
					<th>Semester 8</th>
					<th>Pelajar</th>
					
				</tr>
			</thead>
			<tbody>
			<?php  
				for($cc=1; $cc<=$countcourse; $cc++)
				{ 
			?>
					<tr>
						<td><?=$cc?></td>
						<td><?=$codecoures[$cc]?></td>
						<?php for($s=5; $s<=8; $s++){ ?>
						<td><?=empty($semstudent[$kvc[$cc]][$s])?'-':$semstudent[$kvc[$cc]][$s] ?></td>
						<?php } ?>
						<td><?=$totaldip[$kvc[$cc]]?></td>
					</tr>
			<?php					
				}
			?>
			</tbody>
		</table>
	<!--end of table student-->
	</div>
	 */ ?>
</div>

<script>
	
/**************************************************************************************************
 * HighChart Theme : Drak Blue
 * Add By Norafiq 24 feb 2014
 *************************************************************************************************/

Highcharts.theme = {
   colors: ["#DDDF0D", "#55BF3B", "#DF5353", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      		"#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: { backgroundColor: { linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
	   						   stops: [[0, 'rgb(48, 48, 96)'],[1, 'rgb(0, 0, 0)']]},
      		borderColor: '#000000',
      		borderWidth: 2,
      		className: 'dark-container',
      		plotBackgroundColor: 'rgba(255, 255, 255, .1)',
      		plotBorderColor: '#CCCCCC',
      		plotBorderWidth: 1 },
   title: {style: { color: '#C0C0C0', font: 'bold 16px "Trebuchet MS", Verdana, sans-serif' }},
   subtitle: { style: { color: '#666666', font: 'bold 12px "Trebuchet MS", Verdana, sans-serif' }},
   xAxis: { gridLineColor: '#333333',
	   		gridLineWidth: 1,
	   		labels: { style: { color: '#A0A0A0' }},
	   		lineColor: '#A0A0A0',
	   		tickColor: '#A0A0A0',
	   		title: {style: { color: '#CCC', fontWeight: 'bold', fontSize: '12px', fontFamily: 'Trebuchet MS, Verdana, sans-serif' }
	   	  }},
   yAxis: { gridLineColor: '#333333',
   			labels: { style: { color: '#A0A0A0' }
 		  },
   lineColor: '#A0A0A0',
   minorTickInterval: null,
   tickColor: '#A0A0A0',
   tickWidth: 1,
   title: { style: { color: '#CCC',
   					 fontWeight: 'bold',
   					 fontSize: '12px',
   					 fontFamily: 'Trebuchet MS, Verdana, sans-serif'
   				   }
   		   }
   },
   tooltip: { backgroundColor: 'rgba(0, 0, 0, 0.75)',
   			  style: { color: '#F0F0F0' }
   },
   toolbar: {
      itemStyle: {
         color: 'silver'
      }
   },
   plotOptions: {
      line: {
         dataLabels: {
            color: '#CCC'
         },
         marker: {
            lineColor: '#333'
         }
      },
      spline: {
         marker: {
            lineColor: '#333'
         }
      },
      scatter: {
         marker: {
            lineColor: '#333'
         }
      },
      candlestick: {
         lineColor: 'white'
      }
   },
   legend: {
      itemStyle: {
         font: '9pt Trebuchet MS, Verdana, sans-serif',
         color: '#A0A0A0'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#444'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#CCC'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         hoverSymbolStroke: '#FFFFFF',
         theme: {
            fill: {
               linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
               stops: [
                  [0.4, '#606060'],
                  [0.6, '#333333']
               ]
            },
            stroke: '#000000'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
               [0.4, '#888'],
               [0.6, '#555']
            ]
         },
         stroke: '#000000',
         style: {
            color: '#CCC',
            fontWeight: 'bold'
         },
         states: {
            hover: {
               fill: {
                  linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                  stops: [
                     [0.4, '#BBB'],
                     [0.6, '#888']
                  ]
               },
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: {
                  linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                  stops: [
                     [0.1, '#000'],
                     [0.3, '#333']
                  ]
               },
               stroke: '#000000',
               style: {
                  color: 'yellow'
               }
            }
         }
      },
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(16, 16, 16, 0.5)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      }
   },

   scrollbar: {
      barBackgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
               [0.4, '#888'],
               [0.6, '#555']
            ]
         },
      barBorderColor: '#CCC',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
               [0.4, '#888'],
               [0.6, '#555']
            ]
         },
      buttonBorderColor: '#CCC',
      rifleColor: '#FFF',
      trackBackgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
         stops: [
            [0, '#000'],
            [1, '#333']
         ]
      },
      trackBorderColor: '#666'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   legendBackgroundColorSolid: 'rgb(35, 35, 70)',
   dataLabelsColor: '#444',
   textColor: '#C0C0C0',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);

/**************************************************************************************************
 * This Function to plot a data into graph.
 * Anthor : Sukor Muhammad
 *************************************************************************************************/
$(function () 
{
	$('#chart_container').highcharts({

		chart: { type: 'bar' },
		title: { text: 'Murid Mengikut Kursus dan Semester' },
		xAxis: { categories: [<?=$catuniq?>] },
		yAxis: {
					min: 0,
					title: { text: 'Bilangan Murid' }
		},
        legend: { backgroundColor: '#FFFFFF', reversed: true },
        plotOptions: {
        				series: { stacking: 'normal' }
        },
        series: [{
        		 	name: 'Semester 4',
        		 	color: '#15B42E',
        		 	data: [<?= $semgraf[4]?>]
        		 }, {
        		 	name: 'Semester 3',
        		 	color: '#DE76F1',
        		 	data: [<?= $semgraf[3]?>]
        		 }, {
        		 	name: 'Semester 2',
        		 	color: '#4CE7DB',
        		 	data: [<?= $semgraf[2]?>]
        		 }, {
        		 	name: 'Semester 1',
        		 	color: '#DAE92E',
        		 	data: [<?= $semgraf[1]?>]
        		 }]
		<?php /* //origanal code temperory hidden 
        series: [{
					name: 'Semester 8',
					color: '#0066FF',
					data: [<?= $semgraf[8]?>]
				  }, {
				  	name: 'Semester 7',
				  	color: '#ACA4A4',
				  	data: [<?= $semgraf[7]?>]
				  }, {
				  	name: 'Semester 6',
				  	color: '#E22C1D',
				  	data: [<?= $semgraf[6]?>]
				  }, {
				  	name: 'Semester 5',
				  	color: '#EC911C',
				  	data: [<?= $semgraf[5]?>]
				  }, {
				 	name: 'Semester 4',
				 	color: '#15B42E',
				 	data: [<?= $semgraf[4]?>]
				 }, {
				 	name: 'Semester 3',
				 	color: '#DE76F1',
				 	data: [<?= $semgraf[3]?>]
				 }, {
				 	name: 'Semester 2',
				 	color: '#4CE7DB',
				 	data: [<?= $semgraf[2]?>]
				 }, {
				 	name: 'Semester 1',
				 	color: '#DAE92E',
				 	data: [<?= $semgraf[1]?>]
		 }] */?>
    });

	$('tspan:contains("Highcharts.com")').hide();
	
});
</script>
<?php  ?>
