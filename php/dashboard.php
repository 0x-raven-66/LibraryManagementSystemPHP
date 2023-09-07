<?php ob_start();
session_start();
if ($_SESSION["isLogin"] == "true") 
{
    include_once "nav.php";
    include "function.php";

    ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- master css file-->
    <link rel="stylesheet" href="../css/dasboard.css">
    <!-- rendering all elements to normal -->
    <link rel="stylesheet" href="../css/normalize.css">
    <!-- fontawesome icons  -->
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <title>Library Management System</title>
</head>

<body>
    <h2>Dashboard</h2>
    <div class="dash">
        <div class="total-books">
            <h3>Total Books</h3>
            <p><?php count_books(); ?></p>
        </div>
        <div class="total-users">
            <h3>Total Users</h3>
            <p><?php count_users(); ?></p>
        </div>
        <div class="total-issued">
            <h3>Total Book Issue</h3>
            <p><?php count_issues(); ?></p>
        </div>
        <!-- <div class="total-return">
            <h3>Total Book Returned</h3>
            <p>6</p>
        </div>
        <div class="total-not-return">
            <h3>Total Book Not Returned</h3>
            <p>6</p>
        </div> -->
    </div>
</body>

</html>
<?php
}
else 
{
    header('Location:login.php');
    exit();
}