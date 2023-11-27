<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Formulario de Notificaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<style>
  .form-floating>.form-control::placeholder {
    color: rgba(0, 0, 0, 0.4);
  }

  .form-floating>.form-control:not(:focus)::placeholder {
    color: transparent;
  }
</style>

<body>
  <div class="container-lg mt-5">
    <h2>Integracion de notificaciones Push</h2>

    @if (session('notification.send.success'))
      <div class="alert alert-success mt-4">
        {{ session('notification.send.success') }}
      </div>
    @endif

    @if (session('notification.send.response'))
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Respuesta</h5>
          <pre>{{ session('notification.send.response') }}</pre>
        </div>
      </div>
    @endif

    @if (session('notification.send.fail'))
      <div class="alert alert-danger mt-4">
        {{ session('notification.send.fail') }}
      </div>
    @endif

    <form class="d-flex flex-column mt-4 gap-4" action="{{ route('notifications.campaings.create') }}" method="post">
      @csrf
      <div class="form-floating">
        <input type="text" name="title" class="form-control" placeholder="¡40%OFF en toda la tienda!" required
          value="{{ old('remain') ? old('title', '') : '' }}">
        <label for="title">Titulo</label>
      </div>
      <div class="form-floating">
        <textarea name="description" class="form-control" required placeholder="Los primeros 200 clientes tendrán un..."
          rows="3">{{ old('remain') ? old('description', '') : '' }}</textarea>
        <label for="description">Descripción</label>
      </div>
      <div class="form-floating">
        <input type="text" name="image" class="form-control" placeholder="https://"
          value="{{ old('remain') ? old('image', '') : '' }}" />
        <label for="image">Imagen</label>
      </div>
      <div class="form-floating">
        <input type="text" name="token" class="form-control" placeholder="Token de registro FCM"
          value="{{ old('remain') ? old('token', '') : '' }}">
        <label for="token">Token del dispositivo</label>
      </div>
      <div class="form-check">
        <input type="checkbox" name="remain" class="form-check-input" @checked(old('remain', true)) />
        <label class="form-check-label">
          Recordar los datos despues de enviar
        </label>
      </div>
      <button type="submit" class="btn btn-primary">Enviar notificación</button>
    </form>
  </div>
</body>

</html>
