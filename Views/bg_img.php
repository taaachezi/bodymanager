<script type="text/javascript" charset="utf-8">
	$(function (){
		$(document).scroll(function (){
			var top = $(".bottom_img").offset().top;
			var position = top - $(window).height();
			if($(window).scrollTop() > 1000){
				$(".bottom_img").slideÜp();
			}else{
				$(".bottom_img").slideDown();
			}
		});
		a();
	});
	function a(){
		$(".run").animate({paddingLeft:30},2000);
		$(".run").animate({paddingLeft:0},2000);
		setTimeout(function(){
			a();
		},2000);
	};
</script>

<img src="/img/bg1.jpg" alt="" class="position-absolute run" style="z-index: -1; top: 20vh; left: 0; width: 20vw; opacity: 0.3;">
<img src="/img/bg2.jpg" alt="" class="position-absolute run" style="z-index: -1; width: 20vw; opacity: 0.3; bottom: 0; right: 0;">
<img src="/img/bg3.jpg" alt="" class="position-absolute bottom_img run" style="z-index: -1; bottom: -50vh; left: 0; width: 15vw; opacity: 0.3; display: none;">

