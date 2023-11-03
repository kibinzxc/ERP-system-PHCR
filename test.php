<!DOCTYPE html>
<html>
<head>
    <style>
        .sidebar {
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        .sidebar .item {
            display: flex;
            align-items: center;
            padding: 10px;
        }
        .sidebar .item i {
            margin-right: 10px;
        }
        .sidebar .item span {
            transition: all 0.5s ease;
        }
        .sidebar.collapsed .item span  {
            display: none;
        }
        .sidebar.collapsed{
            width: 50px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
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

    <div class="content">
        <h1>Content</h1>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        }
    </script>
</body>
</html>