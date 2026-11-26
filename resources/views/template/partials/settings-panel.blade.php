<div class="theme-setting-wrapper">
    <div id="theme-settings" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <p class="settings-heading">SIDEBAR SKINS</p>
        <div class="sidebar-bg-options" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border me-3"></div>Light
        </div>

        {{-- Opsi Deep Navy (Default Aktif) --}}
        <div class="sidebar-bg-options selected" id="sidebar-royal-theme">
            <div class="img-ss rounded-circle border me-3" style="background-color: #0f1b54;"></div>Deep Navy
        </div>

        <div class="sidebar-bg-options" id="sidebar-midnight-theme">
            <div class="img-ss rounded-circle border me-3" style="background-color: #152037;"></div>Midnight Blue
        </div>

        <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
        </div>

        <p class="settings-heading mt-2">HEADER SKINS</p>
        <div class="color-tiles mx-0 px-4">
            <div class="tiles primary"></div>
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
        </div>
    </div>
</div>

{{-- 🛠️ CSS OVERRIDE TOTAL: Perbaikan Warna Text Dropdown Menu Mini --}}
<style>
    /* ===================================================
       1. SETTINGAN LAYOUT UTAMA (DEEP NAVY NAVBAR + SIDEBAR)
       =================================================== */
    .navbar,
    .navbar .navbar-menu-wrapper,
    .navbar .navbar-brand-wrapper {
        background: #0f1b54 !important;
    }
    .sidebar,
    .sidebar .sidebar-brand-wrapper {
        background: #0f1b54 !important; /* Deep Navy for Sidebar */
    }
    .navbar .navbar-brand-wrapper .navbar-brand,
    .navbar .navbar-brand-wrapper .navbar-brand i,
    .sidebar .sidebar-brand-wrapper .sidebar-brand {
        color: #ffffff !important;
    }
    .sidebar .nav .nav-item .nav-link i.menu-icon {
        color: #94a3b8 !important;
    }
    .sidebar .nav .nav-item .nav-link {
        color: #cbd5e1 !important;
    }
    .sidebar .nav .nav-item.active-menu-induk>.nav-link,
    .sidebar .nav .nav-item.active>.nav-link,
    .sidebar .nav .nav-link.active-sub,
    .sidebar .nav .nav-item:not(.active-menu-induk) .nav-link:hover {
        color: #ffffff !important;
    }
    .sidebar .nav .nav-item.active-menu-induk>.nav-link i.menu-icon,
    .sidebar .nav .nav-item.active>.nav-link i.menu-icon,
    .sidebar .nav .nav-link.active-sub i.menu-icon,
    .sidebar .nav .nav-item:not(.active-menu-induk) .nav-link:hover i.menu-icon {
        color: #ffffff !important;
    }

    /* FIX TOMBOL HAMBURGER (Tiga Garis di Atas) agar Selalu Putih Terang */
    .navbar-toggler,
    .navbar-toggler span,
    .navbar-toggler i,
    .navbar .navbar-menu-wrapper .navbar-toggler,
    .navbar .navbar-menu-wrapper .navbar-toggler .ti-menu,
    .navbar .navbar-menu-wrapper .navbar-toggler .icon-menu,
    .navbar .navbar-menu-wrapper .navbar-toggler-right .icon-menu {
        color: #ffffff !important;
    }

    /* FIX WARBA MERAH UNTUK MENU & IKON LOGOUT */
    .sidebar .nav .nav-item .nav-link[href*="logout"] i,
    .sidebar .nav .nav-item .nav-link[onclick*="logout"] i,
    .sidebar .nav .nav-item.keluar .nav-link i,
    .sidebar .nav .nav-item .nav-link .ti-power-off,
    .sidebar .nav .nav-item .nav-link .mdi-logout {
        color: #ff4d4d !important;
    }

    /* ===================================================
       2. FIX TOTAL DROPDOWN POPUP SAAT SIDEBAR MINI (MENGECIL)
       =================================================== */

    /* Background box melayang dropdown saat menciut */
    .sidebar-mini .sidebar .nav .nav-item .sub-menu,
    .sidebar-mini .sidebar .nav .nav-item.hover-open .sub-menu,
    .sidebar .nav .nav-item .sub-menu {
        background: #162c91 !important; /* Shaded royal blue for sub-menu */
    }

    /* 🌟 MENGGANTI WARNA TEKS SUBMENU JADI ABU-ABU TERANG KONTRAST */
    .sidebar .nav .nav-item .sub-menu .nav-item .nav-link,
    .sidebar .nav .sub-menu .nav-item .nav-link,
    .sidebar-mini .sidebar .nav .nav-item .sub-menu .nav-item .nav-link,
    body.sidebar-mini .sidebar .nav .nav-item .sub-menu .nav-item a,
    .sidebar-mini .sidebar .nav .nav-item.hover-open .sub-menu .nav-item .nav-link {
        color: #cbd5e1 !important;
    }

    /* Titik bullet bulat kecil di sebelah teks disamakan warnanya */
    .sidebar .nav .nav-item .sub-menu .nav-item .nav-link::before,
    .sidebar-mini .sidebar .nav .nav-item .sub-menu .nav-item .nav-link::before {
        background: #cbd5e1 !important;
    }

    /* Ketika link menu di-hover/disorot, warnanya berubah menjadi Biru Modern */
    .sidebar .nav .nav-item .sub-menu .nav-item .nav-link:hover,
    .sidebar-mini .sidebar .nav .nav-item .sub-menu .nav-item .nav-link:hover {
        background: #2563eb !important;
        color: #ffffff !important;
    }
    .sidebar .nav .nav-item .sub-menu .nav-item .nav-link:hover::before,
    .sidebar-mini .sidebar .nav .nav-item .sub-menu .nav-item .nav-link:hover::before {
        background: #ffffff !important;
    }

    /* Jaga kebersihan warna icon utama saat mode mini */
    .sidebar-mini .sidebar .nav .nav-item .nav-link i.menu-icon {
        color: #ffffff !important;
    }

    /* ===================================================
       3. ATURAN DINAMIS SWITCHER TEMA (DEEP NAVY)
       =================================================== */
    body.custom-royal .sidebar,
    body.custom-royal .sidebar .sidebar-brand-wrapper {
        background: #0f1b54 !important;
    }
    body.custom-royal .navbar,
    body.custom-royal .navbar .navbar-menu-wrapper,
    body.custom-royal .navbar .navbar-brand-wrapper {
        background: #0f1b54 !important;
    }
    body.custom-royal .sidebar .nav:not(.sub-menu) > .nav-item.active > .nav-link,
    body.custom-royal .sidebar .nav .nav-item.active .nav-link {
        background: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
    }

    /* ===================================================
       4. ATURAN DINAMIS SWITCHER TEMA (MIDNIGHT BLUE)
       =================================================== */
    body.custom-midnight .sidebar,
    body.custom-midnight .sidebar .sidebar-brand-wrapper {
        background: #0f172a !important; /* Darker blue-black slate for Midnight Sidebar */
    }
    body.custom-midnight .navbar,
    body.custom-midnight .navbar .navbar-menu-wrapper,
    body.custom-midnight .navbar .navbar-brand-wrapper {
        background: #152037 !important; /* Midnight Blue for Navbar */
    }
    body.custom-midnight .sidebar .nav:not(.sub-menu) > .nav-item.active > .nav-link,
    body.custom-midnight .sidebar .nav .nav-item.active .nav-link {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
    }
    body.custom-midnight .sidebar .nav .nav-item .sub-menu {
        background: #090d16 !important;
    }
</style>

{{-- 📜 JAVASCRIPT SYSTEM --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const royalBtn = document.getElementById('sidebar-royal-theme');
    const midnightBtn = document.getElementById('sidebar-midnight-theme');
    const lightBtn = document.getElementById('sidebar-light-theme');
    const darkBtn = document.getElementById('sidebar-dark-theme');

    const sidebar = document.querySelector('.sidebar');
    const body = document.querySelector('body');
    const options = document.querySelectorAll('.sidebar-bg-options');

    // Paksa tema Royal Blue aktif saat halaman pertama kali dibuka
    if (sidebar && body) {
        sidebar.classList.remove('sidebar-light');
        sidebar.classList.add('sidebar-dark');
        body.classList.remove('sidebar-light');
        body.classList.add('sidebar-dark', 'custom-royal');
    }

    function clearAllThemes() {
        options.forEach(opt => opt.classList.remove('selected'));
        if(sidebar) sidebar.classList.remove('sidebar-light', 'sidebar-dark');
        if(body) body.classList.remove('sidebar-light', 'sidebar-dark');
        if(body) body.classList.remove('custom-royal', 'custom-midnight');
    }

    if (royalBtn && sidebar) {
        royalBtn.addEventListener('click', function () {
            clearAllThemes();
            royalBtn.classList.add('selected');
            sidebar.classList.add('sidebar-dark');
            body.classList.add('sidebar-dark', 'custom-royal');
        });
    }

    if (midnightBtn && sidebar) {
        midnightBtn.addEventListener('click', function () {
            clearAllThemes();
            midnightBtn.classList.add('selected');
            sidebar.classList.add('sidebar-dark');
            body.classList.add('sidebar-dark', 'custom-midnight');
        });
    }

    if (lightBtn) {
        lightBtn.addEventListener('click', function() {
            clearAllThemes();
            lightBtn.classList.add('selected');
            sidebar.classList.add('sidebar-light');
            body.classList.add('sidebar-light');

            const navbar = document.querySelector('.navbar');
            const navWrapper = document.querySelector('.navbar .navbar-menu-wrapper');
            if(navbar) navbar.style.setProperty('background', '', 'important');
            if(navWrapper) navWrapper.style.setProperty('background', '', 'important');
        });
    }

    if (darkBtn) {
        darkBtn.addEventListener('click', function() {
            clearAllThemes();
            darkBtn.classList.add('selected');
            sidebar.classList.add('sidebar-dark');
            body.classList.add('sidebar-dark');
        });
    }
});
</script>
