$('a[data-toggle="tab"]').on('shown', function (e) {
  e.target; // activated tab
  e.relatedTarget; // previous tab
  $('#tabContentAkademik').html("");
  $('#tabContentAkademik').load(site_url+'/maintenance/crud_module/get_table/'+$(this).context.textContent);
  console.log($(this).context.textContent);
});

$(document).ready(function(){
	$('#tabContentAkademik').load(site_url+'/maintenance/crud_module/get_table/Aktif');
});