<link href="<?= base_url('assets/css/bootstrap-editable.css'); ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/bootstrap-editable.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.form.min.js'); ?>"></script>
<style type="text/css">
.tree {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #999;
    border-radius:5px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none
}
.tree li.parent_li>span {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
    background:#eee;
    border:1px solid #94a0b4;
    color:#000
}
</style>
<script>
$(document).ready(function(){

	// Ku : Bootstrap tab
	$('a[data-toggle="tab"]').on('shown', function (e) {
		var id = e.currentTarget.hash; // activated tab
		var sId = id.split('#');
	});

	$.fn.editable.defaults.mode = 'inline';

	// Ku : Bootstrap + JQuery Tree
	$(function () {
	    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
	    $('.tree li.parent_li > span').on('click', function (e) {
	        var children = $(this).parent('li.parent_li').find(' > ul > li');
	        if (children.is(":visible")) {
	            children.hide('fast');
	            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
	        } else {
	            children.show('fast');
	            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
	        }
	        e.stopPropagation();
	    });
	});

	//init editables 
	$('.myeditable').editable({
	    url: '<?= site_url("menu/menu/add") ?>',
	});
	 
	//make username required
	$('#new_menu').editable('option', 'validate', function(v) {
	    if(!v) return 'Required field!';
	});
	 
	//automatically show next editable
	$('.myeditable').on('save.menu', function(){
		var that = this;
		setTimeout(function() {
			$(that).closest('tr').next().find('.myeditable').editable('show');
		}, 200);
	});

	$('#addMenu').ajaxForm(function() { 
		location.reload();
	}); 
});

function fnEditPath(id){
	$('#menu_path'+id).editable({
		type: 'text',
		pk: id,
		url: '<?= site_url("menu/menu/editMenuPath") ?>',
		title: 'Enter username',
		success: function(response, newValue) {
			console.log(response);
		}
	});
}

function fnEdit(id){
	$('#menu'+id).editable({
		type: 'text',
		pk: id,
		url: '<?= site_url("menu/menu/editMenu") ?>',
		title: 'Enter username',
		success: function(response, newValue) {
			console.log(response);
		}
	});
}
</script>

<div class="">
	<ul id="myTab" class="nav nav-tabs">
		<?php
			foreach ($ul as $key) {
				echo "<li><a href='#$key->ul_id' data-toggle='tab'>$key->ul_name</a></li>";
			}
		?>
	</ul>
	<div id="myTabContent" class="tab-content">
		<?php
			foreach ($ul as $key) {
				echo "<div class='tab-pane fade in' id='$key->ul_id'>";
					echo "<div class='row'>";
						echo "<div class='span6'>";
							echo "<div class='tree'>";
								echo "<ul>";
								if(sizeof($menuData[$key->ul_id])>0){
									foreach ($menuData[$key->ul_id] as $parent) {
										echo "<li>";
										echo "<span><i class='icon-folder-open'></i> <a id='menu$parent->menu_id' href='#' onmouseover='fnEdit($parent->menu_id)'>$parent->menu_item</a></span> <a id='menu_path$parent->menu_id' href='#' onmouseover='fnEditPath($parent->menu_id)'><code>$parent->menu_path</code></a><a href='".site_url()."/menu/menu/delete/$parent->menu_id'><i class='icon-trash'></i></a>";
										if(sizeof($parent->children)>0){
											echo "<ul>";
											foreach ($parent->children as $children) {
												echo "<li>";
												echo "<span><i class='icon-minus-sign'></i> <a id='menu$children->menu_id' href='#' onmouseover='fnEdit($children->menu_id)'>$children->menu_item</a></span> <a id='menu_path$children->menu_id' href='#' onmouseover='fnEditPath($children->menu_id)'><code>$children->menu_path</code></a><a href='".site_url()."/menu/menu/delete/$children->menu_id'><i class='icon-trash'></i></a>";
												if(sizeof($children->children)>0){
													echo "<ul>";
													foreach ($children->children as $subchild) {
														echo "<li>";
														echo "<span><i class='icon-leaf'></i> <a id='menu$subchild->menu_id' href='#' onmouseover='fnEdit($subchild->menu_id)'>$subchild->menu_item</a></span> <a id='menu_path$subchild->menu_id' href='#' onmouseover='fnEditPath($subchild->menu_id)'><code>$subchild->menu_path</code></a><a href='".site_url()."/menu/menu/delete/$subchild->menu_id'><i class='icon-trash'></i></a>";
														echo "</li>";
													}
													echo "</ul>";
												}
												echo "</li>";
											}
											echo "</ul>";
										}
										echo "</li>";
									}
								}else{
									echo "No data";
								}
								echo "</ul>";
							echo "</div>";
						echo "</div>"; // close span6 ?>
							<div class='span6'>
								<form id="addMenu" action="<?= site_url('menu/menu/add') ?>" method="post">
									<legend>Tambah Menu</legend>
									<table class="table table-bordered table-striped">
										<tbody>
											<tr>
												<td width="30%">Nama Menu</td>
												<td><input type="text" name="menu"></input></td>
											</tr>
											<tr>
												<td>Path/URL</td>
												<td><input type="text" name="path"></input></td>
											</tr>
											<tr>
												<td>Parent</td>
												<td>
													<select name='parent'>
														<option value='null'> - Sila Pilih - </option>
														<?php foreach ($menuData[$key->ul_id] as $parent) { //open foreach ?>
														<option value="<?=$parent->menu_id?>"><?= $parent->menu_item ?></option>
															<?php if(sizeof($parent->children)>0){ //open if 
																foreach ($parent->children as $children) { ?>
																	<option value="<?=$children->menu_id?>"><?= $children->menu_item ?></option>
																	<?php if(sizeof($children->children)<0){ //open if //sementara disable jap
																		foreach ($children->children as $subchildren) { 
																			echo "<option value='$subchildren->menu_id'>$subchildren->menu_item</option>";
																		}
																	} //close if ?>
																<?php } ?>
															?>
															<?php } //close if ?>
														<?php } //close foreach ?>
													</select>
												</td>
											</tr>
											<tr>
												<td>Order</td>
												<td><input type="number" name="order" min="1" required></td>
											</tr>
										</tbody>
									</table>
									<input type="hidden" name="ul_id" value="<?=$key->ul_id?>">
									<input type="submit" class='btn btn-primary' value="Tambah Menu" /> 
								</form>
							</div>
					</div>
				</div>
			<?php } ?>
	</div>
</div>

<!-- Modal -->
<div id="editMenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Modal header</h3>
	</div>
	<div class="modal-body">
		<p>One fine body…</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary">Save changes</button>
	</div>
</div>