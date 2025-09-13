/**
 * Dynamic Navbar Theme Controller
 * Automatically adjusts navbar colors based on background content
 */

class NavbarThemeController {
    constructor() {
        this.navbarWrapper = document.querySelector('.navbar-wrapper');
        this.navbar = document.querySelector('.navbar');
        this.navItems = document.querySelectorAll('.nav-item');
        this.navButtons = document.querySelectorAll('.navbar-btn');
        this.logo = document.querySelector('.navbar-logo');
        
        this.currentTheme = 'transparent';
        this.intersectionObserver = null;
        this.scrollThreshold = 50;
        
        this.init();
    }

    init() {
        if (!this.navbarWrapper) return;
        
        // Set initial theme based on page
        this.setInitialTheme();
        
        // Set up scroll listener
        this.setupScrollListener();
        
        // Set up intersection observer for sections
        this.setupIntersectionObserver();
        
        // Set up resize listener
        this.setupResizeListener();
    }

    setInitialTheme() {
        const body = document.body;
        const pageClass = body.className;
        
        // Check if we're on a specific page type
        if (pageClass.includes('landing')) {
            this.setTheme('transparent');
        } else if (pageClass.includes('dashboard') || pageClass.includes('classes')) {
            this.setTheme('light');
        } else {
            // Default to transparent for other pages
            this.setTheme('transparent');
        }
    }

    setupScrollListener() {
        let ticking = false;
        
        const updateTheme = () => {
            const scrollY = window.scrollY;
            
            if (scrollY > this.scrollThreshold) {
                this.navbarWrapper.classList.add('visible');
            } else {
                this.navbarWrapper.classList.remove('visible');
            }
            
            // Update theme based on scroll position and content
            this.updateThemeBasedOnScroll(scrollY);
            
            ticking = false;
        };

        const requestTick = () => {
            if (!ticking) {
                requestAnimationFrame(updateTheme);
                ticking = true;
            }
        };

        window.addEventListener('scroll', requestTick, { passive: true });
    }

    setupIntersectionObserver() {
        const sections = document.querySelectorAll('section, .hero, .main, .classes-container');
        
        if (!sections.length) return;

        const options = {
            root: null,
            rootMargin: '-20% 0px -60% 0px',
            threshold: 0.1
        };

        this.intersectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.updateThemeBasedOnSection(entry.target);
                }
            });
        }, options);

        sections.forEach(section => {
            this.intersectionObserver.observe(section);
        });
    }

    setupResizeListener() {
        let resizeTimeout;
        
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.updateThemeBasedOnScroll(window.scrollY);
            }, 100);
        });
    }

    updateThemeBasedOnScroll(scrollY) {
        // Get the element at the current scroll position
        const elementAtScroll = document.elementFromPoint(window.innerWidth / 2, 50);
        
        if (elementAtScroll) {
            const backgroundColor = this.getBackgroundColor(elementAtScroll);
            const theme = this.determineThemeFromColor(backgroundColor);
            this.setTheme(theme);
        }
    }

    updateThemeBasedOnSection(section) {
        const backgroundColor = this.getBackgroundColor(section);
        const theme = this.determineThemeFromColor(backgroundColor);
        this.setTheme(theme);
    }

    getBackgroundColor(element) {
        let currentElement = element;
        let backgroundColor = null;
        
        // Walk up the DOM tree to find a background color
        while (currentElement && currentElement !== document.body) {
            const computedStyle = window.getComputedStyle(currentElement);
            const bgColor = computedStyle.backgroundColor;
            
            // Check if background color is not transparent
            if (bgColor && bgColor !== 'rgba(0, 0, 0, 0)' && bgColor !== 'transparent') {
                backgroundColor = bgColor;
                break;
            }
            
            currentElement = currentElement.parentElement;
        }
        
        // Fallback to body background
        if (!backgroundColor) {
            const bodyStyle = window.getComputedStyle(document.body);
            backgroundColor = bodyStyle.backgroundColor;
        }
        
        return backgroundColor;
    }

    determineThemeFromColor(backgroundColor) {
        if (!backgroundColor || backgroundColor === 'transparent') {
            return 'transparent';
        }
        
        // Convert RGB/RGBA to RGB values
        const rgb = this.parseColor(backgroundColor);
        if (!rgb) return 'transparent';
        
        // Calculate luminance
        const luminance = this.calculateLuminance(rgb.r, rgb.g, rgb.b);
        
        // Determine theme based on luminance
        if (luminance > 0.5) {
            return 'light'; // Light background - use dark text
        } else {
            return 'dark'; // Dark background - use light text
        }
    }

    parseColor(colorString) {
        // Handle rgb() and rgba() formats
        const rgbMatch = colorString.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*[\d.]+)?\)/);
        if (rgbMatch) {
            return {
                r: parseInt(rgbMatch[1]),
                g: parseInt(rgbMatch[2]),
                b: parseInt(rgbMatch[3])
            };
        }
        
        // Handle hex colors
        const hexMatch = colorString.match(/#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/);
        if (hexMatch) {
            return {
                r: parseInt(hexMatch[1], 16),
                g: parseInt(hexMatch[2], 16),
                b: parseInt(hexMatch[3], 16)
            };
        }
        
        return null;
    }

    calculateLuminance(r, g, b) {
        // Convert to relative luminance
        const [rs, gs, bs] = [r, g, b].map(c => {
            c = c / 255;
            return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
        });
        
        return 0.2126 * rs + 0.7152 * gs + 0.0722 * bs;
    }

    setTheme(theme) {
        if (this.currentTheme === theme) return;
        
        // Remove existing theme classes
        this.navbarWrapper.classList.remove('theme-light', 'theme-dark', 'theme-transparent');
        
        // Add new theme class
        this.navbarWrapper.classList.add(`theme-${theme}`);
        
        this.currentTheme = theme;
        
        // Trigger custom event for other scripts
        this.navbarWrapper.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: theme }
        }));
    }

    // Public method to manually set theme
    forceTheme(theme) {
        this.setTheme(theme);
    }

    // Public method to get current theme
    getCurrentTheme() {
        return this.currentTheme;
    }

    // Cleanup method
    destroy() {
        if (this.intersectionObserver) {
            this.intersectionObserver.disconnect();
        }
        
        window.removeEventListener('scroll', this.updateTheme);
        window.removeEventListener('resize', this.updateTheme);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.navbarThemeController = new NavbarThemeController();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NavbarThemeController;
}
