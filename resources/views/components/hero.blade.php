{{-- resources/views/components/sections/hero.blade.php --}}
<section class="hero">
    {{-- Animated Background SVG --}}
    <div style="position: absolute; right: 0; top: 0; width: 65%; height: 100%; pointer-events: none; z-index: 0;">
        <svg style="position: absolute; right: -10%; top: 0; width: 110%; height: 100%;" viewBox="0 0 763 772"
            fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet">
            <path class="animated-svg"
                d="M1522.02 173.667C1532.65 122.466 1512.32 79.8514 1462.81 49.5997C1413.3 19.3481 1336.14 2.39258 1238.18 0.235254C1140.22 -1.92207 1024.47 10.7853 901.196 37.2318C777.917 63.6783 650.91 103.048 531.427 151.852C411.944 200.657 303.671 257.391 216.2 317.028C128.73 376.666 64.7604 437.366 29.9592 493.752C-4.84212 550.138 -9.40129 600.47 16.6855 640.289C42.7723 680.108 98.6998 708.186 179.514 722.034L274.45 664.033C206.799 652.44 159.98 628.936 138.142 595.602C116.305 562.269 120.121 520.135 149.254 472.933C178.387 425.73 231.937 374.917 305.161 324.993C378.385 275.069 469.022 227.576 569.044 186.72C669.067 145.865 775.387 112.908 878.587 90.7687C981.786 68.6298 1078.68 57.9921 1160.69 59.7981C1242.69 61.604 1307.28 75.7978 1348.72 101.122C1390.17 126.447 1407.2 162.12 1398.29 204.982L1522.02 173.667Z"
                fill="url(#paint0_linear_0_1)" />
            <path class="animated-svg"
                d="M1413.58 240.835C1396.64 194.308 1360.85 155.275 1308.67 126.436C1256.5 97.5981 1189.18 79.6431 1111.39 73.8139C1033.6 67.9848 947.186 74.4207 858.132 92.6764C769.079 110.932 679.511 140.572 595.627 179.544C511.743 218.516 435.547 265.89 372.31 318.387C309.074 370.885 260.308 427.253 229.387 483.589C198.466 539.926 186.129 594.887 193.228 644.668C200.328 694.449 226.695 737.861 270.506 771.901L348.395 726.884C310.934 697.777 288.387 660.655 282.316 618.088C276.245 575.52 286.795 528.524 313.235 480.351C339.676 432.178 381.375 383.978 435.448 339.088C489.521 294.198 554.676 253.688 626.404 220.364C698.133 187.039 774.721 161.694 850.87 146.084C927.019 130.474 1000.91 124.971 1067.43 129.955C1133.95 134.94 1191.51 150.293 1236.12 174.952C1280.74 199.612 1311.35 232.989 1325.83 272.773L1413.58 240.835Z"
                fill="url(#paint1_linear_0_1)" />
            <defs>
                <linearGradient id="paint0_linear_0_1" x1="816.418" y1="51.1381" x2="438.158" y2="623.663"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#B1252E" />
                    <stop offset="1" stop-color="#8B1E23" />
                </linearGradient>
                <linearGradient id="paint1_linear_0_1" x1="691.127" y1="140.087" x2="367.384" y2="475.681"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#B1252E" />
                    <stop offset="1" stop-color="#6D1519" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <div class="hero-content">
        {{-- Hero Text --}}
        <div class="hero-text">
            <h1>
                PT Medlab
                <br>
                <span class="text-gradient">Nusantara</span>
            </h1>
            <p>Welcome to our Company Profile Website</p>
            <a href="{{ route('products.public') }}" class="btn-shop">
                Shop Now
                <span class="arrow">&rarr;</span>
            </a>
        </div>

        {{-- Hero Image --}}
        <div class="hero-image">
            <div class="image-wrapper">
                <img src="{{ asset('images/welcome.png') }}" alt="Lab Equipment">
                
                {{-- Floating Elements --}}
                <div class="floating-blob floating-blob-1"></div>
                <div class="floating-blob floating-blob-2"></div>
            </div>
        </div>
    </div>
</section>

<style>
/* --- HERO SECTION --- */
.hero {
    position: relative;
    display: flex;
    align-items: center;
    height: 100vh;
    max-height: 900px;
    padding: 0 60px;
    overflow: hidden;
    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 50%, #ffffff 100%);
}

.hero-content {
    position: relative;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 1800px;
    margin: 0 auto;
    height: 100%;
}

/* --- HERO TEXT --- */
.hero-text {
    flex: 0 0 45%;
    opacity: 0;
    animation: fadeInLeft 0.8s ease-out forwards 0.3s;
}

.hero-text h1 {
    font-size: clamp(40px, 5vw, 72px);
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 20px 0;
    line-height: 1.1;
}

.hero-text h1 .text-gradient {
    background: linear-gradient(135deg, #B1252E 0%, #8f1d24 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-text p {
    margin: 0 0 28px 0;
    color: #6b7280;
    font-size: clamp(16px, 1.8vw, 18px);
    line-height: 1.6;
}

.btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #B1252E 0%, #8f1d24 100%);
    color: #fff;
    padding: 16px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 25px rgba(177, 37, 46, 0.3);
}

.btn-shop:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 20px 40px rgba(177, 37, 46, 0.4);
}

.btn-shop .arrow {
    font-size: 24px;
    transition: transform 0.3s ease;
}

.btn-shop:hover .arrow {
    transform: translateX(5px);
}

/* --- HERO IMAGE --- */
.hero-image {
    position: absolute;
    bottom: -20px;
    right: -50px;
    width: 60%;
    max-width: 900px;
    z-index: 5;
    opacity: 0;
    animation: scaleIn 0.8s ease-out forwards 0.5s;
}

.image-wrapper {
    position: relative;
    animation: float 4s ease-in-out infinite;
}

.hero-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Floating Decorative Elements */
.floating-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    opacity: 0.4;
    z-index: -1;
}

.floating-blob-1 {
    width: 180px;
    height: 180px;
    background: rgba(177, 37, 46, 0.2);
    bottom: 100px;
    left: -40px;
}

.floating-blob-2 {
    width: 220px;
    height: 220px;
    background: rgba(143, 29, 36, 0.2);
    top: 50px;
    right: -40px;
}

/* --- ANIMATIONS --- */
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

.animated-svg {
    stroke: url(#paint0_linear_0_1);
    stroke-width: 3;
    fill: url(#paint0_linear_0_1);
    stroke-dasharray: 3000;
    stroke-dashoffset: 3000;
    fill-opacity: 0;
    animation: drawStroke 1.5s ease-in-out forwards, fillShape 1.5s ease-in-out 1.5s forwards;
}

.animated-svg:nth-child(2) {
    animation: drawStroke 1.5s ease-in-out 0.3s forwards, fillShape 1.5s ease-in-out 1.8s forwards;
}

@keyframes drawStroke {
    to {
        stroke-dashoffset: 0;
    }
}

@keyframes fillShape {
    from {
        fill-opacity: 0;
    }
    to {
        fill-opacity: 1;
    }
}

/* --- RESPONSIVE --- */
@media (max-width: 1024px) {
    .hero {
        padding: 60px 40px;
        height: auto;
        min-height: 100vh;
    }
    
    .hero-content {
        flex-direction: column;
        justify-content: center;
    }
    
    .hero-text {
        flex: 1;
        text-align: center;
    }
    
    .hero-image {
        position: relative;
        width: 70%;
        max-width: 500px;
        margin-top: 40px;
    }
}

@media (max-width: 768px) {
    .hero {
        min-height: auto;
        height: auto;
        padding: 120px 24px 60px;
    }
    
    .hero-content {
        flex-direction: column;
        text-align: center;
    }
    
    .hero-text {
        flex: 1;
    }
    
    .hero-text h1 {
        font-size: 40px;
    }
    
    .hero-text p {
        font-size: 16px;
    }
    
    .hero-image {
        position: relative;
        width: 80%;
        max-width: 450px;
        margin: 40px auto 0;
    }
    
    /* Hide SVG background on mobile */
    .hero > div:first-child {
        display: none;
    }
    
    .floating-blob {
        display: none;
    }
}

@media (max-width: 480px) {
    .hero {
        padding: 80px 20px 40px;
    }
    
    .hero-text h1 {
        font-size: 36px;
        margin-bottom: 16px;
    }
    
    .hero-text p {
        font-size: 16px;
        margin-bottom: 24px;
    }
    
    .btn-shop {
        padding: 14px 32px;
        font-size: 16px;
    }
}
</style>