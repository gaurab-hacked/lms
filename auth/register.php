<?php
include "../common/backendConnector.php";
// db connection in (lms) db
$con = mysqli_connect($host,$dbUserName,$dbPassword,$database);
if (!$con) {
    die("DB connection failed");
}

// to post data in (users) table
if (isset($_POST['registerSubmit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phnumber = $_POST['phnumber'];
    $profession = $_POST['profession'];
    $status = 2;
    
    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM `users` WHERE `email` = '$email'";
    $checkEmailResult = mysqli_query($con, $checkEmailQuery);
    
    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "<div class='showNotificaion error' id='showNotification'>
        <div class='notificationshow'>
            <div class='name'>
                Error:
            </div>
            <div class='message'>
                Email Address Already Exists! Try Another Email..
            </div>
        </div>
    </div>";
    } else {
        if ($email == "admin@gmail.com") {
            $status = 1;
        }

        // Convert password into a hash value
        $passhash = password_hash($password, PASSWORD_DEFAULT);

        // Insert query
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `phnumber`, `profession`, `status`) VALUES ('$name', '$email', '$passhash', '$phnumber', '$profession', '$status')";
        $res = mysqli_query($con, $sql);

        if ($res) {
            $_SESSION['status'] = $status;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            if (intval($status) != 1) {
                header("Location: /lms/");
            } else {
                header("Location: /lms/admin/dashBoard.php");
            }
        } else {
            echo "Record not inserted: " . mysqli_error($con);
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LMS-Register</title>
    <link rel="stylesheet" href="../CSS/register.css" />
</head>

<body>
    <div id="regForm">
        <h2>LMS register</h2>
        <form action="./register.php" method="post">
            <div class="inpfld animationfld">
                <label for="name">User Name</label>
                <input type="text" name="name" id="name" required autocomplete="off"/>
            </div>

            <div class="inpfld animationfld">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required autocomplete="off"/>
            </div>

            <div class="inpfld animationfld">
                <label for="password">Password</label>
                <input type="password" name="password" id="Password" required/>
                <div id="eyeOpen" class="eye" onclick="eyeOpen()">
                    <svg width="17" height="12" viewBox="0 0 20 15" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 4.5C9.27668 4.5 8.58299 4.81607 8.07153 5.37868C7.56006 5.94129 7.27273 6.70435 7.27273 7.5C7.27273 8.29565 7.56006 9.05871 8.07153 9.62132C8.58299 10.1839 9.27668 10.5 10 10.5C10.7233 10.5 11.417 10.1839 11.9285 9.62132C12.4399 9.05871 12.7273 8.29565 12.7273 7.5C12.7273 6.70435 12.4399 5.94129 11.9285 5.37868C11.417 4.81607 10.7233 4.5 10 4.5ZM10 12.5C8.79447 12.5 7.63832 11.9732 6.78588 11.0355C5.93344 10.0979 5.45455 8.82608 5.45455 7.5C5.45455 6.17392 5.93344 4.90215 6.78588 3.96447C7.63832 3.02678 8.79447 2.5 10 2.5C11.2055 2.5 12.3617 3.02678 13.2141 3.96447C14.0666 4.90215 14.5455 6.17392 14.5455 7.5C14.5455 8.82608 14.0666 10.0979 13.2141 11.0355C12.3617 11.9732 11.2055 12.5 10 12.5ZM10 0C5.45455 0 1.57273 3.11 0 7.5C1.57273 11.89 5.45455 15 10 15C14.5455 15 18.4273 11.89 20 7.5C18.4273 3.11 14.5455 0 10 0Z" />
                    </svg>
                </div>
                <div id="eyeClose" class="eye" onclick="eyeClose()">
                    <svg width="18" height="15" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.84545 5.68421L12.7273 8.67789C12.7273 8.63053 12.7273 8.57368 12.7273 8.52632C12.7273 7.77254 12.4399 7.04964 11.9285 6.51664C11.417 5.98365 10.7233 5.68421 10 5.68421C9.94545 5.68421 9.9 5.68421 9.84545 5.68421ZM5.93636 6.44211L7.34545 7.91053C7.3 8.10947 7.27273 8.30842 7.27273 8.52632C7.27273 9.28009 7.56006 10.003 8.07153 10.536C8.58299 11.069 9.27668 11.3684 10 11.3684C10.2 11.3684 10.4 11.34 10.5909 11.2926L12 12.7611C11.3909 13.0737 10.7182 13.2632 10 13.2632C8.79447 13.2632 7.63832 12.7641 6.78588 11.8758C5.93344 10.9874 5.45455 9.7826 5.45455 8.52632C5.45455 7.77789 5.63636 7.07684 5.93636 6.44211ZM0.909091 1.20316L2.98182 3.36316L3.39091 3.78947C1.89091 5.02105 0.709091 6.63158 0 8.52632C1.57273 12.6853 5.45455 15.6316 10 15.6316C11.4091 15.6316 12.7545 15.3474 13.9818 14.8358L14.3727 15.2337L17.0273 18L18.1818 16.7968L2.06364 0M10 3.78947C11.2055 3.78947 12.3617 4.28853 13.2141 5.17686C14.0666 6.06519 14.5455 7.27003 14.5455 8.52632C14.5455 9.13263 14.4273 9.72 14.2182 10.2505L16.8818 13.0263C18.2455 11.8421 19.3364 10.2884 20 8.52632C18.4273 4.36737 14.5455 1.42105 10 1.42105C8.72727 1.42105 7.50909 1.65789 6.36364 2.08421L8.33636 4.12105C8.85455 3.91263 9.40909 3.78947 10 3.78947Z" />
                    </svg>
                </div>
            </div>
            <div class="inpfld animationfld">
                <label for="phnumber">Phone Number</label>
                <input type="number" name="phnumber" id="Phnumber" required/>
            </div>
            <div class="inpfld radioinp">
                <div>
                    <input type="radio" name="profession" id="student" value="1" />
                    <label for="student">Student</label>
                </div>
                <div>
                    <input type="radio" name="profession" id="teacher" value="2" />
                    <label for="teacher">Teacher</label>
                </div>
            </div>
            <p>Already have account? <a href="./login.php">Log-in.</a></p>
            <button type="submit" name="registerSubmit" id="regBtn">Submit</button>
        </form>
    </div>


    <script>
        const passowrd = document.getElementById('Password');
        // for password show and hidden
        const eyeOpenVar = document.getElementById("eyeOpen");
        const eyeCloseVar = document.getElementById("eyeClose");
        eyeOpenVar.style.display = "none";
        const eyeClose = () => {
            eyeCloseVar.style.display = "none";
            eyeOpenVar.style.display = "block";
            passowrd.setAttribute("type", "text");
        };
        const eyeOpen = () => {
            eyeOpenVar.style.display = "none";
            eyeCloseVar.style.display = "block";
            passowrd.setAttribute("type", "password");
        };
        const showNotification = document.getElementById("showNotification");
        setTimeout(() => {
            showNotification.style.right = "100%"
        }, 1500);
    </script>
</body>

</html>