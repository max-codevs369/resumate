<script>
        function toggleMobileMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const nav = document.querySelector('nav');
            const menu = document.getElementById('navMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!nav.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('active');
            }
        });

        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
            this.classList.toggle('open'); 
        });
        
        // --- Back to Top Logic ---
        const backToTopBtn = document.getElementById('backToTop');

        window.onscroll = function() {
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        };

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        (function () {
        const profile   = document.getElementById('navProfile');
        const toggleBtn = document.getElementById('profileToggle');

        if (!profile || !toggleBtn) return;

        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profile.classList.toggle('open');
        });

        document.addEventListener('click', function (e) {
            if (!profile.contains(e.target)) {
                profile.classList.remove('open');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') profile.classList.remove('open');
        });

        })();
    </script>