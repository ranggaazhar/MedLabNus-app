<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Medlab Nusantara</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Keyframe Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100px);
            }
            to {
                transform: translateY(0);
            }
        }

        @keyframe drawPath {
            to {
                stroke-dashoffset: 0;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-slide-down {
            animation: slideDown 0.6s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
        }

        .reveal.active {
            opacity: 1;
        }

        /* SVG Path Animation */
        .animated-svg {
            stroke-dasharray: 3000;
            stroke-dashoffset: 3000;
            animation: drawPath 2s ease-out forwards;
        }
    </style>
</head>
<body class="w-full overflow-x-hidden bg-white" x-data="{ mobileMenuOpen: false, currentSlide: 0, totalSlides: 3 }">

    {{-- Navbar --}}
    @include('components.public-navbar')

    {{-- Hero Section --}}
    @include('components.hero')

    {{-- Profile Section --}}
    @include('components.company-profile')

    {{-- Visi Misi Section --}}
    @include('components.vision-mission')

    {{-- Delivery Section --}}
    @include('components.delivery-banner')

    {{-- Product Section --}}
    @include('components.product-collection')

    {{-- Footer --}}
    @include('components.footer')

    <script>
        // Scroll Reveal Animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        reveal(); // Initial check

        // Smooth Scroll with Animation
        document.querySelectorAll('.smooth-scroll').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('data-scroll-target') || this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    // Add animation class to target section
                    targetElement.style.animation = 'none';
                    setTimeout(() => {
                        targetElement.style.animation = 'fadeInUp 0.8s ease-out forwards';
                    }, 10);
                    
                    // Smooth scroll
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.querySelector('[x-data*="mobileMenuOpen"]');
                    if (mobileMenu && mobileMenu.__x && mobileMenu.__x.$data) {
                        mobileMenu.__x.$data.mobileMenuOpen = false;
                    }
                }
            });
        });
    </script>
