var drop = $('.ui.dropdown');
drop.dropdown();
drop.api({
	action: 'getCategories',
	on: 'now',
	onResponse: addCategories
});
$(".ui.follow.button").api({
	action: 'getCategories',
});

function addCategories(response) {
	$.each(response.results, function (index, val) {
		$('#dropCategorias .menu').append($('<div class="item"></div>').html(val.name));
	});
}