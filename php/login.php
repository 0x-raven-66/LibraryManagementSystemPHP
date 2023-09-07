<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- master css file-->
    <link rel="stylesheet" href="../css/login.css">
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
    <div class="container">
        <!-- start header section -->
        <div class="header">
            <div class="logo">
                <i class="fa-solid fa-book"></i>
                <p>Library Management System</p>
            </div>
        </div>
        <!-- end header section -->
        <!-- start Login section -->
        <div class="login-card">
            <form action="" method="post">
                <div class="card-header">
                    <div class="logo">
                        <i class="fa-solid fa-user-gear"></i>
                        <p>Admin Panel</p>
                    </div>
                </div>
                <div class="card-body">
                <?php ob_start();
                    session_start();
                    $_SESSION["isLogin"] = false;
                    if (isset($_POST['log']))
                    {
                        $username = $_POST['username'];
                        $pass = $_POST['password'];
                        if ($username == "mohamed")
                        {
                            if ($pass == "123456") {
                                $_SESSION["isLogin"] = "true";
                                header('Location:dashboard.php');
                                exit();
                            }
                            else {
                                echo "username or password is not correct";
                            }
                        }
                        else {
                            echo "username or password is not correct";
                        }
                    }
                ?>
                    <p>Username</p>
                    <input type="text" name="username" required autofocus>
                    <p>Password</p>
                    <input type="password" name="password" required>
                    <input class="button" name="log" type="submit" value="Login">
                </div>
            </form>
        </div>
        <!-- end Login section -->
    </div>
</body>
</html>
