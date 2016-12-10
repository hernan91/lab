$(function(){
	$('.removeUserButton').click(function(e){
		let url = location.pathname.split('/')[2]+"/api/removeUser.php?";
		console.log(url);
		/*$.get("ajax/test.html", function( data ) {
			$( ".result" ).html( data );
			alert( "Load was performed." );
		});*/
	});
})
