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

      <!-- Card -->
      <article class="res-card">
        <!-- Badge -->
        <span class="res-badge res-badge--sale">Oferta</span>

        <!-- Imagen clickeable -->
        <div class="res-card__media">
          <a href="producto_detalle.html" class="res-card__link">
            <img
              src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/limpiador_desengrasante_resplandor.png"
              alt="Limpiador Desengrasante Resplandor"
            />
          </a>
        </div>

        <div class="res-card__body">
          <h3 class="res-card__name">Limpiador Desengrasante</h3>

          <div class="res-card__row">
            <div class="res-price">
              <span class="res-price__old">Gs. 18.500</span>
              <span class="res-price__new">Gs. 14.500</span>
            </div>

            <button class="res-cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
            </button>
          </div>
        </div>
      </article>

      <!-- Card -->
      <article class="res-card">
        <span class="res-badge">Destacado</span>

        <!-- Imagen clickeable -->
        <div class="res-card__media">
          <a href="producto_detalle.html" class="res-card__link">
            <img
              src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/limpia_vidrios_resplandor.png"
              alt="Limpia Vidrios Resplandor"
            />
          </a>
        </div>

        <div class="res-card__body">
          <h3 class="res-card__name">Limpia Vidrios</h3>

          <div class="res-card__row">
            <div class="res-price">
              <span class="res-price__old">Gs. 16.500</span>
              <span class="res-price__new">Gs. 15.000</span>
            </div>

            <button class="res-cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
            </button>
          </div>
        </div>
      </article>

      <!-- Card -->
      <article class="res-card">
        <span class="res-badge res-badge--sale">Oferta</span>

        <!-- Imagen clickeable -->
        <div class="res-card__media">
          <a href="producto_detalle.html" class="res-card__link">
            <img
              src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/detergente_frutilla_resplandor.png"
              alt="Detergente Resplandor"
            />
          </a>
        </div>
        <div class="res-card__body">
          <h3 class="res-card__name">Detergente Resplandor 500ml</h3>

          <div class="res-card__row">
            <div class="res-price">
              <span class="res-price__old">Gs. 6.500</span>
              <span class="res-price__new">Gs. 5.000</span>
            </div>

            <button class="res-cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
            </button>
          </div>
        </div>
      </article>

      <!-- Card -->
      <article class="res-card">
        <span class="res-badge res-badge--sale">Oferta</span>

        <div class="res-card__media">
          <a href="producto_detalle.html" class="res-card__link">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/jabon_de_coco_puro_resplandor.png" alt="Jabón de Coco" />
          </a>
        </div>

        <div class="res-card__body">
          <h3 class="res-card__name">Jabón de Coco Puro</h3>

          <div class="res-card__row">
            <div class="res-price">
              <span class="res-price__old">Gs. 6.000</span>
              <span class="res-price__new">Gs. 4.900</span>
            </div>

            <button class="res-cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
            </button>
          </div>
        </div>
      </article>

      <!-- Card -->
      <article class="res-card">
        <span class="res-badge">Destacado</span>

        <div class="res-card__media">
          <a href="producto_detalle.html" class="res-card__link">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/desodorante_de_ambiente_uva_resplandor.png" alt="Desodorante de Ambiente" />
          </a>
        </div>

        <div class="res-card__body">
          <h3 class="res-card__name">Desodorante de Ambiente UVA 1L</h3>

          <div class="res-card__row">
            <div class="res-price">
              <span class="res-price__old">Gs. 9.500</span>
              <span class="res-price__new">Gs. 8.500</span>
            </div>

            <button class="res-cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" class="res-cart__icon" alt="" />
            </button>
          </div>
        </div>
      </article>

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
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_resplandor.png" alt="Resplandor" />
          </div>
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_monarca.png" alt="Monarca" />
          </div>
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_megabril.png" alt="Megabril" />
          </div>
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_clorimax.png" alt="Clorimax" />
          </div>
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_bang.png" alt="Bang" />
          </div>
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_guari.png" alt="Guari" />
          </div>
          <div class="res-partners__item">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/marca_karam.png" alt="Karam" />
          </div>
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
      <!-- Card -->
      <article class="res-fcard">
        <!-- Media -->
        <div class="res-fcard__media">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/portada_limpiavidrios_resplandor.png" alt="Limpiavidrios Resplandor">
          <span class="res-fcard__badge">Uso diario</span>
        </div>

        <!-- Body -->
        <div class="res-fcard__body">
          <div class="res-fcard__top">
            <h3 class="res-fcard__name">Limpiavidrios</h3>
          </div>

          <p class="res-fcard__desc">
            Limpieza efectiva con brillo sin marcas. Secado rápido para vidrios, espejos y vitrinas.
          </p>

          <div class="res-fcard__meta">
            <span class="res-fcard__price">Gs. 15.000</span>
          </div>

          <!-- ACCIONES -->
          <div class="res-fcard__actions">
            <!-- BOTÓN VER DETALLE (YA ESTILADO EN web.css) -->
            <a href="producto_detalle.html" class="res-fcard__cta">
              Ver detalle
            </a>

            <!-- BOTÓN CARRITO -->
            <button class="res-fcard__cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" alt="">
            </button>
          </div>
        </div>
      </article>

      <!-- Card -->
      <article class="res-fcard">
        <!-- Media -->
        <div class="res-fcard__media">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/portada_desodorande_pisos_resplandor.png" alt="Desodorante de Ambiente">
          <span class="res-fcard__badge">Uso diario</span>
        </div>

        <!-- Body -->
        <div class="res-fcard__body">
          <div class="res-fcard__top">
            <h3 class="res-fcard__name">Desodorante de Ambiente UVA 1L</h3>
          </div>

          <p class="res-fcard__desc">
            Neutraliza olores y deja un aroma agradable y duradero. Ideal para ambientes y superficies de alto tránsito.
          </p>

          <div class="res-fcard__meta">
            <span class="res-fcard__price">Gs. 8.500</span>
          </div>

          <!-- ACCIONES -->
          <div class="res-fcard__actions">
            <!-- BOTÓN VER DETALLE (YA ESTILADO EN web.css) -->
            <a href="producto_detalle.html" class="res-fcard__cta">
              Ver detalle
            </a>

            <!-- BOTÓN CARRITO -->
            <button class="res-fcard__cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" alt="">
            </button>
          </div>
        </div>
      </article>

      <!-- Card -->
      <article class="res-fcard">
        <!-- Media -->
        <div class="res-fcard__media">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/portada_detergente_resplandor.png" alt="Detergente Resplandor">
          <span class="res-fcard__badge">Uso diario</span>
        </div>

        <!-- Body -->
        <div class="res-fcard__body">
          <div class="res-fcard__top">
            <h3 class="res-fcard__name">Detergente Resplandor 500ml</h3>
          </div>

          <p class="res-fcard__desc">
            Fórmula concentrada para el lavado diario. Remueve grasa y suciedad con eficacia, cuidando tus utensilios.
          </p>

          <div class="res-fcard__meta">
            <span class="res-fcard__price">Gs. 5.000</span>
          </div>

          <!-- ACCIONES -->
          <div class="res-fcard__actions">
            <!-- BOTÓN VER DETALLE (YA ESTILADO EN web.css) -->
            <a href="producto_detalle.html" class="res-fcard__cta">
              Ver detalle
            </a>

            <!-- BOTÓN CARRITO -->
            <button class="res-fcard__cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" alt="">
            </button>
          </div>
        </div>
      </article>


      <!-- Card -->
      <article class="res-fcard">
        <!-- Media -->
        <div class="res-fcard__media">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/portada_aromatizante_resplandor.png" alt="Aromatizador de Ambientes">
          <span class="res-fcard__badge">Uso diario</span>
        </div>

        <!-- Body -->
        <div class="res-fcard__body">
          <div class="res-fcard__top">
            <h3 class="res-fcard__name">Aromatizador de Ambientes Menta y Limon</h3>
          </div>

          <p class="res-fcard__desc">
            Fragancia fresca y revitalizante que perfuma y renueva el ambiente. Uso doméstico e institucional.
          </p>

          <div class="res-fcard__meta">
            <span class="res-fcard__price">Gs. 14.500</span>
          </div>

          <!-- ACCIONES -->
          <div class="res-fcard__actions">
            <!-- BOTÓN VER DETALLE (YA ESTILADO EN web.css) -->
            <a href="producto_detalle.html" class="res-fcard__cta">
              Ver detalle
            </a>

            <!-- BOTÓN CARRITO -->
            <button class="res-fcard__cart" aria-label="Agregar al carrito">
              <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/carrito-de-compras.svg" alt="">
            </button>
          </div>
        </div>
      </article>      

    </div>
  </div>
</section>

<?php
get_footer();
