<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="src/bootstrap/js/bootstrap.min.js"></script>
    <script src="src/bootstrap/js/bootstrap.js"></script>
</head>

<body style="background: gray;">
    <div class="container-fluid" style="background: red; width: 100%">
        <div class="row">
            <div class="col-md-2" style="background: blue; padding:0;">
                    <button onclick="toggleSidebar()">Toggle</button>
                    <div class="item">
                        <i class="icon">🏠</i>
                        <span>Home</span>
                    </div>
                    <div class="item">
                        <i class="icon">🔍</i>
                        <span>Search</span>
                    </div>
                    <!-- Add more items as needed -->
            </div>

            <div class="col-md-10" style="background: pink;">
                Column
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.col-md-2').classList.toggle('collapsed');
        }
    </script>
</body>

</html>
