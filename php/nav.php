<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System</title>
    <!-- master css file-->
    <link rel="stylesheet" href="../css/nav.css">
    <!-- rendering all elements to normal -->
    <link rel="stylesheet" href="../css/normalize.css">
    <!-- fontawesome icons  -->
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="all">
        <header>
            <p>Library System</p>
            <form action="logout.php" method="post">
                <a href="logout.php" name="logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            </form>
        </header>
        <div class="navbar">
            <ul>
                <!-- Home -->
                <li><i class="fa-solid fa-chart-line"></i><a href="dashboard.php">Dashboard</a></li> 
                <!-- books -->
                <li><i class="fa-solid fa-book"></i><a href="books.php">Books</a></li> 
                <!-- issue books -->
                <li><i class="fa-solid fa-share-from-square"></i><a href="issue.php">Issue Books</a></li> 
                <!-- users -->
                <li><i class="fa-solid fa-users"></i><a href="users.php">Users</a></li> 
            </ul>
        </div>
    </div>
</body>
</html>