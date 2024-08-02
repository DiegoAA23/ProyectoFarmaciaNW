<section class="container-l WWList">
    <section class="depth-1 px-4 py-4">
        <h2>Lista de Usuarios</h2>
        <!--Buscador-->
        <section class="grid">
            <form action="index.php?page=Usuarios-Usuarios" method="post" class="row">
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
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{foreach usuarios}}
                <tr>
                    <td><a href="index.php?page=Usuarios-Usuario&mode=DSP&idUsuario={{idUsuario}}">{{nombreUsuario}}</a></td>
                    <td>{{correo}}</td>
                    <td>{{rol}}</td>
                    <td>{{estadoUsuario}}</td>
                    <td>
                        <a href="index.php?page=Usuarios-Usuario&mode=UPD&idUsuario={{idUsuario}}"> 
                            <i class="fa-solid fa-pen-to-square"></i>&nbsp; Editar
                        </a>

                    </td>
                </tr>
            {{endfor usuarios}}

        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">Total de registros: {{total}}</td>
            </tr>
        </tfoot>
    </table>
</section>