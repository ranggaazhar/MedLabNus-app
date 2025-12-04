{{-- resources/views/components/sections/delivery-banner.blade.php --}}
<section class="delivery-section">
    <div class="delivery-container">
        <div class="delivery-text reveal">
            <h2>
                Order now <strong>for delivery</strong><br>
                <strong>throughout Indonesia !</strong>
            </h2>
        </div>
        <div class="delivery-btn-wrapper reveal delay-200">
            <a href="{{ route('products.public') }}" class="btn-delivery">
                Order Now <span class="arrow">&gt;</span>
            </a>
        </div>
    </div>
</section>

<style>
/* --- DELIVERY BANNER --- */
.delivery-section {
    background: radial-gradient(circle at center, #8a1c21 0%, #1a0405 100%);
    padding: 80px 60px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.delivery-container {
    width: 100%;
    max-width: 1100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.delivery-text h2 {
    font-size: 42px;
    color: #ffffff;
    font-weight: 300;
    line-height: 1.2;
    margin: 0;
}

.delivery-text strong {
    font-weight: 700;
}

.btn-delivery {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    background-color: #b41f24;
    color: #ffffff;
    text-decoration: none;
    padding: 18px 30px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.btn-delivery:hover {
    background-color: #d6262c;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .delivery-section {
        padding: 60px 20px;
        text-align: center;
    }
    
    .delivery-container {
        flex-direction: column;
        gap: 30px;
    }
    
    .delivery-text h2 {
        font-size: 28px;
    }
    
    .btn-delivery {
        width: 100%;
        justify-content: center;
    }
}
</style>