<section class="fullCenter">
  <form class="grid" method="post" action="index.php?page=sec_register">
    <section class="depth-1 row col-12 col-m-8 offset-m-2 col-xl-6 offset-xl-3">
      <h1 class="col-12">Crea tu cuenta</h1>
    </section>
    <section class="depth-1 py-5 row col-12 col-m-8 offset-m-2 col-xl-6 offset-xl-3">
      <div class="row">
        <label class="col-12 col-m-4 flex align-center" for="nombreUsuario">Nombre de Usuario</label>
        <div class="col-12 col-m-8">
          <input class="width-full" type="text" id="nombreUsuario" name="nombreUsuario" value="{{nombreUsuario}}" required />
        </div>
        {{if errorNombreUsuario}}
        <div class="error col-12 py-2 col-m-8 offset-m-4">{{errorNombreUsuario}}</div>
        {{endif errorNombreUsuario}}
      </div>
      <div class="row">
        <label class="col-12 col-m-4 flex align-center" for="correo">Correo Electrónico</label>
        <div class="col-12 col-m-8">
          <input class="width-full" type="email" id="correo" name="correo" value="{{correo}}" required />
        </div>
        {{if errorCorreo}}
        <div class="error col-12 py-2 col-m-8 offset-m-4">{{errorCorreo}}</div>
        {{endif errorCorreo}}
      </div>
      <div class="row">
        <label class="col-12 col-m-4 flex align-center" for="telefono">Teléfono</label>
        <div class="col-12 col-m-8">
          <input class="width-full" type="text" id="telefono" name="telefono" value="{{telefono}}" required />
        </div>
        {{if errorTelefono}}
        <div class="error col-12 py-2 col-m-8 offset-m-4">{{errorTelefono}}</div>
        {{endif errorTelefono}}
      </div>
      <div class="row">
        <label class="col-12 col-m-4 flex align-center" for="contra">Contraseña</label>
        <div class="col-12 col-m-8">
          <input class="width-full" type="password" id="contra" name="contra" value="{{contra}}" required />
        </div>
        {{if errorContra}}
        <div class="error col-12 py-2 col-m-8 offset-m-4">{{errorContra}}</div>
        {{endif errorContra}}
      </div>
      <div class="row right flex-end px-4">
        <button class="primary" id="btnRegister" type="submit">Crear Cuenta</button>
      </div>
    </section>
  </form>
</section>
