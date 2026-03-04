<?php
/**
 * The Template for displaying all single products
 *
 * @package resplandor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

while ( have_posts() ) :
	the_post();
	global $product;

  // Pre-calculate data
  $is_on_sale = $product->is_on_sale();
  
  // Prices
  $regular_price = $product->get_regular_price();
  $sale_price    = $product->get_sale_price();
  
  // Brands
  $brands = wp_get_post_terms( $product->get_id(), 'product_brand', array('fields' => 'names') );
  $brand_name = ! empty( $brands ) ? reset( $brands ) : '';

  // Tags
  $tags = wc_get_product_term_ids( $product->get_id(), 'product_tag' );

  // Main Image
  $main_image_url = get_the_post_thumbnail_url( $product->get_id(), 'full' );
  if ( ! $main_image_url ) {
      $main_image_url = wc_placeholder_img_src();
  }
  
  // Gallery Images
  $attachment_ids = $product->get_gallery_image_ids();
?>

<!-- =========================
  DETALLES DEL PRODUCTO 
========================= -->

<section class="bg-neutral-50" id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
  <!-- Header / Breadcrumb -->
  <div class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-res-green/95 via-res-green to-res-green/90"></div>
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_30%,white_0%,transparent_40%),radial-gradient(circle_at_85%_25%,white_0%,transparent_45%),radial-gradient(circle_at_60%_90%,white_0%,transparent_45%)]"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-12">
      <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
        Detalles del producto
      </h1>

      <nav class="mt-3 text-sm text-white/85 woocommerce-breadcrumb">
        <?php woocommerce_breadcrumb( array(
            'delimiter'   => ' <span class="text-white/60">›</span> ',
            'wrap_before' => '<ol class="flex flex-wrap items-center gap-2">',
            'wrap_after'  => '</ol>',
            'before'      => '<li class="text-white/85">',
            'after'       => '</li>',
            'home'        => _x( 'Inicio', 'breadcrumb', 'woocommerce' ),
        ) ); ?>
      </nav>
    </div>
  </div>

  <!-- Content -->
  <div class="mx-auto max-w-7xl px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
      
      <!-- GALERÍA -->
      <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 overflow-hidden h-fit">
        <div class="p-4 sm:p-6">
          <div class="flex items-center justify-between">
            <?php if ( $product->is_featured() ) : ?>
            <span class="inline-flex items-center rounded-full bg-res-green/10 text-res-green border border-res-green/20 px-3 py-1 text-xs font-semibold">
              Destacado
            </span>
            <?php elseif ( $is_on_sale ) : ?>
            <span class="inline-flex items-center rounded-full bg-res-green/10 text-res-green border border-res-green/20 px-3 py-1 text-xs font-semibold">
              Oferta
            </span>
            <?php else : ?>
            <span></span>
            <?php endif; ?>

            <?php if ( $product->get_sku() ) : ?>
            <span class="text-xs text-res-text/70">
              Código: <strong class="text-res-text"><?php echo esc_html( $product->get_sku() ); ?></strong>
            </span>
            <?php endif; ?>
          </div>

          <!-- Imagen principal -->
          <div class="mt-5 rounded-2xl bg-white border border-res-gray/40 p-6 sm:p-8 flex items-center justify-center relative">
            <img
              id="productMainImage"
              src="<?php echo esc_url( $main_image_url ); ?>"
              alt="<?php echo esc_attr( $product->get_name() ); ?>"
              class="w-full max-w-[520px] lg:max-w-[560px] h-auto object-contain transition-all duration-300"
              loading="lazy"
              decoding="async"
            />
          </div>

          <!-- Thumbs (strip scrolleable) -->
          <?php if ( $attachment_ids && $product->get_image_id() ) : ?>
          <div class="mt-5">
            <div class="res-gal__thumbs" data-gal-thumbs>
              <!-- Main Image Thumb -->
              <button type="button" class="res-thumb is-active" aria-label="Miniatura Principal">
                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $product->get_id(), 'gallery_thumbnail' ) ?: $main_image_url ); ?>" alt="Miniatura Principal" class="w-full h-full object-cover" />
              </button>

              <?php foreach ( $attachment_ids as $attachment_id ) : ?>
              <button type="button" class="res-thumb" aria-label="Miniatura">
                <img src="<?php echo esc_url( wp_get_attachment_image_url( $attachment_id, 'gallery_thumbnail' ) ); ?>" data-full-image="<?php echo esc_url( wp_get_attachment_image_url( $attachment_id, 'full' ) ); ?>" alt="Miniatura" class="w-full h-full object-cover" />
              </button>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

        </div>
      </div>

      <!-- INFO + COMPRA -->
      <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 overflow-hidden h-fit">
        <div class="p-5 sm:p-7">
          <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-neutral-800">
            <?php echo esc_html( $product->get_name() ); ?>
          </h2>

          <div class="mt-2 flex flex-wrap gap-x-6 gap-y-1 text-sm text-res-text/75">
            <?php if ( $product->get_sku() ) : ?>
            <span>COD: <strong class="text-res-text"><?php echo esc_html( $product->get_sku() ); ?></strong></span>
            <?php endif; ?>
            
            <?php if ( $brand_name ) : ?>
            <span>Marca: <strong class="text-res-text"><?php echo esc_html( $brand_name ); ?></strong></span>
            <?php endif; ?>
          </div>

          <!-- Price -->
          <div class="mt-5 flex items-baseline gap-3">
            <?php if ( $is_on_sale && $regular_price && $sale_price ) : ?>
              <span class="text-res-text/60 line-through font-semibold"><?php echo wc_price( $regular_price ); ?></span>
              <span class="text-res-green text-2xl font-extrabold"><?php echo wc_price( $sale_price ); ?></span>
            <?php else : ?>
              <span class="text-res-green text-2xl font-extrabold"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
            <?php endif; ?>
          </div>

          <div class="mt-4 text-res-text leading-relaxed">
            <?php echo wp_kses_post( apply_filters( 'woocommerce_short_description', $product->get_short_description() ) ); ?>
          </div>

          <!-- Tags -->
          <?php if ( ! empty( $tags ) ) : ?>
          <div class="mt-5 flex flex-wrap items-center gap-2">
            <span class="text-sm font-semibold text-neutral-700">Etiquetas:</span>
            <?php foreach ( $tags as $tag_id ) : 
              $tag = get_term( $tag_id, 'product_tag' );
              if ( ! is_wp_error( $tag ) ) :
            ?>
            <span class="inline-flex items-center rounded-full bg-neutral-100 text-res-text px-3 py-1 text-xs font-semibold">
              <?php echo esc_html( $tag->name ); ?>
            </span>
            <?php 
              endif;
            endforeach; 
            ?>
          </div>
          <?php endif; ?>

          <!-- Stock -->
          <div class="mt-5 flex items-center gap-2">
            <span class="text-sm font-semibold text-neutral-700">En stock:</span>
            <?php if ( $product->is_in_stock() ) : ?>
            <span class="inline-flex items-center gap-2 rounded-full bg-res-green/10 text-res-green border border-res-green/20 px-3 py-1 text-xs font-bold">
              <span class="h-2 w-2 rounded-full bg-res-green"></span>
              Disponible
            </span>
            <?php else : ?>
            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 text-red-600 border border-red-200 px-3 py-1 text-xs font-bold">
              <span class="h-2 w-2 rounded-full bg-red-600"></span>
              Agotado
            </span>
            <?php endif; ?>
          </div>

          <!-- Add to Cart Form -->
          <div class="mt-6">
            <?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
              <form class="cart res-custom-cart-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                
                <!-- Cantidad -->
                <div class="flex flex-wrap items-center gap-4 mb-7">
                  <span class="text-sm font-semibold text-neutral-700">Cantidad:</span>

                  <div class="flex items-center rounded-xl border border-res-gray/60 bg-white overflow-hidden">
                    <button
                      type="button"
                      class="res-qty-minus w-11 h-11 grid place-items-center text-res-text/70 hover:bg-neutral-50 active:scale-[.98] transition"
                      aria-label="Restar"
                    >
                      –
                    </button>

                    <?php
                    woocommerce_quantity_input(
                        array(
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                            'classes'     => apply_filters( 'woocommerce_quantity_input_classes', array( 'w-14 h-11 text-center text-sm font-bold text-neutral-800 outline-none border-x border-res-gray/60', 'qty' ), $product ),
                        )
                    );
                    ?>

                    <button
                      type="button"
                      class="res-qty-plus w-11 h-11 grid place-items-center text-res-text/70 hover:bg-neutral-50 active:scale-[.98] transition"
                      aria-label="Sumar"
                    >
                      +
                    </button>
                  </div>
                </div>

                <div class="grid gap-3">
                  <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button w-full inline-flex items-center justify-center gap-3 rounded-xl bg-res-green px-5 py-3.5 text-white font-extrabold tracking-wide shadow-soft hover:brightness-95 active:scale-[.99] transition">
                    <span class="inline-flex items-center justify-center w-6 h-6">
                      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carro-de-la-compra.svg" alt="" class="w-5 h-5 filter brightness-0 invert" />
                    </span>
                    Agregar al carrito
                  </button>
                    
                  <!-- WhatsApp Link (Placeholder for now) -->
                  <a href="https://wa.me/595XXXXXXXXX" target="_blank" rel="noopener" class="res-whatsapp" aria-label="Consultar por WhatsApp">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/whatsapp.svg" alt="WhatsApp" class="res-whatsapp__icon" />
                    <span class="res-whatsapp__text">Consultar producto por WhatsApp</span>
                  </a>
                </div>

              </form>
            <?php endif; ?>
          </div>

          <!-- Share -->
          <div class="mt-6 flex items-center justify-between flex-wrap gap-3">
            <span class="text-sm font-semibold text-neutral-700">Compartir:</span>

            <div class="flex items-center gap-2">
              <a href="#" class="w-10 h-10 rounded-xl border border-res-gray/60 bg-white grid place-items-center hover:border-res-green/60 hover:bg-res-green/5 transition" aria-label="Compartir en Facebook">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/facebook.svg" alt="" class="w-5 h-5 opacity-70" />
              </a>
              <a href="#" class="w-10 h-10 rounded-xl border border-res-gray/60 bg-white grid place-items-center hover:border-res-green/60 hover:bg-res-green/5 transition" aria-label="Compartir en Instagram">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/instagram.svg" alt="" class="w-5 h-5 opacity-70" />
              </a>
              <a href="#" class="w-10 h-10 rounded-xl border border-res-gray/60 bg-white grid place-items-center hover:border-res-green/60 hover:bg-res-green/5 transition" aria-label="Compartir por WhatsApp">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/whatsapp.svg" alt="" class="w-5 h-5 opacity-70" />
              </a>
            </div>
          </div>

          <!-- Nota de confianza (UX) -->
          <div class="mt-6 rounded-xl border border-res-gray/50 bg-neutral-50 p-4">
            <p class="text-sm text-res-text leading-relaxed">
              <strong class="text-neutral-800">Respaldo Resplandor:</strong> productos de uso diario con calidad local y stock disponible.
              ¿Necesitás compra por volumen? Escribinos por WhatsApp.
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- TABS DE DESCRIPCIÓN (Opcional, agregando el contenido de description si es muy largo) -->
    <?php if ( $product->get_description() ) : ?>
    <div class="mt-10 bg-white rounded-2xl shadow-soft border border-res-gray/40 p-6 sm:p-8">
      <h3 class="text-xl font-bold text-neutral-800 mb-4">Información del producto</h3>
      <div class="text-res-text prose max-w-none">
        <?php echo wp_kses_post( wpautop( $product->get_description() ) ); ?>
      </div>
    </div>
    <?php endif; ?>
    
  </div>
</section>

<!-- =========================
  PRODUCTOS RELACIONADOS (CARRUSEL)
========================= -->
<?php
$related_products = wc_get_related_products( $product->get_id(), 5 );

if ( ! empty( $related_products ) ) :
?>
<section class="bg-neutral-50 pt-12 mb-20">
  <div class="mx-auto max-w-7xl px-4">
    <header class="flex items-end justify-between gap-4 flex-wrap">
      <div>
        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-neutral-800">
          Productos relacionados
        </h2>
        <p class="mt-2 text-res-text">
          Productos que suelen comprarse junto a este artículo.
        </p>
      </div>

      <!-- Flechas -->
      <div class="flex items-center gap-2">
        <button class="res-carousel-arrow" type="button" aria-label="Anterior" data-carousel-prev>‹</button>
        <button class="res-carousel-arrow" type="button" aria-label="Siguiente" data-carousel-next>›</button>
      </div>
    </header>

    <!-- Carrusel -->
    <div class="mt-6" data-carousel="related">
      <div class="overflow-hidden rounded-2xl px-2 sm:px-4 py-8" data-carousel-viewport>
        <div class="flex gap-5 transition-transform duration-300 will-change-transform" data-carousel-track>

          <?php foreach ( $related_products as $related_product_id ) : ?>
            <?php
            $rel_product = wc_get_product( $related_product_id );
            if ( ! $rel_product ) continue;
            
            $rel_is_on_sale = $rel_product->is_on_sale();
            $rel_badge_text = $rel_is_on_sale ? 'Oferta' : ( $rel_product->is_featured() ? 'Destacado' : '' );
            $rel_badge_class = $rel_is_on_sale ? 'res-badge res-badge--sale' : 'res-badge';
            
            $rel_image_url = get_the_post_thumbnail_url( $rel_product->get_id(), 'woocommerce_thumbnail' );
            if ( ! $rel_image_url ) $rel_image_url = wc_placeholder_img_src();
            ?>
            <div class="shrink-0 w-[85%] sm:w-[48%] md:w-[31%] xl:w-[23%]">
              <article <?php wc_product_class( 'res-card', $rel_product ); ?>>
                <?php if ( $rel_badge_text ) : ?>
                  <span class="<?php echo esc_attr( $rel_badge_class ); ?>"><?php echo esc_html( $rel_badge_text ); ?></span>
                <?php endif; ?>

                <div class="res-card__media">
                  <a href="<?php echo esc_url( $rel_product->get_permalink() ); ?>" class="res-card__link">
                    <img src="<?php echo esc_url( $rel_image_url ); ?>" alt="<?php echo esc_attr( $rel_product->get_name() ); ?>" loading="lazy" decoding="async"/>
                  </a>
                </div>

                <div class="res-card__body">
                  <h3 class="res-card__name">
                      <a href="<?php echo esc_url( $rel_product->get_permalink() ); ?>" class="text-inherit hover:underline"><?php echo esc_html( $rel_product->get_name() ); ?></a>
                  </h3>

                  <div class="res-card__row">
                    <div class="res-price">
                      <?php
                      if ( $rel_is_on_sale && $rel_product->get_regular_price() ) {
                          echo '<span class="res-price__old">' . wc_price( $rel_product->get_regular_price() ) . '</span>';
                          echo '<span class="res-price__new">' . wc_price( $rel_product->get_sale_price() ) . '</span>';
                      } else {
                          echo '<span class="res-price__new">' . wp_kses_post( $rel_product->get_price_html() ) . '</span>';
                      }
                      ?>
                    </div>

                    <?php
                    $rel_cart_url = $rel_product->add_to_cart_url();
                    $rel_cart_classes = array(
                      'res-cart',
                      'button',
                      'product_type_' . $rel_product->get_type(),
                      $rel_product->is_purchasable() && $rel_product->is_in_stock() ? 'add_to_cart_button' : '',
                      $rel_product->supports( 'ajax_add_to_cart' ) && $rel_product->is_purchasable() && $rel_product->is_in_stock() ? 'ajax_add_to_cart' : '',
                    );
                    ?>
                    <a href="<?php echo esc_url( $rel_cart_url ); ?>"
                       data-quantity="1"
                       class="<?php echo esc_attr( implode( ' ', array_filter( $rel_cart_classes ) ) ); ?>"
                       data-product_id="<?php echo get_the_ID(); ?>"
                       data-product_sku="<?php echo esc_attr( $rel_product->get_sku() ); ?>"
                       aria-label="<?php echo esc_attr( $rel_product->add_to_cart_description() ); ?>"
                       rel="nofollow">
                      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
                    </a>
                  </div>
                </div>
              </article>
            </div>
          <?php endforeach; ?>

        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Thumbnails Click Behavior
    const thumbs = document.querySelectorAll('.res-thumb');
    const mainImage = document.getElementById('productMainImage');
    
    if (thumbs.length && mainImage) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Remove active class from all
                thumbs.forEach(t => t.classList.remove('is-active'));
                // Add active to clicked
                this.classList.add('is-active');
                
                // Update main image src
                const img = this.querySelector('img');
                const fullSrc = img.getAttribute('data-full-image') || img.src;
                
                // Simple fade effect
                mainImage.style.opacity = '0.5';
                setTimeout(() => {
                    mainImage.src = fullSrc;
                    mainImage.style.opacity = '1';
                }, 150);
            });
        });
    }

    // quantity input handlers
    const qtyMinus = document.querySelector('.res-qty-minus');
    const qtyPlus = document.querySelector('.res-qty-plus');
    const qtyInput = document.querySelector('.qty');

    if (qtyInput) {
        if (qtyMinus) {
            qtyMinus.addEventListener('click', function() {
                let current = parseFloat(qtyInput.value);
                let step = parseFloat(qtyInput.getAttribute('step')) || 1;
                let min = parseFloat(qtyInput.getAttribute('min')) || 1;
                if (current > min) {
                    qtyInput.value = current - step;
                }
            });
        }
        
        if (qtyPlus) {
            qtyPlus.addEventListener('click', function() {
                let current = parseFloat(qtyInput.value);
                let step = parseFloat(qtyInput.getAttribute('step')) || 1;
                let max = parseFloat(qtyInput.getAttribute('max')) || '';
                
                if (max && current >= max) {
                    return;
                }
                qtyInput.value = (current ? current : 0) + step;
            });
        }
    }
});
</script>

<?php
endwhile; // end of the loop.

get_footer();
