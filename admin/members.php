
<?php
include "../common/backendConnector.php";

// db connection in (lms) db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}

$sqlFetch = "SELECT `id`, `name`, `email`, `phnumber` FROM users ";
$resFetch = mysqli_query($con, $sqlFetch);

$id = "";
$name = "";
$email = "";
$phnumber = "";


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

// get data 

$sqlFetch = "SELECT * FROM users ORDER BY id DESC LIMIT $offset, $recordsPerPage";
$resFetch = mysqli_query($con, $sqlFetch);


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
       #action, #snTab{
        max-width: 30px;
       }
    </style>
</head>

<body>
    <?php include "./sideNav.php"; ?>


    <div id="content">
        <div id="semicontent">
            <div id="maincontent">                
            </div><div class="contentTable">
                <h2>Members List of Library Management System:-</h2><br>
                    <table>
                        <tr>
                            <th id='snTab'>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th colspan='2' id='action'>Action</th>
                        </tr>
                        <?php
                        $index = 1;
                        if (mysqli_num_rows($resFetch) > 0) {
                            while ($row = mysqli_fetch_assoc($resFetch)) {
                                echo "
                        <tr>
                            <td>" . $index . "</td>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["phnumber"] . "</td>
                            <td>
                            <a href=\"./members.php?restriction=" . $row["id"] . "\">
                            <svg width='21' height='21' viewBox='0 0 25 25' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M4.35001 4.16196V10.162V14.162H6.35001V10.162H8.35001L13.76 15.572L10.18 19.162L11.59 20.572L15.18 16.992L18.76 20.572L20.17 19.162L16.59 15.572L20.17 11.992L18.76 10.572L15.18 14.162L11.18 10.162H11.35C12.1457 10.162 12.9087 9.84589 13.4713 9.28328C14.0339 8.72067 14.35 7.95761 14.35 7.16196C14.35 6.36631 14.0339 5.60325 13.4713 5.04064C12.9087 4.47803 12.1457 4.16196 11.35 4.16196H4.35001ZM6.35001 6.16196H11.35C11.6152 6.16196 11.8696 6.26731 12.0571 6.45485C12.2446 6.64239 12.35 6.89674 12.35 7.16196C12.35 7.42717 12.2446 7.68153 12.0571 7.86906C11.8696 8.0566 11.6152 8.16196 11.35 8.16196H6.35001V6.16196Z'/>
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
</body>

</html>