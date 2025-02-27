<?php
if (!defined('ABSPATH')) {
  exit;
}
add_action('woocommerce_before_main_content', 'pir_wrapper_archive_start', 10);

function pir_wrapper_archive_start()
{
?>
  <section class="product">
    <div class="container">
    <?php
  }
  add_action('woocommerce_after_main_content', 'pir_wrapper_archive_end', 30);

  function pir_wrapper_archive_end()
  {
    ?>
  </section>
  </div>
<?php
  }
