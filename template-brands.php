<?php
/**
 * Template Name: Todas las Marcas
 *
 * @package resplandor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
?>

<section class="bg-neutral-50 min-h-screen pb-20">
    <!-- Header / Breadcrumb -->
    <div class="relative overflow-hidden mb-12">
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
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            <?php
            $brand_terms = get_terms( array(
                'taxonomy'   => 'product_brand',
                'hide_empty' => true,
            ) );

            if ( ! empty( $brand_terms ) && ! is_wp_error( $brand_terms ) ) {
                foreach ( $brand_terms as $brand ) {
                    $thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
                    if ( $thumbnail_id ) {
                        $image_url = wp_get_attachment_image_url( $thumbnail_id, 'large' );
                    } else {
                        $image_url = wc_placeholder_img_src();
                    }
                    
                    $brand_link = get_term_link( $brand );
                    ?>
                    <div class="bg-white rounded-2xl border border-res-gray/40 shadow-soft p-6 hover:shadow-md transition-shadow group flex items-center justify-center">
                        <a href="<?php echo esc_url( $brand_link ); ?>" class="block w-full text-center" aria-label="<?php echo esc_attr( $brand->name ); ?>">
                            <div class="aspect-square flex items-center justify-center mb-4 overflow-hidden">
                                <img src="<?php echo esc_url( $image_url ); ?>" 
                                     alt="<?php echo esc_attr( $brand->name ); ?>" 
                                     class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300" 
                                     loading="lazy" />
                            </div>
                            <h3 class="text-sm font-bold text-neutral-800 group-hover:text-res-green transition-colors">
                                <?php echo esc_html( $brand->name ); ?>
                            </h3>
                            <p class="text-[10px] text-res-text mt-1">
                                <?php echo sprintf( _n( '%s producto', '%s productos', $brand->count, 'resplandor' ), $brand->count ); ?>
                            </p>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-span-full py-10 text-center"><p class="text-res-text">No se encontraron marcas por el momento.</p></div>';
            }
            ?>
        </div>
    </div>
</section>

<?php
get_footer();
