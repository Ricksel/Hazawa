<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send us Feedback - hazawa</title>
    <link rel="stylesheet" href="feedback-style.css">
    <link rel="stylesheet" href="main.css">
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
        $database = "hangaroo_db"; // Change this to your database name
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comments"])) {
            // Prepare and bind parameters
            $stmt = $conn->prepare("INSERT INTO comments_tbl (comments, sender) VALUES (?, ?)");
            $stmt->bind_param("ss", $comments, $sender);
            
            // Set parameters and execute
            $comments = $_POST["comments"];
            $sender = $_POST["sender"];
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
        <p>Leave a comment</p>
        <div class="comment-form">
            <form action="feedback.php" method="post">
                <input type="text" name="sender" placeholder="Sender">
                <textarea name="comments" rows="10" placeholder="Write Your Comment"></textarea>
                <button type="submit">Post Comment</button>
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
</body>
</html>