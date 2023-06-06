<?php

include "../common/backendConnector.php";
// db connection in (lms) db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}

// for get category content from db
$sqlFetchCat = "SELECT DISTINCT cname FROM `category`";
$resFetchsub = mysqli_query($con, $sqlFetchCat);

// for get Book content from db
$sqlFetch = "SELECT * FROM books";
$resFetch = mysqli_query($con, $sqlFetch);

if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlFetch = "SELECT * FROM books WHERE bname LIKE '%$search%'";
        $resFetch = mysqli_query($con, $sqlFetch);
    }
}

// for get subcategory content from db
$sqlFetchSubcat = "SELECT DISTINCT subcatname FROM `subcategory`";
$resFetchSubcat = mysqli_query($con, $sqlFetchSubcat);



// ============= Insertion Start ============

if (isset($_POST['addContent'])) {

    // Define the directory to store uploaded images
    $targetDir = "uploads/";

    // Check if the target directory exists, if not, create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Check if a file was uploaded
    if (isset($_FILES["image"])) {
        $file = $_FILES["image"];

        // Get the file name and extension
        $fileName = basename($file["name"]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if the file extension is allowed
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (in_array($fileExtension, $allowedExtensions)) {
            $targetPath = $targetDir . uniqid() . "." . $fileExtension;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file["tmp_name"], $targetPath)) {
                // File uploaded successfully

                // Get other form field values
                $bname = $_POST['bname'];
                $bauthor = $_POST['bauthor'];
                $bquantity = $_POST['bquantity'];
                $categoryid = $_POST['category'];
                $subcategoryid = $_POST['subcategory'];
                $bpublishdate = $_POST['bpublishdate'];
                $pubName = $_POST['pubname'];


                // Fetch category name from category table
                if (mysqli_num_rows($resFetchsub) > 0) {
                    $res = mysqli_fetch_assoc($resFetchsub);
                    $categoryName = $res['cname'];
                }

                // Fetch subcategory name from subcategory table
                if (mysqli_num_rows($resFetchSubcat) > 0) {
                    $ressubcat = mysqli_fetch_assoc($resFetchSubcat);
                    $subcategoryName = $ressubcat['subcatname'];
                }

                $final_image_path = $fileFront . $targetPath;

                // Insert data into the books table
                $sql = "INSERT INTO books (bname, bauthor, bquantity, categoryid, subcategoryid, bpublishdate, categoryName, subcategoryName, bimage, pubName) VALUES ('$bname', '$bauthor', '$bquantity', '$categoryid', '$subcategoryid', '$bpublishdate', '$categoryName', '$subcategoryName', '$final_image_path', '$pubName')";

                if (mysqli_query($con, $sql)) {
                    // Data inserted successfully
                    header("Location: " . $_SERVER['PHP_SELF']);
                } else {
                    // Error inserting data
                    echo "Error: " . mysqli_error($con);
                }

                // Close the database connection
                mysqli_close($con);
            } else {
                // Failed to move the uploaded file
                echo "Error uploading image.";
            }
        } else {
            // Invalid file type
            echo "Only JPG, JPEG, and PNG files are allowed.";
        }
    } else {
        // No file uploaded
        echo "No image file provided.";
    }
}



// for delete content
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sqlDel = "DELETE FROM `books` WHERE `id`='$id'";

    if (mysqli_query($con, $sqlDel)) {
        echo "del success";
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Cannot Delete";
    }
}



// // for edit logic

$editId = 0;
$bid = "";
$catName = "";
$subcatname = "";
$bname = "";
$bauthor = "";
$pubName = "";
$bquantity = "";
$bimage = "";
$bpublishdate = "";

if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editsql = "SELECT * FROM `books` WHERE `id` = ?";
    $stmt = mysqli_prepare($con, $editsql);
    mysqli_stmt_bind_param($stmt, "i", $editId);
    mysqli_stmt_execute($stmt);
    $editres = mysqli_stmt_get_result($stmt);

    if (!$editres) {
        echo "Book not found";
    } else {
        $book = mysqli_fetch_array($editres);
        $bid = $book['id'];
        $catName = $book['categoryName'];
        $subcatname = $book['subcategoryName'];
        $bname = $book['bname'];
        $bauthor = $book['bauthor'];
        $pubName = $book['pubName'];
        $bquantity = $book['bquantity'];
        $bimage = $book['bimage'];
        $bpublishdate = $book['bpublishdate'];
    }
}

// Update the data in the database
if (isset($_POST['updateContent'])) {
    $newBname = $_POST['bname'];
    $newBauthor = $_POST['bauthor'];
    $newPubName = $_POST['pubName'];
    $newBquantity = $_POST['bquantity'];
    $newBimage = $_POST['bimage'];
    $newBpublishdate = $_POST['bpublishdate'];

    $updatesql = "UPDATE `books` SET `bname`=?, `bauthor`=?, `pubName`=?, `bquantity`=?, `bimage`=?, `bpublishdate`=? WHERE `id`=?";
    $stmt = mysqli_prepare($con, $updatesql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $newBname, $newBauthor, $newPubName, $newBquantity, $newBimage, $newBpublishdate, $editId);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Update failed: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}


// $sqlFetchAll = "SELECT * FROM `books`";
// $res = mysqli_query($con, $sqlFetchAll);

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
    <title>Books</title>
    <link rel="stylesheet" href="./sidestyles.css">
    <link rel="stylesheet" href="../CSS/globalass.css">
    <link rel="stylesheet" href="./CSS/model.css">
    <link rel="stylesheet" href="./CSS/books.css">
    <style>
        select {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            outline: none;
            cursor: pointer !important;
            font-size: 17px !important;
            gap: 10px;
            display: flex;
            flex-direction: column;
        }

        #contentModal {
            min-height: 580px;
        }

        .formContent {
            margin-top: 105px;
        }

        #nameTab {
            width: 20%;
        }

        #pbdate input {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include "./sideNav.php"; ?>

    <div id="content">
        <div id="semicontent">
            <div id="maincontent">
                <div class="contentTable">
                    <button id="modalOpen">Add Books</button>
                    <table>
                        <tr>
                            <th id="snTab">S.N</th>
                            <th id="nameTab">Books Name</th>
                            <th>Category Name</th>
                            <th>Sub-Category Name</th>
                            <th>Author</th>
                            <th>Publication</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Publish Date</th>
                            <th colspan="2">Action</th>
                        </tr>
                        <?php
                        $index = 1;
                        if (mysqli_num_rows($resFetch) > 0) {
                            while ($row = mysqli_fetch_assoc($resFetch)) {
                                echo "
                        <tr style='text-transform:capitalize'>
                            <td>" . $index . "</td>
                            <td>" . $row["bname"] . "</td>
                            <td>" . $row["categoryName"] . "</td>
                            <td>" . $row["subcategoryName"] . "</td>
                            <td>" . $row["bauthor"] . "</td>
                            <td>" . $row["pubName"] . "</td>
                            <td>" . $row["bquantity"] . "</td>
                            <td><img src='" . $row["bimage"] . "' height='30' width='30' style='border-radius: 0% 30% 10% 10%'></td>
                            <td>" . $row["bpublishdate"] . "</td>
                            <td>
                                <a href=\"./book.php?edit=" . $row["id"] . "\">
                                    <svg width='16' height='16' viewBox='0 0 25 24' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M22.5 8.75V7.5L15 0H2.5C1.1125 0 0 1.1125 0 2.5V20C0 21.3875 1.125 22.5 2.5 22.5H10V20.1625L20.4875 9.675C21.0375 9.125 21.7375 8.825 22.5 8.75ZM13.75 1.875L20.625 8.75H13.75V1.875ZM24.8125 13.9875L23.5875 15.2125L21.0375 12.6625L22.2625 11.4375C22.5 11.1875 22.9125 11.1875 23.1625 11.4375L24.8125 13.0875C25.0625 13.3375 25.0625 13.75 24.8125 13.9875ZM20.1625 13.5375L22.7125 16.0875L15.05 23.75H12.5V21.2L20.1625 13.5375Z' />
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href=\"./book.php?delete=" . $row["id"] . "\">
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
                    <form action="./book.php" method="post" enctype="multipart/form-data">
                        <select name="category" id="category">
                            <?php
                            if (mysqli_num_rows($resFetchsub) > 0) {
                                while ($rowcat = mysqli_fetch_assoc($resFetchsub)) {
                                    echo "<option value=" . $rowcat['id'] . ">" . $rowcat['cname'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <select name="subcategory" id="subcategory">
                            <?php
                            if (mysqli_num_rows($resFetchSubcat) > 0) {
                                while ($rowsubcat = mysqli_fetch_assoc($resFetchSubcat)) {
                                    echo "<option value=" . $rowsubcat['id'] . ">" . $rowsubcat['subcatname'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="editId" value="<?php echo $editId ?>" id="">
                        <input type="text" name="bname" value="<?php echo $bname ?>" id=" bname" placeholder="Book Name" required>
                        <input type="text" name="bauthor" value="<?php echo $bauthor ?>" id=" bauthor" placeholder="Author Name" required>
                        <input type="text" name="pubname" value="<?php echo $pubName ?>" id="pubname" placeholder="Publication Name" required>
                        <input type="number" name="bquantity" value="<?php echo $bquantity ?>" id=" bquantity" placeholder="Quantity" required>
                        <input id="bimage" type="file" name="image" accept=".jpg, .png, .jpeg" value="<?php echo $bimage ?>" required>
                        <div id="pbdate">
                            <input type="date" name="bpublishdate" value="<?php echo $bpublishdate ?>" id=" bpublishdate" required>
                        </div>
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