<footer>
	<div class="container">
		<div class="footer_block">
			<!-- footer_item -->
			<div class="footer_item">
				<p class="footer_name">С нами можно связаться</p>
				<a href="tel:+<?php echo preg_replace('/[^0-9]/', '', carbon_get_theme_option('crb_phone_number')); ?>"
					class="footer_details">
					<span class="phone"></span>
					<p><?php echo carbon_get_theme_option('crb_phone_number'); ?></p>
				</a>
				<a href="#" class="footer_details">
					<span class="pin"></span>
					<p><?php echo carbon_get_theme_option('crb_address_footer'); ?></p>
				</a>
				<a href="mailto:sibbest@list.ru" class="footer_details">
					<span class="mail"></span>
					<p><?php echo carbon_get_theme_option('crb_email'); ?></p>
				</a>
				<a href="#" class="footer_details">
					<span class="time"></span>
					<p>Режим и время работы:
						<?php echo carbon_get_theme_option('crb_schedule'); ?>
					</p>
				</a>
			</div>
			<!-- footer_item -->
			<div class="footer_item">
				<p class="footer_name">Меню</p>
				<?php wp_nav_menu([
					'theme_location' => 'footer_menu',
					'container' => null,
					'menu_class' => 'footer_navs',
					'walker' => new Footer_Menu_Walker_Nav_Menu,
				]); ?>
			</div>
			<div class="footer_item">
				<p class="footer_name">Навигация</p>
				<?php wp_nav_menu([
					'theme_location' => 'footer_nav',
					'container' => 'ul',
					'menu_class' => 'footer_navs',
				]); ?>
			</div>
			<div class="footer_item question">
				<p class="footer_name">Остались вопросы?</p>
				<div class="footer_buttons">
					<a href="#">Задать вопрос</a>
					<a href="#">Перезвонить вам?</a>
				</div>
				<div class="footer_socials">
					<a
						href="<?php echo (carbon_get_theme_option('crb_address_telegram')) ? carbon_get_theme_option('crb_address_telegram') : '#' ?>">
						<img src="<?php bloginfo('template_url') ?>/img/7fut/telegram(2).png" alt="">
					</a>
					<a
						href="<?php echo (carbon_get_theme_option('crb_address_whatsapp')) ? carbon_get_theme_option('crb_address_whatsapp') : '#' ?>">
						<img src="<?php bloginfo('template_url') ?>/assets/images/footer/whatssapp-big-logo.png" alt="">
					</a>
					<a
						href="<?php echo (carbon_get_theme_option('crb_address_viber')) ? carbon_get_theme_option('crb_address_viber') : '#' ?>">
						<img src="<?php bloginfo('template_url') ?>/assets/images/footer/viber(1).png" alt="">
					</a>
				</div>
				<a href="#" class="ask_question">
					Задать вопрос онлайн
				</a>
			</div>
		</div>
	</div>
	<div class="footer_bottom_wrapper">
		<div class="container">
			<div class="footer_bottom">
				<div class="footer_left">
					<p>
						<?php echo carbon_get_theme_option('crb_bottom_footer_copy'); ?>
					</p>
					<p>
						<?php
						$policy = carbon_get_theme_option('crb_bottom_footer_policy');
						$terms = carbon_get_theme_option('crb_bottom_footer_terms');
						if ($policy) {
							echo '<a class="policy_link" href="' . $policy . '">Политика конфиденциальности</a>';
						}
						echo (($policy) && ($terms)) ? ' | ' : '';
						if ($terms) {
							echo '<a href="' . $terms . '">Пользовательское соглашение</a>';
						}
						?>
					</p>
				</div>
				<div class="footer_right">
					<p>
						ОГРН: <?php echo carbon_get_theme_option('crb_bottom_footer_ogrn'); ?>
					</p>
					<p>
						ИНН: <?php echo carbon_get_theme_option('crb_bottom_footer_inn'); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile_appear">
		<div class="mobile_footer_block">
			<div class="mobile_footer_item">
				<a id="mobile_menu_top_btn" href="#" data-skr="header" class="icon">
					<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/main-menu.png" alt="">
				</a>
				<p class="mobile_name">Меню</p>
			</div>
			<div class="mobile_footer_item">
				<a href="/aktsii/#top" class="icon">
					<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/discount.png" alt="">
				</a>
				<p class="mobile_name">Акции</p>
			</div>
			<div class="mobile_footer_item">
				<?php ohpirogi_woocommerce_cart_link(); ?>
			</div>
			<div class="mobile_footer_item">
				<a href="/kontakty/#karta" class="icon">
					<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/pin.png" alt="">
				</a>
				<p class="mobile_name">Самовывоз</p>
			</div>
			<div class="mobile_footer_item">
				<a class="icon mobile_search_btn">
					<img src="<?php bloginfo('template_url') ?>/assets/images/mobile/search.png" alt="">
				</a>
				<p class="mobile_name">Поиск</p>
			</div>
		</div>
		<div class="search_form search_form_footer">
			<form class="header_input" action="<?php esc_url(home_url('/')); ?>" method="post">
				<input type="text" placeholder="Поиск" value="<?php get_search_query(); ?>" name="s">
				<div class="search_icon">
					<span class="search_img"></span>
				</div>
			</form>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>

<div class="btn-call-holder">
	<a href="tel:+73912952161" rel="nofollow" class="btn-call">
		<div class="btn-call__ico">
			<i class="fas fa-phone-alt"></i>
		</div>
	</a>
</div>


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
	(function (m, e, t, r, i, k, a) { m[i] = m[i] || function () { (m[i].a = m[i].a || []).push(arguments) }; m[i].l = 1 * new Date(); for (var j = 0; j < document.scripts.length; j++) { if (document.scripts[j].src === r) { return; } } k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a) })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(44566749, "init", { clickmap: true, trackLinks: true, accurateTrackBounce: true, webvisor: true, ecommerce: "dataLayer" });
</script>
<noscript>
	<div><img src="https://mc.yandex.ru/watch/44566749" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter -->


</body>

</html>