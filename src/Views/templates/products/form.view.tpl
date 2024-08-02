<section class="grid">
    <section class="row">
        <h2 class="col-12 col-m-6 offset-m-3 depth-1 p-4">{{modeDsc}}</h2>
    </section>
</section>
<section class="grid">
    <section class="row my-4">
    <form class="col-12 col-m-6 offset-m-3 depth-1" action="index.php?page=Products-Product&mode={{mode}}&idProducto={{idProducto}}" method="POST" >
        <input type="hidden" name="idProducto" value="{{idProducto}}">
        <input type="hidden" name="xsrftk" value="{{xsrftk}}">
        <input type="hidden" name="mode" value="{{mode}}">

        <div class="row my-4">
            <label class="col-4" for="nombreProducto">Nombre:</label>
            <input class="col-8" type="text" name="nombreProducto" id="nombreProducto" value="{{nombreProducto}}" required {{isReadOnly}}>
            {{with errors}}
                {{if error_nombreProducto}}
                    {{foreach error_nombreProducto}}
                        <div class="col-12 error">{{this}}</div>
                    {{endfor error_nombreProducto}}
                {{endif error_nombreProducto}}
            {{endwith errors}}
        </div>

        <div class="row my-4">
            <label class="col-4" for="precioProducto">Precio:</label>
            <input class="col-8" type="number" name="precioProducto" id="precioProducto" value="{{precioProducto}}" required {{isReadOnly}}>
            {{with errors}}
                {{if error_precioProducto}}
                    {{foreach error_precioProducto}}
                        <div class="col-12 error">{{this}}</div>
                    {{endfor error_precioProducto}}
                {{endif error_precioProducto}}
            {{endwith errors}}
        </div>

        <div class="row my-4">
            <label class="col-4" for="cantidadProducto">Cantidad:</label>
            <input class="col-8" type="number" name="cantidadProducto" id="cantidadProducto" value="{{cantidadProducto}}" required {{isReadOnly}}>
            {{with errors}}
                {{if error_cantidadProducto}}
                    {{foreach error_cantidadProducto}}
                        <div class="col-12 error">{{this}}</div>
                    {{endfor error_cantidadProducto}}
                {{endif error_cantidadProducto}}
            {{endwith errors}}
        </div>

        <div class="row my-4">
            <label class="col-4" for="imagenProducto">Enlace de Imagen:</label>
            <input class="col-8" type="text" name="imagenProducto" id="imagenProducto" value="{{imagenProducto}}" required {{isReadOnly}}>
            {{with errors}}
                {{if error_imagenProducto}}
                    {{foreach error_imagenProducto}}
                        <div class="col-12 error">{{this}}</div>
                    {{endfor error_imagenProducto}}
                {{endif error_imagenProducto}}
            {{endwith errors}}
        </div>

        <div class="row my-4">
            <label class="col-4" for="estadoProducto">Estado:</label>
            <select class="col-8" name="estadoProducto" id="estadoProducto" required {{if isReadOnly}} readonly disabled {{endif isReadOnly}}>
                <option value="ACT" {{prdestACT}}>Activo</option>
                <option value="INA" {{prdestINA}}>Inactivo</option>
            </select>
            {{with errors}}
                {{if error_estadoProducto}}
                    {{foreach error_estadoProducto}}
                        <div class="col-12 error">{{this}}</div>
                    {{endfor error_estadoProducto}}
                {{endif error_estadoProducto}}
            {{endwith errors}}
        </div>

        <div class="row flex-end">
            {{ifnot isDisplay}}
                <button type="submit" class="primary mx-2">
                    <i class="fa-solid fa-check"></i>&nbsp;
                    Guardar
                </button>
            {{endifnot isDisplay}}
            <button type="button" onclick="window.location='index.php?page=Products-Products'">
                <i class="fa-solid fa-xmark"></i>
                Cancelar
            </button>
        </div>
    </form>
    </section>
</section>