{{-- resources/views/components/sections/vision-mission.blade.php --}}
<section id="visi-misi-section" class="visi-misi-section">
    {{-- Section Title --}}
    <div class="section-header reveal-fade">
        <h2 class="section-title">
            Visi & <span class="text-gradient">Misi</span>
        </h2>
        <div class="title-accent-line"></div>
    </div>

    <div class="visi-misi-container">
        {{-- Vision Row - Slide from LEFT --}}
        <div class="vm-row">
            <div class="vm-content reveal-left">
                <div class="vm-header">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <h3>Visi</h3>
                </div>
                
                <div class="accent-line"></div>
                
                <p>
                    Membantu dan Mempermudah Bagi Semua Kalangan Masyarakat
                    untuk Kebutuhan Alat-Alat Kesehatan, Laboratorium, dan
                    Kebutuhan Lainnya yang Sesuai dengan Kegiatan Perusahaan Kami.
                </p>
            </div>
            
            <div class="vm-image-box reveal-right">
                <img src="{{ asset('images/visi.jpg') }}" alt="Ilustrasi Visi">
            </div>
        </div>

        {{-- Mission Row - Slide from RIGHT --}}
        <div class="vm-row">
            <div class="vm-image-box reveal-left">
                <img src="{{ asset('images/misi.jpg') }}" alt="Ilustrasi Misi">
            </div>
            
            <div class="vm-content reveal-right">
                <div class="vm-header">
                    <div class="icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h3>Misi</h3>
                </div>
                
                <div class="accent-line"></div>
                
                <ul class="misi-list">
                    <li>
                        <div class="number-badge">1</div>
                        <p>Selalu berusaha untuk menjadi yang terbaik dalam melakukan sesuatu hal yang berkaitan dengan pelayanan terhadap konsumen.</p>
                    </li>
                    <li>
                        <div class="number-badge">2</div>
                        <p>Memberikan kepuasan dan menjamin mutu dalam penjualan produk sesuai dengan standar SNI.</p>
                    </li>
                    <li>
                        <div class="number-badge">3</div>
                        <p>Menjamin kinerja yang profesional dan tepat waktu sesuai keinginan konsumen.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
/* --- VISI & MISI SECTION --- */
.visi-misi-section {
    position: relative;
    padding: 120px 90px;
    background: linear-gradient(135deg, #f9fafb 0%, #ffffff 50%, #f9fafb 100%);
    overflow: hidden;
}

/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 100px;
}

.section-title {
    font-size: clamp(48px, 6vw, 20px);
    font-weight: 620;
    color: #1a1a1a;
    margin: 0 0 16px 0;
}

.section-title .text-gradient {
    background: linear-gradient(135deg, #B1252E 0%, #8f1d24 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.title-accent-line {
    width: 96px;
    height: 6px;
    background: linear-gradient(90deg, #B1252E, #8f1d24);
    border-radius: 3px;
    margin: 0 auto;
}

/* Container */
.visi-misi-container {
    display: flex;
    flex-direction: column;
    gap: 120px;
    max-width: 1600px;
    margin: 0 auto;
}

/* VM Row */
.vm-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 80px;
}

/* VM Content */
.vm-content {
    flex: 1.2;
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.vm-header {
    display: flex;
    align-items: center;
    gap: 16px;
}

.icon-box {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #B1252E, #8f1d24);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(177, 37, 46, 0.3);
    flex-shrink: 0;
}

.icon-box svg {
    width: 32px;
    height: 32px;
    color: #ffffff;
}

.vm-content h3 {
    font-size: clamp(36px, 4vw, 36px);
    font-weight: 500;
    margin: 0;
    color: #1a1a1a;
}

.accent-line {
    width: 64px;
    height: 4px;
    background: linear-gradient(90deg, #B1252E, #8f1d24);
    border-radius: 2px;
}

.vm-content p {
    font-size: 18px;
    line-height: 1.8;
    color: #6b7280;
    margin: 0;
}

/* Misi List */
.misi-list {
    display: flex;
    flex-direction: column;
    gap: 24px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.misi-list li {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.number-badge {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    background: rgba(177, 37, 46, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #B1252E;
    font-size: 16px;
    margin-top: 4px;
}

.misi-list li p {
    flex: 1;
    font-size: 17px;
    line-height: 1.8;
    color: #6b7280;
    margin: 0;
}

/* VM Image Box */
.vm-image-box {
    flex: 0.8;
    display: flex;
    justify-content: center;
    align-items: center;
}

.vm-image-box img {
    width: 100%;
    max-width: 515px;
    height: 484px;
    object-fit: cover;
    border-radius: 100px 100px 100px 240px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    display: block;
    transition: transform 0.3s ease;
}

.vm-image-box img:hover {
    transform: scale(1.05);
}

/* --- REVEAL ANIMATIONS --- */
/* Fade In for Title */
.reveal-fade {
    opacity: 0;
    transform: translateY(-20px);
}

.reveal-fade.active {
    opacity: 1;
    transform: translateY(0);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Slide from LEFT */
.reveal-left {
    opacity: 0;
    transform: translateX(-100px);
}

.reveal-left.active {
    opacity: 1;
    transform: translateX(0);
    transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Slide from RIGHT */
.reveal-right {
    opacity: 0;
    transform: translateX(100px);
}

.reveal-right.active {
    opacity: 1;
    transform: translateX(0);
    transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
}

/* --- RESPONSIVE --- */
@media (max-width: 1024px) {
    .visi-misi-section {
        padding: 100px 60px;
    }
    
    .visi-misi-container {
        gap: 100px;
    }
    
    .vm-row {
        gap: 60px;
    }
}

@media (max-width: 768px) {
    .visi-misi-section {
        padding: 80px 24px;
    }
    
    .section-header {
        margin-bottom: 60px;
    }
    
    .section-title {
        font-size: 40px;
    }
    
    .title-accent-line {
        width: 80px;
        height: 5px;
    }
    
    .visi-misi-container {
        gap: 80px;
    }
    
    .vm-row {
        flex-direction: column;
        gap: 40px;
    }
    
    .vm-content {
        text-align: left;
    }
    
    .vm-content h3 {
        font-size: 32px;
    }
    
    .icon-box {
        width: 56px;
        height: 56px;
    }
    
    .icon-box svg {
        width: 28px;
        height: 28px;
    }
    
    .vm-image-box {
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
    }
    
    .vm-image-box img {
        height: 350px;
        max-width: 100%;
        border-radius: 60px 60px 60px 120px;
    }
    
    .vm-content p,
    .misi-list li p {
        font-size: 16px;
    }
    
    /* Mobile: all animations from bottom */
    .reveal-left,
    .reveal-right {
        transform: translateY(30px);
    }
    
    .reveal-left.active,
    .reveal-right.active {
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .visi-misi-section {
        padding: 60px 20px;
    }
    
    .section-title {
        font-size: 32px;
    }
    
    .vm-content h3 {
        font-size: 28px;
    }
    
    .vm-image-box img {
        height: 300px;
    }
}
</style>

<script>
// Scroll Animation Trigger
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    // Observe all reveal elements
    document.querySelectorAll('.reveal-fade, .reveal-left, .reveal-right').forEach(el => {
        observer.observe(el);
    });
});
</script>