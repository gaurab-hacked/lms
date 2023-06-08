<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: /lms/auth/login.php");
}
?>
<?php
$id = $_SESSION['id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

?>


<html>

<head>
    <link rel="stylesheet" href="./CSS/home.css">
</head>
<style>
    #userIcon svg {
        height: 43px;
        width: 43px;
        padding: 5px;
        background-color: rgba(0, 0, 0, 0.7);
        fill: white;
        border-radius: 50%;
        cursor: pointer;
    }

    #content {
        position: absolute;
        content: "";
        top: 60px;
        right: 18px;
        min-height: 110px;
        width: 200px;
        color: rgba(0, 0, 0, 1);
        text-align: left;
        text-decoration: none;
        font-size: 12px;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 2px;
        box-shadow: 0px 1px 3px 1px rgba(0, 0, 0, 0.2);
        line-height: 20px;
        letter-spacing: 1px;
        font-family: Arial;
        background-color: rgba(241, 241, 252, 1);
        font-weight: 400;
    }

    #name {
        font-size: 14px;
        text-transform: capitalize;
    }

    #head {
        font-weight: 400;
        font-size: 13px;
        color: rgba(0, 0, 0, 0.7);
    }


    #logout-btn {
        border: none;
        padding: 6px 8px;
        font-size: 14px;
        font-weight: 600;
        background-color: rgba(144, 132, 214, 1);
        width: 100%;
        margin-top: 5px;
        cursor: pointer;
        border-radius: 2px;
        transition: 0.2s;
        letter-spacing: 1px;
    }

    #logout-btn:hover,
    #showContentButton:hover {
        background-color: rgb(39, 29, 94);
        color: white;
    }
</style>

<body>
    <div>
        <nav class="navbar">
            <img src="./images/image 2.png" alt="LOGO" id="logo">
            <div class="menu">
                <ul class="list">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./allBook.php">All Books</a></li>
                    <li><a href="./contactUs.php">Contact Us</a></li>
                    <li><a href="./about.php">About Us</a></li>
                    <li id="userIcon" onclick="showContent()"><svg width="45" height="45" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.5 7.5C24.4891 7.5 26.3968 8.29018 27.8033 9.6967C29.2098 11.1032 30 13.0109 30 15C30 16.9891 29.2098 18.8968 27.8033 20.3033C26.3968 21.7098 24.4891 22.5 22.5 22.5C20.5109 22.5 18.6032 21.7098 17.1967 20.3033C15.7902 18.8968 15 16.9891 15 15C15 13.0109 15.7902 11.1032 17.1967 9.6967C18.6032 8.29018 20.5109 7.5 22.5 7.5ZM22.5 26.25C30.7875 26.25 37.5 29.6062 37.5 33.75V37.5H7.5V33.75C7.5 29.6062 14.2125 26.25 22.5 26.25Z" />
                        </svg>
                        <div id="content" style="display: none;">
                            <!-- Content to be displayed -->
                            <p id="name"><?php echo "User: " . $name; ?></p>
                            <p><?php echo "Email: " . $email; ?></p>

                            <p id="head">Library Management System</p>
                            <form action="./auth/logOut.php" method="POST">
                                <button id="logout-btn" name="logOutSubmit" type="submit">Log Out</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <script>
        function showContent() {
            let contentDiv = document.getElementById("content");
            if (contentDiv.style.display === "none") {
                contentDiv.style.display = "block";
            } else {
                contentDiv.style.display = "none";
            }
        }
    </script>
</body>

</html>