<?php ob_start();
session_start();
if ($_SESSION["isLogin"] == "true") 
{
    include "nav.php";
    include "function.php";
    deleteUser();
    ?>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <!-- master css file-->
        <link rel="stylesheet" href="../css/users.css">
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
        <div id="pop-up-form">
            <div class="users-form">
                <form action="" method="post">
                    <button id="close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
                    <p>User Name</p>
                    <input type="text" name="userName" required>
                    <p>Email</p>
                    <input type="email" name="email" required>
                    <p>Phone Number</p>
                    <input type="text" name="phoneNum" required>
                    <p>Address</p>
                    <input type="text" name="address" required>
                    <button id="in-add-btn" type="submit" name="add-user">ADD</button>
                    <?php
                        add_user();
                    ?>
                </form>
            </div>
        </div>
        <h2>Users Management</h2>
        <div class="content">
            <div class="head">
                <div class="search-add-container">
                    <div class="search">
                    <form method="get">
                            <input type="text" placeholder="Search.." name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>">
                            <button type="submit" name="go"><i class="fa fa-search"></i></button>
                            <select class="by" name="searchBy" vlaue="<?php echo $_GET['searchBy'];?>">
                                <option value="0">Search by Name</option>
                                <option value="1">Search by ID</option>
                                <option value="2">Search by Email</option>
                            </select>
                        </form>
                    </div>
                    <div class="add">
                        <button id="out-add-btn" type="submit">Add User</button>
                    </div>
                </div>
            </div>
            <div class="tbl">
                <form method="post">
                    <table>
                        <tr>
                            <th>user id</th>
                            <th>user name</th>
                            <th>email</th>
                            <th>phone number</th>
                            <th>address</th>
                            <th>action</th>
                        </tr>
                        <?php
                            search_user();
                        ?>
                    </table>
                </form>
            </div>
        </div>
        <script src="../js/users.js"></script>
    </body>

    </html>
<?php
}
else 
{
    header('Location:login.php');
    exit();
}