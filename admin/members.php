<?php
include "../common/backendConnector.php";

// db connection in (lms) db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}


// for delete content
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sqlDel = "DELETE FROM `users` WHERE `id`='$id'";

    if (mysqli_query($con, $sqlDel)) {
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Cannot Delete";
    }
}

if (isset($_GET['block'])) {
    $id = $_GET['block'];
    $sqlDel = "UPDATE `users` SET `restriction`='1' WHERE `id`='$id'";
    $res = mysqli_query($con, $sqlDel);
    if ($res) {
        header("Location: " . $_SERVER['PHP_SELF']);
    }
}


// ================================ for pagination (start) ==========================================
$querytotalnumberROw = "SELECT COUNT(*) as total FROM users";
$resultRowNum = mysqli_query($con, $querytotalnumberROw);
$rowNumbers = mysqli_fetch_assoc($resultRowNum);
$totalRowNumber = $rowNumbers['total'];

// for total page 
$recordsPerPage = 10;
$totalPages = ceil($totalRowNumber / $recordsPerPage);

// my current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $recordsPerPage;


$sqlFetch = "SELECT * FROM users  WHERE `restriction` = '0' ORDER BY id DESC LIMIT $offset, $recordsPerPage";
$resFetch = mysqli_query($con, $sqlFetch);


// ================================ for Search ==========================================

if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlFetch = "SELECT * FROM users WHERE name LIKE '%$search%'";
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
    <title>Members</title>
    <link rel="stylesheet" href="./sidestyles.css">
    <link rel="stylesheet" href="./CSS/messagemodel.css">
    <link rel="stylesheet" href="../CSS/globals.css">

    <style>
        #action,
        #snTab {
            max-width: 30px;
        }
    </style>
</head>

<body>
    <?php include "./sideNav.php"; ?>


    <div id="content">
        <div id="semicontent">
            <div id="maincontent">
            </div>
            <div class="contentTable">
                <h2> Members List of LMS:-</h2><br>
                <table>
                    <tr>
                        <th id='snTab'>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th colspan='2' id='action'>Action</th>
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
                        <tr>
                            <td>" . $index . "</td>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["phnumber"] . "</td>
                            <td>
                            <a href='?block=" . $row["id"] . "'>
                            <svg width='17' height='17' viewBox='0 0 21 21' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M10.2195 0.71106C15.7495 0.71106 20.2195 5.18106 20.2195 10.7111C20.2195 16.2411 15.7495 20.7111 10.2195 20.7111C4.68945 20.7111 0.219452 16.2411 0.219452 10.7111C0.219452 5.18106 4.68945 0.71106 10.2195 0.71106ZM13.8095 5.71106L10.2195 9.30106L6.62945 5.71106L5.21945 7.12106L8.80945 10.7111L5.21945 14.3011L6.62945 15.7111L10.2195 12.1211L13.8095 15.7111L15.2195 14.3011L11.6295 10.7111L15.2195 7.12106L13.8095 5.71106Z' fill='black'/>
                            </svg>
                        </a>
                            </td>
                            <td>
                            <a href=\"./members.php?delete=" . $row["id"] . "\">
                                    <svg width='14' height='16' viewBox='0 0 20 23' xmlns='http://www.w3.org/2000/svg'>
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
            <!-- =======================pagination============================ -->
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
</body>

</html>