<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Medlab Nusantara</title>

    <!-- LINK CSS -->
    @vite(['resources/css/welcome.css'])
</head>
<body>

    <!-- NAVBAR -->
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logom.png') }}" alt="Hero Image" style="width: 50px;">
        </div>

        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Visi & Misi</a></li>
            <li><a href="#">Products</a></li>
        </ul>

        <a href="#" class="nav-shop-btn">
            <img src="{{ asset('icons/shop.svg') }}" class="icon-shop" alt="icon">
            Shop
        </a>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-text">
            <h1>PT Medlab<br>Nusantara</h1>
            <p>Welcome to our Company Profile Website</p>
            <a href="#" class="btn-shop">Shop Now</a>
        </div>

        <div class="hero-image">
            <img src="{{ asset('images/alatw.png') }}" alt="Lab Equipment">
        </div>
    </section>

</body>
</html>
