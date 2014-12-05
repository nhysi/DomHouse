function changeState(pin,elem){
	var newState = ($(elem).hasClass('on')?0:1);
	$.ajax({
			type: "POST",
			 url: "./action.php?action=changeState",
			 data:{pin:pin,state:newState},
			success: function(r){
				var result = eval(r);
				if(result.state == 1){
					$(elem).removeClass('on');
					$(elem).removeClass('off');
					$(elem).addClass((newState==1?'on':'off'));
				}else{
					alert('Erreur : '+result.error);
				}
		 }});
}

function changeState2(state,numero){
var newState = (state==1?'on':'off');
	$.ajax({
			type: "POST",
			 url: "./action.php?action=changeState2",
			 data:{state:newState,numero:numero},
			success: function(r){
				}
		 });
}

