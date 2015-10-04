<script>
// Datepicker
$(function(){
	$('#date').datepicker({dateFormat:"dd-mm-yy"});
});

// HTML Required custom language
$(document).ready(function() {
    var elements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Data tidak benar");
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
    var elements1 = document.getElementsByTagName("SELECT");
    for (var i = 0; i < elements1.length; i++) {
        elements1[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Data tidak benar");
            }
        };
        elements1[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
})
</script>
<legend><h3>Tarikh Tutup Pengesahan Pendaftaran Murid</h3></legend>
<div class="row-fluid">
	<div class="span5">
		<form class="form-horizontal" action="<?= site_url() ?>/maintenance/pengesahan/simpan" method="POST">
			<div class="control-group">
				<label class="control-label" for="inputEmail">Sesi</label>
				<div class="controls">
					<input type="number" id='sesi' name="sesi" placeholder="Cth:1" min="1" max="2" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Tahun</label>
				<div class="controls">
					<select name="tahun" placeholder="Cth: 2013" required>
						<option></option>
						<?php
						for($i=date('Y')-1;$i<date('Y')+5;$i++){ ?>
							<option value="<?= $i ?>"><?= $i ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Tarikh Tutup</label>
				<div class="controls">
					<input type="text" id="date" name="tarikh" placeholder="DD-MM-YYYY" required>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-info">Simpan</button>
				</div>
			</div>
		</form>
	</div>
	<div class="span7">
		<?= $table ?>
	</div>
</div>