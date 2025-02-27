<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, minimum-scale=1">
	<meta name="google-site-verification" content="6jI_8eTdfz4dhFIPNYfEzhKnvnkbYKqXLwWvEpOw4ws" />
	<!-- initial-scale=1  -->
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- <title><?php // bloginfo('name'); 
	?></title> -->

	<script type="application/ld+json">
		{
			"@context" : "https://schema.org",
			"@type" : "WebSite",
			"name" : «Ох пироги»,
			"alternateName" : "Ох пироги",
			"url" : "https://ohpirogi24.ru/"
		}
</script>

	<!-- <meta name="description" content=""> -->

	<!-- <meta property="og:title" content="">
	<meta property="og:type" content="">
	<meta property="og:url" content="">
	<meta property="og:image" content="">
	<meta property="og:image:alt" content=""> -->

	<meta name="theme-color" content="#fff">
	<?php wp_head(); ?>
</head>

<body>







	<div class="wrapper">
		<!-- <div> -->
		<!-- header -->
		<header class="header" id="header">
			<div class="header_top_wrapper">
				<div class="container">
					<div class="header_top ">
						<div class="mobile_appear">
							<a href="#" class="close">
								<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/close.svg" alt="">
							</a>
							<a href="#" class="hamburger">
								<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/hamburger.png" alt="">
							</a>
							<a href="<?php bloginfo('url') ?>" class="logo">
								<img src="<?php echo carbon_get_theme_option('crb_logo'); ?>" alt="<?php bloginfo('name'); ?>" alt="">
							</a>
							<a href="tel:+73912855222" class="mobp"></a>


							<?php
							if (is_user_logged_in()) {
								?>
								<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
									class="login login-in">
									<span class="mybonus">
										<div class="coin">
											<div class="side head"></div>
											<div class="side tail"></div>
											<div class="edge"></div>
										</div>
											<!-- <?php // echo get_the_author_meta('bonuss'); 
												?> -->
												<?php
												// $my_bonuss_vel = get_user_meta(get_current_user_id(), 'bonuss', true);
												echo ($my_bonuss_vel) ? $my_bonuss_vel : '';
												?>
									</span>
									<span class="avatar_img avatr-dop"></span>
								</a>
								<?php
							} else {
								?>
								<!-- <a href="<?php // echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="login">
									<span class="avatar_img"></span>
									<span>Войти</span>
								</a> -->
								<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="avatar">
									<img src="<?php bloginfo('template_url') ?>/assets/images/menu1/avatar.png" alt="">
								</a>
								<?php
							}
							?>



						</div>
						<div class="header_top_box">
							<div class="header_start">
								<!-- mobile hamburger -->
								<div class="mobile_appear">
									<a href="#" class="close">
										<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/close.svg" alt="">
									</a>
								</div>
								<div class="header_logo">
									<a href="<?php bloginfo('url') ?>">
										<img src="<?php echo carbon_get_theme_option('crb_logo'); ?>" alt="<?php bloginfo('name'); ?>">
									</a>
								</div>
								<!-- header_item -->
								<a href="tel:+<?php echo preg_replace('/[^0-9]/', '', carbon_get_theme_option('crb_phone_number')); ?>"
									class="header_item telephone">
									<div class="header_icon">
										<span class="phone_img"></span>
									</div>
									<div class="header_item_text">
										<span> <?php echo carbon_get_theme_option('crb_phone_number'); ?> </span>
										<p><?php echo carbon_get_theme_option('crb_schedule'); ?></p>
									</div>
								</a>
								<!-- header_item -->
								<a href="mailto:sibbest@list.ru" class="header_item email">
									<div class="header_icon">
										<span class="email_img"></span>
									</div>
									<div class="header_item_text">
										<span><?php echo carbon_get_theme_option('crb_email'); ?></span>
										<p>Задать вопрос</p>
									</div>
								</a>
								<!-- header_item -->
								<a href="/kontakty/#karta" class="header_item">
									<div class="header_icon">
										<span class="map_img"></span>
									</div>
									<div class="header_item_text">
										<span><?php echo carbon_get_theme_option('crb_address_header'); ?></span>
										<p>Самовывоз</p>
									</div>
								</a>
								<?php // get_search_form(); 
								?>
								<!-- header_input -->
								<div class="search_form">
									<form class="header_input" action="<?php esc_url(home_url('/')); ?>" method="post">
										<input type="text" placeholder="Поиск" value="<?php get_search_query(); ?>" name="s">
										<div class="search_icon">
											<span class="search_img"></span>
										</div>
									</form>
								</div>
								<?php
								wp_nav_menu([
									'theme_location' => 'mobile_menu',
									'menu' => '',
									'container' => 'div',
									'container_class' => '',
									'container_id' => '',
									'menu_class' => 'mobile_menu',
									'menu_id' => '',
									'echo' => true,
									'fallback_cb' => 'wp_page_menu',
									'before' => '',
									'after' => '',
									'link_before' => '',
									'link_after' => '',
									'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth' => 0,
									'walker' => '',
								]);
								?>
							</div>
							<div class="header_end">
								<?php $endpoint = '' ?>
								<?php
								if (is_user_logged_in()) {
									?>
									<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
										class="login login-in">
										<span class="mybonus">
											<div class="coin">
												<div class="side head"></div>
												<div class="side tail"></div>
												<div class="edge"></div>
											</div>
											<!-- <?php // echo get_the_author_meta('bonuss'); 
												?> -->
											<?php
											$my_bonuss_vel = get_user_meta(get_current_user_id(), 'bonuss', true);
											echo ($my_bonuss_vel) ? $my_bonuss_vel : '';
											?>
										</span>
										<span class="avatar_img avatr-dop"></span>
									</a>
									<?php
								} else {
									?>
									<a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id'));
									?>" class="login">
										<span class="avatar_img"></span>
										<span>Войти</span>
									</a>
									<?php
								}
								?>
								<div class="card_btn">
									<?php ohpirogi_woocommerce_cart_link(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="header_bottom">
					<?php wp_nav_menu([
						'theme_location' => 'top',
						'container' => null,
						'menu_class' => 'header_nav',
						'walker' => new Top_Walker_Nav_Menu,
					]); ?>
				</div>
			</div>
			<div class="swiper_product top_swiper">
				<div class="container">
					<div class="swiper mySwiper">
						<div class="swiper-wrapper">

							<?php
							foreach (carbon_get_theme_option('crb_slider') as $item) {
								if ($item['crb_event_date'] != current_time('d.m.Y') && $item['crb_event_date'] != '') {
									continue;
								}
								// echo $item['crb_event_date'];
								// echo '<br>';
								// echo current_time('d.m.Y');
								foreach ($item['crb_slide'] as $item_slide) {
									?>
									<a <?php echo ($item_slide['link']) ? 'href="' . $item_slide['link'] . '"' : ''; ?> class="swiper-slide">
										<img src="<?php echo $item_slide['photo']; ?>" alt="">
									</a>
									<?php
									// echo '<pre>';
									// var_dump($item);
									// echo '</pre>';
								}
							}
							?>

							<!-- <div class="swiper-slide">
									<img src="<?php bloginfo('template_url'); ?>/assets/images/banner/banner2.webp" alt="">
								</div>
								<div class="swiper-slide">
									<img src="<?php bloginfo('template_url'); ?>/assets/images/banner/banner.webp" alt="">
								</div>
								<div class="swiper-slide">
									<img src="<?php bloginfo('template_url'); ?>/assets/images/banner/banner.webp" alt="">
								</div> -->
						</div>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
				</div>
			</div>
		</header>
		<!-- submenu -->
		<section class="submenu">
			<div class="submenu_top">
				<div class="container submenu_top_general_block">
					<?php wp_nav_menu([
						'theme_location' => 'submenu_top',
						'container' => null,
						'menu_class' => 'submenu_top_block',
						'walker' => new Submenu_Top_Walker_Nav_Menu,
					]); ?>
				</div>
			</div>
			<div class="submenu_bottom_wrapper" id="cat">
				<div class="container submenu_bottom_general_block">
					<?php wp_nav_menu([
						'theme_location' => 'submenu_bottom1',
						'container' => null,
						'menu_class' => 'submenu_bottom_block',
						'walker' => new Submenu_Bottom_Walker_Nav_Menu,
					]); ?>
					<?php wp_nav_menu([
						'theme_location' => 'submenu_bottom2',
						'container' => null,
						'menu_class' => 'submenu_bottom_block',
						// 'container_class' => 'header_nav',
						// 'menu' => '',
						// 'container_id' => '',
						// 'menu_id' => '',
						// 'echo' => true,
						// 'fallback_cb' => 'wp_page_menu',
						// 'before' => '',
						// 'after' => '',
						// 'link_before' => '',
						// 'link_after' => '',
						// 'items_wrap' => '<ul id="%1$s" class="%2$s manu1">%3$s</ul>',
						// 'depth' => 0,
						// 'walker' => '',
						'walker' => new Submenu_Bottom_Walker_Nav_Menu,
					]); ?>
				</div>
			</div>
		</section>