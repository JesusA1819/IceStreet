<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ICE STREET | Pago Seguro</title>

<script src="https://www.paypal.com/sdk/js?client-id=TU_CLIENT_ID_DE_PAYPAL_AQUI&currency=MXN"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Anton&family=Archivo+Black&family=Roboto+Mono:wght@400;700&display=swap');
    
    body { margin: 0; background-color: #f4f4f4; font-family: 'Roboto Mono', monospace; }
    
    .header { background: black; color: white; padding: 25px; text-align: center; border-bottom: 4px solid #D6001C; position: relative; }
    .logo { font-family: 'Archivo Black'; font-size: 24px; color: #D6001C; font-style: italic; }

    .btn-home {
        position: absolute; top: 25px; right: 30px;
        text-decoration: none; color: white; font-weight: bold;
        border: 2px solid white; padding: 8px 20px; font-size: 0.9rem;
        background-color: black; transition: 0.3s; text-transform: uppercase;
    }
    .btn-home:hover { background: #D6001C; border-color: #D6001C; }

    .checkout-container { display: flex; flex-wrap: wrap; max-width: 1000px; margin: 40px auto; gap: 30px; padding: 20px; }
    .products-list { flex: 3; }
    .products-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    
    .item-row { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 15px 0; }
    .item-img { width: 70px; height: 70px; object-fit: cover; border-radius: 5px; margin-right: 15px; }
    .item-details { flex-grow: 1; }
    .item-name { font-weight: bold; font-size: 1rem; display: block; }
    .item-price { color: #D6001C; font-weight: bold; }
    .btn-remove { color: #999; cursor: pointer; font-size: 0.8rem; text-decoration: underline; background: none; border: none; }

    .payment-section { flex: 2; background: white; padding: 30px; height: fit-content; border-radius: 8px; border-top: 5px solid #D6001C; }
    .summary-title { font-family: 'Anton'; font-size: 1.5rem; margin-bottom: 20px; text-transform: uppercase; }
    .form-group { margin-bottom: 15px; }
    .form-label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; }
    .form-input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: 'Roboto Mono'; box-sizing: border-box; }
    .form-input:focus { border-color: #D6001C; outline: none; }
    .total-row { display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold; margin: 20px 0; border-top: 2px solid #eee; padding-top: 20px; }
    .locked-payment { opacity: 0.5; pointer-events: none; position: relative; }
    .unlock-msg { color: red; font-size: 0.8rem; text-align: center; margin-bottom: 10px; font-weight: bold; display: block; }
    .empty-msg { text-align: center; padding: 50px; color: #777; }
    
    .btn-mercadopago {
        width: 100%; background-color: #009EE3; color: white; border: none; padding: 12px;
        border-radius: 4px; font-family: sans-serif; font-size: 1rem; font-weight: bold;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 15px;
        transition: 0.3s;
    }
    .btn-mercadopago:hover { background-color: #007bb0; }
    .divider { text-align: center; margin: 15px 0; color: #aaa; font-size: 0.8rem; }
    
    .login-wall { text-align: center; padding: 50px; background: white; max-width: 500px; margin: 50px auto; border-top: 5px solid #D6001C; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .btn-auth { display: inline-block; padding: 15px 30px; margin: 10px; text-decoration: none; font-weight: bold; color: white; background: black; transition: 0.3s; }
    .btn-auth:hover { background: #D6001C; }

    /* Spinner de carga */
    .loader { border: 4px solid #f3f3f3; border-top: 4px solid #009EE3; border-radius: 50%; width: 20px; height: 20px; animation: spin 1s linear infinite; display: none; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    @media (max-width: 768px) { 
        .checkout-container { flex-direction: column; } 
        .btn-home { position: static; display: block; margin: 15px auto 0 auto; width: fit-content;}
    }
</style>
</head>
<body>

<div class="header">
    <div class="logo">ICE STREET // CHECKOUT</div>
    <a href="index.php" class="btn-home">⬅ VOLVER A LA TIENDA</a>
</div>

<?php if (isset($_SESSION['nombre'])): ?>
    <div class="checkout-container">
        <div class="products-list" id="lista-productos"></div>

        <div class="payment-section" id="panel-pago">
            <div class="summary-title">Datos de Envío</div>
            <div class="form-group">
                <label class="form-label">Nombre Completo:</label>
                <input type="text" class="form-input" id="cliente-nombre" value="<?php echo $_SESSION['nombre']; ?>" placeholder="Ej: Juan Pérez" oninput="validarFormulario()">
            </div>
            <div class="form-group">
                <label class="form-label">Dirección de Entrega:</label>
                <input type="text" class="form-input" id="cliente-direccion" placeholder="Calle, Número, Colonia, Ciudad" oninput="validarFormulario()">
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono / WhatsApp:</label>
                <input type="tel" class="form-input" id="cliente-tel" placeholder="Para contactarte" oninput="validarFormulario()">
            </div>
            <div class="total-row">
                <span>TOTAL:</span>
                <span>$<span id="total-price">0</span> MXN</span>
            </div>
            <span id="mensaje-bloqueo" class="unlock-msg">* Llena tus datos para habilitar el pago *</span>
            <div id="zona-pagos" class="locked-payment">
                <div id="paypal-button-container"></div>
                
                <div class="divider">- O TAMBIÉN -</div>

                <button class="btn-mercadopago" id="btn-mp" onclick="procesarMercadoPago()">
                    <span id="txt-mp">Pagar con Mercado Pago (Tarjetas / OXXO)</span>
                    <div class="loader" id="loader-mp"></div>
                </button>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="login-wall">
        <h2 style="font-family:'Anton'; font-size: 2rem;">🔒 ACCESO REQUERIDO</h2>
        <p>Para asegurar tu pedido, necesitas identificarte.</p>
        <br>
        <a href="login.php" class="btn-auth">INICIAR SESIÓN</a>
        <a href="registro.php" class="btn-auth" style="background:#D6001C">CREAR CUENTA</a>
    </div>
<?php endif; ?>

<script>
    const TU_WHATSAPP = "529993580530"; // Tu número real
    let carrito = JSON.parse(localStorage.getItem('iceCart')) || [];
    const listaDiv = document.getElementById('lista-productos');
    let total = 0;
    let listaTextoPlana = ""; 

    function renderizarCarrito() {
        if (!listaDiv) return;

        if (carrito.length === 0) {
            listaDiv.innerHTML = `<div class="products-box empty-msg"><h3>CARRITO VACÍO</h3><a href="index.php" class="btn-back">VOLVER</a></div>`;
            document.getElementById('panel-pago').style.display = 'none';
            return;
        }

        document.getElementById('panel-pago').style.display = 'block';
        listaDiv.innerHTML = '<div class="products-box">'; 
        total = 0;
        let nombresProd = [];

        carrito.forEach((prod, index) => {
            total += prod.precio;
            nombresProd.push(prod.nombre);
            listaDiv.innerHTML += `
                <div class="item-row">
                    <img src="${prod.imagen}" class="item-img">
                    <div class="item-details">
                        <span class="item-name">${prod.nombre}</span>
                        <span class="item-price">$${prod.precio} MXN</span>
                        <br><button class="btn-remove" onclick="eliminar(${index})">Eliminar</button>
                    </div>
                </div>`;
        });
        listaDiv.innerHTML += '</div>';
        document.getElementById('total-price').innerText = total;
        listaTextoPlana = nombresProd.join(", ");
        validarFormulario();
    }

    function eliminar(indice) {
        carrito.splice(indice, 1);
        localStorage.setItem('iceCart', JSON.stringify(carrito));
        renderizarCarrito();
        location.reload();
    }

    function validarFormulario() {
        const nombreInput = document.getElementById('cliente-nombre');
        if(!nombreInput) return;
        const nombre = nombreInput.value;
        const direccion = document.getElementById('cliente-direccion').value;
        const tel = document.getElementById('cliente-tel').value;
        const zonaPagos = document.getElementById('zona-pagos');
        const mensaje = document.getElementById('mensaje-bloqueo');

        if(nombre.length > 3 && direccion.length > 5 && tel.length > 5) {
            zonaPagos.classList.remove('locked-payment');
            mensaje.style.display = 'none';
        } else {
            zonaPagos.classList.add('locked-payment');
            mensaje.style.display = 'block';
        }
    }

    // --- FUNCIÓN WHATSAPP DE RESPALDO ---
    function enviarTicket(metodo) {
        const nombre = document.getElementById('cliente-nombre').value;
        const direccion = document.getElementById('cliente-direccion').value;
        const tel = document.getElementById('cliente-tel').value;
        const ordenID = "ICE-" + Math.floor(Math.random() * 100000);
        let mensaje = `🧾 *NUEVO PEDIDO PAGADO*`;
        mensaje += `%0A🆔 *ID:* ${ordenID}`;
        mensaje += `%0A👤 *Cliente:* ${nombre}`;
        mensaje += `%0A📍 *Dirección:* ${direccion}`;
        mensaje += `%0A💳 *Método:* ${metodo}`;
        mensaje += `%0A📦 *Productos:* ${listaTextoPlana}`;
        mensaje += `%0A💰 *TOTAL:* $${total}`;
        localStorage.removeItem('iceCart');
        window.location.href = `https://wa.me/${TU_WHATSAPP}?text=${mensaje}`;
    }

    renderizarCarrito();

    // --- PAYPAL REAL ---
    if(total > 0) {
        paypal.Buttons({
            createOrder: function(data, actions) {
                const nombreCliente = document.getElementById('cliente-nombre').value;
                const direccionCliente = document.getElementById('cliente-direccion').value;
                return actions.order.create({ purchase_units: [{ description: `Pedido ICE: ${listaTextoPlana}`, amount: { value: total } }] });
            },
            onApprove: function(data, actions) { 
                return actions.order.capture().then(function(details) { 
                    enviarTicket("PayPal (Tarjeta Aprobada)"); 
                }); 
            }
        }).render('#paypal-button-container');
    }

    // --- MERCADO PAGO REAL (CONEXIÓN PHP) ---
    async function procesarMercadoPago() {
        const btn = document.getElementById('btn-mp');
        const loader = document.getElementById('loader-mp');
        const txt = document.getElementById('txt-mp');

        // Efecto de carga
        btn.disabled = true;
        txt.style.display = 'none';
        loader.style.display = 'block';

        // Enviamos el carrito al archivo PHP
        try {
            const respuesta = await fetch('crear_preferencia.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ items: carrito })
            });

            const datos = await respuesta.json();

            if (datos.init_point) {
                // REDIRIGIR AL CHECKOUT REAL DE MERCADO PAGO
                window.location.href = datos.init_point;
            } else {
                alert("Error al conectar con Mercado Pago. Revisa tu Access Token.");
                btn.disabled = false;
                txt.style.display = 'block';
                loader.style.display = 'none';
            }
        } catch (error) {
            console.error(error);
            alert("Error del servidor.");
            btn.disabled = false;
        }
    }
</script>

</body>
</html>