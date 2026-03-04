/* =========================================================
   RESPLANDOR - scripts.js (FIXED)
   - Scroll navbar: oculta topbar + menubar (desktop) y compacta mainbar
   - Drawer (menú lateral) multi-trigger (mobile + desktop)
   - Año automático footer drawer
   - Dropdown Categorías (click + ESC + click afuera)
   - Mobile search toggle (lupa)
========================================================= */

(() => {
  const onReady = (fn) => {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", fn, { once: true });
    } else {
      fn();
    }
  };

  onReady(() => {
    /* =========================
       1) NAVBAR SCROLL (DESKTOP)
    ========================= */
    (() => {
      const navbar = document.getElementById("res-navbar");
      const spacer = document.getElementById("nav-spacer");
      if (!navbar || !spacer) return;

      const topbar = navbar.querySelector("[data-topbar]");
      const menubar = navbar.querySelector("[data-menubar]");
      const mainbar = document.getElementById("mainbar");

      // Un poco más sensible
      const ENTER_SCROLL = 80;
      const EXIT_SCROLL = 40;

      let isScrolled = false;
      let ticking = false;

      const isDesktop = () => window.matchMedia("(min-width: 1024px)").matches;

      function setSpacerHeight() {
        const h = navbar.offsetHeight;
        spacer.style.height = `${h}px`;
        document.documentElement.style.setProperty("--nav-h", `${h}px`);
      }

      function setMenubarHidden(hidden) {
        if (!menubar) return;

        // Inline-style para ganarle a tailwind (hidden lg:block)
        menubar.style.display = hidden ? "none" : "";
      }

      function applyState(next) {
        if (next === isScrolled) return;
        isScrolled = next;

        // Topbar
        if (topbar) topbar.classList.toggle("hidden", isScrolled);

        // Menubar SOLO desktop
        if (menubar) {
          if (isDesktop()) setMenubarHidden(isScrolled);
          else setMenubarHidden(false);
        }

        // Compacta mainbar
        if (mainbar) {
          mainbar.classList.toggle("py-4", !isScrolled);
          mainbar.classList.toggle("py-3", isScrolled);
        }

        navbar.classList.toggle("shadow-soft", isScrolled);

        requestAnimationFrame(setSpacerHeight);
      }

      function update() {
        const y = window.scrollY || document.documentElement.scrollTop || 0;

        if (!isScrolled && y > ENTER_SCROLL) applyState(true);
        else if (isScrolled && y < EXIT_SCROLL) applyState(false);

        // Si cambia el breakpoint, re-aplica lógica
        if (menubar) {
          if (!isDesktop()) setMenubarHidden(false);
          else setMenubarHidden(isScrolled);
        }

        ticking = false;
      }

      function onScroll() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(update);
      }

      const ro = new ResizeObserver(() => setSpacerHeight());
      ro.observe(navbar);

      window.addEventListener("scroll", onScroll, { passive: true });
      window.addEventListener("resize", () => requestAnimationFrame(update), { passive: true });

      setSpacerHeight();
      update();
    })();

    /* =========================
       2) DRAWER (MENÚ LATERAL) - MULTI TRIGGER
    ========================= */
    (() => {
      const drawer = document.getElementById("sideDrawer");
      const overlay = document.getElementById("drawerOverlay");
      const closeBtn = document.getElementById("drawerClose");

      if (!drawer || !overlay || !closeBtn) return;

      // Dedupe triggers (por si un mismo elemento matchea varios selectores)
      const triggerNodes = [
        ...document.querySelectorAll('[data-drawer-open]'),
        ...document.querySelectorAll('[aria-controls="sideDrawer"]'),
      ];
      const triggers = Array.from(new Set(triggerNodes));

      if (triggers.length === 0) return;

      const setExpanded = (val) => {
        triggers.forEach((t) => t.setAttribute("aria-expanded", String(val)));
      };

      const open = (fromBtn) => {
        overlay.hidden = false;
        drawer.classList.add("is-open");
        drawer.setAttribute("aria-hidden", "false");
        document.body.classList.add("drawer-open");
        setExpanded(true);

        drawer.dataset.lastTrigger = fromBtn?.id || "";

        const firstFocusable = drawer.querySelector(
          "a, button, [tabindex]:not([tabindex='-1'])"
        );
        firstFocusable?.focus?.();
      };

      const close = () => {
        drawer.classList.remove("is-open");
        drawer.setAttribute("aria-hidden", "true");
        document.body.classList.remove("drawer-open");
        setExpanded(false);

        window.setTimeout(() => {
          overlay.hidden = true;
        }, 250);

        const lastId = drawer.dataset.lastTrigger;
        const lastBtn = lastId ? document.getElementById(lastId) : triggers[0];
        lastBtn?.focus?.();
      };

      triggers.forEach((btn) => {
        if (!btn.hasAttribute("aria-expanded")) btn.setAttribute("aria-expanded", "false");

        btn.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();

          const isOpen = drawer.classList.contains("is-open");
          isOpen ? close() : open(btn);
        });
      });

      closeBtn.addEventListener("click", (e) => {
        e.preventDefault();
        close();
      });

      overlay.addEventListener("click", close);

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && drawer.classList.contains("is-open")) close();
      });

      // Cerrar al hacer click en un link del drawer
      drawer.addEventListener("click", (e) => {
        const a = e.target.closest("a");
        if (a) close();
      });
    })();


// Footer link abre el menú lateral
(() => {
  const footerDrawerLinks = document.querySelectorAll('[data-open-drawer]');
  const drawerButton = document.querySelector('[data-drawer-open]');

  if (!drawerButton) return;

  footerDrawerLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      drawerButton.click(); // reutiliza la lógica existente
    });
  });
})();


    /* =========================
       3) AÑO FOOTER DRAWER
    ========================= */
    (() => {
      const yearEl = document.getElementById("drawerYear");
      if (yearEl) yearEl.textContent = new Date().getFullYear();
    })();

    /* =========================
       4) DROPDOWN CATEGORÍAS (CLICK)
    ========================= */
    (() => {
      const dd = document.querySelector(".nav-dropdown");
      if (!dd) return;

      const btn = dd.querySelector(".nav-link");
      const menu = dd.querySelector(".dropdown-menu");
      if (!btn || !menu) return;

      const close = () => {
        dd.classList.remove("is-open");
        btn.setAttribute("aria-expanded", "false");
      };

      btn.addEventListener("click", (e) => {
        e.preventDefault();
        const isOpen = dd.classList.toggle("is-open");
        btn.setAttribute("aria-expanded", String(isOpen));
      });

      document.addEventListener("click", (e) => {
        if (!dd.contains(e.target)) close();
      });

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") close();
      });
    })();

    /* =========================
       5) MOBILE SEARCH TOGGLE (LUPA)
    ========================= */
    (() => {
      const btn = document.getElementById("searchToggle");
      const box = document.getElementById("mobileSearch");
      if (!btn || !box) return;

      const input = box.querySelector("input");

      btn.addEventListener("click", (e) => {
        e.preventDefault();

        const isHidden = box.hasAttribute("hidden");
        if (isHidden) {
          box.removeAttribute("hidden");
          setTimeout(() => input?.focus(), 0);
        } else {
          box.setAttribute("hidden", "");
        }
      });

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") box.setAttribute("hidden", "");
      });
    })();
  });
})();





/* =========================================================
   HERO RESPONSIVE IMAGES (mobile/desktop backgrounds)
========================================================= */
(() => {
  const hero = document.querySelector(".res-hero");
  if (!hero) return;

  const slides = Array.from(hero.querySelectorAll(".res-hero__slide"));
  if (slides.length === 0) return;

  // Breakpoint: usá el mismo criterio que tu layout (Tailwind sm=640)
  const mq = window.matchMedia("(max-width: 640px)");

  const applyHeroBackgrounds = () => {
    const isMobile = mq.matches;

    slides.forEach((slide) => {
      const desktop = slide.getAttribute("data-bg-desktop");
      const mobile = slide.getAttribute("data-bg-mobile");

      // Elegimos la mejor disponible
      const src = (isMobile ? mobile : desktop) || desktop || mobile;
      if (!src) return;

      // Evita re-aplicar si ya está
      const current = slide.dataset.bgApplied;
      if (current === src) return;

      slide.style.backgroundImage = `url('${src}')`;
      slide.dataset.bgApplied = src;
    });
  };

  // Init + cambios de breakpoint
  applyHeroBackgrounds();

  // Safari/old: addListener fallback
  if (typeof mq.addEventListener === "function") {
    mq.addEventListener("change", applyHeroBackgrounds);
  } else if (typeof mq.addListener === "function") {
    mq.addListener(applyHeroBackgrounds);
  }

  // Por si el usuario rota pantalla / resize raro
  window.addEventListener("resize", () => applyHeroBackgrounds(), { passive: true });
})();




/* =========================================================
   HERO SLIDER (flechas + dots)
========================================================= */
(() => {
  const hero = document.querySelector(".res-hero");
  if (!hero) return;

  const track = hero.querySelector(".res-hero__track");
  const slides = Array.from(hero.querySelectorAll(".res-hero__slide"));
  const prevBtn = hero.querySelector(".res-hero__arrow--prev");
  const nextBtn = hero.querySelector(".res-hero__arrow--next");
  const dots = Array.from(hero.querySelectorAll(".res-hero__dot"));

  if (!track || slides.length === 0 || !prevBtn || !nextBtn) return;

  let index = 0;

  // Si ya tenés un slide con is-active, arrancamos desde ahí
  const initial = slides.findIndex(s => s.classList.contains("is-active"));
  if (initial >= 0) index = initial;

  function render() {
    // mover el track
    track.style.transform = `translateX(-${index * 100}%)`;

    // clases active
    slides.forEach((s, i) => s.classList.toggle("is-active", i === index));
    dots.forEach((d, i) => d.classList.toggle("is-active", i === index));
  }

  function goTo(i) {
    index = (i + slides.length) % slides.length;
    render();
  }

  nextBtn.addEventListener("click", () => goTo(index + 1));
  prevBtn.addEventListener("click", () => goTo(index - 1));

  // dots
  dots.forEach((dot, i) => dot.addEventListener("click", () => goTo(i)));

  // swipe (mobile)
  let startX = 0;
  let isDown = false;

  hero.addEventListener("pointerdown", (e) => {
    isDown = true;
    startX = e.clientX;
  });

  hero.addEventListener("pointerup", (e) => {
    if (!isDown) return;
    isDown = false;

    const dx = e.clientX - startX;
    if (Math.abs(dx) < 40) return; // umbral

    if (dx < 0) goTo(index + 1);
    else goTo(index - 1);
  });

  hero.addEventListener("pointercancel", () => (isDown = false));

  // evitar que al clickear el banner (es <a>) se vaya al # al hacer drag
  slides.forEach((s) =>
    s.addEventListener("click", (e) => {
      // si querés que sea clickeable a futuro, removemos esta línea
      e.preventDefault();
    })
  );

  // Auto-play (opcional)
  const AUTOPLAY_MS = 6000;
  let timer = setInterval(() => goTo(index + 1), AUTOPLAY_MS);

  // pausa al pasar el mouse
  hero.addEventListener("mouseenter", () => clearInterval(timer));
  hero.addEventListener("mouseleave", () => (timer = setInterval(() => goTo(index + 1), AUTOPLAY_MS)));

  // init
  render();
})();


  // CARRUSEL MARCAS 


(() => {
  const root = document.querySelector("[data-partners]");
  if (!root) return;

  const track = root.querySelector(".res-partners__track");
  const prev = root.querySelector(".res-partners__arrow--prev");
  const next = root.querySelector(".res-partners__arrow--next");
  const viewport = root.querySelector(".res-partners__viewport");
  const items = Array.from(root.querySelectorAll(".res-partners__item"));
  if (!track || !prev || !next || !viewport || items.length === 0) return;

  let index = 0;

  const gap = () => {
    const style = getComputedStyle(track);
    return parseFloat(style.columnGap || style.gap || "0") || 0;
  };

  const step = () => {
    const first = items[0];
    const rect = first.getBoundingClientRect();
    return rect.width + gap();
  };

  const maxIndex = () => {
    // cuántos “steps” podemos mover antes de quedar sin contenido
    const vp = viewport.getBoundingClientRect().width;
    const total = items.length * step();
    const max = Math.max(0, Math.ceil((total - vp) / step()));
    return max;
  };

  const clamp = (n, a, b) => Math.max(a, Math.min(b, n));

  const update = () => {
    index = clamp(index, 0, maxIndex());
    track.style.transform = `translateX(${-index * step()}px)`;
    prev.disabled = index === 0;
    next.disabled = index === maxIndex();
  };

  prev.addEventListener("click", () => { index -= 1; update(); });
  next.addEventListener("click", () => { index += 1; update(); });

  // Swipe (touch)
  let startX = 0;
  let dx = 0;
  let isDown = false;

  const onDown = (x) => { isDown = true; startX = x; dx = 0; };
  const onMove = (x) => { if (!isDown) return; dx = x - startX; };
  const onUp = () => {
    if (!isDown) return;
    isDown = false;
    const threshold = 40;
    if (dx <= -threshold) index += 1;
    if (dx >= threshold) index -= 1;
    update();
  };

  viewport.addEventListener("touchstart", (e) => onDown(e.touches[0].clientX), { passive: true });
  viewport.addEventListener("touchmove", (e) => onMove(e.touches[0].clientX), { passive: true });
  viewport.addEventListener("touchend", onUp);

  // Mouse drag (opcional)
  viewport.addEventListener("mousedown", (e) => onDown(e.clientX));
  window.addEventListener("mousemove", (e) => onMove(e.clientX));
  window.addEventListener("mouseup", onUp);

  // Recalcular al redimensionar
  window.addEventListener("resize", () => update());

  update();
})();



/* =========================
   7) PRODUCT DETAIL: STEPPER CANTIDAD (+ / -)
========================= */
(() => {
  const qtyInput = document.querySelector('input[type="number"][aria-label="Cantidad"]');
  if (!qtyInput) return;

  const wrap = qtyInput.closest("div");
  if (!wrap) return;

  const btnMinus = wrap.querySelector('button[aria-label="Restar"]');
  const btnPlus  = wrap.querySelector('button[aria-label="Sumar"]');

  const clamp = (n) => {
    const min = parseInt(qtyInput.min || "1", 10);
    return Math.max(min, isNaN(n) ? min : n);
  };

  const setVal = (n) => { qtyInput.value = String(clamp(n)); };

  btnMinus?.addEventListener("click", () => setVal(parseInt(qtyInput.value || "1", 10) - 1));
  btnPlus?.addEventListener("click",  () => setVal(parseInt(qtyInput.value || "1", 10) + 1));

  qtyInput.addEventListener("input", () => setVal(parseInt(qtyInput.value || "1", 10)));
})();


/* =========================
   8) CARRUSEL: PRODUCTOS RELACIONADOS
========================= */
(() => {
  const root = document.querySelector('[data-carousel="related"]');
  if (!root) return;

  const viewport = root.querySelector("[data-carousel-viewport]");
  const track = root.querySelector("[data-carousel-track]");
  const prev = document.querySelector("[data-carousel-prev]");
  const next = document.querySelector("[data-carousel-next]");

  if (!viewport || !track || !prev || !next) return;

  const items = Array.from(track.children);
  if (items.length === 0) return;

  let index = 0;

  const gap = () => {
    const style = getComputedStyle(track);
    return parseFloat(style.gap || "0") || 0;
  };

  const step = () => {
    const first = items[0];
    return first.getBoundingClientRect().width + gap();
  };

  const maxIndex = () => {
    const vp = viewport.getBoundingClientRect().width;
    const total = items.length * step();
    return Math.max(0, Math.ceil((total - vp) / step()));
  };

  const clamp = (n) => Math.max(0, Math.min(maxIndex(), n));

  const update = () => {
    index = clamp(index);
    track.style.transform = `translateX(${-index * step()}px)`;
    prev.disabled = index === 0;
    next.disabled = index === maxIndex();
  };

  prev.addEventListener("click", () => { index -= 1; update(); });
  next.addEventListener("click", () => { index += 1; update(); });

  window.addEventListener("resize", update, { passive: true });

  update();
})();


/* =========================
   9) PRODUCT DETAIL: GALLERY (prev/next + thumbs)
========================= */
(() => {
  const mainImg = document.getElementById("productMainImage");
  const thumbsWrap = document.querySelector("[data-gal-thumbs]");
  const btnPrev = document.querySelector("[data-gal-prev]");
  const btnNext = document.querySelector("[data-gal-next]");

  if (!mainImg || !thumbsWrap) return;

  const thumbBtns = Array.from(thumbsWrap.querySelectorAll("button.res-thumb"));
  if (thumbBtns.length === 0) return;

  // Tomamos la imagen desde el <img> interno de cada thumb
  const images = thumbBtns
    .map((btn) => btn.querySelector("img")?.getAttribute("src"))
    .filter(Boolean);

  if (images.length === 0) return;

  let current = Math.max(0, thumbBtns.findIndex((b) => b.classList.contains("is-active")));
  if (current === -1) current = 0;

  const setActive = (i) => {
    thumbBtns.forEach((b, idx) => b.classList.toggle("is-active", idx === i));

    // scroll suave para traer la thumb visible
    const target = thumbBtns[i];
    if (target?.scrollIntoView) {
      target.scrollIntoView({ behavior: "smooth", inline: "nearest", block: "nearest" });
    }
  };

  const show = (i) => {
    current = (i + images.length) % images.length;
    mainImg.src = images[current];
    setActive(current);
  };

  // Click en thumbs
  thumbBtns.forEach((btn, idx) => btn.addEventListener("click", () => show(idx)));


  // Teclado (mejora UX)
  document.addEventListener("keydown", (e) => {
    // evitar romper si el usuario está escribiendo en inputs
    const tag = document.activeElement?.tagName?.toLowerCase();
    if (tag === "input" || tag === "textarea") return;

    if (e.key === "ArrowLeft") show(current - 1);
    if (e.key === "ArrowRight") show(current + 1);
  });

  // Init
  show(current);
})();
