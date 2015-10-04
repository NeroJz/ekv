var minWidth = '5%';
var maxWidth = '95%';
var minHeight = '100px';

$('#box2').css('height',minHeight);
$('#box2').css('width',minWidth);
$('#box3').css('width',maxWidth);

$('#box2').toggle(function()
	{
		$(this).animate({
			'width':'20%',
			'height':'505px'
		}, 400, 'swing');
		$('#box3').animate({'width':'80%'}, 350, 'swing');
    
    },function(){
	
    $(this).animate({
		'width':'5%',
		'height':'100px',
	}, 350, 'swing');
	$('#box3').animate({'width':'95%'}, 400, 'swing');
	
	});
	
function adjustStyle(width) {
    width = parseInt(width);
    if (width < 500) {
        $("#size-stylesheet").attr("href", "../css/mobile.css");
    }
}

$(function() {
    adjustStyle($(this).width());
    $(window).resize(function() {
        adjustStyle($(this).width());
    });
});