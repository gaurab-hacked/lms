<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: /lms/auth/login.php");
}
?>
<?php
// $id = $_SESSION['id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

?>
<style>
    #userIcon svg {
        height: 50px;
        width: 50px;
        padding: 5px;
        background-color: rgba(0, 0, 0, 0.7);
        fill: white;
        border-radius: 50%;
        cursor: pointer;
    }

    #contentShowing {
        position: absolute;
        content: "";
        top: 70px;
        right: 23px;
        min-height: 110px;
        width: 200px;
        color: black;
        text-align: left;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 2px;
        box-shadow: 0px 1px 2px 1px rgba(0, 0, 1, 0.8);
        background-color: rgba(241, 241, 252, 1);
        line-height: 20px;
        letter-spacing: 1px;
        font-family: Arial;
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
        padding: 5px 8px;
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

    #goHomeDiv {
        width: 100%;
        max-height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 5px;
        cursor: pointer;
        transition: 0.2s;
        border-radius: 2px;
        border: 2px solid rgba(144, 132, 214, 1);
        ;
    }

    #goIndex-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        gap: 5px;
        font-family: arial;
        font-size: 14px;
        color: black;
        font-weight: 600;
        transition: 0.2s;
    }

    #goHomeDiv:hover,
    #goIndex-btn:hover {
        color: white;
        background-color: rgba(144, 132, 214, 1);
    }
    /* css of search div */
.search-box{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 400px;
    gap: 10px;
    background-color: white;
    border-radius: 3px;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
}
/* css for search input field */
.search-box input{
    width: 335px;
    outline: none;
    border: none;
}
.search-box input::placeholder{
    letter-spacing: 1px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
    font-weight: 600;
}
/* css for search icon */
.search-box svg{
    cursor: pointer;
    margin-top: 5px;
}
#search-btn {
    background-color: transparent;
            border: none;
        }
</style>
<div id="maindiv">
    <nav id="snav">
        <div class="icon">
            <img src="./LMS.jpg" height="50" width="50" style="border-radius:50%; object-fit:cover; "
                alt="Logo Not Found">
            <ul>
                <li>
                    <a href="dashBoard.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.3334 26.6667V18.6667H18.6667V26.6667H25.3334V16H29.3334L16 4L2.66669 16H6.66669V26.6667H13.3334Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Dashboard</p>
                    </div>
                </li>
                <li>
                    <a href="category.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.6667 18V28.6667H4V18H14.6667ZM16 2.66667L23.3333 14.6667H8.66667L16 2.66667ZM23.3333 17.3333C26.6667 17.3333 29.3333 20 29.3333 23.3333C29.3333 26.6667 26.6667 29.3333 23.3333 29.3333C20 29.3333 17.3333 26.6667 17.3333 23.3333C17.3333 20 20 17.3333 23.3333 17.3333Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Category</p>
                    </div>
                </li>
                <li>
                    <a href="subcategory.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.66669 2.66666H14.6667V14.6667H2.66669V2.66666ZM23.3334 2.66666C26.6667 2.66666 29.3334 5.33333 29.3334 8.66666C29.3334 12 26.6667 14.6667 23.3334 14.6667C20 14.6667 17.3334 12 17.3334 8.66666C17.3334 5.33333 20 2.66666 23.3334 2.66666ZM8.66669 18.6667L14.6667 29.3333H2.66669L8.66669 18.6667ZM25.3334 22.6667H29.3334V25.3333H25.3334V29.3333H22.6667V25.3333H18.6667V22.6667H22.6667V18.6667H25.3334V22.6667Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Subcategory</p>
                    </div>
                </li>
                <li>
                    <a href="book.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M25.3333 2.66666L18.6666 8.66666V23.3333L25.3333 17.3333V2.66666ZM8.66665 6.66666C6.06665 6.66666 3.26665 7.19999 1.33331 8.66666V28.2133C1.33331 28.5467 1.66665 28.88 1.99998 28.88C2.13331 28.88 2.19998 28.7867 2.33331 28.7867C4.13331 27.92 6.73331 27.3333 8.66665 27.3333C11.2666 27.3333 14.0666 27.8667 16 29.3333C17.8 28.2 21.0666 27.3333 23.3333 27.3333C25.5333 27.3333 27.8 27.7467 29.6666 28.7467C29.8 28.8133 29.8666 28.7867 30 28.7867C30.3333 28.7867 30.6666 28.4533 30.6666 28.12V8.66666C29.8666 8.06666 29 7.66666 28 7.33332V25.3333C26.5333 24.8667 24.9333 24.6667 23.3333 24.6667C21.0666 24.6667 17.8 25.5333 16 26.6667V8.66666C14.0666 7.19999 11.2666 6.66666 8.66665 6.66666Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Books</p>
                    </div>
                </li>
                <li>
                    <a href="message.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.6667 10.6667L16 17.3333L5.33335 10.6667V8L16 14.6667L26.6667 8M26.6667 5.33334H5.33335C3.85335 5.33334 2.66669 6.52 2.66669 8V24C2.66669 24.7072 2.94764 25.3855 3.44774 25.8856C3.94783 26.3857 4.62611 26.6667 5.33335 26.6667H26.6667C27.3739 26.6667 28.0522 26.3857 28.5523 25.8856C29.0524 25.3855 29.3334 24.7072 29.3334 24V8C29.3334 6.52 28.1334 5.33334 26.6667 5.33334Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Message</p>
                    </div>
                </li>
                <li>
                    <a href="members.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16 7.33333C17.2377 7.33333 18.4247 7.825 19.2998 8.70017C20.175 9.57534 20.6667 10.7623 20.6667 12C20.6667 13.2377 20.175 14.4247 19.2998 15.2998C18.4247 16.175 17.2377 16.6667 16 16.6667C14.7623 16.6667 13.5753 16.175 12.7002 15.2998C11.825 14.4247 11.3333 13.2377 11.3333 12C11.3333 10.7623 11.825 9.57534 12.7002 8.70017C13.5753 7.825 14.7623 7.33333 16 7.33333ZM6.66667 10.6667C7.41333 10.6667 8.10667 10.8667 8.70667 11.2267C8.50667 13.1333 9.06667 15.0267 10.2133 16.5067C9.54667 17.7867 8.21333 18.6667 6.66667 18.6667C5.6058 18.6667 4.58839 18.2452 3.83824 17.4951C3.08809 16.7449 2.66667 15.7275 2.66667 14.6667C2.66667 13.6058 3.08809 12.5884 3.83824 11.8382C4.58839 11.0881 5.6058 10.6667 6.66667 10.6667ZM25.3333 10.6667C26.3942 10.6667 27.4116 11.0881 28.1618 11.8382C28.9119 12.5884 29.3333 13.6058 29.3333 14.6667C29.3333 15.7275 28.9119 16.7449 28.1618 17.4951C27.4116 18.2452 26.3942 18.6667 25.3333 18.6667C23.7867 18.6667 22.4533 17.7867 21.7867 16.5067C22.9333 15.0267 23.4933 13.1333 23.2933 11.2267C23.8933 10.8667 24.5867 10.6667 25.3333 10.6667ZM7.33333 24.3333C7.33333 21.5733 11.2133 19.3333 16 19.3333C20.7867 19.3333 24.6667 21.5733 24.6667 24.3333V26.6667H7.33333V24.3333ZM0 26.6667V24.6667C0 22.8133 2.52 21.2533 5.93333 20.8C5.14667 21.7067 4.66667 22.96 4.66667 24.3333V26.6667H0ZM32 26.6667H27.3333V24.3333C27.3333 22.96 26.8533 21.7067 26.0667 20.8C29.48 21.2533 32 22.8133 32 24.6667V26.6667Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Members</p>
                    </div>
                </li>


                <li>
                    <a href="restriction.php"><svg width="32" height="32" viewBox="0 0 32 32"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.6667 13.3333H4V16H18.6667V13.3333ZM18.6667 8H4V10.6667H18.6667V8ZM4 21.3333H13.3333V18.6667H4V21.3333ZM19.2 29.3333L22.6667 25.8667L26.1333 29.3333L28 27.4667L24.5333 24L28 20.5333L26.1333 18.6667L22.6667 22.1333L19.2 18.6667L17.3333 20.5333L20.8 24L17.3333 27.4667L19.2 29.3333Z" />
                        </svg>
                    </a>
                    <div class="iconname">
                        <p>Restriction</p>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div id="topMain">
        <nav id="topnav">
            <div>
                <h2>Library Management System</h2>
                <p id="greeting">
                    
                </p>
            </div>
            <div id="rightnavContent">
                <div id="toplast">
                    <ul>
                    <form action="">
                <div class="search-box">
                    <input type="text" name="search" id="search"
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>"
                        placeholder="Search Books..." id="search-box" autocomplete="off">
                    <div>
                        <svg width="3" height="25" viewBox="0 0 1 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0.5" y1="23.0217" x2="0.5" stroke="#757575" />
                        </svg>
                    </div>
                    <div>
                        <button id="search-btn">
                            <svg width="20" height="20" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.42857 0C9.39875 0 11.2882 0.782651 12.6814 2.17578C14.0745 3.56891 14.8571 5.45839 14.8571 7.42857C14.8571 9.26857 14.1829 10.96 13.0743 12.2629L13.3829 12.5714H14.2857L20 18.2857L18.2857 20L12.5714 14.2857V13.3829L12.2629 13.0743C10.96 14.1829 9.26857 14.8571 7.42857 14.8571C5.45839 14.8571 3.56891 14.0745 2.17578 12.6814C0.782651 11.2882 0 9.39875 0 7.42857C0 5.45839 0.782651 3.56891 2.17578 2.17578C3.56891 0.782651 5.45839 0 7.42857 0ZM7.42857 2.28571C4.57143 2.28571 2.28571 4.57143 2.28571 7.42857C2.28571 10.2857 4.57143 12.5714 7.42857 12.5714C10.2857 12.5714 12.5714 10.2857 12.5714 7.42857C12.5714 4.57143 10.2857 2.28571 7.42857 2.28571Z"
                                    fill="#757575" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
                        <li id="userIcon" onclick="showContent()" style="margin-left:20px">
                            <svg width="45" height="45" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.5 7.5C24.4891 7.5 26.3968 8.29018 27.8033 9.6967C29.2098 11.1032 30 13.0109 30 15C30 16.9891 29.2098 18.8968 27.8033 20.3033C26.3968 21.7098 24.4891 22.5 22.5 22.5C20.5109 22.5 18.6032 21.7098 17.1967 20.3033C15.7902 18.8968 15 16.9891 15 15C15 13.0109 15.7902 11.1032 17.1967 9.6967C18.6032 8.29018 20.5109 7.5 22.5 7.5ZM22.5 26.25C30.7875 26.25 37.5 29.6062 37.5 33.75V37.5H7.5V33.75C7.5 29.6062 14.2125 26.25 22.5 26.25Z" />
                            </svg>

                        </li>
                        <div id="contentShowing" style="display:none">
                            <p id="name">
                                <?php echo "User: " . $name; ?>
                            </p>
                            <p>
                                <?php echo "Email: " . $email; ?>
                            </p>
                            <p id="head">Library Management System</p>
                            <form action="../auth/logOut.php" method="POST">
                                <button id="logout-btn" name="logOutSubmit" type="submit">Log Out</button>
                            </form>
                            <div id="goHomeDiv">
                                <a href="../index.php" id="goIndex-btn">
                                    <svg width="25" height="25" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_204_2)">
                                            <path d="M40 80V56H56V80H76V48H88L48 12L8 48H20V80H40Z" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_204_2">
                                                <rect width="96" height="96" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p>Go Home</p>
                                </a>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <script>
        function showContent() {
            let content = document.getElementById("contentShowing");
            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }
        }

        let date = new Date();
        let hour = date.getHours();
        let greet = "";

        if (hour >= 5 && hour < 12) {
            greet = "Welcome, Admin! Good morning.";
        } else if (hour >= 12 && hour < 18) {
            greet = "Welcome, Admin! Good Afternoon.";
        } else {
            greet = "Welcome, Admin! Good Evening";
        }
        let greetingParagraph = document.getElementById("greeting");
        greetingParagraph.textContent = greet;

    </script>