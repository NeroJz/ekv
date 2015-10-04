

<legend><h3>Fail Induk Nama</h3></legend>
<center>

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



<!---<script src="<?=base_url()?>assets/js/report/kv.attendance.js" type="text/javascript"></script> -->

<script language="javascript" type="text/javascript" >
    $(document).ready(function()
    {   
    
        function reAssignTable()
        {
            
        }

var loading_img = "<?=base_url()?>assets/img/loading_ajax.gif";
    
    oTable = $('#fin_ajax').dataTable( {
        "bSort": true,
                                              "oLanguage": {
                "sProcessing": '<img src="'+loading_img+'" width="24" height="24" align="center"/> Sedang diproses...',
                    "sLengthMenu": 'Paparan <select>'+
        '<option value="10">10</option>'+
        '<option value="100">100</option>'+
        '<option value="150">150</option>'+
        '<option value="200">200</option>'+
        '<option value="250">250</option>'+
        '<option value="-1">All</option>'+
        '</select> rekod',
                    "sZeroRecords": "No Records Found!",
                    "sEmptyTable": "Tiada Rekod!",
                    "sLoadingRecords": "Loading...",
                    "sInfo": "Paparan _START_ hingga _END_ daripada _TOTAL_ Rekod",
                    "sInfoEmpty": "Paparan 0 hingga 0 daripada 0 rekod",
                    "sInfoFiltered": " ",
                    "sInfoPostFix": "",
                    "sSearch": "Carian:",
                    "sUrl": "",
                            "oPaginate": {
                              "sFirst": "Pertama",
                              "sLast": "Akhir",
                              "sNext": "Seterus",
                              "sPrevious": "Sebelum"
                    }
            },
    "aoColumns": [
      { "bSortable": false },
      { "bSortable": false },{ "bSortable": false },{ "bSortable": false },
      { "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false }
    ],
    "iDisplayLength": 10,
    "aaSorting": [[1, 'asc']],
    "bJQueryUI": true,
    
    "sPaginationType": "full_numbers",
    "bProcessing": true,
    "bServerSide": true,
    "bPaginate": true,
   
    "sAjaxSource": "<?=site_url('report/report/reportfin_ajax/')?>",
    "fnServerData": function ( sSource, aoData, fnCallback ) {
         aoData.push({"name": "search", "value": "<?=isset($search)?$search:""?>"});
             
      $.ajax( {
        "dataType": 'json', 
        "type": "POST", 
        "url": sSource, 
        "data": aoData, 
        "success": [fnCallback, fnMyNewCallback],
        "complete":reAssignTable
      } );
    }

  });

    new FixedHeader( oTable, {
        "offsetTop": 40
    } );
  
 });

    function fnMyNewCallback(json)
    {
        //console.log(json.iTotalDisplayRecords);
        if(json.iTotalDisplayRecords != 0)
        {
            $("#exprt1").show();
            $("#exprt2").show();
        }
        else
        {
            $("#exprt1").hide();
            $("#exprt2").hide();
        }
        
    }
    
    function getw()
    {   
        var centreCode  = $('#hkodpusat').val();
        var year        = $('#hmt_year').val();
        var course      = $('#hslct_kursus').val();
        var semester    = $('#hsemester').val();
        var status      = $('#hstatus').val();

        window.location.href = 'export_xls_fin'+'?ckod='+centreCode+'&kursus='+course+'&semtr='+semester+'&tahun='+year+'&stts='+status;
    }
    
</script>

<center>

<form id="frm_pusat" action="<?= site_url('report/report/view_fin')?>" method="post">
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
        <input type="text" name="kodpusat" id="kodpusat" class="span3 validate[required]" style="margin-left:0px;width:270px;"/>
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
            <select class="validate[required]" id="slct_kursus" name="slct_kursus" style="width:270px;"   disabled="true">
            <option value="">-- Sila Pilih --</option>
          
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
    <? /*
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
	 * 
	 */?>
     <tr>
        <td height="35"><div align="right">Status</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
            <div align="left">
                <select id="statusID" name="status" style="width:270px;" class="validate[required]" >
                    <option value="">-- Sila Pilih --</option>
                    <option value="1">Biasa</option>
                    <option value="2">Mengulang</option>
                </select>
            </div>
        </td>
    </tr>
   
    <tr>
        <td></td>
        <td height="35"><div align="right"></div></td>
        <td height="35">
            <div align="left">
                <input class="btn btn-info" type="submit" name="btn_papar" value="Papar Fail Induk">
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>
</br>
<?php if(isset($_POST['btn_papar']) )
{ 
	if(isset($search))
	{	
		/*echo"<pre>";
		print_r($search);
		echo"</pre>";
		die();*/
		
		$search = explode("|", $search);
		
		$col_name= $search[0];
		$cou_id = $search[1];
		$current_sem= $search[2];
		$current_year = $search[3];
		$status_stu = $search[4];
		
	}
?>
<div align="right" style="margin-bottom: 5px;">
	
	<input type="hidden" id="hkodpusat" name="hkodpusat" value="<?= $col_name ?>">
	<input type="hidden" id="hslct_kursus" name="hslct_kursus" value="<?= $cou_id ?>">
	<input type="hidden" id="hsemester" name="hsemester" value="<?= $current_sem ?>">
	<input type="hidden" id="hmt_year" name="hmt_year" value="<?= $current_year ?>">
	<input type="hidden" id="hstatus" name="hstatus" value="<?= $status_stu ?>">
	
	<a href="javascript:void(0);" id="exprt1" class="btn btn-primary" onclick="getw()">Eksport Excel</a>

</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display " id="fin_ajax">
        <thead>
            <tr>
                <th width="80" id="tdleft" align="center"><b>BIL</b></a></th>
                <th width="400" align="center"><b>NAMA MURID</b></th>
		<th width="195" id="tdright" align="center"><b>MYKAD</b></th>
                <th width="195" id="tdright" align="center"><b>ANGKA GILIRAN</b></th>
                <th width="195" id="tdright" align="center"><b>KOD KURSUS</b></th>
                <th width="195" id="tdright" align="center"><b>JANTINA</b></th>
                <th width="195" id="tdright" align="center"><b>KAUM</b></th>
                <th width="195" id="tdright" align="center"><b>AGAMA</b></th>
                <th width="195" id="tdright" align="center"><b>STATUS</b></th>
            </tr>
        </thead>
        
    </table>
<div align="right" style="margin-top: 5px;">
	<a href="javascript:void(0);" id="exprt2" class="btn btn-primary" onclick="getw()">Eksport Excel</a>
</div>
    <?php  } ?>