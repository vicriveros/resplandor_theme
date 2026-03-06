<?php
/**
 * Template Name: Carrito Resplandor
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
    <div class="relative overflow-hidden mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-res-green/95 via-res-green to-res-green/90"></div>
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_30%,white_0%,transparent_40%),radial-gradient(circle_at_85%_25%,white_0%,transparent_45%),radial-gradient(circle_at_60%_90%,white_0%,transparent_45%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                Tu Carrito
            </h1>
            <nav class="mt-3 text-sm text-white/85">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:underline">Inicio</a></li>
                    <li class="text-white/60">›</li>
                    <li>Carrito</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4">
        <?php if ( WC()->cart->is_empty() ) : ?>
            <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 p-10 text-center">
                <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full bg-res-green/10 text-res-green">
                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carro-de-la-compra.svg" alt="" class="w-10 h-10" />
                </div>
                <h2 class="text-2xl font-bold text-neutral-800 mb-4">Tu carrito está vacío</h2>
                <p class="text-res-text mb-8">Parece que aún no has añadido ningún producto.</p>
                <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="inline-flex items-center justify-center rounded-xl bg-res-green px-8 py-3.5 text-white font-extrabold tracking-wide shadow-soft hover:brightness-95 transition">
                    Ir a la tienda
                </a>
            </div>
        <?php else : ?>
            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Lista de Productos -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 overflow-hidden">
                            <div class="hidden md:grid grid-cols-6 gap-4 p-4 border-b border-res-gray/40 bg-neutral-50 text-xs font-bold text-res-text uppercase tracking-wider">
                                <div class="col-span-3">Producto</div>
                                <div class="text-center">Precio</div>
                                <div class="text-center">Cantidad</div>
                                <div class="text-right">Subtotal</div>
                            </div>

                            <div class="divide-y divide-res-gray/30">
                                <?php
                                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                        ?>
                                        <div class="p-4 md:p-6 grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
                                            <!-- Producto Info -->
                                            <div class="md:col-span-3 flex items-center gap-4">
                                                <div class="w-20 h-20 shrink-0 rounded-xl border border-res-gray/40 p-2 bg-white flex items-center justify-center">
                                                    <?php
                                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                                    if ( ! $product_permalink ) {
                                                        echo $thumbnail;
                                                    } else {
                                                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                                    }
                                                    ?>
                                                </div>
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-neutral-800 leading-tight mb-1">
                                                        <?php
                                                        if ( ! $product_permalink ) {
                                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                                        } else {
                                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="hover:text-res-green transition">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                                        }
                                                        ?>
                                                    </h3>
                                                    <div class="text-xs text-res-text/70 uppercase font-medium">
                                                        <?php
                                                        $brands = wp_get_post_terms( $product_id, 'product_brand', array('fields' => 'names') );
                                                        if ( ! empty( $brands ) ) {
                                                            echo esc_html( reset( $brands ) );
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="md:hidden mt-2 flex items-center justify-between">
                                                        <span class="text-res-green font-bold"><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Precio (Desktop) -->
                                            <div class="hidden md:block text-center font-semibold text-neutral-700">
                                                <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                                            </div>

                                            <!-- Cantidad -->
                                            <div class="flex flex-col items-center gap-2">
                                                <div class="flex items-center rounded-xl border border-res-gray/60 bg-white overflow-hidden h-10 w-32">
                                                    <button type="button" class="cart-qty-minus w-8 h-full flex items-center justify-center text-res-text hover:bg-neutral-50 transition border-r border-res-gray/30">–</button>
                                                    <?php
                                                    if ( $_product->is_sold_individually() ) {
                                                        $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                                    } else {
                                                        $product_quantity = woocommerce_quantity_input(
                                                            array(
                                                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                                                'input_value'  => $cart_item['quantity'],
                                                                'max_value'    => $_product->get_max_purchase_quantity(),
                                                                'min_value'    => '0',
                                                                'product_name' => $_product->get_name(),
                                                                'classes'      => array( 'w-16 h-full text-center text-sm font-bold text-neutral-800 outline-none qty' ),
                                                            ),
                                                            $_product,
                                                            false
                                                        );
                                                    }
                                                    echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                                    ?>
                                                    <button type="button" class="cart-qty-plus w-8 h-full flex items-center justify-center text-res-text hover:bg-neutral-50 transition border-l border-res-gray/30">+</button>
                                                </div>
                                                <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="text-[11px] font-bold text-red-500 uppercase tracking-wider hover:underline" title="Eliminar Item">Eliminar Item</a>
                                            </div>

                                            <!-- Subtotal -->
                                            <div class="text-right font-bold text-neutral-800">
                                                <span class="md:hidden text-xs text-res-text/50 font-normal block">Total: </span>
                                                <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="p-4 bg-neutral-50 flex items-center justify-between border-t border-res-gray/40">
                                <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="text-sm font-bold text-res-green hover:underline">
                                    ← Seguir comprando
                                </a>
                                <button type="submit" name="update_cart" value="Actualizar carrito" class="text-sm font-bold bg-white border border-res-gray/60 px-4 py-2 rounded-lg hover:bg-neutral-100 transition">
                                    Actualizar carrito
                                </button>
                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen del Pedido -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 p-6 sticky top-28">
                            <h2 class="text-xl font-bold text-neutral-800 mb-6 pb-4 border-b border-res-gray/30">
                                Resumen del pedido
                            </h2>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center text-res-text font-medium">
                                    <span>Subtotal</span>
                                    <span class="text-neutral-800"><?php wc_cart_totals_subtotal_html(); ?></span>
                                </div>
                                <div class="flex justify-between items-center text-res-text font-medium">
                                    <span>Envío</span>
                                    <span class="text-xs text-res-text/70 italic text-right">Calculado al confirmar</span>
                                </div>
                                
                                <div class="pt-4 border-t border-res-gray/30 flex justify-between items-center text-res-green">
                                    <span class="font-extrabold text-lg">Total del pedido</span>
                                    <span class="font-extrabold text-2xl"><?php wc_cart_totals_order_total_html(); ?></span>
                                </div>
                            </div>

                            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="w-full inline-flex items-center justify-center rounded-xl bg-res-green px-5 py-4 text-white font-extrabold tracking-wide shadow-soft hover:brightness-95 active:scale-[.99] transition mb-4">
                                Confirmar Pedido
                            </a>

                            <div class="flex items-center justify-center gap-2 text-xs text-res-text/60 font-medium uppercase">
                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/bala.svg" alt="" class="w-3 h-3 opacity-50" />
                                Compra segura y respaldo local
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<style>
/* Ocultar flechas de input number */
.qty::-webkit-outer-spin-button,
.qty::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.qty {
    -moz-appearance: textfield;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de cantidades en carrito
    const plusBtns = document.querySelectorAll('.cart-qty-plus');
    const minusBtns = document.querySelectorAll('.cart-qty-minus');
    const qtyInputs = document.querySelectorAll('.qty');

    plusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty');
            if (input) {
                let currentVal = parseInt(input.value);
                let maxVal = parseInt(input.getAttribute('max')) || Infinity;
                if (currentVal < maxVal) {
                    input.value = currentVal + 1;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    });

    minusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty');
            if (input) {
                let currentVal = parseInt(input.value);
                let minVal = parseInt(input.getAttribute('min')) || 0;
                if (currentVal > minVal) {
                    input.value = currentVal - 1;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    });

    // Opcional: Asegurar que el botón de actualizar no se deshabilite por scripts externos
    const updateBtn = document.querySelector('button[name="update_cart"]');
    if (updateBtn) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'disabled') {
                    if (updateBtn.disabled) {
                        updateBtn.disabled = false;
                    }
                }
            });
        });
        observer.observe(updateBtn, { attributes: true });
    }
});
</script>

<?php
get_footer();
