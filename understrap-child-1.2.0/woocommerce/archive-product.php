<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

?>

<?php
// Get the ID of the current shop page
$page_id = get_option('woocommerce_shop_page_id');
// Get the field value for the shop page image
$shop_image = get_field('shop_page_image', $page_id);
$shop_page_title_image = get_field('shop_page_title_image', $page_id);
$shop_image_text = get_field('shop_image_text', $page_id);

$angebot_image = get_field('angebot_page_image', $page_id);
$angebot_page_title_image = get_field('angebot_page_title_image', $page_id);
$angebot_image_text = get_field('angebot_image_text', $page_id);
?>

<?php if (strpos($_SERVER['REQUEST_URI'], 'marken') === false) { ?>

  <?php if (is_product_category('angebot')) { ?>
    <!-- Current page is the "angebot" product category page -->
    <div class="row">
      <div class="col-md-12 wc-shop-img-wrapper new-shop-image-wrapper">
        <div class="wc-shop-img" style="background-image: url('<?php echo esc_url($angebot_image); ?>')">
          <div class="container">
            <div class="row">
              <div class="col-md-6 text-start">
                <h2><?php echo ($angebot_page_title_image); ?></h2>
                <p><?php echo ($angebot_image_text); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <!-- Current page is not the "angebot" product category page -->
    <div class="row">
      <div class="col-md-12 wc-shop-img-wrapper new-shop-image-wrapper">
        <div class="wc-shop-img" style="background-image: url('<?php echo esc_url($shop_image); ?>')">
          <div class="container">
            <div class="row">
              <div class="col-md-6 text-start">
                <h2><?php echo ($shop_page_title_image); ?></h2>
                <p><?php echo ($shop_image_text); ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

<?php } else { ?>
  <?php $marken_title = get_queried_object(); ?>
  <!-- Content for the "marken" product category -->
  <div class="row">
    <div class="col-md-12 wc-shop-img-wrapper new-shop-image-wrapper">
      <div class="wc-shop-img" >
        <div class="container">
          <div class="row">
            <div class="col-md-6 text-start">
              <h2><?php echo $marken_title->name; ?></h2>
              <p></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>


<div class="container">
  <?php if (!wp_is_mobile() && intval($_SERVER['HTTP_CLIENT_WIDTH']) < 992) : ?>
    <div class="row wc-shop-page-wrapper">
      <div class="col-lg-3 col-md-3 col-sm-12">
        <?php if (is_active_sidebar('woocommerce_filters')) : ?>
          <div class="woocommerce-filters">
            <?php dynamic_sidebar('woocommerce_filters'); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-9 products-list-wrapper">

        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-12 wc-search-page">
            <p><?php esc_html_e('Search:', 'understrap-child'); ?></p>
            <?php echo do_shortcode('[annasta_filters preset_id=1]'); ?>
          </div>
          <div class="col-lg-4 wc-shop-page-simple-filter">
            <p><?php esc_html_e('Sorting:', 'understrap-child'); ?></p>
            <?php do_action('woocommerce_before_shop_loop'); ?>
          </div>
        </div>
      <?php else : ?>
        <!-- For mobile device -->
        <div class="row wc-shop-page-wrapper">
          <div class="col-12 wc-search-page">
            <!-- Search bar code here -->
            <p><?php esc_html_e('Search:', 'understrap-child'); ?></p>
            <form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
              <input type="text" name="s" id="s" placeholder="<?php echo esc_attr_x('Mit dem tippen beginnen', 'placeholder', 'woocommerce'); ?>" value="<?php echo get_search_query(); ?>">
              <button type="submit" id="searchsubmit">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ion_search-outline.svg" alt="Search" />
              </button>
              <input type="hidden" name="post_type" value="product">
            </form>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-6 wc-mobile-filter-link">
                <a href="#" id="filter-link" class="btn btn-primary"><?php esc_html_e('Filter', 'understrap-child'); ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/product-filter.svg" alt="filter-icon"></a>
              </div>
              <div class="col-6 wc-mobile-sorting-link">
                <a href="#" id="sorting-link" class="btn btn-primary"><?php esc_html_e('Sorting', 'understrap-child'); ?><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/product-sorting.svg" alt="sorting-icon"></a>
              </div>
            </div>
          </div>
          <div class="col-12 wc-mobile-filters">
            <!-- Woocommerce filters code here -->
            <?php if (is_active_sidebar('woocommerce_filters')) : ?>
              <div class="woocommerce-filters">
                <?php dynamic_sidebar('woocommerce_filters'); ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="col-12 wc-shop-page-simple-filter wc-mobile-sorting">
            <!-- Woocommerce sorting code here -->
            <p><?php esc_html_e('Sorting:', 'understrap-child'); ?></p>
            <?php do_action('woocommerce_before_shop_loop'); ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="product-switcher">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/one-col-products.svg" class="switcher-btn one-col-m-product-view" data-target="col-6" alt="Button 1">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/two-col-products.svg" class="switcher-btn two-col-m-product-view" data-target="col-12" alt="Button 2">
      </div>
    </div>



    <?php
    do_action('woocommerce_before_main_content');
    ?>


    <!-- <div class="product-list-wrapper"> -->
    <?php
    if (woocommerce_product_loop()) {
      woocommerce_product_loop_start();
      if (wc_get_loop_prop('total')) {
        while (have_posts()) {
          the_post();

          do_action('woocommerce_shop_loop');

          wc_get_template_part('content', 'product');
        }
      }
      woocommerce_product_loop_end();
      do_action('woocommerce_after_shop_loop');
    } else {
      do_action('woocommerce_no_products_found');
    } ?>


    <?php
    do_action('woocommerce_after_main_content');
    ?>
    <!-- </div> -->


    </div>
    <div class="col-lg-12">
      <?php echo '<p class="woocommerce-product-count">' . sprintf(__('Showing %1$d&ndash;%2$d of %3$d products', 'understrap-child'), wc_get_loop_prop('current_page'), wc_get_loop_prop('per_page'), wc_get_loop_prop('total')) . '</p>'; ?>
    </div>
</div>

<div class="container">
  <?php if (is_product_category('angebot')) { ?>
    <!-- Current page is the "angebot" product category page -->
    <?php
    $page_id = 12; // Shop page

    $page = get_post($page_id);

    if ($page) {
      $content = $page->post_content;
      $content = do_shortcode($content);

      echo $content;
    } else {
      echo "Page not found.";
    }
    ?>
  <?php } else { ?>
    <!-- Current page is not the "angebot" product category page -->
    <div class="row">
      <?php
      do_action('woocommerce_archive_description');
      ?>
    </div>
  <?php } ?>
</div>

</div>

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

<?php
get_footer('shop');
