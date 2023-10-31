<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Side Navigation</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="sidenav">
            <div class="icon" onmouseover="showTitle('Home')" onmouseout="hideTitle()">&#128736; Home</div>
            <div class="icon" onmouseover="showTitle('Profile')" onmouseout="hideTitle()">&#128100; Profile</div>
            <div class="icon" onmouseover="showTitle('Settings')" onmouseout="hideTitle()">&#9881; Settings</div>
        </div>
        <div class="content">
            <h2>Hover over the icons</h2>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
