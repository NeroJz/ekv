function printit(printOptions) {
	document.getElementById('idPrint').style.display = 'none';

  if ( $.browser.mozilla ) {
    
    if(typeof jsPrintSetup != 'undefined'){

      if ($.inArray('headerStrLeft', printOptions.map(function(x) {
          return x.id;
          })) == -1)
      printOptions.push({'id':"headerStrLeft",'val':''});
      if ($.inArray('headerStrCenter', printOptions.map(function(x) {
          return x.id;
          })) == -1)
      printOptions.push({'id':"headerStrCenter",'val':''});
      if ($.inArray('headerStrRight', printOptions.map(function(x) {
          return x.id;
          })) == -1)
      printOptions.push({'id':"headerStrRight", 'val':''});

      if ($.inArray('footerStrLeft', printOptions.map(function(x) {
          return x.id;
          })) == -1)
      printOptions.push({'id':"footerStrLeft",'val':''});
      if ($.inArray('footerStrCenter', printOptions.map(function(x) {
          return x.id;
          })) == -1)
      printOptions.push({'id':"footerStrCenter",'val':''});
      if ($.inArray('footerStrRight', printOptions.map(function(x) {
          return x.id;
          })) == -1)
      printOptions.push({'id':"footerStrRight",'val':''});

      $.each(printOptions, function(i, item) {
		    jsPrintSetup.setOption(item.id, item.val);
		  });

      jsPrintSetup.print();
    }
    else{
      window.print();
    }

  }else{
    window.print();
  }

	setTimeout("document.getElementById('idPrint').style.display = 'block';", 5000);
}