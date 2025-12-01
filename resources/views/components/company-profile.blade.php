{{-- resources/views/components/sections/company-profile.blade.php --}}
<section class="profile-section">
    <div class="profile-container">
        {{-- Image Side --}}
        <div class="profile-image-wrapper reveal">
            <div class="image-container">
                <img src="{{ asset('images/company.png') }}" alt="Company Profile Activity">
                
                {{-- Decorative Elements --}}
                <div class="decorative-blob decorative-blob-1"></div>
                <div class="decorative-blob decorative-blob-2"></div>
            </div>
        </div>

        {{-- Text Content --}}
        <div class="profile-text reveal delay-200">
            <div class="text-header">
                <div class="accent-line"></div>
                <h2>
                    Company
                    <br>
                    <span class="text-gradient">Profile</span>
                </h2>
            </div>

            <div class="text-content">
                <p>
                    PT Medlab Nusantara hadir untuk mendukung kebutuhan fasilitas kesehatan,
                    laboratorium, dan institusi medis dengan menyediakan produk yang terpercaya,
                    aman, dan sesuai standar nasional maupun internasional.
                </p>
                <p>
                    Dengan komitmen pada inovasi dan pelayanan profesional, kami memastikan
                    setiap pelanggan mendapatkan solusi kesehatan terbaik untuk meningkatkan
                    kualitas diagnosa dan layanan medis.
                </p>
            </div>
        </div>
    </div>
</section>

<style>
/* --- COMPANY PROFILE SECTION --- */
.profile-section {
    position: relative;
    width: 100%;
    padding: 120px 60px;
    background-color: #ffffff;
    overflow: hidden;
}

.profile-container {
    display: grid;
    grid-template-columns: 0.8fr 1.2fr;
    gap: 80px;
    align-items: center;
    max-width: 1600px;
    margin: 0 auto;
}

/* --- IMAGE SIDE --- */
.profile-image-wrapper {
    position: relative;
    max-width: 550px;
}

.image-container {
    position: relative;
    overflow: hidden;
    border-radius: 24px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

.image-container:hover {
    transform: scale(1.05);
}

.profile-image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
}

/* Decorative Blobs */
.decorative-blob {
    position: absolute;
    border-radius: 50%;
    opacity: 0.2;
    filter: blur(40px);
    z-index: -1;
}

.decorative-blob-1 {
    width: 150px;
    height: 150px;
    background: linear-gradient(135deg, #B1252E, #8f1d24);
    top: -40px;
    left: -40px;
}

.decorative-blob-2 {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #B1252E, #8f1d24);
    bottom: -40px;
    right: -40px;
}

/* --- TEXT CONTENT --- */
.profile-text {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.text-header {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.accent-line {
    width: 80px;
    height: 6px;
    background: linear-gradient(90deg, #B1252E, #8f1d24);
    border-radius: 3px;
    animation: expandWidth 0.8s ease-out forwards;
}

@keyframes expandWidth {
    from {
        width: 0;
    }
    to {
        width: 80px;
    }
}

.profile-text h2 {
    font-size: clamp(48px, 6vw, 20px);
    font-weight: 620;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.1;
}

.profile-text h2 .text-gradient {
    background: linear-gradient(135deg, #B1252E 0%, #8f1d24 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.text-content {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.text-content p {
    font-size: 18px;
    line-height: 1.8;
    color: #6b7280;
    margin: 0;
}

/* --- REVEAL ANIMATION --- */
.reveal {
    opacity: 0;
    transform: translateY(30px);
}

.reveal.active {
    opacity: 1;
    transform: translateY(0);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.reveal.delay-200.active {
    transition-delay: 0.2s;
}

/* --- RESPONSIVE --- */
@media (max-width: 1024px) {
    .profile-section {
        padding: 100px 40px;
    }
    
    .profile-container {
        grid-template-columns: 1fr 1fr;
        gap: 60px;
    }
    
    .profile-image-wrapper {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .profile-section {
        padding: 80px 24px;
    }
    
    .profile-container {
        grid-template-columns: 1fr;
        gap: 48px;
    }
    
    .profile-image-wrapper {
        max-width: 450px;
        margin: 0 auto;
    }
    
    .profile-text h2 {
        font-size: 40px;
    }
    
    .text-content p {
        font-size: 16px;
    }
    
    .decorative-blob {
        display: none;
    }
}

@media (max-width: 480px) {
    .profile-section {
        padding: 60px 20px;
    }
    
    .profile-text h2 {
        font-size: 36px;
    }
    
    .accent-line {
        width: 60px;
        height: 5px;
    }
}
</style>