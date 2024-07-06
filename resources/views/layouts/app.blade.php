<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Supplier</title>
  <link rel="stylesheet" href="{{ asset('css/orderindex.css') }}">
  <link rel="stylesheet" href="{{ asset('css/inventoryindex.css') }}">

  @viteReactRefresh
    <!-- Load your Vite JavaScript bundle -->
    @vite('../resources/js/app.jsx')
  
</head>
<body>
<div id="hello-react"></div>
<div id="content">
@yield('content')
</div>

   
</body>
</html>










