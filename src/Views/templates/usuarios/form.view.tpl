<section class="grid">
    <section class="row">
        <h2 class="col-12 col-m-6 offset-m-3 depth-1 p-4">{{modeDsc}}</h2>
    </section>
</section>
<section class="grid">
    <section class="row my-4">
        <form class="col-12 col-m-6 offset-m-3 depth-1" action="index.php?page=Usuarios-Usuario&mode={{mode}}&idUsuario={{idUsuario}}" method="POST">
            <input type="hidden" name="idUsuario" value="{{idUsuario}}">
            <input type="hidden" name="xsrftk" value="{{xsrftk}}">
            <input type="hidden" name="mode" value="{{mode}}">

            <style>
                .readonly {
                    opacity: 0.6;
                    pointer-events: none;
                }
            </style>

            <div class="row my-4">
                <label class="col-4" for="idUsuario">Código:</label>
                <input class="col-8 readonly" type="text" name="idUsuario" id="idUsuario" value="{{idUsuario}}" readonly>
            </div>

            <div class="row my-4">
                <label class="col-4" for="nombreUsuario">Usuario:</label>
                <input class="col-8 readonly" type="text" name="nombreUsuario" id="nombreUsuario" value="{{nombreUsuario}}" readonly>
            </div>

            <div class="row my-4">
                <label class="col-4" for="correo">Correo:</label>
                <input class="col-8 readonly" type="text" name="correo" id="correo" value="{{correo}}" readonly>
            </div>

            <div class="row my-4">
                <label class="col-4" for="idRol">Rol:</label>
                <select class="col-8" name="idRol" id="idRol" required {{if isReadOnly}} readonly disabled {{endif isReadOnly}}>
                    <option value="1" {{prdcat1}}>Admin</option>
                    <option value="2" {{prdcat2}}>Cliente</option>
                </select>
                {{with errors}}
                    {{if error_idRol}}
                        {{foreach error_idRol}}
                            <div class="col-12 error">{{this}}</div>
                        {{endfor error_idRol}}
                    {{endif error_idRol}}
                {{endwith errors}}
            </div>

            <div class="row my-4">
                <label class="col-4" for="estadoUsuario">Estado:</label>
                <select class="col-8" name="estadoUsuario" id="estadoUsuario" required {{if isReadOnly}} readonly disabled {{endif isReadOnly}}>
                    <option value="ACT" {{prdestACT}}>Activo</option>
                    <option value="INA" {{prdestINA}}>Inactivo</option>
                </select>
                {{with errors}}
                    {{if error_estadoUsuario}}
                        {{foreach error_estadoUsuario}}
                            <div class="col-12 error">{{this}}</div>
                        {{endfor error_estadoUsuario}}
                    {{endif error_estadoUsuario}}
                {{endwith errors}}
            </div>

            <div class="row flex-end">
                {{ifnot isDisplay}}
                    <button type="submit" class="primary mx-2">
                        <i class="fa-solid fa-check"></i>&nbsp; Guardar
                    </button>
                {{endifnot isDisplay}}
                <button type="button" onclick="window.location='index.php?page=Usuarios-Usuarios'">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </button>
            </div>
        </form>
    </section>
</section>