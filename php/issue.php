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
        <link rel="stylesheet" href="../css/issue.css">
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
        <h2>Issues Management</h2>
        <div class="content">
            <div class="head">
                <div class="search-add-container">
                    <div class="search">
                        <form method="get">
                            <input type="text" placeholder="Search.." name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>">
                            <button type="submit" name="go"><i class="fa fa-search"></i></button>
                            <select class="by" name="searchBy">
                                <option value="0">Search by username</option>
                                <option value="1">Search by Book Title</option>
                                <option value="2">Search by Issue ID</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tbl">
                <table>
                    <tr>
                        <th>issue id</th>
                        <th>user id</th>
                        <th>book title</th>
                        <th>book id</th>
                        <th>user name</th>
                        <th>loan date</th>
                        <th>return date</th>
                        <th>fined</th>
                        <th>action</th>
                    </tr>
                    <?php
                        search_issue();
                        ?>
                </table>
            </div>
        </div>
    </body>

    </html>
    <script src="../js/issue.js"></script>
<?php
}
else 
{
    header('Location:login.php');
    exit();
}