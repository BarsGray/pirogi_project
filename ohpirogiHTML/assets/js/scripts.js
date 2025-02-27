$(document).ready(function () {
	// hamburger
	$(".hamburger").on("click", function (e) {
		e.preventDefault();
		$(".header_top_box").addClass("active");
	});

	$(".close").on("click", function (e) {
		e.preventDefault();
		$(".header_top_box").removeClass("active");
	});

	// swiper
	var swiper = new Swiper(".mySwiper", {
		slidesPerView: 1,
		centeredSlides: true,
		spaceBetween: 20,
		loop: true,
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
	});
	$(".product_size").eq(0).on('click', function(e){
		e.preventDefault();
		if($(".product_size.active").eq(1)){
			$(".product_prev_price").text('880 ₽')
			$(".product_currently_price").text('770 ₽')
			$(".product_size").eq(1).removeClass('active')
			$(".product_size").eq(0).addClass('active')
		}
	});
	$(".product_size").eq(1).on('click', function(e){
		e.preventDefault();
		$(".product_prev_price").text('750 ₽')
		$(".product_currently_price").text('660 ₽')
		if($(".product_size.active").eq(0)){
			$(".product_size").eq(0).removeClass('active')
			$(".product_size").eq(1).addClass('active')
		}
	});
});
