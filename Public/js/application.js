$(function (){
	$("#menu").click(function(){
		if($("#menu-item").hasClass("open")){
			$("#menu-item").slideUp();
			$("#menu-item").removeClass("open");
		} else {
			$("#menu-item").slideDown();
			$("#menu-item").addClass("open");
		}

	});
});
$(function (){
	$(".item_delete").click(function (){
		if(confirm("選択した食材を削除します")){
			return true;
		}else{
			return false;
		}
	});
});
$(function (){
	$(".intake_delete").click(function (){
		if(confirm("摂取食材を削除します")){
			return true;
		} else {
			return false;
		}
	});
});
$(function(){
	$("input").change(function(){
		var result = 0;
		$(".pc").each(function(){
			result = result + Number($(this).val());
		})
		result = result*4;
		var fat = Number($(".f").val());
		fat = fat*9;
		result = result + fat;
		result = result.toFixed(1);
		$(".result").text(result);
	});
});

