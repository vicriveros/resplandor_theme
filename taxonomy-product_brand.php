<?php
/**
 * Taxonomy Template for Brands (product_brand)
 *
 * @package resplandor
 */

get_header();

$brand = get_queried_object();
?>

<div class="res-container py-10 pt-32">
  <header class="res-featured__head mb-12">
    <h1 class="res-featured__title"><?php echo esc_html( $brand->name ); ?></h1>
    <?php if ( ! empty( $brand->description ) ) : ?>
      <p class="res-featured__subtitle">
        <?php echo wp_kses_post( $brand->description ); ?>
      </p>
    <?php endif; ?>
  </header>

  <?php if ( have_posts() ) : ?>
    <div class="res-grid">
      <?php
      while ( have_posts() ) : the_post();
          global $product;
          
          if ( ! is_a( $product, 'WC_Product' ) ) {
              $product = wc_get_product( get_the_ID() );
          }
          if ( ! $product ) continue;
          
          // Check if product is on sale
          $is_on_sale = $product->is_on_sale();
          $badge_text = $is_on_sale ? 'Oferta' : 'Destacado';
          $badge_class = $is_on_sale ? 'res-badge res-badge--sale' : 'res-badge';
          
          // Prices
          $regular_price = $product->get_regular_price();
          $sale_price    = $product->get_sale_price();
          $price_html    = '';
          if ( $is_on_sale && $regular_price && $sale_price ) {
              $price_html .= '<span class="res-price__old">' . wc_price( $regular_price ) . '</span>';
              $price_html .= '<span class="res-price__new">' . wc_price( $sale_price ) . '</span>';
          } else {
              $price_html .= '<span class="res-price__new">' . $product->get_price_html() . '</span>';
          }
          
          // Thumbnail
          $image_url = get_the_post_thumbnail_url( $product->get_id(), 'woocommerce_thumbnail' );
          if ( ! $image_url ) {
              $image_url = wc_placeholder_img_src();
          }
          ?>
          <!-- Card -->
          <article <?php wc_product_class( 'res-card', $product ); ?>>
            <span class="<?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $badge_text ); ?></span>

            <div class="res-card__media">
              <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="res-card__link">
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" />
              </a>
            </div>

            <div class="res-card__body">
              <h3 class="res-card__name">
                  <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
              </h3>

              <div class="res-card__row">
                <div class="res-price">
                  <?php echo wp_kses_post( $price_html ); ?>
                </div>

                <?php
                $add_to_cart_url = $product->add_to_cart_url();
                $add_to_cart_classes = array(
                  'res-cart',
                  'button',
                  'product_type_' . $product->get_type(),
                  $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                  $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                );
                ?>
                <a href="<?php echo esc_url( $add_to_cart_url ); ?>"
                   data-quantity="1"
                   class="<?php echo esc_attr( implode( ' ', array_filter( $add_to_cart_classes ) ) ); ?>"
                   data-product_id="<?php echo get_the_ID(); ?>"
                   data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                   aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
                   rel="nofollow">
                  <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
                </a>
              </div>
            </div>
          </article>
          <?php
      endwhile;
      ?>
    </div>
    
    <div class="res-pagination mt-10">
      <?php
      echo paginate_links( array(
          'prev_text' => '&laquo; Anterior',
          'next_text' => 'Siguiente &raquo;',
      ) );
      ?>
    </div>
  <?php else : ?>
    <p>No se encontraron productos para esta marca.</p>
  <?php endif; ?>
</div>

<?php
get_footer();
