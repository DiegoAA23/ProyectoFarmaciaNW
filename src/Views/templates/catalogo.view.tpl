<h1 class="titulo">Catálogo de Productos</h1>
 <div>
        <a href="index.php?page=Carretilla_Carreta" class="card">VER CARRITO</a>
    </div>
<div class="container">
    {{foreach productos}}
    <div class="card">
        <input type="hidden" name="id" id="id" value="{{idProducto}}">
        <img src="{{imagenProducto}}" alt="Imagen del producto">
        <h3>{{nombreProducto}}</h3>
        <p class="price">$ {{precioProducto}}</p>
        <p class="stock">Stock: {{cantidadProducto}}</p>
        <div class="cantidad-botones">
            <button class="disminuir">-</button>
            <input type="number" name="cantidad" id="cantidad" class="cantidad" value="1" min="1"
                data-max="{{cantidadProducto}}" disabled>
            <button class="aumentar">+</button>
        </div>
        <button class="agregar-carrito" data-id="{{idProducto}}" data-nombre="{{nombreProducto}}"
            data-precio="{{precioProducto}}" data-cantidad="{{cantidadProducto}}">
            Agregar al Carrito
        </button>
    </div>
    {{endfor productos}}
</div>

<script>
    document.querySelectorAll('.cantidad-botones').forEach(function (control) {
        const disminuirButton = control.querySelector('.disminuir');
        const aumentarButton = control.querySelector('.aumentar');
        const cantidadInput = control.querySelector('.cantidad');
        const maxcantidad = parseInt(cantidadInput.getAttribute('data-max'), 10);

        disminuirButton.addEventListener('click', function () {
            let currentValue = parseInt(cantidadInput.value, 10);
            if (currentValue > 1) {
                cantidadInput.value = currentValue - 1;
            }
        });

        aumentarButton.addEventListener('click', function () {
            let currentValue = parseInt(cantidadInput.value, 10);
            if (currentValue < maxcantidad) {
                cantidadInput.value = currentValue + 1;
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.agregar-carrito').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const precio = button.getAttribute('data-precio');
                const cantidad = button.getAttribute('data-cantidad');
                fetch('index.php?page=Carretilla_Carretilla', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id: id,
                        nombre: nombre,
                        precio: precio,
                        cantidad: cantidad
                    })
                })
                .then(response => response.text())
                .then(result => {
                    alert('Producto Agregado');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
