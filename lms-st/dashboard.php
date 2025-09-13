<?php 
require_once __DIR__ . '/session_helper.php';
safe_session_start();
$cfg = require __DIR__ . '/config.php'; 
$site = $cfg['site_name'] ?? 'EduLearn'; 

// Redirect to login if not authenticated
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard — <?php echo htmlspecialchars($site); ?></title>
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
  <script src="https://unpkg.com/lucide@latest"></script>
  
</head>
<body data-nav-theme="dark">
  <!-- Liquid Glass Background (dashboard only) -->
  <div id="liquidBg" class="liquid-bg" aria-hidden="true"></div>
  
  <!-- Dashboard Navbar with Profile Dropdown -->
  <?php include __DIR__ . '/components/dashboard-navbar.php'; ?>
  <style>
    /* Dashboard-only: force navbar text to gray */
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
    /* Hide legacy emoji symbols inside item-head */
    .item-head .item-symbol { display: none !important; }
  </style>

  <main class="container main">
    <section class="welcome-banner" id="overview">
      <div class="welcome-text">
        <div class="eyebrow">2025 A/L • ONLINE</div>
        <h1>Welcome back, <span id="welcomeName"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Student'); ?></span>!</h1>
        <div class="flex flex-wrap gap-2 mt-3">
          <div class="flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 border border-white/10">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-yellow-100/80">
              <i data-lucide="trophy" class="w-4 h-4 text-yellow-700"></i>
            </span>
            <span class="text-sm">0 Points</span>
          </div>
          <div class="flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 border border-white/10">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-purple-100/80">
              <i data-lucide="target" class="w-4 h-4 text-purple-700"></i>
            </span>
            <span class="text-sm">developer</span>
          </div>
        </div>
      </div>
      <div class="metrics">
        <div class="metric">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white/25">
            <i data-lucide="graduation-cap" class="w-5 h-5 text-white"></i>
          </span>
          <div class="metric-body">
            <div class="label">Classes</div>
            <div class="value" id="classesCount">6</div>
          </div>
        </div>
        <div class="metric">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-white/25">
            <i data-lucide="percent" class="w-5 h-5 text-white"></i>
          </span>
          <div class="metric-body">
            <div class="label">Score</div>
            <div class="value" id="scoreValue">0%</div>
          </div>
        </div>
      </div>
    </section>

    

    <section class="bento-grid">
      <article class="bento-item" data-key="practicals" id="classes">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-purple-100">
            <i data-lucide="code" class="w-5 h-5 text-purple-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">💻</span></div>
        <h3 class="item-title">Practicals</h3>
        <p class="item-desc">Code & Practice</p>
      </article>

      <article class="bento-item" data-key="results" id="results">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-green-100">
            <i data-lucide="check-square" class="w-5 h-5 text-green-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">✅</span></div>
        <h3 class="item-title">View Results</h3>
        <p class="item-desc">Check your marks</p>
      </article>

      <article class="bento-item" data-key="payments" id="payments">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-orange-100">
            <i data-lucide="wallet" class="w-5 h-5 text-orange-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">💳</span></div>
        <h3 class="item-title">Payments</h3>
        <p class="item-desc">View history</p>
      </article>

      <article class="bento-item" data-key="classes" id="my-classes">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100">
            <i data-lucide="book-open" class="w-5 h-5 text-blue-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">📚</span></div>
        <h3 class="item-title">My Classes</h3>
        <p class="item-desc">Enrolled courses</p>
      </article>

      <article class="bento-item span-2" data-key="graph" id="graph">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-violet-100">
            <i data-lucide="trending-up" class="w-5 h-5 text-violet-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">📈</span></div>
        <h3 class="item-title">Performance Graph</h3>
        <p class="item-desc">Your recent exam results</p>
        <canvas id="perfChart" height="120"></canvas>
      </article>

      <article class="bento-item span-2" data-key="notices" id="notices">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-amber-100">
            <i data-lucide="bell" class="w-5 h-5 text-amber-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">🔔</span></div>
        <h3 class="item-title">Important Notices</h3>
        <p class="item-desc">Latest announcements</p>
        <ul class="notices">
          <li><span class="badge low">LOW</span> Poson Poya Holiday — center closed.</li>
          <li><span class="badge high">HIGH</span> Free Seminar — YouTube + Zoom live.</li>
        </ul>
      </article>

      <article class="bento-item" data-key="calendar" id="calendar-section">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-pink-100">
            <i data-lucide="calendar" class="w-5 h-5 text-pink-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">📅</span></div>
        <h3 class="item-title">Calendar</h3>
        <p class="item-desc">Class schedule</p>
        <div id="calendar" class="calendar"></div>
      </article>

      <article class="bento-item" data-key="rankings">
        <div class="item-head">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-teal-100">
            <i data-lucide="medal" class="w-5 h-5 text-teal-700"></i>
          </span>
        </div>
        <div class="item-head"><span class="item-symbol" aria-hidden="true">🏅</span></div>
        <h3 class="item-title">Your Top Rankings</h3>
        <p class="item-desc">Recent achievements</p>
        <div class="empty-state"><i class="fa-regular fa-star"></i> No top rankings yet</div>
      </article>
    </section>
  </main>

  <footer id="help" class="footer">
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

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <script src="script.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/navbar-theme.js"></script>
  <script>
    // Initialize Lucide icons after DOM and CDN load
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
      window.lucide.createIcons();
    } else {
      document.addEventListener('DOMContentLoaded', function () {
        try { window.lucide && window.lucide.createIcons && window.lucide.createIcons(); } catch (e) {}
      });
    }
  </script>
  
  <script>
    // Force light theme for dashboard page
    document.addEventListener('DOMContentLoaded', function() {
      if (window.navbarThemeController) {
        window.navbarThemeController.forceTheme('light');
      }
    });
  </script>
</body>
</html>
