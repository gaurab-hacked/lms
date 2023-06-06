<?php
include "./common/backendConnector.php";
// db connection in (lms) db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}

$sqlFetchAll = "SELECT * FROM `books`";
$res = mysqli_query($con, $sqlFetchAll);

// for searching
// Retrieve the search value from the GET request]
if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlNote = "SELECT * FROM books WHERE bname LIKE '%$search%'";
        $res = mysqli_query($con, $sqlNote);
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/home.css">
    <link rel="stylesheet" href="./CSS/allBook.css">
    <title>All Books</title>
    <style>
        #search-btn {
            background-color: transparent;
            border: none;
        }
    </style>
</head>

<body>

    <?php include "./common/header.php"; ?>
    <!-- main div of all books  -->
    <div class="container">

        <div class="all-books-nav">
            <div class="all-books">
                <h3>All Books:</h3>
            </div>
            <form action="">
                <div class="search-box">
                    <input type="text" name="search" id="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>" placeholder="Search Books..." id="search-box" autocomplete="off">
                    <div>
                        <svg width="3" height="25" viewBox="0 0 1 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0.5" y1="23.0217" x2="0.5" stroke="#757575" />
                        </svg>
                    </div>
                    <div>
                        <button id="search-btn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.42857 0C9.39875 0 11.2882 0.782651 12.6814 2.17578C14.0745 3.56891 14.8571 5.45839 14.8571 7.42857C14.8571 9.26857 14.1829 10.96 13.0743 12.2629L13.3829 12.5714H14.2857L20 18.2857L18.2857 20L12.5714 14.2857V13.3829L12.2629 13.0743C10.96 14.1829 9.26857 14.8571 7.42857 14.8571C5.45839 14.8571 3.56891 14.0745 2.17578 12.6814C0.782651 11.2882 0 9.39875 0 7.42857C0 5.45839 0.782651 3.56891 2.17578 2.17578C3.56891 0.782651 5.45839 0 7.42857 0ZM7.42857 2.28571C4.57143 2.28571 2.28571 4.57143 2.28571 7.42857C2.28571 10.2857 4.57143 12.5714 7.42857 12.5714C10.2857 12.5714 12.5714 10.2857 12.5714 7.42857C12.5714 4.57143 10.2857 2.28571 7.42857 2.28571Z" fill="#757575" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>


        </div>
        <!-- div for border bar HR -->
        <hr>



        <!-- Books and books Details -->
        <div class="books-details">
            <?php
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "
            <div class='book-details-list'>
                <div class='book-img'>
                    <img src='" . $row["bimage"] . "' alt='Books'>
                </div>
                <div class='details'>
                    <div class='book-name'>
                    <h2>" . $row["bname"] . "</h2>
                    <h4>" . 'Author: ' . $row["bauthor"] . "</h4>
                    <h4>" . 'Faculty: ' . $row["categoryName"] . "</h4>
                    <h4>" . 'Sem/Year: ' . $row["subcategoryName"] . "</h4>
                    <p>" . 'Publication: ' . $row["pubName"] . "</p>
                    </div>
                    <div class='date'>
                    <h5>" . $row["bpublishdate"] . "</h5>
                    </div>
                    <p>" . 'Quantity: ' . $row["bquantity"] . "</p>
                    <div class='pre-order-btn'>
                        <a href='#'><button>Pre-Order</button></a>
                    </div>
                </div>
            </div>  ";
                }
            } else {
                echo "<div class='pageNotFound'>Books Not Found</div>";
            }
            ?>
        </div>




        <!-- for next page or view more -->
        <div class="page-break" style="margin-bottom: 15px;">
            <div class="line-view">

            </div>
            <div>
                <a href="#">View More</a>
            </div>
            <div class="line-view">

            </div>
        </div>

    </div>


    <!-- footer section -->
    <?php include "./common/footer.php"; ?>

</body>

</html>