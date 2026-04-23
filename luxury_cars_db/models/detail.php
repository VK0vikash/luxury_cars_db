<?php
require_once '../includes/db.php';

$carId = $_GET['id'] ?? 0;

// Fetch car details
$stmt = $conn->prepare("
    SELECT cm.*, cs.* 
    FROM car_models cm 
    LEFT JOIN car_specs cs ON cm.id = cs.car_id 
    WHERE cm.id = ? AND cm.status = 'active'
");
$stmt->execute([$carId]);
$car = $stmt->fetch();

if (!$car) {
    header('Location: ../models.php');
    exit;
}

// Fetch car images
$stmt = $conn->prepare("
    SELECT * FROM car_images 
    WHERE car_id = ? 
    ORDER BY image_type, sort_order
");
$stmt->execute([$carId]);
$images = $stmt->fetchAll();

// Fetch features
$stmt = $conn->prepare("
    SELECT * FROM car_features 
    WHERE car_id = ? 
    ORDER BY feature_type
");
$stmt->execute([$carId]);
$features = $stmt->fetchAll();

// Fetch color variants
$stmt = $conn->prepare("SELECT * FROM color_variants WHERE car_id = ? AND available = 1");
$stmt->execute([$carId]);
$colors = $stmt->fetchAll();

// Fetch brochure
$stmt = $conn->prepare("SELECT * FROM brochures WHERE car_id = ? LIMIT 1");
$stmt->execute([$carId]);
$brochure = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($car['model_name']); ?> | LUXURY AUTO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .car-detail-hero {
            height: 80vh;
            position: relative;
            overflow: hidden;
        }
        
        .car-hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease;
            background-size: cover;
            background-position: center;
        }
        
        .hero-slide.active {
            opacity: 1;
        }
        
        .car-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 3rem;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            color: white;
        }
        
        .car-title {
            font-size: 4rem;
            margin-bottom: 0.5rem;
        }
        
        .car-price {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .detail-section {
            padding: 5rem 0;
        }
        
        .specs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .spec-card {
            background: var(--glass-bg);
            padding: 2rem;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            text-align: center;
        }
        
        .spec-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .spec-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .spec-label {
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .color-selector {
            display: flex;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .color-option:hover,
        .color-option.active {
            border-color: var(--primary-color);
            transform: scale(1.1);
        }
        
        .features-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .feature-tab {
            padding: 0.8rem 2rem;
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .feature-tab.active {
            background: var(--primary-color);
            color: var(--secondary-color);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .feature-item {
            display: flex;
            gap: 1rem;
            padding: 1.5rem;
            background: var(--glass-bg);
            border-radius: 10px;
            border: 1px solid var(--glass-border);
        }
        
        .feature-icon {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-top: 0.5rem;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .gallery-item {
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }
        
        .btn-download {
            background: transparent;
            border: 2px solid var(--text-primary);
            color: var(--text-primary);
        }
        
        .btn-download:hover {
            background: var(--text-primary);
            color: var(--secondary-color);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-image {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }
        
        .close-modal {
            position: absolute;
            top: 2rem;
            right: 2rem;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: none;
            border: none;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <section class="car-detail-hero">
        <div class="car-hero-slider" id="heroSlider">
            <?php 
            $heroImages = array_filter($images, function($img) {
                return $img['image_type'] === 'hero';
            });
            
            if (empty($heroImages)) {
                $heroImages = array_slice($images, 0, 3);
            }
            
            foreach($heroImages as $index => $image): 
            ?>
            <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" 
                 style="background-image: url('../assets/uploads/<?php echo $image['image_path']; ?>')"></div>
            <?php endforeach; ?>
        </div>
        
        <div class="car-overlay">
            <h1 class="car-title"><?php echo htmlspecialchars($car['model_name']); ?></h1>
            <p class="car-tagline"><?php echo htmlspecialchars($car['tagline']); ?></p>
            <p class="car-price">From $<?php echo number_format($car['base_price'], 0); ?></p>
        </div>
    </section>
    
    <section class="section detail-section">
        <div class="container">
            <!-- 3D Viewer -->
            <div class="section-header">
                <h2 class="section-title">360° View</h2>
                <p class="section-subtitle">Explore every angle of perfection</p>
            </div>
            
            <div id="car3dViewer" style="width: 100%; height: 500px; margin: 3rem 0; border-radius: 10px; overflow: hidden;"></div>
            
            <!-- Key Specifications -->
            <div class="section-header">
                <h2 class="section-title">Performance Specifications</h2>
            </div>
            
            <div class="specs-grid">
                <?php if($car['horsepower']): ?>
                <div class="spec-card">
                    <div class="spec-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="spec-value"><?php echo $car['horsepower']; ?> HP</h3>
                    <p class="spec-label">Horsepower</p>
                </div>
                <?php endif; ?>
                
                <?php if($car['acceleration_0_100']): ?>
                <div class="spec-card">
                    <div class="spec-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3 class="spec-value"><?php echo $car['acceleration_0_100']; ?>s</h3>
                    <p class="spec-label">0-100 km/h</p>
                </div>
                <?php endif; ?>
                
                <?php if($car['top_speed']): ?>
                <div class="spec-card">
                    <div class="spec-icon">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <h3 class="spec-value"><?php echo $car['top_speed']; ?> km/h</h3>
                    <p class="spec-label">Top Speed</p>
                </div>
                <?php endif; ?>
                
                <?php if($car['torque']): ?>
                <div class="spec-card">
                    <div class="spec-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3 class="spec-value"><?php echo $car['torque']; ?> Nm</h3>
                    <p class="spec-label">Torque</p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Color Options -->
            <?php if(!empty($colors)): ?>
            <div class="section-header">
                <h2 class="section-title">Available Colors</h2>
            </div>
            
            <div class="color-selector">
                <?php foreach($colors as $color): ?>
                <div class="color-option" 
                     style="background-color: <?php echo $color['color_code']; ?>"
                     title="<?php echo htmlspecialchars($color['color_name']); ?>"
                     data-color="<?php echo $color['color_name']; ?>">
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Features Tabs -->
            <?php if(!empty($features)): ?>
            <div class="section-header">
                <h2 class="section-title">Features & Technology</h2>
            </div>
            
            <div class="features-tabs" id="featureTabs">
                <button class="feature-tab active" data-tab="all">All Features</button>
                <button class="feature-tab" data-tab="safety">Safety</button>
                <button class="feature-tab" data-tab="technology">Technology</button>
                <button class="feature-tab" data-tab="comfort">Comfort</button>
                <button class="feature-tab" data-tab="performance">Performance</button>
            </div>
            
            <div class="features-grid" id="featuresContainer">
                <?php foreach($features as $feature): ?>
                <div class="feature-item" data-type="<?php echo $feature['feature_type']; ?>">
                    <div class="feature-icon">
                        <i class="fas fa-<?php echo $feature['icon'] ?? 'star'; ?>"></i>
                    </div>
                    <div>
                        <h4><?php echo htmlspecialchars($feature['feature_name']); ?></h4>
                        <p><?php echo htmlspecialchars($feature['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Gallery -->
            <?php if(count($images) > 3): ?>
            <div class="section-header">
                <h2 class="section-title">Gallery</h2>
            </div>
            
            <div class="gallery-grid">
                <?php foreach($images as $image): ?>
                <div class="gallery-item" onclick="openModal('<?php echo $image['image_path']; ?>')">
                    <img src="../assets/uploads/<?php echo $image['image_path']; ?>" 
                         alt="<?php echo htmlspecialchars($image['alt_text'] ?? $car['model_name']); ?>">
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="../book-drive.php?model=<?php echo $carId; ?>" class="btn-primary btn-large">
                    <i class="fas fa-calendar-alt"></i> Book Test Drive
                </a>
                
                <a href="../contact.php" class="btn-secondary btn-large">
                    <i class="fas fa-envelope"></i> Request Quote
                </a>
                
                <?php if($brochure): ?>
                <a href="../assets/uploads/<?php echo $brochure['file_path']; ?>" 
                   class="btn-download btn-large" download>
                    <i class="fas fa-download"></i> Download Brochure
                </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Image Modal -->
    <div class="modal" id="imageModal">
        <button class="close-modal" onclick="closeModal()">&times;</button>
        <img class="modal-image" id="modalImage" src="" alt="">
    </div>
    
    <?php include '../includes/footer.php'; ?>
    
    <script src="../assets/js/three.min.js"></script>
    <script>
        // Hero Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);
        
        // Color Selector
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(o => o.classList.remove('active'));
                this.classList.add('active');
                
                // Change car color in 3D viewer
                // This would update the 3D model color
                console.log('Selected color:', this.getAttribute('data-color'));
            });
        });
        
        // Feature Tabs
        const featureTabs = document.querySelectorAll('.feature-tab');
        const featureItems = document.querySelectorAll('.feature-item');
        
        featureTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                featureTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.getAttribute('data-tab');
                
                featureItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-type') === filter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Image Modal
        function openModal(imagePath) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            
            modalImage.src = '../assets/uploads/' + imagePath;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
        
        // Close modal on background click
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        
        // Initialize 3D Viewer
        function init3DViewer() {
            const container = document.getElementById('car3dViewer');
            if (!container || typeof THREE === 'undefined') return;
            
            // Create scene
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(renderer.domElement);
            
            // Add lights
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(5, 10, 7);
            scene.add(directionalLight);
            
            // Create a more detailed car model (placeholder)
            const carGroup = new THREE.Group();
            
            // Car body
            const bodyGeometry = new THREE.BoxGeometry(4, 1.2, 8);
            const bodyMaterial = new THREE.MeshStandardMaterial({ 
                color: 0xD4AF37,
                metalness: 0.9,
                roughness: 0.1
            });
            const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
            carGroup.add(body);
            
            // Wheels
            const wheelGeometry = new THREE.CylinderGeometry(0.5, 0.5, 0.3, 16);
            const wheelMaterial = new THREE.MeshStandardMaterial({ 
                color: 0x222222,
                metalness: 0.8,
                roughness: 0.2
            });
            
            const positions = [
                [-1.5, -0.6, 2.5],
                [1.5, -0.6, 2.5],
                [-1.5, -0.6, -2.5],
                [1.5, -0.6, -2.5]
            ];
            
            positions.forEach(pos => {
                const wheel = new THREE.Mesh(wheelGeometry, wheelMaterial);
                wheel.rotation.z = Math.PI / 2;
                wheel.position.set(pos[0], pos[1], pos[2]);
                carGroup.add(wheel);
            });
            
            scene.add(carGroup);
            camera.position.z = 8;
            camera.position.y = 3;
            
            // Auto rotation
            let autoRotate = true;
            
            function animate() {
                requestAnimationFrame(animate);
                
                if (autoRotate) {
                    carGroup.rotation.y += 0.005;
                }
                
                renderer.render(scene, camera);
            }
            animate();
            
            // Mouse controls
            let isDragging = false;
            let previousMousePosition = { x: 0, y: 0 };
            
            container.addEventListener('mousedown', (e) => {
                isDragging = true;
                autoRotate = false;
                previousMousePosition = { x: e.clientX, y: e.clientY };
            });
            
            container.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                
                const deltaX = e.clientX - previousMousePosition.x;
                carGroup.rotation.y += deltaX * 0.01;
                
                previousMousePosition = { x: e.clientX, y: e.clientY };
            });
            
            container.addEventListener('mouseup', () => {
                isDragging = false;
                setTimeout(() => { autoRotate = true; }, 2000);
            });
            
            // Handle window resize
            window.addEventListener('resize', () => {
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            });
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', init3DViewer);
    </script>
</body>
</html>