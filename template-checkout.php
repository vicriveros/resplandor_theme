<?php
/**
 * Template Name: Checkout Resplandor
 *
 * @package resplandor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

// If checkout is not enabled or cart is empty, redirect
if ( WC()->cart->is_empty() ) {
    ?>
    <section class="bg-neutral-50 min-h-screen py-20">
        <div class="mx-auto max-w-7xl px-4 text-center">
            <h2 class="text-2xl font-bold text-neutral-800 mb-4">¡Gracias por tu compra!</h2>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center justify-center rounded-xl bg-res-green px-8 py-3.5 text-white font-extrabold shadow-soft hover:brightness-95 transition">
                Volver a la tienda
            </a>
        </div>
    </section>
    <?php
    get_footer();
    exit;
}
?>

<section class="bg-neutral-50 min-h-screen pb-20">
    <!-- Header / Breadcrumb -->
    <div class="relative overflow-hidden mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-res-green/95 via-res-green to-res-green/90"></div>
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_30%,white_0%,transparent_40%),radial-gradient(circle_at_85%_25%,white_0%,transparent_45%),radial-gradient(circle_at_60%_90%,white_0%,transparent_45%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-12">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                Finalizar Compra
            </h1>
            <nav class="mt-3 text-sm text-white/85">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:underline">Inicio</a></li>
                    <li class="text-white/60">›</li>
                    <li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="hover:underline">Carrito</a></li>
                    <li class="text-white/60">›</li>
                    <li>Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4">
        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Formulario de Datos -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 p-6 md:p-8">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-res-green text-white flex items-center justify-center text-sm">1</span>
                            Tus Datos de Entrega
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nombre completo (Billing First Name) -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="billing_first_name" class="block text-sm font-semibold text-neutral-700 mb-2">Nombre Completo *</label>
                                <input type="text" name="billing_first_name" id="billing_first_name" placeholder="Ej: Juan Pérez" class="w-full px-4 py-3 rounded-xl border border-res-gray/60 focus:border-res-green focus:ring-1 focus:ring-res-green outline-none transition" required value="<?php echo esc_attr( WC()->checkout->get_value( 'billing_first_name' ) ); ?>">
                            </div>

                            <!-- Teléfono (Billing Phone) -->
                            <div class="col-span-1">
                                <label for="billing_phone" class="block text-sm font-semibold text-neutral-700 mb-2">Número de Teléfono *</label>
                                <input type="tel" name="billing_phone" id="billing_phone" placeholder="Ej: 0981 123456" class="w-full px-4 py-3 rounded-xl border border-res-gray/60 focus:border-res-green focus:ring-1 focus:ring-res-green outline-none transition" required value="<?php echo esc_attr( WC()->checkout->get_value( 'billing_phone' ) ); ?>">
                            </div>

                            <!-- Dirección (Billing Address 1) -->
                            <div class="col-span-1 md:col-span-2">
                                <label for="billing_address_1" class="block text-sm font-semibold text-neutral-700 mb-2">Dirección de Entrega *</label>
                                <input type="text" name="billing_address_1" id="billing_address_1" placeholder="Calle, número, barrio o ciudad" class="w-full px-4 py-3 rounded-xl border border-res-gray/60 focus:border-res-green focus:ring-1 focus:ring-res-green outline-none transition" required value="<?php echo esc_attr( WC()->checkout->get_value( 'billing_address_1' ) ); ?>">
                            </div>

                            <!-- Nota adicional (Opcional - Order Comments) -->
                            <div class="col-span-1 md:col-span-2 mt-2">
                                <label for="order_comments" class="block text-sm font-semibold text-neutral-700 mb-2">Instrucciones adicionales (Opcional)</label>
                                <textarea name="order_comments" id="order_comments" rows="3" placeholder="Referencias de la casa, horario de entrega, etc." class="w-full px-4 py-3 rounded-xl border border-res-gray/60 focus:border-res-green focus:ring-1 focus:ring-res-green outline-none transition"><?php echo esc_textarea( WC()->checkout->get_value( 'order_comments' ) ); ?></textarea>
                            </div>
                        </div>

                        <!-- Campos ocultos requeridos por WooCommerce para que el proceso no falle -->
                        <input type="hidden" name="billing_country" value="PY"> <!-- Paraguay por defecto -->
                        <input type="hidden" name="billing_last_name" value="-">
                        <input type="hidden" name="billing_email" value="cliente@resplandor.com.py"> <!-- Email placeholder -->
                        
                        <!-- Nuevos campos ocultos requeridos -->
                        <input type="hidden" name="billing_city" value="Asunción">
                        <input type="hidden" name="billing_state" value="Asunción">
                        <input type="hidden" name="billing_postcode" value="1001">
                        
                        <!-- Método de pago por defecto (Contra reembolso / COD) -->
                        <input type="hidden" name="payment_method" value="cod">

                        <?php
                        // Intentar obtener el primer método de envío disponible para evitar el error "No se ha seleccionado método de envío"
                        $packages = WC()->shipping()->get_packages();
                        foreach ( $packages as $i => $package ) {
                            $available_methods = $package['rates'];
                            if ( ! empty( $available_methods ) ) {
                                $first_method = current( $available_methods );
                                echo '<input type="hidden" name="shipping_method[' . $i . ']" value="' . esc_attr( $first_method->get_id() ) . '" />';
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Resumen y Acción -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-soft border border-res-gray/40 p-6 sticky top-28">
                        <h2 class="text-xl font-bold text-neutral-800 mb-6 pb-4 border-b border-res-gray/30">
                            Resumen de tu pedido
                        </h2>

                        <!-- Lista de items simplificada -->
                        <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                            <?php
                            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                $_product = $cart_item['data'];
                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
                                    ?>
                                    <div class="flex justify-between gap-4 text-sm">
                                        <span class="text-res-text flex-1">
                                            <strong class="text-neutral-800"><?php echo esc_html( $_product->get_name() ); ?></strong> 
                                            <span class="text-xs ml-1">x<?php echo $cart_item['quantity']; ?></span>
                                        </span>
                                        <span class="font-bold text-neutral-800">
                                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                        </span>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="space-y-4 mb-8 pt-4 border-t border-res-gray/30">
                            <div class="flex justify-between items-center text-res-text font-medium">
                                <span>Subtotal</span>
                                <span class="text-neutral-800"><?php wc_cart_totals_subtotal_html(); ?></span>
                            </div>
                            
                            <div class="pt-4 flex justify-between items-center text-res-green">
                                <span class="font-extrabold text-lg">Total</span>
                                <span class="font-extrabold text-2xl"><?php wc_cart_totals_order_total_html(); ?></span>
                            </div>
                        </div>

                        <button type="submit" name="woocommerce_checkout_place_order" id="place_order" value="Hacer Pedido" class="w-full inline-flex items-center justify-center rounded-xl bg-res-green px-5 py-4 text-white font-extrabold tracking-wide shadow-soft hover:brightness-95 active:scale-[.99] transition mb-4">
                            Hacer Pedido
                        </button>

                        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>

                        <div class="text-[10px] text-res-text/50 text-center leading-tight">
                            Al hacer pedido, aceptas nuestros términos y condiciones. Tu pedido será procesado y nos pondremos en contacto para la entrega.
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #ceced0;
    border-radius: 10px;
}
/* Estilos para los radio buttons de pago de WC */
.payment_methods input[type="radio"] {
    display: none;
}
.payment_methods label {
    display: block;
    padding: 1rem;
    border: 1px solid #ceced0;
    border-radius: 0.75rem;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.875rem;
    color: #555555;
    transition: all 0.2s;
}
.payment_methods input[type="radio"]:checked + label {
    border-color: #00a651;
    background-color: rgba(0, 166, 81, 0.05);
    color: #00a651;
}
.payment_box {
    padding: 0.75rem 1rem;
    font-size: 0.8125rem;
    color: #555555;
    background: #f9f9f9;
    border-radius: 0 0 0.75rem 0.75rem;
    margin-top: -0.5rem;
    border: 1px solid #ceced0;
    border-top: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.querySelector('form.checkout');
    const placeOrderBtn = document.getElementById('place_order');
    
    // Configuración de WhatsApp (Cambiar este número al del negocio)
    const whatsappNumber = '595961618105'; 

    if (placeOrderBtn && checkoutForm) {
        placeOrderBtn.addEventListener('click', function(e) {
            // Solo disparamos WhatsApp si el formulario es válido (campos requeridos llenos)
            if (checkoutForm.checkValidity()) {
                const name = document.getElementById('billing_first_name').value;
                const phone = document.getElementById('billing_phone').value;
                const address = document.getElementById('billing_address_1').value;
                const total = '<?php echo strip_tags(WC()->cart->get_total()); ?>';
                
                let itemsList = '';
                <?php
                foreach ( WC()->cart->get_cart() as $cart_item ) {
                    $_product = $cart_item['data'];
                    echo "itemsList += '- " . esc_js( $_product->get_name() ) . " x" . $cart_item['quantity'] . "\\n';";
                }
                ?>

                const message = `*Nuevo Pedido - Resplandor*\n\n` +
                                `*Nombre:* ${name}\n` +
                                `*Teléfono:* ${phone}\n` +
                                `*Dirección:* ${address}\n\n` +
                                `*Resumen del pedido:*\n${itemsList}\n` +
                                `*Total:* ${total}\n\n` +
                                `Hola, acabo de realizar mi pedido en la web y me gustaría coordinar la entrega.`;

                const waUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
                
                // Abrimos WhatsApp en una nueva pestaña
                window.open(waUrl, '_blank');
            }
        });
    }
});
</script>

<?php
get_footer();
