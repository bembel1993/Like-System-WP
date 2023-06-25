<?php
$servername = "localhost";
$username = "sqluser";
$password = "password";
$dbname = "systemlike";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection succes";

$dbuser = "SELECT id, nameus FROM user WHERE id=9";
$user = $conn->query($dbuser);
$row = $user->fetch_assoc();
$userId = $row['id'];
$userName = $row['nameus'];

$sqlArticle = "SELECT id, articlename FROM article WHERE id = 2";
$result2 = $conn->query($sqlArticle);
$row = $result2->fetch_assoc();
$articleId = $row['id'];

if (!empty($articleId)) {
    if (isset($_POST['like'])) {
        $sqlFromTable = "SELECT likes, nameus FROM liked ORDER BY likes DESC";
        $result1 = $conn->query($sqlFromTable);
        $row = $result1->fetch_assoc();
        $like = $row['likes'];
        $nameLike = $row['nameus'];

        $sqlFromTable = "SELECT dis, nameus FROM dislike ORDER BY dis DESC";
        $result1 = $conn->query($sqlFromTable);
        $row = $result1->fetch_assoc();
        $dislike = $row['dis'];
        $nameDisLike = $row['nameus'];

        if ($userName != $nameLike && $userName != $nameDisLike) {
            $sql = "INSERT INTO liked (likes, nameus, userId, articleId) VALUES ('$like'+1, '$userName', '$userId', '$articleId')";
            if (mysqli_query($conn, $sql)) {

                $sql = "SELECT likes FROM liked ORDER BY likes DESC";
                $result2 = $conn->query($sql);
                $row = $result2->fetch_assoc();
                $like2 = $row['likes'];

                header("Location: index.php");
                // echo $like2;
            } else {
                echo "Error like: ";
            }
        }
        if ($userName != $nameLike && $userName == $nameDisLike) {

            $sql = "DELETE FROM dislike WHERE userId=$userId";

            if (mysqli_query($conn, $sql)) {

                $sql2 = "SELECT likes, nameus FROM liked ORDER BY likes DESC";
                $result2 = $conn->query($sql2);
                $row = $result2->fetch_assoc();
                $like2 = $row['likes'];
                $nameL = $row['nameus'];

                $sql1 = "INSERT INTO liked (likes, nameus, userId, articleId) VALUES ('$like'+1, '$userName', '$userId', '$articleId')";

                if (mysqli_query($conn, $sql1)) {
                    header("Location: index.php");
                    // echo $like2;
                }
            } else {
                echo "Error like: ";
            }
        } else {
            header("Location: index.php");
        }
    }

    if (isset($_POST['dislike'])) {
        $sqlFromTable = "SELECT dis, nameus FROM dislike ORDER BY dis DESC";
        $result1 = $conn->query($sqlFromTable);
        $row = $result1->fetch_assoc();
        $dislike = $row['dis'];
        $nameDisLike = $row['nameus'];

        $sqlFromTable = "SELECT likes, nameus FROM liked ORDER BY likes DESC";
        $result1 = $conn->query($sqlFromTable);
        $row = $result1->fetch_assoc();
        $like = $row['likes'];
        $nameLike = $row['nameus'];

        if ($userName != $nameLike && $userName != $nameDisLike) {
            $sql = "INSERT INTO dislike (dis, nameus, userId) VALUES ('$dislike'+1, '$userName', '$userId')";
            if (mysqli_query($conn, $sql)) {

                $sql = "SELECT dis FROM dislike ORDER BY dis DESC";
                $result2 = $conn->query($sql);
                $row = $result2->fetch_assoc();
                $like2 = $row['dis'];
                header("Location: index.php");
                // echo $like2;
            } else {
                echo "Error dislike: ";
            }
        }
        if ($userName == $nameLike && $userName != $nameDisLike) {

            $sql = "DELETE FROM liked WHERE userId=$userId";

            if (mysqli_query($conn, $sql)) {

                $sql2 = "SELECT likes, nameus FROM liked ORDER BY likes DESC";
                $result2 = $conn->query($sql2);
                $row = $result2->fetch_assoc();
                $like2 = $row['likes'];
                $nameL = $row['nameus'];

                $sql1 = "INSERT INTO dislike (dis, nameus, userId) VALUES ('$dislike'+1, '$userName', '$userId')";
                if (mysqli_query($conn, $sql1)) {
                    header("Location: index.php");
                    // echo $like2;
                }
            } else {
                echo "Error like: ";
            }
        } else {

            header("Location: index.php");
        }
    }
}
$conn->close();
