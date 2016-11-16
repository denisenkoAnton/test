$(document).ready(function(){
	$('.button').bind('click', function(){
		var container = $(this).parent();
		var firstEl = container.find('.button:first');
		container.append(firstEl);
		return true;
	});
});