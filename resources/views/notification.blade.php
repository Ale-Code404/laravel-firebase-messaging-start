<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Formulario de Notificaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
  <div class="container mt-5">
    <h2>Integracion de notificaciones Push</h2>

    @if(session('notification.send.success'))
    <div class="alert alert-success mt-4">
      {{ session('notification.send.success') }}
    </div>
    @endif

    @if(session('notification.send.fail'))
    <div class="alert alert-danger mt-4">
      {{ session('notification.send.fail') }}
    </div>
    @endif

    <form class="mt-4" action="{{ route('notifications.campaings.create') }}" method="post">
      @csrf
      <div class="form-floating mb-3">
        <input type="text" name="title" class="form-control" placeholder="¡40%OFF en toda la tienda!" required>
        <label for="title">Titulo</label>
      </div>
      <div class="form-floating mb-3">
        <textarea name="description" class="form-control" required placeholder="Los primeros 200 clientes tendrán un..." rows="3"></textarea>
        <label for="description">Descripción</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" name="image" class="form-control" placeholder="https://" />
        <label for="image">Imagen</label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" name="token" class="form-control" placeholder="Token de registro FCM">
        <label for="token">Token del dispositivo</label>
      </div>
      <button type="submit" class="btn btn-primary">Enviar Notificación</button>
    </form>
  </div>
</body>

</html>