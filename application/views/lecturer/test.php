  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
  <script src="http://malsup.github.com/jquery.form.js"></script> 
 
 <script language="javascript">
	// prepare the form when the DOM is ready 
	var bar = null;
	var percent = null;
 $(document).ready(function() { 
		
		bar = $('.bar');
		percent = $('.percent');

	    var options = {
	    	beforeSubmit:  showRequest,  // pre-submit callback   
	        success: function(data){

	   

	        	var percentVal = '100%';
		        bar.width(percentVal)
		        percent.html(percentVal);
	        },  // post-submit callback
	        uploadProgress: function(event, position, total, percentComplete) {
						        var percentVal = percentComplete + '%';
						        bar.width(percentVal)
						        percent.html(percentVal);
						    },
	        clearForm: true,        // clear all form fields after successful submit 
        	resetForm: true   
	    }; 
	 
	    // bind form using 'ajaxForm' 
	   $('#formUploadMarkah').ajaxForm(options); 
	});

	// pre-submit callback 
	function showRequest(formData, jqForm, options) { 
		var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
	}
 </script>
 <div class="accordion" id="accordionUpload">
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUpload" href="#collapseOne">
			        Muatnaik markah dari Excel
			      	<i style="float:right;" class="icon-large icon-upload"></i>
			      </a>
			    </div>
			    <div id="collapseOne" class="accordion-body collapse">
			      <div class="accordion-inner">
			      <form method="post" action="<?=site_url("/examination/markings_v3/upload_from_excel");?>" id="formUploadMarkah" enctype="multipart/form-data">
			      <span id="outputDataUpload"></span>
			  
			      <span>
					    <input  type="file" 
					            style="visibility:hidden; width: 1px;" 
					            id='userfile' name='userfile'  
					            onchange="$(this).parent().find('span').html($(this).val().replace('C:\\fakepath\\', ''))"  /> <!-- Chrome security returns 'C:\fakepath\'  -->
					    <input class="btn btn-primary" type="button" value="Sila pilih fail untuk di muatnaik..." onclick="$(this).parent().find('input[type=file]').click();"/> <!-- on button click fire the file click event -->
					    &nbsp;
					    <span id="panelFileName"  class="badge badge-important" style="padding-left:25px;padding-right:25px;" ></span>
				   </span>
				   <br>
				   <br>
				   <div class="progress progress-striped">
				        <div class="bar" style="width: 0%;"></div>
				        <div class="percent">0%</div>
				    </div>
				    <div id="panelAlertErrorUpload" class="alert" style="display:none;">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <span id="panelUploadMsg">Best check yo self, you're not...</span>
					</div>
				  <button id="btnUploadMarkah" type="submit" class="btn btn-info pull-right"><span>Muatnaik</span></button>
		            	<br>
		           </form>
			      </div>
			    </div>
			  </div>
			</div>