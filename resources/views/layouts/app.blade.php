<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Supplier</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- Custom CSS Files -->
  <link rel="stylesheet" href="{{ asset('css/orderindex.css') }}">
  <link rel="stylesheet" href="{{ asset('css/inventoryindex.css') }}">

  <!-- React and Vite -->
  @viteReactRefresh
  @vite('resources/js/app.jsx')
</head>
<body>
  <div id="hello-react" data-user="{{ json_encode(Auth::user()) }}" data-role="{{ Auth::user()->is_admin ? 'admin' : 'customer' }}"></div>
  <div id="content">
    @yield('content')
  </div>

  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Admin jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Admin DataTables JS -->
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>

  <!-- Include pushed scripts -->
  @stack('scripts')
</body>
</html>
