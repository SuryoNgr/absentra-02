<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuItems = document.querySelectorAll('.menu-item');
    const pageContents = document.querySelectorAll('.page-content');
    const breadcrumb = document.getElementById('breadcrumb');

    // Navigasi Menu Sidebar
    menuItems.forEach(item => {
        item.addEventListener('click', (e) => {
            if (item.getAttribute('data-external') === 'true') return;

            e.preventDefault();

            menuItems.forEach(mi => mi.classList.remove('active'));
            item.classList.add('active');

            pageContents.forEach(pc => pc.classList.remove('active'));

            const pageId = item.getAttribute('data-page');
            const targetPage = document.getElementById(pageId);
            if (targetPage) {
                targetPage.classList.add('active');
                breadcrumb.textContent = item.textContent.trim();
            }
        });
    });

    // Fungsi kembali ke beranda
    window.backToBeranda = function () {
        pageContents.forEach(pc => pc.classList.remove('active'));

        const berandaPage = document.getElementById('beranda');
        if (berandaPage) {
            berandaPage.classList.add('active');
            breadcrumb.textContent = 'Beranda';

            menuItems.forEach(mi => mi.classList.remove('active'));
            const berandaMenu = document.querySelector('[data-page="beranda"]');
            if (berandaMenu) berandaMenu.classList.add('active');
        }
    };

    // Fungsi tampilkan detail kategori dengan loading animasi
    window.showCategoryDetail = function (category) {
        const tempDiv = document.createElement('div');
        tempDiv.className = 'page-content active';
        tempDiv.innerHTML = `
            <div style="text-align: center; padding: 50px;">
                <div style="font-size: 24px; margin-bottom: 10px;">⏳</div>
                <p>Memuat data ${category}...</p>
            </div>
        `;

        pageContents.forEach(pc => pc.classList.remove('active'));
        document.querySelector('.content-area').appendChild(tempDiv);

        setTimeout(() => {
            tempDiv.remove();

            const detailPage = document.getElementById(`${category}-detail`);
            if (detailPage) {
                detailPage.classList.add('active');

                const categoryNames = {
                    'security': 'Security Services',
                    'cleaning': 'Cleaning Services',
                    'driver': 'Driver Services',
                    'pramugari': 'Pramugari Services'
                };

                breadcrumb.textContent = categoryNames[category] || 'Detail';
                menuItems.forEach(mi => mi.classList.remove('active'));
                const berandaMenu = document.querySelector('[data-page="beranda"]');
                if (berandaMenu) berandaMenu.classList.add('active');
            }
        }, 500);
    };

    // Tambah tombol kembali ke setiap detail kategori
    ['security', 'cleaning', 'driver', 'pramugari'].forEach(category => {
        const page = document.getElementById(`${category}-detail`);
        if (page) {
            const backButton = document.createElement('button');
            backButton.textContent = '← Kembali ke Beranda';
            backButton.style.cssText = `
                background: #3182ce;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                margin-bottom: 20px;
                font-size: 14px;
                transition: background 0.3s ease;
            `;
            backButton.onmouseover = () => backButton.style.background = '#2c5aa0';
            backButton.onmouseout = () => backButton.style.background = '#3182ce';
            backButton.onclick = backToBeranda;

            const contentFrame = page.querySelector('.content-frame');
            if (contentFrame) {
                contentFrame.insertBefore(backButton, contentFrame.firstChild);
            }
        }
    });

    // Logout
    window.logout = function () {
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            window.location.href = 'login.php';
        }
    };

    // Tombol menu mobile
    function toggleMobileMenu() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('mobile-open');
    }

    if (window.innerWidth <= 768) {
        const topBar = document.querySelector('.top-bar');
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.innerHTML = '☰';
        mobileMenuBtn.style.cssText = `
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            margin-right: 15px;
            color: #2d3748;
        `;
        mobileMenuBtn.onclick = toggleMobileMenu;
        topBar.insertBefore(mobileMenuBtn, topBar.firstChild);
    }

    // Tutup menu jika klik di luar
    document.addEventListener('click', function (e) {
        const sidebar = document.querySelector('.sidebar');
        const mobileMenuBtn = document.querySelector('.top-bar button');
        if (sidebar.classList.contains('mobile-open') &&
            !sidebar.contains(e.target) &&
            e.target !== mobileMenuBtn) {
            sidebar.classList.remove('mobile-open');
        }
    });

    // Tambahkan overlay mobile dengan style dinamis
    const mobileStyles = `
        @media (max-width: 768px) {
            .sidebar::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: -1;
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
            }

            .sidebar.mobile-open::before {
                opacity: 1;
                pointer-events: auto;
            }
        }
    `;
    const styleSheet = document.createElement('style');
    styleSheet.textContent = mobileStyles;
    document.head.appendChild(styleSheet);

    // Efek hover kartu statistik
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.boxShadow = '0 4px 6px rgba(0,0,0,0.05)';
        });
    });
});
</script>
