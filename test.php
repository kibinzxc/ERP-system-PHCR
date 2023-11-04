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
    <script src="https://kit.fontawesome.com/0d118bca32.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar">
            <a href="#" class="item">
            <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
            <a href="#" class="item">
                <i class="icon">🔍</i>
                <span>Search</span>
            </a>
            <a href="#" class="item">
                <i class="icon">🔍</i>
                <span>Search</span>
            </a>
            <button class = "item" onclick="toggleSidebar()">Toggle</button>
            <!-- Add more items as needed -->
        </div>

        <div class="content" style="background: pink;">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero quas soluta commodi, fugiat quasi pariatur iure amet unde earum quidem ad quibusdam vitae minus odit voluptas, quia rerum iste! Nesciunt.
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.content').classList.toggle('collapsed');
        }
    </script>
</body>

</html>