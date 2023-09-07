<?php ob_start();
session_start();
if ($_SESSION["isLogin"] == "true") 
{
    include_once "nav.php";
    include_once "function.php";

    ?>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <!-- master css file-->
        <link rel="stylesheet" href="../css/books.css">
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    </head>
    <body>
    <h2>Books Management => Loan book</h2> 
            <?php
                loan();
            ?>
    </body>
    </html>
<?php
}
else 
{
    header('Location:login.php');
    exit();
}