<?php
/**
 * The front page template file
 *
 * @package resplandor
 */

get_header();
?>

<!-- =========================
  HERO BANNER
========================= -->
<section class="res-hero">
  <div class="res-hero__viewport">
    <div class="res-hero__track">
      <!-- Slide 1 -->
      <a
        href="#"
        class="res-hero__slide is-active"
        data-bg-desktop="<?php echo esc_url( get_template_directory_uri() ); ?>/img/banner_desodorante_frutilla_resplandor.png"
        data-bg-mobile="<?php echo esc_url( get_template_directory_uri() ); ?>/img/banner_desodorante_frutilla_resplandor_m.png"
        aria-label="Productos de limpieza Resplandor"
      ></a>

      <!-- Slide 2 -->
      <a
        href="#"
        class="res-hero__slide is-active"
        data-bg-desktop="<?php echo esc_url( get_template_directory_uri() ); ?>/img/banner_limpia_vidrios_resplandor.png"
        data-bg-mobile="<?php echo esc_url( get_template_directory_uri() ); ?>/img/banner_limpia_vidrios_resplandor_m.png"
        aria-label="Productos de limpieza Resplandor"
      ></a>

      <!-- Slide 3 -->
      <a
        href="#"
        class="res-hero__slide is-active"
        data-bg-desktop="<?php echo esc_url( get_template_directory_uri() ); ?>/img/banner_detergentes_resplandor.png"
        data-bg-mobile="<?php echo esc_url( get_template_directory_uri() ); ?>/img/banner_detergentes_resplandor_m.png"
        aria-label="Productos de limpieza Resplandor"
      ></a>
    </div>

    <!-- Flechas -->
    <button class="res-hero__arrow res-hero__arrow--prev" aria-label="Anterior">‹</button>
    <button class="res-hero__arrow res-hero__arrow--next" aria-label="Siguiente">›</button>

    <!-- Dots -->
    <div class="res-hero__dots">
      <button class="res-hero__dot is-active"></button>
      <button class="res-hero__dot"></button>
      <button class="res-hero__dot"></button>
    </div>
  </div>
</section>

<!-- =========================
  PRODUCTOS DESTACADOS
========================= -->
<section class="res-featured pb-40">
  <div class="res-container">
    <header class="res-featured__head">
      <h2 class="res-featured__title">Productos destacados</h2>
      <p class="res-featured__subtitle">
        Lo más pedido esta semana 🧼✨
      </p>
    </header>

    <div class="res-grid">

      <?php
      $args = array(
          'post_type'      => 'product',
          'posts_per_page' => 4,
          'tax_query'      => array(
              array(
                  'taxonomy' => 'product_visibility',
                  'field'    => 'name',
                  'terms'    => 'featured',
                  'operator' => 'IN',
              ),
          ),
      );
      $featured_query = new WP_Query( $args );

      if ( $featured_query->have_posts() ) :
          while ( $featured_query->have_posts() ) : $featured_query->the_post();
              global $product;
              
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
                <!-- Badge -->
                <span class="<?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $badge_text ); ?></span>

                <!-- Imagen clickeable -->
                <div class="res-card__media">
                  <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="res-card__link">
                    <img
                      src="<?php echo esc_url( $image_url ); ?>"
                      alt="<?php echo esc_attr( $product->get_name() ); ?>"
                    />
                  </a>
                </div>

                <div class="res-card__body">
                  <h3 class="res-card__name"><?php echo esc_html( $product->get_name() ); ?></h3>

                  <div class="res-card__row">
                    <div class="res-price">
                      <?php echo wp_kses_post( $price_html ); ?>
                    </div>

                    <?php
                    // Set up Add to Cart URL and Classes
                    $add_to_cart_url = $product->add_to_cart_url();
                    
                    // Specific WooCommerce classes needed for AJAX functionality
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
          wp_reset_postdata();
      else :
          echo '<p>No hay productos destacados por el momento.</p>';
      endif;
      ?>

    </div>
  </div>
</section>

<!-- =========================
  NUESTRAS MARCAS
========================= -->

<section class="res-partners" data-partners>
  <div class="res-partners__container">
    <h2 class="res-partners__title">Nuestras marcas</h2>

    <div class="res-partners__carousel">
      <button
        class="res-partners__arrow res-partners__arrow--prev"
        aria-label="Anterior"
      >‹</button>

      <div class="res-partners__viewport">
        <div class="res-partners__track">

          <?php
          $brand_terms = get_terms( array(
              'taxonomy'   => 'product_brand',
              'hide_empty' => true,
          ) );

          if ( ! empty( $brand_terms ) && ! is_wp_error( $brand_terms ) ) {
              foreach ( $brand_terms as $brand ) {
                  // Get the thumbnail if WooCommerce Brands or similar is used.
                  // Usually stored in term meta 'thumbnail_id'
                  $thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
                  if ( $thumbnail_id ) {
                      $image_url = wp_get_attachment_url( $thumbnail_id );
                  } else {
                      $image_url = wc_placeholder_img_src();
                  }
                  
                  // Wrap in link to the brand archive
                  $brand_link = get_term_link( $brand );
                  ?>
                  <div class="res-partners__item">
                    <a href="<?php echo esc_url( $brand_link ); ?>" aria-label="<?php echo esc_attr( $brand->name ); ?>">
                      <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" />
                    </a>
                  </div>
                  <?php
              }
          } else {
              echo '<p>No se encontraron marcas.</p>';
          }
          ?>
        </div>
      </div>

      <button
        class="res-partners__arrow res-partners__arrow--next"
        aria-label="Siguiente"
      >›</button>
    </div>
  </div>
</section>

<!-- =========================
  CUIDADO DIARIO PARA TU HOGAR
========================= -->

<section class="res-featured pt-40">
  <div class="res-featured__inner">
    <header class="res-featured__head">
      <h2 class="res-featured__title">Cuidado diario para tu hogar</h2>
      <p class="res-featured__subtitle">
        Soluciones prácticas de limpieza y aroma para el uso cotidiano.🏡✨
      </p>
    </header>

    <div class="res-featured__grid">
      <?php
      $args = array(
          'post_type'      => 'product',
          'posts_per_page' => 4,
          'product_cat'    => 'linea-hogar',
      );
      $hogar_query = new WP_Query( $args );

      if ( $hogar_query->have_posts() ) :
          while ( $hogar_query->have_posts() ) : $hogar_query->the_post();
              global $product;
              
              // Thumbnail
              $image_url = get_the_post_thumbnail_url( $product->get_id(), 'woocommerce_thumbnail' );
              if ( ! $image_url ) {
                  $image_url = wc_placeholder_img_src();
              }
              ?>
              <!-- Card -->
              <article <?php wc_product_class( 'res-fcard', $product ); ?>>
                <!-- Media -->
                <div class="res-fcard__media">
                  <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">
                  </a>
                  <span class="res-fcard__badge">Uso diario</span>
                </div>

                <!-- Body -->
                <div class="res-fcard__body">
                  <div class="res-fcard__top">
                    <h3 class="res-fcard__name">
                      <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
                    </h3>
                  </div>

                  <div class="res-fcard__desc">
                    <?php 
                      if ( has_excerpt() ) {
                          echo wp_kses_post( wpautop( get_the_excerpt() ) ); 
                      } else {
                          echo wp_kses_post( wpautop( wp_trim_words( get_the_content(), 15, '...' ) ) );
                      }
                    ?>
                  </div>

                  <div class="res-fcard__meta">
                    <span class="res-fcard__price"><?php echo $product->get_price_html(); ?></span>
                  </div>

                  <!-- ACCIONES -->
                  <div class="res-fcard__actions">
                    <!-- BOTÓN VER DETALLE -->
                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="res-fcard__cta">
                      Ver detalle
                    </a>

                    <!-- BOTÓN CARRITO -->
                    <?php
                    $add_to_cart_url = $product->add_to_cart_url();
                    
                    $add_to_cart_classes = array(
                      'res-fcard__cart',
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
                      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" alt="">
                    </a>
                  </div>
                </div>
              </article>
              <?php
          endwhile;
          wp_reset_postdata();
      else :
          echo '<p>No hay productos en esta categoría por el momento.</p>';
      endif;
      ?>      

    </div>
  </div>
</section>

<?php
get_footer();
