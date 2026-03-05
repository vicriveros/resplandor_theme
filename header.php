<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/favicon.png">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Tailwind Config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            res: {
              green: "#00a651",
              gray: "#ceced0",
              text: "#555555"
            }
          },
          boxShadow: {
            soft: "0 8px 24px rgba(0,0,0,.08)"
          }
        }
      }
    }
  </script>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- NAVBAR -->
  <header id="res-navbar" class="fixed top-0 left-0 right-0 z-50 bg-white">
    <!-- TOPBAR -->
    <div data-topbar class="nav-ease bg-res-green text-white">
      <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-center justify-between py-2 text-sm">
          <span class="font-medium">Obtené un 10% de descuento en tu primera compra!</span>
          <nav class="hidden md:flex gap-8 font-medium">
            <a href="<?php echo esc_url( get_template_directory_uri() ); ?>/catalogo_resplandor.pdf" target="_blank">Catálogos</a>
            <a href="faq.html">FAQ</a>
            <a href="contactos.html">Contactos</a>
          </nav>
        </div>
      </div>
    </div>

    <!-- MAIN BAR (RESPONSIVE) -->
<!-- MAIN BAR -->
<div class="border-b border-res-gray/60">
  <div class="mx-auto max-w-7xl px-4">
    <div id="mainbar" class="nav-ease py-3 lg:py-4">

      <!-- MOBILE -->
      <div class="mobile-topbar lg:hidden">
        <!-- Menú -->
      <button
        id="menuToggleDesk"
        data-drawer-open
        class="icon-btn"
        type="button"
        aria-label="Menú"
        aria-controls="sideDrawer"
        aria-expanded="false"
      >
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/red.svg" alt="Menú" class="icon-svg" />
      </button>

        <!-- Logo centrado -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-logo" aria-label="Inicio">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo_resplandor.png" alt="Grupo Resplandor" class="logo-resplandor" />
        </a>

        <!-- Acciones -->
        <div class="mobile-actions">
          <!-- Buscar -->
          <button id="searchToggle" class="icon-btn" type="button" aria-label="Buscar">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/buscar.svg" alt="" aria-hidden="true" class="icon-svg" />
          </button>

          <!-- Carrito -->
          <button class="icon-btn cart-btn" type="button" aria-label="Carrito">
            <span class="cart-badge cart-count-dynamic"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carro-de-la-compra.svg" alt="Carrito" class="icon-svg" />
          </button>
        </div>
      </div>

      <!-- MOBILE: buscador desplegable (solo cuando se activa) -->
      <div id="mobileSearch" class="mobile-search lg:hidden" hidden>
        <form role="search" method="get" class="search-form w-full" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <input
            type="search"
            name="s"
            value="<?php echo get_search_query(); ?>"
            placeholder="Buscá tu producto aquí…"
            class="search-input w-full px-5 py-3 text-res-text placeholder:text-res-text/50"
          />
          <input type="hidden" name="post_type" value="product" />
        </form>
      </div>

      <!-- DESKTOP: fila normal (logo - buscador - botones) -->
      <div class="hidden lg:flex lg:items-center lg:gap-4">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 shrink-0">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo_resplandor.png" alt="Grupo Resplandor" class="logo-resplandor" />
        </a>

        <div class="flex justify-center flex-1">
          <div class="w-full max-w-[1000px]">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <input
                type="search"
                name="s"
                value="<?php echo get_search_query(); ?>"
                placeholder="Buscá tu producto aquí…"
                class="search-input w-full px-6 py-3 text-res-text placeholder:text-res-text/50"
              />
              <input type="hidden" name="post_type" value="product" />
            </form>
          </div>
        </div>

        <div class="flex items-center gap-5 shrink-0">
          <button
            id="menuToggleDesktop"
            class="icon-btn"
            type="button"
            aria-label="Menú"
            aria-controls="sideDrawer"
            aria-expanded="false"
            data-drawer-open
          >
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/red.svg" alt="Menú" class="icon-svg" />
          </button>

          <a class="icon-btn cart-btn" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="Carrito">
            <span class="cart-badge cart-count-dynamic"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carro-de-la-compra.svg" alt="Carrito" class="icon-svg" />
          </a>
        </div>
      </div>

    </div>
  </div>
</div>


    <!-- MENÚ HORIZONTAL (DESKTOP) -->
    <div data-menubar class="border-b border-res-gray/60 hidden lg:block">
      <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-center justify-between py-4">
          <?php if ( has_nav_menu( 'menu-1' ) ) : ?>
            <?php
            wp_nav_menu( array(
                'theme_location'  => 'menu-1',
                'container'       => 'nav',
                'container_class' => 'nav-main flex items-center gap-10 text-res-text font-medium',
                'items_wrap'      => '%3$s',
                'walker'          => new Resplandor_Nav_Walker(),
                'fallback_cb'     => false,
            ) );
            ?>
          <?php else : ?>
          <nav class="nav-main flex items-center gap-10 text-res-text font-medium">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a>
          </nav>
          <?php endif; ?>

          <div class="hidden xl:flex gap-10">
            <div>
              <strong>Llamanos</strong><br>(+595 21) 328 5079
            </div>
            <div>
              <strong>Escribinos</strong><br>info@resplandor.com.py
            </div>
          </div>

        </div>
      </div>
    </div>
  </header>

  <div id="nav-spacer" aria-hidden="true"></div>

  <!-- MENÚ VERTICAL -->
  <div id="drawerOverlay" class="drawer-overlay" hidden></div>

  <aside id="sideDrawer" class="drawer" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="drawer-header">
      <div class="drawer-header-center">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo_resplandor.png" alt="Grupo Resplandor" class="drawer-logo" />
      </div>

      <button id="drawerClose" class="drawer-close" type="button" aria-label="Cerrar menú">
        ✕
      </button>
    </div>

    <nav class="drawer-nav" aria-label="Menú principal">

<div class="drawer-mobile-only">
  <?php if ( has_nav_menu( 'menu-1' ) ) : ?>
    <?php
    wp_nav_menu( array(
        'theme_location'  => 'menu-1',
        'container'       => false,
        'items_wrap'      => '%3$s',
        'walker'          => new Resplandor_Mobile_No_Children_Walker(),
        'fallback_cb'     => false,
    ) );
    ?>
  <?php else : ?>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="drawer-link">
    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/bala.svg" class="drawer-icon" alt="" aria-hidden="true" />
    <span>Inicio</span>
  </a>

  <a href="marcas.html" class="drawer-link">
    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/bala.svg" class="drawer-icon" alt="" aria-hidden="true" />
    <span>Marcas</span>
  </a>

  <a href="nosotros.html" class="drawer-link">
    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/bala.svg" class="drawer-icon" alt="" aria-hidden="true" />
    <span>Sobre nosotros</span>
  </a>

  <a href="ofertas.html" class="drawer-link">
    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/bala.svg" class="drawer-icon" alt="" aria-hidden="true" />
    <span>Ofertas</span>
  </a>
  <?php endif; ?>

  <hr class="drawer-sep" />
</div>

      <a href="linea-hogar.html" class="drawer-link">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Hogar.svg" alt="" class="drawer-icon" />
        <span>Línea Hogar</span>
      </a>

      <a href="linea-prendas.html" class="drawer-link">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Prendas.svg" alt="" class="drawer-icon" />
        <span>Línea Prendas</span>
      </a>

      <a href="linea-desinfeccion.html" class="drawer-link">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Desinfeccion.svg" alt="" class="drawer-icon" />
        <span>Línea Desinfección</span>
      </a>

      <a href="linea-automotiva.html" class="drawer-link">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Automotiva.svg" alt="" class="drawer-icon" />
        <span>Línea Automotiva</span>
      </a>

      <a href="linea-piscinas.html" class="drawer-link">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Piscinas.svg" alt="" class="drawer-icon" />
        <span>Línea Piscinas</span>
      </a>

      <a href="linea-bazar.html" class="drawer-link">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Bazar.svg" alt="" class="drawer-icon" />
        <span>Línea Bazar</span>
      </a>
    </nav>

    <div class="drawer-footer">
      <p>
        © <span id="drawerYear"></span>
        <strong>Grupo Resplandor</strong><br>
        Todos los derechos reservados
      </p>
    </div>
  </aside>
