function kv_confirm(opts) {
	
	/*
	*opts is Associative Array
	* heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback, hidecallback, hidecancelcallback
	*/
	
	heading = opts.heading ? opts.heading : "Kepastian";
	question = opts.question ? opts.question : "Anda Pasti?";
	okButtonTxt = opts.okButtonTxt ? opts.okButtonTxt : "Pasti";
	cancelButtonTxt = opts.cancelButtonTxt ? opts.cancelButtonTxt : "Tidak";
	hidecallback = opts.hidecallback ? opts.hidecallback : false;
	hidecancelcallback = opts.hidecancelcallback ? opts.hidecancelcallback : false;
	
	var confirmModal = 
	  $('<div class="modal hide fade">' +    
		  '<div class="modal-header">' +
			'<h3>' + heading +'</h3>' +
		  '</div>' +

		  '<div class="modal-body">' +
			'<p>' + question + '</p>' +
		  '</div>' +

		  '<div class="modal-footer">' +
			'<a href="javascript:void(0);" id="mdl_cancel_btn" class="btn" data-dismiss="modal">' + 
			  cancelButtonTxt + 
			'</a>' +
			'<a href="javascript:void(0);" id="okButton" class="btn btn-primary">' + 
			  okButtonTxt + 
			'</a>' +
		  '</div>' +
		'</div>');

	confirmModal.find('#okButton').click(function(event) {
	  if(hidecallback)
	  {
		  confirmModal.modal('hide');
		  if(opts.callback) opts.callback();
	  }
	  else
	  {
		  if(opts.callback) opts.callback();
	  	  confirmModal.modal('hide');
	  }
	  
	});
	
	confirmModal.find('#mdl_cancel_btn').click(function(event) {
	  
	  if(hidecancelcallback)
	  {
		  confirmModal.modal('hide');
		  if(opts.cancelCallback) opts.cancelCallback();
	  }
	  else
	  {
		  if(opts.cancelCallback) opts.cancelCallback();
	  	  confirmModal.modal('hide');
	  }
	  
	});

	confirmModal.modal({keyboard: false,backdrop: 'static'});     
 };
 
 function kv_alert(opts) {
	
	/*
	*opts is Associative Array
	* heading, content, okButtonTxt, callback, hidecallback
	*/
	heading = opts.heading ? opts.heading : "Mesej";
	content = opts.content ? opts.content : "Mesej?";
	okButtonTxt = opts.okButtonTxt ? opts.okButtonTxt : "Ok";
	hidecallback = opts.hidecallback ? opts.hidecallback : false;
	
	var okModal = 
	  $('<div class="modal hide fade">' +    
		 	 '<div class="modal-header">' +
			'<h3>' + heading +'</h3>' +
		  '</div>' +

		  '<div class="modal-body">' +
				'<p>' + content + '</p>' +
		  '</div>' +

		  '<div class="modal-footer">' +
			'<a href="javascript:void(0);" id="okButton" class="btn btn-primary">' + 
			  okButtonTxt + 
			'</a>' +

		  '</div>' +
		'</div>');

	okModal.find('#okButton').click(function(event) {
		  if(hidecallback)
		  {
			  okModal.modal('hide');
			  if(opts.callback) opts.callback();
		  }
		  else
		  {
			  if(opts.callback) opts.callback();
			  okModal.modal('hide');
		  }
	});

	okModal.modal({keyboard: false,backdrop: 'static'});     
 };
		
