<?php
/*
Template Name: home
*/
?>
<?php get_header(); ?>


<!-- swiper -->
<section class="swiper_product">
  <div class="container">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">

        <?php
        // echo '<pre>';
        // print_r(count(carbon_get_theme_option('crb_slider')));
        // echo '</pre>';
        $GLOBALS['count_all_slides'] = 0;
        function home_slides()
        {
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
              $GLOBALS['count_all_slides']++;
              // }
              // echo '<pre>';
              // var_dump($item);
              // echo '</pre>';
            }
          }
        }

        home_slides();

        if ($GLOBALS['count_all_slides'] == 1) {
          home_slides();
        }
        ?>



        <!-- <div class="swiper-slide">
          <img src="<?php // bloginfo('template_url'); 
          ?>/assets/images/banner/banner.webp" alt="">
        </div>
        <div class="swiper-slide">
          <img src="<?php // bloginfo('template_url'); 
          ?>/assets/images/banner/banner.webp" alt="">
        </div> -->
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>

<?php

?>

<section class="section_def_content">
  <div class="container">
    <?php
    // <header>
    //   <h1 class="page-title screen-reader-text"> // single_post_title(); </h1>
    // </header>
    ?>
    <?php
    while (have_posts()):
      the_post();

      get_template_part('template-parts/content', 'page');

      // If comments are open or we have at least one comment, load up the comment template.
      if (comments_open() || get_comments_number()):
        comments_template();
      endif;

    endwhile; // End of the loop.
    ?>
  </div>
</section>


<!-- <?php // echo do_shortcode( '[swiper]' ); 
?> -->

<?php get_footer(); ?>