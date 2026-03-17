<?php
/**
 * Template Name: Productos en Oferta
 *
 * @package resplandor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
?>

<section class="bg-neutral-50 min-h-screen">
    <!-- Header / Breadcrumb -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-res-green/95 via-res-green to-res-green/90"></div>
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_30%,white_0%,transparent_40%),radial-gradient(circle_at_85%_25%,white_0%,transparent_45%),radial-gradient(circle_at_60%_90%,white_0%,transparent_45%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                <?php the_title(); ?>
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
    <div class="mx-auto max-w-7xl px-4 py-12">
        <div class="res-grid">
            <?php
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            
            if ( ! empty( $product_ids_on_sale ) ) {
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'post__in'       => array_merge( array( 0 ), $product_ids_on_sale ),
                );
                $sales_query = new WP_Query( $args );

                if ( $sales_query->have_posts() ) :
                    while ( $sales_query->have_posts() ) : $sales_query->the_post();
                        global $product;
                        
                        $is_on_sale = $product->is_on_sale();
                        $badge_text = $is_on_sale ? 'Oferta' : '';
                        $badge_class = 'res-badge res-badge--sale';
                        
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
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" loading="lazy" />
                                </a>
                            </div>

                            <div class="res-card__body">
                                <h3 class="res-card__name"><?php echo esc_html( $product->get_name() ); ?></h3>

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
                    echo '<div class="col-span-full py-10 text-center"><p class="text-res-text">No hay productos en oferta en este momento.</p></div>';
                endif;
            } else {
                echo '<div class="col-span-full py-10 text-center"><p class="text-res-text">No hay productos en oferta en este momento.</p></div>';
            }
            ?>
        </div>
    </div>
</section>

<?php
get_footer();
