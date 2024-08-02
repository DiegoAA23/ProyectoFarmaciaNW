<section class="container-l WWList">
    <section class="depth-1 px-4 py-4">
        <h2>Lista de Productos</h2>
        <!--Buscador-->
        <section class="grid">
            <form action="index.php?page=Products-Products" method="post" class="row">
                <input class="col-8" type="text" name="search" placeholder="Buscar por nombre" value="{{search}}">
                <button class="col-4" type="submit"> 
                <i class="fa-solid fa-magnifying-glass"></i>&nbsp; Buscar
                </button>
            </form>
        </section>
    </section>
    
    <table class="my-4">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th><a href="index.php?page=Products-Product&mode=INS">
                <i class="fa-solid fa-file-circle-plus"></i>&nbsp; Nuevo Producto</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach products}}
                <tr>
                    <td>{{idProducto}}</td>
                    <td><a href="index.php?page=Products-Product&mode=DSP&idProducto={{idProducto}}">{{nombreProducto}}</a></td>
                    <td>{{precioProducto}}</td>
                    <td>{{cantidadProducto}}</td>
                    <td>{{imagenProducto}}</td>
                    <td>{{estadoProducto}}</td>
                    <td>
                        <a href="index.php?page=Products-Product&mode=UPD&idProducto={{idProducto}}"> 
                            <i class="fa-solid fa-pen-to-square"></i>&nbsp; Editar
                        </a>
                        &nbsp;
                        &nbsp;
                        <a href="index.php?page=Products-Product&mode=DEL&idProducto={{idProducto}}">
                            <i class="fa-solid fa-trash-can"></i> &nbsp;
                            Eliminar
                        </a>
                    </td>
                </tr>
            {{endfor products}}

        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">Total de registros: {{total}}</td>
            </tr>
        </tfoot>
    </table>
</section>