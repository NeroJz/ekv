<script>
	var loading_img = "<?=base_url()?>assets/img/loading_ajax.gif";
	$(document).ready(function() {
		$("#tblStudent").hide();
		
		var cache = {};
		var iColid = <?= $colid ?>;
		$("#nama").autocomplete({
		  source: function(request, response) {
		    var term          = request.term.toLowerCase(),
		        element       = this.element,
		        cache         = this.element.data('autocompleteCache') || {},
		        foundInCache  = false;
		      $.ajax({
		          url: 'student_management/ajax_student_autosuggest/'+iColid,
		          dataType: "json",
		          data: request,
		          success: function(data) {
		              cache[term] = data;
		              response(data);
		          }
		      });
		  },
		  minLength: 2
		});
		
		var kodkv = [
			<?= $centrecode ?>
		];

		var kursus = [
			<?= $kursuscode ?>
		];
		
		$( "#kv" ).autocomplete({
			source: kodkv
		});

		$( "#kursus" ).autocomplete({
			source: kursus
		});	
		
		$("#cari").bind("click",function(){
			$("#tblStudent").show();
			var sName =$('#nama').val();
			var sSlct_kv =$('#kv').val();
			var sSlct_sem =$('#slct_sem').val();
			var sSlct_course =$('#kursus').val();

			<?=$vScript?>

			new FixedHeader( oTabletblStudent, {
				"offsetTop": 40
			} );
		});
	}); 
</script>
<?php
$user_login = $this->ion_auth->user()->row();
$colid = $user_login->col_id;
$userId = $user_login->user_id;
$state_id= $user_login->state_id;

$user_groups = $this->ion_auth->get_users_groups($userId)->row();
$ul_type= $user_groups->ul_type;
$ul_name= $user_groups->ul_name;
$col=get_user_collegehelp($userId);
?>
<legend><h3>Senarai Murid</h3></legend>
	<table class="breadcrumb border" width="100%" align="center">
		<tbody>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr style="">
				<td width="45%" height="35">
				<div align="right">
					Nama Murid
				</div></td>
				<td width="3%" height="35">
				<div align="center">
					:
				</div></td>
				<td width="52%" height="35" align="left">
				<div align="left">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
					<input type="text" name="nama" id="nama" />
					dan/atau
				</div></td>
			</tr>
			<tr style="">
				<td width="45%" height="35">
				<div align="right">
					Kolej Vokasional
				</div></td>
				<td width="3%" height="35">
				<div align="center">
					:
				</div></td>
				<td width="52%" height="35" align="left">
				<div align="left">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
					<?php
					if($ul_name=="KUPP"){
						foreach ($kv_list as $key) {
							if($colid==$key->col_id){
								echo '<input type="text" name="kv" id="kv" value="'.$col[0]->col_name.'" disabled />';
							}
						}
					}else{
						echo '<input type="text" name="kv" id="kv" />';
					}
					?>
					dan/atau
				</div></td>
			</tr>
			<tr style="">
				<td width="45%" height="35">
				<div align="right">
					Semester
				</div></td>
				<td width="3%" height="35">
				<div align="center">
					:
				</div></td>
				<td width="52%" height="35" align="left">
				<div align="left">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
					<select name="slct_sem" id="slct_sem">
						<option value="">Semua Semester</option>
						<?php
						for($i=1;$i<=10;$i++){ ?>
							<option value="<?=$i?>"><?=$i?></option>
						<?php }	?>
					</select>
					dan/atau
				</div></td>
			</tr>
			<tr style="">
				<td width="45%" height="35">
				<div align="right">
					Kursus
				</div></td>
				<td width="3%" height="35">
				<div align="center">
					:
				</div></td>
				<td width="52%" height="35" align="left">
				<div align="left">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
					<input type="text" name="kursus" id="kursus" style="z-index:105;" />
				</div></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<button id="cari" class="btn btn-info" style="margin-bottom: 10px;"><i class="icon-search icon-white"></i>&nbsp;Cari</button>
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
		</tbody>
	</table>
<?php
echo $vView;
?>