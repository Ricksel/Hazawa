<?php
// Include your database connection code here if not in a separate file
require_once("database.php");

// Initialize variables to store user input and error messages
$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    // If both email and password are provided and valid, attempt login
    if (empty($emailErr) && empty($passwordErr)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                // Verify password
                if (password_verify($password, $row['password'])) {
                    // Password is correct, start a new session
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['email'] = $row['email'];
                    // Redirect to the dashboard or any other page after successful login
                    header("Location: feedback.php");
                    exit();
                } else {
                    $passwordErr = "Invalid password";
                }
            } else {
                $emailErr = "Email not found";
            }
        } else {
            echo "Error: " . mysqli_error($conn); // Output the specific database error for debugging
        }

        mysqli_stmt_close($stmt);
    }
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send us Feedback - hazawa</title>
    <link rel="stylesheet" href="signin-style.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <?php
        // Establish database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "comments_db"; // Change this to your database name
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment_text"])) {
            // Prepare and bind parameters
            $stmt = $conn->prepare("INSERT INTO comments (comment_text, comment_user) VALUES (?, ?)");
            $stmt->bind_param("ss", $comment_text, $comment_user);
            
            // Set parameters and execute
            $comment_text = $_POST["comment_text"];
            $comment_user = $_POST["comment_user"];
            $stmt->execute();
            
            // Close statement
            $stmt->close();
        }

        // Close connection
        $conn->close();
    ?>

    <section>
        <div class="empty">
            <br><br>
        </div>
    </section>
    <section>
        <div class="navbar">
            <a href="page-home.html"><img src="image.png" class="logo"></a>
            <ul>
                <li><a href="page-home.html">Home</a></li>
                <li id="active"><a href="page-news.html">News</a></li>
                <li><a href="PageHome.html">About Me</a></li>
                <li><a href="feedback.php">Contact</a></li>
            </ul>
        </div>
    </section>
    <div class="comment-box">
    <br><br>
        <h1>Sign In to Send Feedback</h1>
        <br><br><br>
        <div class="comment-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                <span class="text-danger"><?php echo $emailErr; ?></span>
                <br><br>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                <span class="text-danger"><p class="error"><?php echo $passwordErr; ?></p></span>
                <br>
                <button type="submit">Sign In</button>
                <br>
                <p class="to-signup">Don't have an account? Sign up <a href="signup.php" class="link">here</a></p>
                <br>
            </form>
        </div>
    </div>
    <section>
        <div class="empty">
            <br>
        </div>
    </section>
    <footer>
        <div class="footer-col">
            <div class="logo-container">
                <img src="image.png" alt="Your Logo">
            </div>
        </div>
        <div class="footer-col">
            <h4>Gallery</h4>
            <ul>
                <li class="mini-gallery"><a href="news-bookreview-bookthief.html"><img src="C.jpg" alt="Team 1"></a></li>
                <li class="mini-gallery"><a href="news-games-gaming.html"><img src="LC.png" alt="Team 2"></a></li>
                <li class="mini-gallery"><a href="news-bookreview-si.html"><img src="A.jpg" alt="Team 3"></a></li>
                <li class="mini-gallery"><a href="news-drawings-toilet.html"><img src="1.jpg" alt="Team 3"></a></li>
            </ul>
        </div>        
        <div class="footer-col">
        <h4>Latest</h4>
            <ul class="aye">
                <li><a href="news-bookreview-animalfarm.html">
                    <p>
                        Book Review: "Animal Farm" George Orwell
                    </p>
                </a></li>
                <li><a href="news-bookreview-bookthief.html">
                    <p>
                        Book Review: "The Book Thief" Markus Zusak
                    </p>
                </a></li>
                <li><a href="news-drawings-sparkle.html">
                    <p>
                        Childe is the best 
                        character on this 
                        g**damn game 
                    </p>
                </a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Socials</h4>
            <div class="links">
                <a href="https://www.facebook.com/ricksel.cadano" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/_RixeL_" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/rckslm.cdn/" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>