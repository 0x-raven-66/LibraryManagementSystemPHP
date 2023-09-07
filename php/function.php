<?php
// connect with LMS databse 
$conn = mysqli_connect("localhost","root","","LMS");


function deleteBook() {
    if(isset($_POST["del"])) {
        global $conn;
        $bookid = $_POST["heddinID"];
        $del_query = "DELETE FROM `books` WHERE `id` = '$bookid'";
        mysqli_query($conn,$del_query);
    }
}

function search_book() {
    global $conn;
    // display all books 
    if (empty($_GET["search"])) {
        $query = "SELECT * FROM `books`";
        $result = mysqli_query($conn,$query);
        display_books($result);
    }
    // only search then display the result
    else if (isset($_GET["go"])) {
        $method = $_GET["searchBy"];
        $value = $_GET["search"];
        // Search by Title
        if ($method == 0) {
            $query = "SELECT * FROM `books` WHERE `title` LIKE '%$value%'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_books($result);
            }
            else {
                echo "<tr> <td colspan='7'>No Data Found</td> </tr>";
            }
        }
        // Search by Category
        else if ($method == 1) {
            $query = "SELECT * FROM `books` WHERE `category` = '$value'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_books($result);
            }
            else {
                echo "<tr> <td colspan='7'>No Data Found</td> </tr>";
            }
            
        }
        // Search by Auther
        else if ($method == 2) {
            $query = "SELECT * FROM `books` WHERE `Author` = '$value'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_books($result);
            }
            else {
                echo "<tr> <td colspan='7'>No Data Found</td> </tr>";
            }
            
        }
        // Search by ID
        else if ($method == 3) {
            $query = "SELECT * FROM `books` WHERE `id` = '$value'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_books($result);
            }
            else {
                echo "<tr> <td colspan='7'>No Data Found</td> </tr>";
            }
        }
    }
}

// function display dosn't have a connection with database 
// it take the result of connection from search methods .... so it only work inside search
function display_books($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <input type='hidden' value='".$row['id']."' name='heddinID'>
                <td>".$row['id']."</td>
                <td>".$row['title']."</td>
                <td>".$row['category']."</td>
                <td>".$row['Author']."</td>
                <td>".$row['RackNumber']."</td>
                <td>".$row['Copies']."</td>
                <td>
                    <a class='edit' href='bookedit.php?id=".$row['id']."'><i class='fa-regular fa-pen-to-square'></i></a>
                    <button class='delete' name='del' type='submit'><i class='fa-solid fa-trash-can'></i></button>
                    <a class='loan'  href='loan.php?id=$row[id]'><i class='fa-solid fa-share'></i></a>
                </td>
            </tr>";
        }
}

function add_book() {
    if(isset($_POST["add-book"])){
        global $conn;
        $title = $_POST["bookName"];
        $category = $_POST["Category"];
        $author = $_POST["Author"];
        $rackNumber = $_POST["rackNum"];
        $copies = $_POST["copiesNum"];
        if ($title !="" && $category !="" && $author !="" && $rackNumber !="" && $copies !="" ){
            $add = "INSERT INTO `books` (`id`, `title`, `category`, `Author`, `RackNumber`, `Copies`) 
            VALUES (NULL, '$title','$category','$author','$rackNumber','$copies');";
            mysqli_query($conn,$add);
        }
    }
}

function edit_book() {
    global $conn;
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    $id = explode("=",$urlParts['query']);
    $id = $id[1];
    $query = "SELECT * FROM `books` WHERE `id` = '$id'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    // echo edit form
    echo '<p>Book Title</p>
        <input type="text" name="bookName" value="'.$row['title'].'">
        <p>Category</p>
        <input type="text" name="Category" value="'.$row['category'].'">
        <p>Author</p>
        <input type="text" name="Author" value="'.$row['Author'].'">
        <p>Rack Number</p>
        <input type="text" name="rackNum" value="'.$row['RackNumber'].'">
        <p>Number of Copies</p>
        <input type="number" name="copiesNum" value="'.$row['Copies'].'">
        <button id="edit-btn" type="submit" name="edit-book">Save</button>';
    
    if(isset($_POST["edit-book"])) {
        $title = $_POST["bookName"];
        $category = $_POST["Category"];
        $author = $_POST["Author"];
        $rackNumber = $_POST["rackNum"];
        $copies = $_POST["copiesNum"];
        $update_query = "UPDATE `books` SET `title`='$title',`category`='$category',`Author`='$author',
                    `RackNumber`='$rackNumber',`Copies`='$copies' WHERE `id` = $id;";
        $do_update = mysqli_query($conn,$update_query);
        if($do_update) {
            header("Location:books.php");
            exit();
        }
    }
}

function loan() {
    global $conn;
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    $id = explode("=",$urlParts['query']);
    $id = $id[1];
    // echo loan form
    echo '<div id="pop-up-loan">
        <div class="loan-form">
            <form method="post">
                <p class="details">Loan Details</p>
                <p>User id</p>
                <input type="text" name="userId" required autofocus>
                <p>Book ID</p>
                <input type="text" id="bookid" name="bookId" value="'.$id.'" readonly>
                <p>Return Date</p>
                <input type="date" name="returnDate" required>
                <button id="record-loan" type="submit" name="record">Record Loan</button>
            </form>
        </div>
        </div>';
    $check_query = "SELECT `userid` FROM `users`";
    $result = mysqli_query($conn,$check_query);
    $ids =array();
    while ($valid_id = mysqli_fetch_assoc($result)) {
        array_push($ids,$valid_id["userid"]);
    }
    if(isset($_POST["record"])) {
        // get return date
        $return_date = $_POST["returnDate"];
        // get user info
        $input_userid = $_POST["userId"];
        // record loan if user id in users database
        if (in_array($input_userid,$ids)) {
            $query = "SELECT * FROM `users` WHERE `userid` = '$input_userid'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $userID = $row["userid"];
            $username = $row["username"];
            $email = $row["email"];
            $phone = $row["phone"];
            $address = $row["address"];
            // get book info 
            $input_bookid = $_POST["bookId"];
            $query = "SELECT * FROM `books` WHERE `id` = '$input_bookid'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $bookID = $row["id"];
            $title = $row["title"];
            $category = $row["category"];
            $author = $row["Author"];
            // put it all together in issued database
            $add_query = "INSERT INTO `issued` (`issueID`,`bookID`,`title`,`category`,`Author`,`userID`,`username`,`email`,`phone`,`address`,`returndate`)
            VALUES (NULL,'$bookID','$title','$category','$author','$userID','$username','$email','$phone','$address','$return_date');";
            $add_issue = mysqli_query($conn,$add_query);
            if($add_issue) {
                header("Location:books.php");
                exit();
            }
        }
        else {
            // show error msg 
            echo "<div><p class='not-found'>user id not found</p></div>";
        }
    }
}

function search_user() {
    global $conn;
    if (empty($_GET["search"])) {
        $query = "SELECT * FROM `users`";
        $result = mysqli_query($conn,$query);
        display_users($result);
    }
    else if (isset($_GET["go"])) {
        $method = $_GET["searchBy"];
        $value = $_GET["search"];
        // Search by name
        if ($method == 0) {
            $query = "SELECT * FROM `users` WHERE `username` LIKE '%$value%'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_users($result);
            }
            else {
                echo "<tr> <td colspan='6'>No Data Found</td> </tr>";
            }
        }
        // Search by id
        else if ($method == 1) {
            $query = "SELECT * FROM `users` WHERE `userid` = '$value'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_users($result);
            }
            else {
                echo "<tr> <td colspan='6'>No Data Found</td> </tr>";
            }
        }
        // Search by email
        else if ($method == 2) {
            $query = "SELECT * FROM `users` WHERE `email` = '$value'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_users($result);
            }
            else {
                echo "<tr> <td colspan='6'>No Data Found</td> </tr>";
            }
        }
    }
}

function display_users($result) {
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
            <input type='hidden' value='".$row['userid']."' name='heddinID'>
            <td>".$row['userid']."</td>
            <td>".$row['username']."</td>
            <td>".$row['email']."</td>
            <td>".$row['phone']."</td>
            <td>".$row['address']."</td>
            <td>
                <a class='edit' href='useredit.php?id=".$row['userid']."'><i class='fa-regular fa-pen-to-square'></i></a>
                <button class='delete' name='del' type='submit'><i class='fa-solid fa-trash-can'></i></button>
            </td>
        </tr>";
    }
}

function deleteUser() {
    if(isset($_POST["del"])) {
        global $conn;
        $userid = $_POST["heddinID"];
        $del_query = "DELETE FROM `users` WHERE `userid` = '$userid'";
        mysqli_query($conn,$del_query);
    }
}

function add_user() {
    if(isset($_POST["add-user"])){
        global $conn;
        $userName = $_POST["userName"];
        $email = $_POST["email"];
        $phoneNum = $_POST["phoneNum"];
        $address = $_POST["address"];
        if ($userName !="" && $email !="" && $phoneNum !="" && $address !="" ){
            $add = "INSERT INTO `users` (`userid`, `username`, `email`, `phone`, `address`) 
            VALUES (NULL, '$userName','$email','$phoneNum','$address');";
            mysqli_query($conn,$add);
        }
    }
}

function edit_user() {
    global $conn;
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    $id = explode("=",$urlParts['query']);
    $id = $id[1];
    $query = "SELECT * FROM `users` WHERE `userid` = '$id'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    echo '<p>User Name</p>
        <input type="text" name="userName" value="'.$row['username'].'">
        <p>Email</p>
        <input type="text" name="email" value="'.$row['email'].'">
        <p>Phone Number</p>
        <input type="text" name="phoneNum" value="'.$row['phone'].'">
        <p>Address</p>
        <input type="text" name="address" value="'.$row['address'].'">
        <button id="edit-btn" type="submit" name="edit-user">Save</button>';
    
    if(isset($_POST["edit-user"])) {
        $username = $_POST["userName"];
        $email = $_POST["email"];
        $phone = $_POST["phoneNum"];
        $address = $_POST["address"];
        $update_query = "UPDATE `users` SET `username`='$username',`email`='$email',`phone`='$phone',
                    `address`='$address' WHERE `userid` = $id;";
        $do_update = mysqli_query($conn,$update_query);
        if($do_update) {
            header("Location:users.php");
            exit();
        }
    }
}

function search_issue() {
    global $conn;
    if (empty($_GET["search"])) {
        $query = "SELECT `issueID`,`bookID`,`title`,`userID`,`username`,`laondate`,`returndate` FROM `issued`";
        $result = mysqli_query($conn,$query);
        display_issue($result);
    }
    else if (isset($_GET["go"])) {
        $method = $_GET["searchBy"];
        $value = $_GET["search"];
        // Search by username
        if ($method == 0) {
            $query = "SELECT `issueID`,`bookID`,`title`,`userID`,`username`,`laondate`,`returndate` FROM `issued` WHERE `username` LIKE '%$value%'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_issue($result);
            }
            else {
                echo "<tr> <td colspan='9'>No Data Found</td> </tr>";
            }
        }
        // Search by book title
        else if ($method == 1) {
            $query = "SELECT `issueID`,`bookID`,`title`,`userID`,`username`,`laondate`,`returndate` FROM `issued` WHERE `title` LIKE '%$value%'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_issue($result);
            }
            else {
                echo "<tr> <td colspan='9'>No Data Found</td> </tr>";
            }
        }
        // Search by issuID
        else if ($method == 2) {
            $query = "SELECT `issueID`,`bookID`,`title`,`userID`,`username`,`laondate`,`returndate` FROM `issued` WHERE `issueID` ='$value'";
            $result = mysqli_query($conn,$query);
            if (mysqli_num_rows($result) > 0) {
                display_issue($result);
            }
            else {
                echo "<tr> <td colspan='9'>No Data Found</td> </tr>";
            }
        }
    }
}

function display_issue($result) {
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
        <td>".$row['issueID']."</td>
        <td>".$row['bookID']."</td>
        <td>".$row['title']."</td>
        <td>".$row['userID']."</td>
        <td>".$row['username']."</td>
        <td>".$row['laondate']."</td>
        <td>".$row['returndate']."</td>
        <td>".is_fined($row['returndate'])."</td>
        <td><a class='view' href='return.php?id=".$row['issueID']."'>view</a></td>
    </tr>";
    }
}

function view_and_return_issue() {
    global $conn;
    $urlParts = parse_url($_SERVER['REQUEST_URI']);
    $id = explode("=",$urlParts['query']);
    $id = $id[1];
    $query = "SELECT * FROM `issued` WHERE `issueID` = '$id'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $returndate = $row["returndate"];
    echo '<div class="issue-info">
        <div>
            <p class="details">issue Details</p>
            <p>Issue id : '.$row["issueID"].'</p>
            <p>Laon date : '.$row["laondate"].'</p>
            <p>Return date : '.$row["returndate"].'</p>
            <p>Fined : '.is_fined($returndate).'</p>
        </div>
        <div class="user-info">
            <p class="details">User Details</p>
            <p>Username : '.$row["username"].'</p>
            <p>User ID : '.$row["userID"].'</p>
            <p>Email : '.$row["email"].'</p>
            <p>Phone : '.$row["phone"].'</p>
            <p>Address : '.$row["address"].'</p>
        </div>
        <div class="book-info">
            <p class="details">Book Details</p>
            <p>Book Title : '.$row["title"].'</p>
            <p>Book ID : '.$row["bookID"].'</p>
            <p>Category: '.$row["category"].'</p>
            <p>Author : '.$row["Author"].'</p>
        </div>
            <form action="" method="post">
                <button id="return-btn" name="return" type="submit">Return</button>
            </form>
        </div>';
    if(isset($_POST["return"])) {
        // delete issue record
        $remove_query = "DELETE FROM `issued` WHERE `issueID` = '$id'";
        $result=mysqli_query($conn,$remove_query);
        if($result) {
            header("Location:issue.php");
            exit();
        }
    }
}

function count_users() {
    global $conn;
    $query = "SELECT `userid` FROM `users`";
    $result = mysqli_num_rows(mysqli_query($conn,$query));
    echo $result;
}

function count_books() {
    global $conn;
    $query = "SELECT `id` FROM `books`";
    $result = mysqli_num_rows(mysqli_query($conn,$query));
    echo $result;
}

function count_issues() {
    global $conn;
    $query = "SELECT `issueID` FROM `issued`";
    $result = mysqli_num_rows(mysqli_query($conn,$query));
    echo $result;
}

function logout() {
    session_destroy();
    header("Location:login.php");
    exit();
}

function is_fined($returndate) {
    $current_date = date("Y-m-d");
    if ($returndate < $current_date){
        return "Yes";
    }
    else {
        return "No";
    }
}
