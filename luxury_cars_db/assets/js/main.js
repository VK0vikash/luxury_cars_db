// Main JavaScript for Luxury Auto Website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initPageLoader();
    initNavbar();
    initAnimations();
    init3DViewer();
    initFormValidation();
    initVideoBackground();
});

// Page Loader
function initPageLoader() {
    const loader = document.querySelector('.page-loader');
    if (loader) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hidden');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1000);
        });
    }
}

// Navbar Scroll Effect
function initNavbar() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
    
    // Mobile menu toggle
    const toggleBtn = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (toggleBtn && navMenu) {
        toggleBtn.addEventListener('click', () => {
            navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
        });
        
        // Responsive menu
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                navMenu.style.display = 'flex';
            } else {
                navMenu.style.display = 'none';
            }
        });
    }
}

// GSAP Animations
function initAnimations() {
    // Hero text animation
    if (typeof gsap !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        
        // Parallax sections
        gsap.utils.toArray('.parallax-section').forEach(section => {
            gsap.to(section, {
                backgroundPositionY: () => -window.scrollY * 0.5,
                ease: "none",
                scrollTrigger: {
                    trigger: section,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                }
            });
        });
        
        // Fade in elements on scroll
        gsap.utils.toArray('.fade-in').forEach(element => {
            gsap.from(element, {
                opacity: 0,
                y: 50,
                duration: 1,
                scrollTrigger: {
                    trigger: element,
                    start: "top 80%",
                    toggleActions: "play none none none"
                }
            });
        });
    }
}

// 3D Car Viewer
function init3DViewer() {
    const viewerContainer = document.getElementById('car3dViewer');
    if (!viewerContainer) return;
    
    // Check if Three.js is loaded
    if (typeof THREE === 'undefined') {
        console.warn('Three.js not loaded');
        return;
    }
    
    // Setup basic Three.js scene
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, viewerContainer.clientWidth / viewerContainer.clientHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    
    renderer.setSize(viewerContainer.clientWidth, viewerContainer.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    viewerContainer.appendChild(renderer.domElement);
    
    // Add lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(10, 10, 5);
    scene.add(directionalLight);
    
    // Load car model (placeholder - would be a GLTF/GLB file)
    const geometry = new THREE.BoxGeometry(2, 1, 4);
    const material = new THREE.MeshStandardMaterial({ 
        color: 0xD4AF37,
        metalness: 0.8,
        roughness: 0.2
    });
    const car = new THREE.Mesh(geometry, material);
    scene.add(car);
    
    camera.position.z = 5;
    
    // Auto rotation
    let autoRotate = true;
    let rotationSpeed = 0.005;
    
    function animate() {
        requestAnimationFrame(animate);
        
        if (autoRotate) {
            car.rotation.y += rotationSpeed;
        }
        
        renderer.render(scene, camera);
    }
    
    animate();
    
    // Mouse controls
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };
    
    viewerContainer.addEventListener('mousedown', (e) => {
        isDragging = true;
        autoRotate = false;
    });
    
    viewerContainer.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        
        const deltaX = e.clientX - previousMousePosition.x;
        car.rotation.y += deltaX * 0.01;
        
        previousMousePosition = { x: e.clientX, y: e.clientY };
    });
    
    viewerContainer.addEventListener('mouseup', () => {
        isDragging = false;
        setTimeout(() => { autoRotate = true; }, 3000);
    });
    
    viewerContainer.addEventListener('mouseleave', () => {
        isDragging = false;
    });
    
    // Handle window resize
    window.addEventListener('resize', () => {
        camera.aspect = viewerContainer.clientWidth / viewerContainer.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(viewerContainer.clientWidth, viewerContainer.clientHeight);
    });
}

// Form Validation
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('error');
                    
                    // Create error message
                    let errorMsg = input.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.textContent = 'This field is required';
                        input.parentNode.appendChild(errorMsg);
                    }
                } else {
                    input.classList.remove('error');
                    const errorMsg = input.parentNode.querySelector('.error-message');
                    if (errorMsg) errorMsg.remove();
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                gsap.from('.error-message', {
                    y: -10,
                    opacity: 0,
                    duration: 0.3,
                    stagger: 0.1
                });
            }
        });
    });
}

// Video Background Management
function initVideoBackground() {
    const heroVideos = document.querySelectorAll('.hero-video');
    
    heroVideos.forEach(video => {
        // Ensure video plays inline on mobile
        video.setAttribute('playsinline', '');
        video.setAttribute('webkit-playsinline', '');
        
        // Play/pause based on visibility
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    video.play();
                } else {
                    video.pause();
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(video);
    });
}

// Color Selector for Car Models
function initColorSelector() {
    const colorSelectors = document.querySelectorAll('.color-selector');
    
    colorSelectors.forEach(selector => {
        const colors = selector.querySelectorAll('.color-option');
        const carImage = selector.closest('.car-detail').querySelector('.car-main-image');
        
        colors.forEach(color => {
            color.addEventListener('click', function() {
                // Remove active class from all colors
                colors.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked color
                this.classList.add('active');
                
                // Change car image
                const imageUrl = this.getAttribute('data-image');
                if (imageUrl && carImage) {
                    carImage.style.opacity = 0;
                    setTimeout(() => {
                        carImage.src = imageUrl;
                        carImage.style.opacity = 1;
                    }, 300);
                }
            });
        });
    });
}

// Lazy Load Images
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.getAttribute('data-src');
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Smooth Scrolling for Anchor Links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Initialize all functions
window.addEventListener('load', () => {
    initColorSelector();
    initLazyLoading();
    initSmoothScroll();
});

// Performance monitoring
window.addEventListener('load', function() {
    // Log page load performance
    if (window.performance) {
        const perfData = window.performance.getEntriesByType("navigation")[0];
        console.log(`Page loaded in ${perfData.loadEventEnd - perfData.loadEventStart}ms`);
    }
});