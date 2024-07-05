<x-customerheader />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/customer-dashboard.css') }}" />
</head>
<body>
    
    <main class="container">
        <div id="product-menu" class="product-menu">
            <!-- Product cards will be appended here by JavaScript -->
        </div>
    </main>
    <script src="{{ asset('assets/js/customer-dashboard.js') }}"></script>
</body>
</html>

