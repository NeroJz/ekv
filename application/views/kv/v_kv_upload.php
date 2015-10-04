<script type="text/javascript">
$(document).ready(function()
{
    $('#btnUploadLogo').click(function()
    {
        $('#formUploadLogo').submit();
    });

    $('#btnUploadCop').click(function()
    {
        $('#formUploadCop').submit();
    });

    var logo_upload = $('#status').val();

    if(logo_upload == 1)
    {
        var mssg = new Array();
        mssg['heading'] = 'Informasi';
        mssg['content'] = 'Berjaya Muatnaik Logo Kolej';
        kv_alert(mssg);
    }
    else if(logo_upload == 2)
    {
        var mssg = new Array();
        mssg['heading'] = 'Informasi';
        mssg['content'] = 'Sila Pilih Gambar Dalam Format .jpg / .png Sahaja Untuk dimuat naik..';
        kv_alert(mssg);
    }
    else if(logo_upload == 3)
    {
        var mssg = new Array();
        mssg['heading'] = 'Informasi';
        mssg['content'] = 'Sila Pilih Gambar Dalam Format .png Sahaja Untuk dimuat naik..';
        kv_alert(mssg);
    }
}); 
</script>


<legend><h3>Muat Naik Gambar</h3></legend>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span6 alert alert-success">
            <fieldset>
                <legend><h4 style="color:black;">Logo Kolej</h4></legend>
                <form method="post" action="<?=site_url("/management/college/upload_logo");?>" id="formUploadLogo" enctype="multipart/form-data">
                    <!--<span id="outputDataUpload"></span>-->
                    <span><input type="hidden" id="status" name="status" value="<?= $status; ?>" /></span>
                    <span style="margin-left:10px;">
                        <input  type="file" 
                                style="visibility:hidden; width: 1px;" 
                                id='userfile' name='userfile'  
                                onchange="$(this).parent().find('span').html($(this).val().replace('C:\\fakepath\\', ''))"  /> <!-- Chrome security returns 'C:\fakepath\'  -->
                        <input class="btn btn-primary" type="button" value="Pilih Logo" onclick="$(this).parent().find('input[type=file]').click();"/> <!-- on button click fire the file click event -->
                        <span id="panelFileName"  class="badge badge-important" style="padding-left:25px;padding-right:25px;" ></span>
                        &nbsp;
                    </span><br>
                    <span style="margin-left:15px; margin-top:5px;">
                        <button id="btnUploadLogo" type="button" class="btn btn-info" style="margin-top:11px; margin-bottom:11px;"><span>Muatnaik&nbsp;</span></button><br>
                    </span>                      
                </form>
                <ul class="thumbnails" style="margin-left: 16px;">
                    <li >
                      <a href="#" class="thumbnail">
                        <img width="91" height="70" alt="160x100" src="<?=base_url().$img->col_image?>">
                      </a>
                    </li>
                    <li >
                      <a href="#" class="thumbnail">
                        <img width="165" height="127" alt="260x190" src="<?=base_url().$img->col_image?>">
                      </a>
                    </li>
                    <li >
                      <a href="#" class="thumbnail">
                        <img width="369" height="284" alt="360x355" src="<?=base_url().$img->col_image?>">
                      </a>
                    </li>                        
                  </ul>
            </fieldset>
                
        </div>
        <div class="span6 alert alert-success">
            <fieldset>
                <legend><h4 style="color:black;">Cop Kolej</h4></legend>
                <form method="post" action="<?=site_url("/management/college/upload_cop");?>" id="formUploadCop" enctype="multipart/form-data">
                    <!-- <span id="outputDataUploadCop"></span> -->
                    <span><input type="hidden" id="status" name="status" value="<?= $status; ?>" /></span>
                    <span style="margin-left:10px;">
                        <input  type="file" 
                                style="visibility:hidden; width: 1px;" 
                                id='userfile' name='userfile'  
                                onchange="$(this).parent().find('span').html($(this).val().replace('C:\\fakepath\\', ''))"  /> <!-- Chrome security returns 'C:\fakepath\'  -->
                        <input class="btn btn-primary" type="button" value="Pilih Cop" onclick="$(this).parent().find('input[type=file]').click();"/> <!-- on button click fire the file click event -->
                        <span id="panelFileName"  class="badge badge-important" style="padding-left:25px;padding-right:25px;" ></span>
                        &nbsp;
                    </span><br>
                    <span style="margin-left:15px; margin-top:5px;">
                        <button id="btnUploadCop" type="button" class="btn btn-info" style="margin-top:11px; margin-bottom:11px;"><span>Muatnaik</span></button><br>
                    </span>
                </form>
                <ul class="thumbnails" style="margin-left: 16px;">
                    <li >
                        <a href="#" class="thumbnail">
                              <img width="91" height="70" alt="160x100" src="<?=base_url().$stmp->col_stamp?>">
                        </a>
                    </li>
                    <li >
                        <a href="#" class="thumbnail">
                             <img width="165" height="127" alt="260x190" src="<?=base_url().$stmp->col_stamp?>">
                        </a>
                    </li>                       
                </ul>
            </fieldset>
        </div>
    </div>
</div>