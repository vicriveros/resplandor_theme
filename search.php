<?php
/**
 * The template for displaying search results pages
 *
 * @package resplandor
 */

get_header();
?>

<section class="bg-neutral-50" id="search-results">
  <!-- Header / Breadcrumb -->
  <div class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-res-green/95 via-res-green to-res-green/90"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_30%,white_0%,transparent_40%),radial-gradient(circle_at_85%_25%,white_0%,transparent_45%),radial-gradient(circle_at_60%_90%,white_0%,transparent_45%)]"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-12">
      <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white focus:outline-none">
        <?php
        /* translators: %s: search query. */
        printf( esc_html__( 'Resultados de búsqueda para: %s', 'resplandor' ), '<span>' . get_search_query() . '</span>' );
        ?>
      </h1>

      <nav class="mt-3 text-sm text-white/85 woocommerce-breadcrumb">
        <ol class="flex flex-wrap items-center gap-2">
          <li class="text-white/85"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'resplandor' ); ?></a></li>
          <li class="text-white/60">›</li>
          <li class="text-white/85"><?php esc_html_e( 'Búsqueda', 'resplandor' ); ?></li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Content -->
  <div class="mx-auto max-w-7xl px-4 py-10">
    <div class="res-container">
      <?php if ( have_posts() ) : ?>
        <div class="res-grid">
          <?php
          while ( have_posts() ) : the_post();
              global $product;
              
              if ( ! is_a( $product, 'WC_Product' ) ) {
                  $product = wc_get_product( get_the_ID() );
              }
              if ( ! $product ) continue;
              
              $is_on_sale = $product->is_on_sale();
              $is_featured = $product->is_featured();
              $badge_text = '';
              $badge_class = '';

              if ( $is_on_sale ) {
                  $badge_text = 'Oferta';
                  $badge_class = 'res-badge res-badge--sale';
              } elseif ( $is_featured ) {
                  $badge_text = 'Destacado';
                  $badge_class = 'res-badge';
              }
              
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
                <?php if ( $badge_text ) : ?>
                  <span class="<?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $badge_text ); ?></span>
                <?php endif; ?>

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
        <p class="text-res-text text-lg"><?php esc_html_e( 'No se encontraron productos que coincidan con tu búsqueda.', 'resplandor' ); ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php
get_footer();
