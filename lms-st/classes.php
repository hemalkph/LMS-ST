<?php 
// Start session before any output to avoid header warnings
require_once __DIR__ . '/session_helper.php';
safe_session_start();

$cfg = require __DIR__ . '/config.php'; 
$site = $cfg['site_name'] ?? 'EduLearn'; 

// Sample course data (in a real app, this would come from a database)
$courses = [
    [
        'id' => 1,
        'title' => 'Web Development Bootcamp',
        'description' => 'Master HTML, CSS, JavaScript, and modern frameworks like React and Vue.js',
        'category' => 'web_development',
        'difficulty' => 'beginner',
        'duration_hours' => 120,
        'total_lessons' => 45,
        'total_exercises' => 20,
        'price' => 199,
        'rating' => 4.9,
        'reviews' => 2500,
        'image' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?q=80&w=400&auto=format&fit=crop',
        'created_date' => '2024-01-15',
        'instructor' => 'John Smith'
    ],
    [
        'id' => 2,
        'title' => 'Data Science Mastery',
        'description' => 'Learn Python, Machine Learning, and Data Analysis with real-world projects',
        'category' => 'data_automation',
        'difficulty' => 'intermediate',
        'duration_hours' => 160,
        'total_lessons' => 60,
        'total_exercises' => 35,
        'price' => 299,
        'rating' => 4.8,
        'reviews' => 1800,
        'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=400&auto=format&fit=crop',
        'created_date' => '2024-01-10',
        'instructor' => 'Sarah Johnson'
    ],
    [
        'id' => 3,
        'title' => 'API Integration Course',
        'description' => 'Build and integrate RESTful APIs with Node.js, Express, and MongoDB',
        'category' => 'api_integration',
        'difficulty' => 'intermediate',
        'duration_hours' => 80,
        'total_lessons' => 30,
        'total_exercises' => 15,
        'price' => 149,
        'rating' => 4.7,
        'reviews' => 1200,
        'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=400&auto=format&fit=crop',
        'created_date' => '2024-01-20',
        'instructor' => 'Mike Chen'
    ],
    [
        'id' => 4,
        'title' => 'Database Management',
        'description' => 'Master SQL, database design, and optimization techniques',
        'category' => 'database_management',
        'difficulty' => 'beginner',
        'duration_hours' => 60,
        'total_lessons' => 25,
        'total_exercises' => 12,
        'price' => 129,
        'rating' => 4.6,
        'reviews' => 900,
        'image' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?q=80&w=400&auto=format&fit=crop',
        'created_date' => '2024-01-25',
        'instructor' => 'Lisa Wang'
    ],
    [
        'id' => 5,
        'title' => 'Cloud Computing Fundamentals',
        'description' => 'Learn AWS, Azure, and Google Cloud Platform essentials',
        'category' => 'cloud_computing',
        'difficulty' => 'intermediate',
        'duration_hours' => 100,
        'total_lessons' => 40,
        'total_exercises' => 18,
        'price' => 249,
        'rating' => 4.8,
        'reviews' => 1500,
        'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=400&auto=format&fit=crop',
        'created_date' => '2024-01-12',
        'instructor' => 'David Brown'
    ],
    [
        'id' => 6,
        'title' => 'Mobile App Development',
        'description' => 'Build iOS and Android apps with React Native and Flutter',
        'category' => 'mobile_development',
        'difficulty' => 'advanced',
        'duration_hours' => 140,
        'total_lessons' => 55,
        'total_exercises' => 25,
        'price' => 349,
        'rating' => 4.9,
        'reviews' => 2100,
        'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=400&auto=format&fit=crop',
        'created_date' => '2024-01-08',
        'instructor' => 'Emma Davis'
    ]
];

// Sample user progress data - no enrolled courses
$userProgress = []; // User is not enrolled in any courses

$categories = [
    'all' => 'All Categories',
    'api_integration' => 'API Integration',
    'data_automation' => 'Data Automation',
    'web_development' => 'Web Development',
    'database_management' => 'Database Management',
    'cloud_computing' => 'Cloud Computing',
    'mobile_development' => 'Mobile Development'
];

$difficulties = [
    'all' => 'All Levels',
    'beginner' => 'Beginner',
    'intermediate' => 'Intermediate',
    'advanced' => 'Advanced'
];

// Get filter parameters
$searchTerm = $_GET['search'] ?? '';
$selectedCategory = $_GET['category'] ?? 'all';
$selectedDifficulty = $_GET['difficulty'] ?? 'all';
$sortBy = $_GET['sort'] ?? 'newest';

// Filter courses
$filteredCourses = array_filter($courses, function($course) use ($searchTerm, $selectedCategory, $selectedDifficulty) {
    $matchesSearch = empty($searchTerm) || 
        stripos($course['title'], $searchTerm) !== false || 
        stripos($course['description'], $searchTerm) !== false;
    $matchesCategory = $selectedCategory === 'all' || $course['category'] === $selectedCategory;
    $matchesDifficulty = $selectedDifficulty === 'all' || $course['difficulty'] === $selectedDifficulty;
    
    return $matchesSearch && $matchesCategory && $matchesDifficulty;
});

// Sort courses
usort($filteredCourses, function($a, $b) use ($sortBy) {
    switch ($sortBy) {
        case 'newest':
            return strtotime($b['created_date']) - strtotime($a['created_date']);
        case 'popular':
            return ($b['total_lessons'] + $b['total_exercises']) - ($a['total_lessons'] + $a['total_exercises']);
        case 'duration':
            return $a['duration_hours'] - $b['duration_hours'];
        default:
            return 0;
    }
});

// Separate enrolled and available courses
$enrolledCourses = array_filter($filteredCourses, function($course) use ($userProgress) {
    return in_array($course['id'], $userProgress);
});

$availableCourses = array_filter($filteredCourses, function($course) use ($userProgress) {
    return !in_array($course['id'], $userProgress);
});

$userSkillPoints = 1250; // Sample skill points
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes — <?php echo htmlspecialchars($site); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tailwind CDN (preflight disabled to avoid global resets) -->
    <script>
        window.tailwind = window.tailwind || {};
        tailwind.config = { corePlugins: { preflight: false } };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <style>
        .classes-container {
            padding: 2rem 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        /* Removed navbar on classes page; no overrides required */
        
        .classes-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .classes-header h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }
        
        .classes-header p {
            font-size: 1.125rem;
            color: #6b7280;
            max-width: 42rem;
            margin: 0 auto;
        }
        
        .filters-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .filter-group {
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #7c3aed;
        }
        
        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            margin-top: -0.5rem;
            color: #9ca3af;
            font-size: 1rem;
        }
        
        .select-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            background: white;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        
        .select-input:focus {
            outline: none;
            border-color: #7c3aed;
        }
        
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }
        
        .section-header i {
            font-size: 1.5rem;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-purple {
            background: #f3e8ff;
            color: #7c3aed;
        }
        
        .badge-blue {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .course-card {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            position: relative;
        }
        
        
        
        .course-content {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
        }
        
        
        
        .course-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .course-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
        }
        
        .course-overlay i {
            color: white;
            font-size: 2rem;
        }
        
        .course-content {
            padding: 1.5rem;
        }
        
        .course-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        
        .course-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .course-duration {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .course-level {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .level-beginner {
            background: #dcfce7;
            color: #166534;
        }
        
        .level-intermediate {
            background: #fef3c7;
            color: #92400e;
        }
        
        .level-advanced {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .course-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .stars {
            display: flex;
            gap: 0.125rem;
        }
        
        .stars i {
            color: #fbbf24;
            font-size: 0.875rem;
        }
        
        .rating-text {
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        .course-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
        }
        
        .btn-enroll {
            background: #7c3aed;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-enroll:hover {
            background: #6d28d9;
        }
        
        .btn-continue {
            background: #10b981;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-continue:hover {
            background: #059669;
        }
        
        .stats-footer {
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            border-radius: 0.75rem;
            padding: 2rem;
            color: white;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #9ca3af;
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .classes-header h1 {
                font-size: 2rem;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Disable 3D hover effect on course cards for Classes page */
        .classes-container .courses-grid { perspective: none !important; }
        .classes-container .card-container { perspective: none !important; transform-style: flat !important; }
        .classes-container .course-card { transform: none !important; transform-style: flat !important; box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important; }
        .classes-container .course-card:hover { transform: none !important; box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important; }

        /* New subtle hover highlight effect (Aceternity-style) */
        .classes-container .courses-grid { position: relative; }
        .classes-container .course-card { position: relative; z-index: 1; transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease; }
        .classes-container .course-card:hover { border-color: #7c3aed !important; box-shadow: 0 8px 24px rgba(124,58,237,.18) !important; }
        .classes-container .hover-bg {
            position: absolute;
            inset: auto;
            border-radius: 20px;
            background: rgba(124,58,237,.12); /* purple */
            box-shadow: 0 16px 40px rgba(124,58,237,.15), 0 0 0 1px rgba(124,58,237,.25);
            opacity: 0;
            pointer-events: none;
            transform: translate(0,0);
            transition: opacity .15s ease, transform .2s ease, width .2s ease, height .2s ease;
            z-index: 0;
        }
    </style>
</head>
<body data-nav-theme="dark">
    <!-- Liquid Glass Background (dashboard only) -->
    <div id="liquidBg" class="liquid-bg" aria-hidden="true"></div>
    
    <!-- Dashboard Navbar with active highlight -->
    <?php $activeSlug = 'classes'; include __DIR__ . '/components/dashboard-navbar.php'; ?>
    <style>
      /* Classes page: force navbar text to gray */
      #tw-nav-body a,
      #tw-nav-body .fas,
      #tw-nav-body .nav-text,
      #tw-nav-body span {
        color: #9ca3af !important; /* gray-400 */
      }
      #tw-nav-body a:hover { color: #d1d5db !important; } /* gray-300 */
      #tw-nav-body a.tw-active,
      #tw-nav-body.tw-light a.tw-active { color: #9ca3af !important; }
      /* When navbar switches to light background on scroll */
      #tw-nav-body.tw-light a,
      #tw-nav-body.tw-light .fas,
      #tw-nav-body.tw-light .nav-text,
      #tw-nav-body.tw-light span {
        color: #4b5563 !important; /* gray-600 for contrast on light bg */
      }
    </style>

    <div class="classes-container">
        <div class="container">
            <!-- Header -->
            <div class="classes-header">
                <h1>Professional Coding Courses</h1>
                <p>Master real-world coding skills with hands-on projects designed for working professionals</p>
            </div>

            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" class="filters-grid">
                    <div class="filter-group">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" name="search" placeholder="Search courses..." 
                               value="<?php echo htmlspecialchars($searchTerm); ?>" 
                               class="search-input">
                    </div>
                    
                    <select name="category" class="select-input">
                        <?php foreach ($categories as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo $selectedCategory === $value ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="difficulty" class="select-input">
                        <?php foreach ($difficulties as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo $selectedDifficulty === $value ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="sort" class="select-input">
                        <option value="newest" <?php echo $sortBy === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="popular" <?php echo $sortBy === 'popular' ? 'selected' : ''; ?>>Most Popular</option>
                        <option value="duration" <?php echo $sortBy === 'duration' ? 'selected' : ''; ?>>Shortest First</option>
                    </select>
                </form>
            </div>

            <!-- All Courses Section -->
            <div class="section-header">
                <i class="fa-solid fa-code" style="color: #2563eb;"></i>
                <h2>All Courses</h2>
                <span class="badge badge-blue"><?php echo count($filteredCourses); ?> Available</span>
            </div>

            <?php if (!empty($filteredCourses)): ?>
            <div class="courses-grid">
                <?php foreach ($filteredCourses as $course): ?>
                <div class="course-card">
                    <div class="course-image">
                        <img src="<?php echo $course['image']; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <div class="course-overlay">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                    </div>
                    <div class="course-content">
                        <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
                        <div class="course-meta">
                            <span class="course-duration">
                                <i class="fa-solid fa-clock"></i>
                                <?php echo $course['duration_hours']; ?> hours
                            </span>
                            <span class="course-level level-<?php echo $course['difficulty']; ?>">
                                <?php echo ucfirst($course['difficulty']); ?>
                            </span>
                        </div>
                        <div class="course-rating">
                            <div class="stars">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-text"><?php echo $course['rating']; ?> (<?php echo $course['reviews']; ?>+ reviews)</span>
                        </div>
                        <div class="course-price">
                            <span class="price">$<?php echo $course['price']; ?></span>
                            <button class="btn-enroll">Enroll Now</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-code"></i>
                <h3>No courses found</h3>
                <p>
                    <?php if ($searchTerm || $selectedCategory !== 'all' || $selectedDifficulty !== 'all'): ?>
                        Try adjusting your filters to find more courses
                    <?php else: ?>
                        New courses are being added regularly. Check back soon!
                    <?php endif; ?>
                </p>
            </div>
            <?php endif; ?>

            <!-- Stats Footer -->
            <div class="stats-footer">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo count($courses); ?>+</div>
                        <div class="stat-label">Total Courses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">0</div>
                        <div class="stat-label">Courses Enrolled</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $userSkillPoints; ?></div>
                        <div class="stat-label">Skill Points Earned</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (same as landing page) -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-graduation-cap"></i>
                        <span><?php echo htmlspecialchars($site); ?></span>
                    </div>
                    <p>Empowering learners worldwide with quality education and innovative learning experiences.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php#home">Home</a></li>
                        <li><a href="index.php#courses">Courses</a></li>
                        <li><a href="index.php#features">Features</a></li>
                        <li><a href="index.php#about">About</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Subscribe to get updates on new courses and features.</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Enter your email">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script>
        // Auto-submit form when filters change
        document.querySelectorAll('.select-input').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });

        // Card hover background effect (Aceternity-style)
        document.addEventListener('DOMContentLoaded', function() {
            const grids = document.querySelectorAll('.classes-container .courses-grid');
            grids.forEach((grid) => {
                const hoverBg = document.createElement('span');
                hoverBg.className = 'hover-bg';
                grid.appendChild(hoverBg);

                const pad = 8; // extra padding around active card
                const cards = grid.querySelectorAll('.course-card');

                const moveHover = (card) => {
                    const cardRect = card.getBoundingClientRect();
                    const gridRect = grid.getBoundingClientRect();
                    const left = cardRect.left - gridRect.left - pad;
                    const top = cardRect.top - gridRect.top - pad;
                    hoverBg.style.width = (cardRect.width + pad*2) + 'px';
                    hoverBg.style.height = (cardRect.height + pad*2) + 'px';
                    hoverBg.style.transform = `translate(${left}px, ${top}px)`;
                    hoverBg.style.opacity = '1';
                };

                cards.forEach((card) => {
                    card.addEventListener('mouseenter', () => moveHover(card));
                    card.addEventListener('focusin', () => moveHover(card));
                    card.addEventListener('mouseleave', () => { hoverBg.style.opacity = '0'; });
                    card.addEventListener('focusout', () => { hoverBg.style.opacity = '0'; });
                });

                window.addEventListener('resize', () => { hoverBg.style.opacity = '0'; });
                document.addEventListener('scroll', () => { hoverBg.style.opacity = '0'; }, { passive: true });
            });
        });
    </script>
</body>
</html>
