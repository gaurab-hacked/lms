<?php
include "../common/backendConnector.php";

// db connection in (lms) db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}

if (isset($_POST['addContent'])) {
    $cname = $_POST['cName'];

    // Check if cname already exists in the database
    $checkQuery = "SELECT COUNT(*) FROM `category` WHERE `cname` = '$cname'";
    $result = mysqli_query($con, $checkQuery);
    $row = mysqli_fetch_array($result);
    $count = $row[0];

    if ($count == 0) {
        // Insert the data into the database
        $sql = "INSERT INTO `category` (`cname`) VALUES ('$cname')";
        if (mysqli_query($con, $sql)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
            // echo "Inserted success";
        } else {
            // Handle the insertion failure
        }
    } else {
        // Handle the case when cname already exists
    }
}





// for delete content
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sqlDel = "DELETE FROM `category` WHERE `id`='$id'";

    if (mysqli_query($con, $sqlDel)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Cannot Delete";
    }
}

// for edit logic
$cName = "";
$editId = 0;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $sqlFetchOne = "SELECT * FROM `category` WHERE `id`='$editId'";
    $res = mysqli_query($con, $sqlFetchOne);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $cName = $row['cname'];
    }
}
if (isset($_POST['updateContent'])) {
    $cname = $_POST['cName'];
    $id = $_POST['editId'];
    // echo $id;
    $sql = "UPDATE `category` SET `cname`='$cname' WHERE `id`='$id'";
    if (mysqli_query($con, $sql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Cannot update";
    }
}




// ================================ for pagination (start) ==========================================
$querytotalnumberROw = "SELECT COUNT(*) as total FROM category";
$resultRowNum = mysqli_query($con, $querytotalnumberROw);
$rowNumbers = mysqli_fetch_assoc($resultRowNum);
$totalRowNumber = $rowNumbers['total'];

// for total page 
$recordsPerPage = 10;
$totalPages = ceil($totalRowNumber / $recordsPerPage);

// my current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $recordsPerPage;


$sqlFetch = "SELECT * FROM category ORDER BY id DESC LIMIT $offset, $recordsPerPage";
$resFetch = mysqli_query($con, $sqlFetch);


// =======================Search Logic====================
if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlFetch = "SELECT * FROM category WHERE cname LIKE '%$search%'";
        $resFetch = mysqli_query($con, $sqlFetch);
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="./sidestyles.css">
    <link rel="stylesheet" href="../CSS/globals.css">
    <link rel="stylesheet" href="./CSS/model.css">

</head>

<body>
    <?php include "./sideNav.php"; ?>

    <div id="content">
        <div id="semicontent">
            <div id="maincontent">
                <div class="contentTable">
                    <button id="modalOpen">Add Category</button>
                    <table>
                        <tr>
                            <th id="snTab">S.N</th>
                            <th>Name</th>
                            <th colspan="2">Action</th>
                        </tr>
                        <?php
                        if (isset($_GET['page'])) {
                            $index = ($_GET['page'] - 1) * ($recordsPerPage) + 1;
                        } else {
                            $index = 1;
                        }
                        if (mysqli_num_rows($resFetch) > 0) {
                            while ($row = mysqli_fetch_assoc($resFetch)) {
                                echo "
                        <tr  style='text-transform:capitalize'>
                            <td>" . $index . "</td>
                            <td>" . $row["cname"] . "</td>
                            <td>
                                <a href=\"./category.php?edit=" . $row["id"] . "\">
                                    <svg width='16' height='16' viewBox='0 0 25 24' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M22.5 8.75V7.5L15 0H2.5C1.1125 0 0 1.1125 0 2.5V20C0 21.3875 1.125 22.5 2.5 22.5H10V20.1625L20.4875 9.675C21.0375 9.125 21.7375 8.825 22.5 8.75ZM13.75 1.875L20.625 8.75H13.75V1.875ZM24.8125 13.9875L23.5875 15.2125L21.0375 12.6625L22.2625 11.4375C22.5 11.1875 22.9125 11.1875 23.1625 11.4375L24.8125 13.0875C25.0625 13.3375 25.0625 13.75 24.8125 13.9875ZM20.1625 13.5375L22.7125 16.0875L15.05 23.75H12.5V21.2L20.1625 13.5375Z' />
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href=\"./category.php?delete=" . $row["id"] . "\">
                                    <svg width='16' height='16' viewBox='0 0 20 23' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M6.25 0V1.25H0V3.75H1.25V20C1.25 20.663 1.51339 21.2989 1.98223 21.7678C2.45107 22.2366 3.08696 22.5 3.75 22.5H16.25C16.913 22.5 17.5489 22.2366 18.0178 21.7678C18.4866 21.2989 18.75 20.663 18.75 20V3.75H20V1.25H13.75V0H6.25ZM6.25 6.25H8.75V17.5H6.25V6.25ZM11.25 6.25H13.75V17.5H11.25V6.25Z' />
                                    </svg>
                                </a>
                            </td>
                        </tr> ";
                                $index++;
                            }
                        }
                        ?>
                    </table>
                </div>
                <!-- ================================= for pagination =============================== -->
                <div class="pagination">
                    <?php
                    if ($currentPage > 1) {
                        echo '<a href="?page=' . ($currentPage - 1) . '" class="leftArrow">&laquo;</a>';
                    } else {
                        echo '<a class="leftArrow">&laquo;</a>';
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = ($currentPage == $i) ? 'activePage' : '';
                        echo '<a href="?page=' . $i . '" class="' . $activeClass . '">' . $i . '</a>';
                    }

                    if ($currentPage < $totalPages) {
                        echo '<a href="?page=' . ($currentPage + 1) . '" class="rightArrow">&raquo;</a>';
                    } else {
                        echo '<a class="rightArrow">&raquo;</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <!-- for modal  -->
    <div id="modal">
        <div id="background">
            <div id="contentModal">
                <!-- For close button -->
                <button id="crossModal">X</button>
                <div class="formContent">
                    <form action="./category.php" method="post">
                        <h2 style="opacity:0.5">Add category</h2>
                        <input type="hidden" name="editId" value="<?php echo $editId ?>" id="">
                        <input type="text" name="cName" value="<?php echo $cName ?>" id=" cName"
                            placeholder="Category Name" required>
                        <div class="formButtons">
                            <?php
                            if (intval($editId) > 0) {
                                echo "<button type='submit' name='updateContent'>Update</button>";
                            } else {
                                echo "<button type='submit' name='addContent'>Add</button>";
                            }
                            ?>
                            <button type="reset">Reset</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script>
        const modal = document.getElementById("modal");
        const modalOpen = document.getElementById("modalOpen");
        const crossModal = document.getElementById("crossModal");
        const params = new URLSearchParams(window.location.search);
        let editParameter = Number(params.get('edit'));
        if (editParameter > 0) {
            modal.style.display = "block";
        }
        const urlWithoutParams = window.location.origin + window.location.pathname;

        modalOpen.addEventListener('click', () => {
            modal.style.display = "block";
        })
        crossModal.addEventListener('click', () => {
            modal.style.display = "none";
            window.location.href = urlWithoutParams;
        })
    </script>
</body>

</html>