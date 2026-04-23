<?php
// includes/footer.php
?>
    <!-- Footer -->
    <footer style="background: #0a0a0a; padding: 50px; text-align: center; border-top: 1px solid #333; margin-top: 100px;">
        <div class="logo" style="font-size: 24px; margin-bottom: 30px;">LUXURY <span>AUTO</span></div>
        <div class="social-icons" style="margin: 30px 0;">
            <a href="#" style="color: #fff; font-size: 24px; margin: 0 15px; transition: color 0.3s;"><i class="fab fa-facebook"></i></a>
            <a href="#" style="color: #fff; font-size: 24px; margin: 0 15px; transition: color 0.3s;"><i class="fab fa-instagram"></i></a>
            <a href="#" style="color: #fff; font-size: 24px; margin: 0 15px; transition: color 0.3s;"><i class="fab fa-twitter"></i></a>
            <a href="#" style="color: #fff; font-size: 24px; margin: 0 15px; transition: color 0.3s;"><i class="fab fa-youtube"></i></a>
        </div>
        <p style="color: #666; margin-top: 20px;">© 2024 LUXURY AUTO. All rights reserved.</p>
    </footer>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(10, 10, 10, 0.98)';
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.3)';
            } else {
                navbar.style.background = 'rgba(10, 10, 10, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>