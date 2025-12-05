<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ICE STREET | Tienda Oficial</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anton&family=Archivo+Black&family=Roboto+Mono:wght@400;700&display=swap');

    :root { --primary-red: #D6001C; --bg-color: #FFFFFF; --text-color: #000000; }
    body { margin: 0; background-color: var(--bg-color); color: var(--text-color); font-family: 'Roboto Mono', monospace; overflow-x: hidden; }

    nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 5%; border-bottom: 4px solid var(--primary-red); background: white; position: sticky; top: 0; z-index: 100; }
    .logo { font-family: 'Archivo Black', sans-serif; font-size: 24px; color: var(--primary-red); text-transform: uppercase; font-style: italic; }
    .nav-links { display: flex; align-items: center; }
    .nav-links a { text-decoration: none; color: black; font-weight: bold; margin: 0 10px; font-size: 0.9rem; }
    .nav-links a:hover { color: var(--primary-red); }

    .cart-link { background-color: black; color: white; padding: 10px 15px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px; transition: 0.3s; }
    .cart-link:hover { background-color: var(--primary-red); }
    .cart-badge { background: white; color: black; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; }

    .hero { height: 55vh; background-color: var(--primary-red); display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white; background-image: radial-gradient(#ff4d6a 1px, transparent 1px); background-size: 20px 20px; }
    h1 { font-family: 'Archivo Black', sans-serif; font-size: 4.5rem; margin: 0; text-transform: uppercase; line-height: 0.9; }
    .hero p { letter-spacing: 3px; margin-bottom: 20px; font-weight: bold;}

    .category-header { text-align: center; background: black; color: white; padding: 10px 20px; margin-top: 50px; margin-bottom: 30px; font-family: 'Anton', sans-serif; font-size: 2rem; text-transform: uppercase; transform: skew(-5deg); display: inline-block; }
    .container { max-width: 1200px; margin: 0 auto; padding: 20px; text-align: center; }
    .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; }

    .product-card { border: 2px solid #f0f0f0; background: white; padding-bottom: 15px; transition: 0.2s; }
    .product-card:hover { border-color: var(--primary-red); transform: translateY(-5px); }
    .product-img { width: 100%; height: 260px; object-fit: cover; }
    
    .info { padding: 15px; text-align: left; }
    .name { font-weight: bold; display: block; font-size: 1.1rem; }
    .price { color: var(--primary-red); font-family: 'Anton', sans-serif; font-size: 1.3rem; }
    
    .btn-add { width: 90%; margin-left: 5%; padding: 12px; background: black; color: white; border: none; font-family: 'Roboto Mono', monospace; cursor: pointer; text-transform: uppercase; font-weight: bold; }
    .btn-add:hover { background: var(--primary-red); }

    .btn-wsp { position: fixed; bottom: 30px; right: 30px; background-color: #25D366; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; justify-content: center; align-items: center; text-decoration: none; box-shadow: 0 4px 10px rgba(0,0,0,0.3); z-index: 999; transition: transform 0.3s; border: 2px solid white; }
    .btn-wsp:hover { transform: scale(1.1); }
    .icon-wsp { width: 35px; height: 35px; }

    @media (max-width: 768px) {
        h1 { font-size: 3rem; }
        .grid { grid-template-columns: 1fr 1fr; gap: 10px; }
        .nav-links { display: none; }
        .product-img { height: 180px; }
    }
</style>
</head>
<body>

<nav>
    <div class="logo">ICE STREET</div>
    <div class="nav-links">
        <a href="#playeras">PLAYERAS</a>
        <a href="#gorras">GORRAS</a>

        <?php if(isset($_SESSION['nombre'])): ?>
            <span style="font-weight:bold; color:black; margin:0 10px; border-left: 2px solid #ccc; padding-left: 10px;">
                Hola, <?php echo strtoupper($_SESSION['nombre']); ?>
            </span>
            <a href="logout.php" style="color:var(--primary-red); font-size:0.8rem;">(SALIR)</a>
        <?php else: ?>
            <span style="border-left: 2px solid #ccc; margin: 0 10px; height: 20px;"></span>
            <a href="login.php">LOGIN</a>
            <a href="../registro.php" style="background:black; color:white; padding:5px 10px;">REGISTRO</a>
        <?php endif; ?>
    </div>

    <a href="carrito.php" class="cart-link">
        CARRITO <span class="cart-badge" id="cart-count">0</span>
    </a>
</nav>

<div class="hero">
    <p>// COLLECTION 2025 //</p>
    <h1>ICE<br>STREET</h1>
    <a href="#playeras" style="margin-top:20px; padding: 15px 30px; background:white; color:var(--primary-red); text-decoration:none; font-weight:bold;">VER CATÁLOGO</a>
</div>

<a href="#" class="btn-wsp" id="whatsapp-link" target="_blank">
    <svg class="icon-wsp" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.0316 0C5.39676 0 0 5.37367 0 11.9772C0 14.1207 0.563941 16.143 1.54576 17.9157L0.344053 22.3826L4.98634 21.1738C6.67841 22.0969 8.62147 22.6109 10.669 22.6109H10.7184C17.3532 22.6109 22.75 17.8447 22.75 11.2411C22.75 8.23667 21.5808 5.41263 19.4573 3.28821C17.3338 1.16379 14.5106 0 11.6916 0H12.0316ZM12.0628 19.7821H12.0347C10.3664 19.7821 8.73063 19.3323 7.30061 18.4842L6.96052 18.2818L3.43596 19.1997L4.37566 15.7601L4.15418 15.4082C3.2176 13.9189 2.72382 12.1932 2.72382 10.4216C2.72382 5.31215 6.89635 1.1557 12.0691 1.1557C14.5574 1.1557 16.8973 2.12484 18.6534 3.88457C20.4095 5.6443 21.3783 7.98399 21.3783 10.4746C21.3783 15.6315 17.2027 19.7821 12.0628 19.7821Z"/>
        <path d="M17.1328 14.3326C16.8552 14.1925 15.4889 13.5204 15.2331 13.427C14.9774 13.3336 14.7902 13.2869 14.6031 13.5669C14.416 13.8468 13.8824 14.4705 13.7202 14.6572C13.558 14.8439 13.3958 14.8672 13.1182 14.7272C12.8406 14.5872 11.9448 14.2932 10.8837 13.3491C10.0501 12.606 9.48712 11.6885 9.32483 11.4085C9.16255 11.1285 9.30758 10.9776 9.44634 10.8392C9.57113 10.7147 9.72398 10.5153 9.86125 10.352C9.99853 10.1886 10.0453 10.0719 10.1389 9.88523C10.2325 9.69854 10.1857 9.53523 10.1171 9.39521C10.0485 9.25519 9.48712 7.87856 9.25316 7.31871C9.0254 6.77332 8.79455 6.84805 8.6198 6.84805C8.45448 6.84805 8.26731 6.84805 8.08013 6.84805C7.89295 6.84805 7.5872 6.91807 7.3318 7.19812C7.07641 7.47817 6.35272 8.15486 6.35272 9.52906C6.35272 10.9033 7.35676 12.2335 7.49716 12.4202C7.63756 12.6069 9.48088 15.5401 12.3842 16.7126C14.2753 17.4761 14.9928 17.3827 15.6542 17.3205C16.3843 17.252 17.9066 16.4402 18.2217 15.5532C18.5367 14.6663 18.5367 13.9035 18.4431 13.7401C18.3495 13.5768 18.1623 13.5301 17.8847 13.3901H17.1328V14.3326Z"/>
    </svg>
</a>

<div class="container" id="playeras">
    <div><h2 class="category-header">/// PLAYERAS & HOODIES ///</h2></div>
    <div class="grid">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Box Logo White</span><span class="price">$450</span></div>
            <button class="btn-add" onclick="agregar('Box Logo White', 450, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800')">AGREGAR</button>
        </div>
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Oversize Black Tee</span><span class="price">$550</span></div>
            <button class="btn-add" onclick="agregar('Oversize Black Tee', 550, 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?q=80&w=800')">AGREGAR</button>
        </div>
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Graffiti V2 Limited</span><span class="price">$499</span></div>
            <button class="btn-add" onclick="agregar('Graffiti V2 Limited', 499, 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=800')">AGREGAR</button>
        </div>
         <div class="product-card">
            <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Urban Basic Black</span><span class="price">$1</span></div>
            <button class="btn-add" onclick="agregar('Urban Basic Black', 1, 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?q=80&w=800')">AGREGAR</button>
        </div>
    </div>
</div>

<div class="container" id="gorras">
    <div><h2 class="category-header" style="background: var(--primary-red);">/// HEADWEAR & GORRAS ///</h2></div>
    <div class="grid">
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Red Snapback OG</span><span class="price">$350</span></div>
            <button class="btn-add" onclick="agregar('Red Snapback OG', 350, 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?q=80&w=800')">AGREGAR</button>
        </div>
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1534215754734-18e55d13e346?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Black Bucket Hat</span><span class="price">$399</span></div>
            <button class="btn-add" onclick="agregar('Black Bucket Hat', 399, 'https://images.unsplash.com/photo-1534215754734-18e55d13e346?q=80&w=800')">AGREGAR</button>
        </div>
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1521369909029-2afed882baee?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Dad Cap White</span><span class="price">$299</span></div>
            <button class="btn-add" onclick="agregar('Dad Cap White', 299, 'https://images.unsplash.com/photo-1521369909029-2afed882baee?q=80&w=800')">AGREGAR</button>
        </div>
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?q=80&w=800" class="product-img">
            <div class="info"><span class="name">Trucker Mesh Cap</span><span class="price">$320</span></div>
            <button class="btn-add" onclick="agregar('Trucker Mesh Cap', 320, 'https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?q=80&w=800')">AGREGAR</button>
        </div>
    </div>
</div>

<footer style="background:black; color:white; padding:40px; text-align:center; margin-top:50px;">
    <h2>ICE STREET &copy; 2025</h2>
</footer>

<script>
    const MI_WHATSAPP = "529993580530"; 
    
    const btnWsp = document.getElementById('whatsapp-link');
    btnWsp.href = `https://wa.me/${MI_WHATSAPP}?text=Hola ICE STREET, tengo una duda sobre la ropa...`;

    let carrito = JSON.parse(localStorage.getItem('iceCart')) || [];
    actualizarContador();

    function agregar(nombre, precio, imagen) {
        const item = { nombre, precio, imagen };
        carrito.push(item);
        
        localStorage.setItem('iceCart', JSON.stringify(carrito));
        actualizarContador();
        
        let btn = event.target;
        let textoOriginal = btn.innerText;
        btn.innerText = "¡LISTO!";
        btn.style.backgroundColor = "#D6001C";
        setTimeout(() => {
            btn.innerText = textoOriginal;
            btn.style.backgroundColor = "black";
        }, 800);
    }

    function actualizarContador() {
        document.getElementById('cart-count').innerText = carrito.length;
    }
</script>

</body>

</html>
