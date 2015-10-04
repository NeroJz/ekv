
<legend><h4>Maklumat Terperinci Modul</h4></legend>
<table class="breadcrumb border" width="100%" align="left">
    <tbody><tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td width="35%"><div align="right">Nama Modul</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
                <?=$module['name']?>
            </div></b>
        </td>
    </tr>
    <tr>
        <td width="35%"><div align="right">Kod Modul</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
                <?=$module['code']?>
            </div></b>
        </td>
    </tr>
    <tr>
        <td width="35%"><div align="right">Kertas Modul</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
                <?=$module['paper']?>
            </div></b>
        </td>
    </tr>
    <tr>
        <td width="35%"><div align="right">Jenis Modul</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
                <?=$module['type']?>
            </div></b>
        </td>
    </tr>
    <tr>
        <td width="35%"><div align="right">Status</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
                <?=$module['status']?>
            </div></b>
        </td>
    </tr>
    
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        
    </tr>
</tbody></table>
<?php
echo $table;
echo '<a href="#myModal" style="margin-bottom:5px" class="btn btn-info" data-toggle="modal">Tambah Kursus</a>';
echo $table_course;
?>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Tambah Kursus</h3>
    </div>
    <div class="modal-body" style="overflow-y:inherit !important;">
        <form class="form-horizontal" action="<?= site_url(); ?>/maintenance/crud_module/assign_cou_to_mod" method="POST">
            <div class="control-group">
                <label class="control-label" for="kursus">Kursus</label>
                <div class="controls clearfix">
                    <select data-placeholder="Pilih kursus..." name="kursus[]" class="chosen-select" multiple style="width:350px;" tabindex="4" required>
                    <?php foreach ($cou_list as $key) { ?>
                        <option value="<?= $key->cou_id ?>"><?= $key->cou_name ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="semester">Semester</label>
                <div class="controls">
                    <input type="text" id="semester" name="semester" placeholder="Cth: 1" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="mod_id" value="<?= $mod_id; ?>">
            <input type="hidden" name="cou_id" value="" id="cou_id">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Maklumat</button>
        </div>
    </div>
</form>
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/chosen.css">
  <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>
<script src="<?= base_url() ?>assets/js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, tiada item!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>