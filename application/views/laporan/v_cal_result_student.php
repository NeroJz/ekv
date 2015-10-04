<script language="javascript" type="text/javascript" >
    var kodkv = [
                <?= $centrecode ?>
            ];
  $(document).ready(function(){
	$("#frm_pusat").validationEngine(
			'attach', {scroll: false}
			
		);
	
		$( "#kodpusat" ).autocomplete({
			source: kodkv,
			close: function( event, ui ) {}
		});	
		
		//alert($('#kodpusat').attr('type'));
		if("hidden" == $('#kodpusat').attr('type'))
		{
			var inputVal = $('#kodpusat').val();
			//alert(inputVal);
			var data = inputVal.split('-');
			
			var request = $.ajax({
					url: site_url+"/report/report/get_course_by_kv_edit",
					type: "POST",
					data: {kodpusat : data[1]},
					dataType: "html"
					});
				
				request.done(function(msg) {
					//alert("Berjaya");
					//alert(msg);
					//console.log(msg);
					$('#divKursus').html(msg);
				});
				
				request.fail(function(jqXHR, textStatus) {
					//alert("Gagal");
					//Do nothing
				});
		}

		          
            
            $( "#kodpusat" ).on( "autocompleteclose", function( event, ui ) {
			
			var inputVal = $(this).val();
			
			var data = inputVal.split('-');
			
			//alert(data[1].substr(2));
			
			$('#divKursus').html('<img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');
			
			setTimeout(function()
			{
				var request = $.ajax({
					url: site_url+"/report/report/get_course_by_kv_edit",
					type: "POST",
					data: {kodpusat : data[1]},
					dataType: "html"
					});
				
				request.done(function(msg) {
					//alert("Berjaya");
					//alert(msg);
					console.log(msg);
					$('#divKursus').html(msg);
				});
				
				request.fail(function(jqXHR, textStatus) {
					//alert("Gagal");
					//Do nothing
				});
			}, 1500);
		
		
		} );
            
        });    
</script>


<legend><h3>Pengiraan Gred</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('report/result/calculate_result_student')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
  
           <?php
            $colll=empty($colname)?'':$colname;
            
            if($colll!=''){
            ?>
          <input type="hidden" value="<?=$colll?>" name="kodpusat" id="kodpusat"/>
          <?php
    }else{
        ?>
         <tr>
        <td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
        <input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px;width:270px;"/>
        <?php
    }
    ?>
        </div>
        </td>
    </tr>
   <tr>
    <td height="35"><div align="right">Kursus</div></td>
    <td height="35"><div align="center">:</div></td>
    <td width="52%" height="35">
    <div align="left" id="divKursus">
    <select id="slct_kursus" name="slct_kursus" style="width:270px;"  disabled="true">
    <option value="">-- Sila Pilih --</option>
    <!-- <?php 
    foreach ($courses as $row)  {
 ?>
<option value="<?= $row->cou_id ?>">
<?= ucwords($row->cou_course_code).' - '.strcap($row->cou_name) ?>
</option>
 <?php 
 } 
?> -->
</select>
</div>
</td>
</tr>

    <tr>
        <td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left"><select width="50%" style="width:270px;" name="semester" id="semester" class="validate[required]" >
            <option value="">-- Sila Pilih --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            </select></td>
          
        </div>
        </td>
    </tr>
        <tr>
        <td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
            <div align="left">
                <select id="slct_tahun" name="mt_year" class="validate[required]" style="width:270px;" >
                    <option value="">-- Sila Pilih --</option>
                    <?php           
                foreach ($year as $row)
                {
            ?>
                    <option value="<?= $row->mt_year ?>">
                        <?= strtoupper($row->mt_year) ?>
                    </option>
            <?php 
                } 
            ?>
                </select>
            </div>
        </td>
    </tr>
    <?php
    /*
     <tr>
        <td height="35"><div align="right">Status</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
            <div align="left">
                <select id="statusID" name="status" style="width:270px;" class="validate[required]">
                    <option value="">-- Sila Pilih --</option>
                    <option value="1">Biasa</option>
                    <option value="2">Mengulang</option>
                </select>
            </div>
        </td>
    </tr>
    */
	?>
    <tr>
        <td height="35"><div align="right">Angka Giliran Murid</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
            <div align="left">
                <input id="angka_giliran" name="angka_giliran" style="width:270px;" size="25" type="text" class="span3"/>
            </div>            
        </td>
    </tr>
    <tr>
        <td></td>
        <td height="35"><div align="right"></div></td>
        <td height="35">
            <div align="left">
                <input class="btn btn-info" type="submit" name="btn_papar_kira" value="Kira Keputusan">
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>

<?php   if(isset($_POST['btn_papar_kira']) ){      ?>
<table class="table table-striped table-bordered" id="studentBilangan">
<thead>
<tr>
<td>Bil</td>
<td>NAMA MURID</td>
<td>ANGKA GILIRAN</td>
<td>SEMSTER</td>
<td>PNGKK</td>
</tr>
</thead>
</tbody>
<?php
$bil=0;
foreach ($result as $value) {
    $bil++;
    ?>
  <tr>  
  <td><?= $bil ?></td>
<td><?= ucwords(strtolower($value['nama']))  ?></td>
<td><?= $value['no_matrix']  ?></td>
<td><?= $value['sem']  ?></td>
<td><?= $value['pngkk']  ?></td>
</tr>
  <?php  
}

?>
</tbody>
</table> 
<script>
$(document).ready(function() {
    var oTable = $('#studentBilangan').dataTable({
            "aoColumnDefs": [{ bSortable: false, aTargets: [0] } ],
            "iDisplayLength" : 10,
            "bJQueryUI": false,
            "bAutoWidth": true,
            //"sScrollY": "200px",
            "bPaginate": true,
            "oLanguage": {      "sSearch": "Carian :",
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
<?php } ?>