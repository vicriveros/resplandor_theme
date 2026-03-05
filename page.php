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
	
?>

<section class="bg-neutral-50" id="page-<?php the_ID(); ?>">
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
  <div class="mx-auto max-w-7xl px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
      <?php the_content(); ?>
    </div>
  </div>
</section>


<?php
endwhile; // end of the loop.

get_footer();
