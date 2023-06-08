<?php
include "../common/backendConnector.php";

// db connection in (lms) db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}

$sqlFetch = "SELECT * FROM contactus";
$resFetch = mysqli_query($con, $sqlFetch);



// To fetch one person data 
if (isset($_GET['view'])) {
    $cont_id = $_GET['view'];
    $oneUserSqlFetch = "SELECT * FROM contactus WHERE `id`='$cont_id'";
    $oneUserResFetch = mysqli_query($con, $oneUserSqlFetch);
    $oneUserData = mysqli_fetch_assoc($oneUserResFetch);
    $cont_name = $oneUserData['cont_fname'] . " " . $oneUserData['cont_lname'];
    $cont_email = $oneUserData['cont_email'];
    $cont_phone = $oneUserData['cont_phone'];
    $cont_message = $oneUserData['cont_message'];
}


// for delete content
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sqlDel = "DELETE FROM `contactus` WHERE `id`='$id'";

    if (mysqli_query($con, $sqlDel)) {
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Cannot Delete";
    }
}


// ================================ for pagination (start) ==========================================
$querytotalnumberROw = "SELECT COUNT(*) as total FROM contactus";
$resultRowNum = mysqli_query($con, $querytotalnumberROw);
$rowNumbers = mysqli_fetch_assoc($resultRowNum);
$totalRowNumber = $rowNumbers['total'];

// for total page 
$recordsPerPage = 10;
$totalPages = ceil($totalRowNumber / $recordsPerPage);

// my current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $recordsPerPage;


$sqlFetch = "SELECT * FROM contactus ORDER BY id DESC LIMIT $offset, $recordsPerPage";
$resFetch = mysqli_query($con, $sqlFetch);



// ================================ for Search ==========================================

if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlFetch = "SELECT * FROM contactus WHERE cont_fname LIKE '%$search%'";
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
    <title>Message</title>
    <link rel="stylesheet" href="./sidestyles.css">
    <link rel="stylesheet" href="../CSS/globals.css">
    <link rel="stylesheet" href="./CSS/messagemodel.css">
</head>

<body>
    <?php include "./sideNav.php"; ?>

    <div id="content">
        <div id="semicontent">
            <div id="maincontent">
                <div class="contentTable">
                    <table>
                        <tr>
                            <th id='snTab'>S.N</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th colspan='2'>Action</th>
                        </tr>
                        <?php
                        if (isset($_GET['page'])) {
                            $index = ($_GET['page'] - 1) * ($recordsPerPage) + 1;
                        } else {
                            $index = 1;
                        }
                        if (mysqli_num_rows($resFetch) > 0) {
                            while ($row = mysqli_fetch_assoc($resFetch)) {
                                $msgshow = strlen($row["cont_message"]) > 30 ? substr($row["cont_message"], 0, 30) . '...' : $row["cont_message"];
                                echo "
                        <tr>
                            <td>" . $index . "</td>
                            <td>" . $row["cont_fname"] . " " . $row["cont_lname"] . "</td>
                            <td>" . $row["cont_email"] . "</td>
                            <td>" . $row["cont_phone"] . "</td>
                            <td id='messageWidth'>" . $msgshow . "</td>
                            <td>
                            <a href=\"./message.php?view=" . $row["id"] . "\">
                           <svg width='20' height='15' viewBox='0 0 23 16' xmlns='http://www.w3.org/2000/svg' id='modalOpen'>
                        <path d='M11.868 5.40091C11.0724 5.40091 10.3093 5.71698 9.74671 6.27959C9.1841 6.8422 8.86803 7.60526 8.86803 8.40091C8.86803 9.19656 9.1841 9.95962 9.74671 10.5222C10.3093 11.0848 11.0724 11.4009 11.868 11.4009C12.6637 11.4009 13.4267 11.0848 13.9893 10.5222C14.552 9.95962 14.868 9.19656 14.868 8.40091C14.868 7.60526 14.552 6.8422 13.9893 6.27959C13.4267 5.71698 12.6637 5.40091 11.868 5.40091ZM11.868 13.4009C10.5419 13.4009 9.27017 12.8741 8.33249 11.9364C7.39481 10.9988 6.86803 9.72699 6.86803 8.40091C6.86803 7.07483 7.39481 5.80306 8.33249 4.86538C9.27017 3.92769 10.5419 3.40091 11.868 3.40091C13.1941 3.40091 14.4659 3.92769 15.4036 4.86538C16.3412 5.80306 16.868 7.07483 16.868 8.40091C16.868 9.72699 16.3412 10.9988 15.4036 11.9364C14.4659 12.8741 13.1941 13.4009 11.868 13.4009ZM11.868 0.900909C6.86803 0.900909 2.59803 4.01091 0.868027 8.40091C2.59803 12.7909 6.86803 15.9009 11.868 15.9009C16.868 15.9009 21.138 12.7909 22.868 8.40091C21.138 4.01091 16.868 0.900909 11.868 0.900909Z' />
                        </svg>
                    </a>
                            </td>
                            <td>
                            <a href=\"./message.php?delete=" . $row["id"] . "\">
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
    </div>



    <div id="modal">
        <div id="background">
            <div id="contentModal">
                <!-- For close button -->
                <button id="crossModal">X</button>
                <div class="formContent">
                    <h2>Messages</h2>

                    <p><span class="label">Name:</span> <span class="value">
                            <?php echo $cont_name; ?>
                        </span></p>
                    <p><span class="label">Email:</span> <span class="value">
                            <?php echo $cont_email; ?>
                        </span></p>
                    <p><span class="label">Phone:</span> <span class="value">
                            <?php echo $cont_phone; ?>
                        </span></p>
                    <div class="valueMessage">
                        <p><span class="label">Message_</span><br>
                            <span class="value">
                                <?php echo $cont_message; ?>
                            </span>
                        </p>
                    </div>


                    <!-- ?> -->
                </div>
            </div>
        </div>
    </div>




    <script>
        const modal = document.getElementById("modal");
        const modalOpen = document.getElementById("modalOpen");
        const crossModal = document.getElementById("crossModal");
        const background = document.getElementById('background');
        const params = new URLSearchParams(window.location.search);
        modalOpen.addEventListener("click", () => {
            modal.style.display = "block";
        })
        background.addEventListener('click', () => {
            modal.style.display = "none";
            urlParams.delete('view');
            const urlWithoutParams = window.location.origin + window.location.pathname;
            history.replaceState(null, '', urlWithoutParams);
        });
        crossModal.addEventListener('click', () => {
            modal.style.display = "none";
            // Remove the "view" parameter
            urlParams.delete('view');

            // Get the URL without the "view" parameter
            const urlWithoutParams = window.location.origin + window.location.pathname;

            // Update the URL without the parameter
            history.replaceState(null, '', urlWithoutParams);

        });

        const urlParams = new URLSearchParams(window.location.search);

        // Get the value of the "view" parameter
        const viewParam = urlParams.get('view');
        if (viewParam) {
            modal.style.display = "block";
        }
    </script>

</body>

</html>