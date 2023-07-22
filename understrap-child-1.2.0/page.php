<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');

?>

<?php if (is_page(5)) {
  // Slider for homepage
  echo do_shortcode('[metaslider id="236"]');
}
?>





<div class="wrapper" id="page-wrapper">

  <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

    <div class="row">

      <?php
      // Do the left sidebar check and open div#primary.
      get_template_part('global-templates/left-sidebar-check');
      ?>

      <main class="site-main" id="main">

        <?php
        while (have_posts()) {
          the_post();
          get_template_part('loop-templates/content', 'page');

          // If comments are open or we have at least one comment, load up the comment template.
          if (comments_open() || get_comments_number()) {
            comments_template();
          }
        }
        ?>

      </main>

      <?php
      // Do the right sidebar check and close div#primary.
      get_template_part('global-templates/right-sidebar-check');
      ?>

    </div><!-- .row -->

  </div><!-- #content -->

</div><!-- #page-wrapper -->

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto"><?php esc_html_e('Added to Cart', 'understrap-child'); ?></strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php esc_html_e('Product successfully added to your cart.', 'understrap-child'); ?>
    </div>
  </div>
</div>

<?php if (is_page(5)) : ?>

  <div class="subscription-banner sub-bnr-no-mobile">
    <div class="newsletter-layer-wrapper">
      <div class="newsletter-title-text">
        <h3 class="newsletter-title"><?php _e('Newsletter', 'understrap-child'); ?></h3>
        <p class="newsletter-text"><?php _e('Subscribe to our newsletter to receive updates and special offers.', 'understrap-child'); ?></p>
      </div>
      <div class="newsletter-link-subscribe">
        <a class="newsletter-link" href="#"><?php _e('Subscribe Now', 'understrap-child'); ?></a>
      </div>
      <div class="close-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </div>
    </div>
  </div>

  <div class="subscription-banner sub-bnr-mobile">
    <div class="newsletter-layer-wrapper">
      <div class="newsletter-content">
        <div class="newsletter-title-row">
          <h3 class="newsletter-title"><?php _e('Newsletter', 'understrap-child'); ?></h3>
          <div class="close-button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
              <line x1="18" y1="6" x2="6" y2="18" />
              <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </div>
        </div>
        <p class="newsletter-text"><?php _e('Subscribe to our newsletter to receive updates and special offers.', 'understrap-child'); ?></p>
      </div>
      <div class="newsletter-link-subscribe">
        <a class="newsletter-link" href="#"><?php _e('Subscribe Now', 'understrap-child'); ?></a>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php
get_footer();
