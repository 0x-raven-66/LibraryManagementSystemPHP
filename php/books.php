<?php ob_start();
session_start();
if ($_SESSION["isLogin"] == "true") 
{
    include_once "nav.php";
    include_once "function.php";
    deleteBook();
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
    </head>

    <body>
        <div id="pop-up-form">
            <div class="books-form">
                <form action="" method="post">
                    <button id="close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
                    <p>Book Title</p>
                    <input type="text" name="bookName" required>
                    <p>Category</p>
                    <input type="text" name="Category" required>
                    <p>Author</p>
                    <input type="text" name="Author" required>
                    <p>Rack Number</p>
                    <input type="text" name="rackNum" required>
                    <p>Number of Copies</p>
                    <input type="number" name="copiesNum" required>
                    <button id="in-add-btn" type="submit" name="add-book">ADD</button>
                    <?php
                        add_book();
                    ?>
                </form>
            </div>
        </div>
        <h2>Books Management</h2>
        <div class="content">
            <div class="head">
                <div class="search-add-container">
                    <div class="search">
                        <form method="get">
                            <input type="text" placeholder="Search.." name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>">
                            <button type="submit" name="go"><i class="fa fa-search"></i></button>
                            <select class="by" name="searchBy">
                                <option value="0">Search by Title</option>
                                <option value="1">Search by Category</option>
                                <option value="2">Search by Auther</option>
                                <option value="3">Search by ID</option>
                            </select>
                        </form>
                    </div>
                    <div class="add">
                        <button id="out-add-btn" type="submit">Add Book</button>
                    </div>
                </div>
            </div>
            <div class="tbl">
                <form method="post">
                    <table>
                        <tr>
                            <th>book ID</th>
                            <th>book title</th>
                            <th>category</th>
                            <th>author</th>
                            <th>rack number</th>
                            <th>number of copies</th>
                            <th>action</th>
                        </tr>
                        <?php
                            search_book();
                        ?>
                    </table>
                </form>
            </div>
        </div>
        <script src="../js/books.js"></script>
    </body>

    </html>
<?php
}
else 
{
    header('Location:login.php');
    exit();
}