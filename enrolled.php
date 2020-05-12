<?php
require("dbinfo.inc");
require("front.php");
?>

<?php
// Create connection
 $conn = mysqli_connect($servername, $username, $password, $database);
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//display();
header('Location: remove.php');
if (isset($_POST['Enroll'])) {
    // print_r($_POST);
    if (isset($_POST['value'])) {

        $checkbox1 = $_POST['value'];
        $chk = "";

        foreach ($checkbox1 as $chk1) {
            $chk .= $chk1 . ",";
        }
        $in_ch = mysqli_query($conn, "insert into enrolledCourses(cid) values ('$chk')");
        if ($in_ch == 1) {
            echo '<script>alert("You have been enrolled into the course")</script>';
            //display();
            header('Location: remove.php');
        } else {
            echo '<script>alert("You are already enrolled in the course")</script>';
        }
    }

}
//function display()
//{
//    echo "<strong>" . "Below are the list of your enrolled courses. Select the courses by clicking the checkbox button and click on Remove button to Deenroll from the courses." . "</strong>";
//    echo "<br><br>";
//    $sql = "select * from Course, enrolledCourses where Course.cid = enrolledCourses.cid";
//    global $conn;
//    $result = $conn->query($sql);
//    if ($result->num_rows > 0) {
//        // output data of each row
//        while ($row = $result->fetch_assoc()) {
//            $r2=$row['cid'];
//            echo '<form action="remove.php" method="post">';
//            echo "<strong>" . "<input type='checkbox' value='$r2' name='remove[]'/>";
//            echo " ";
//            echo $row['cid'] . " ";
//            echo $row['credits'] . " " . $row['name'] . "</strong><br>";
//            echo "<strong>" . "Course Description: " . "</strong>";
//            echo $row['description'];
//            echo "<br/><br/>";
//        }
//        echo  '<input type="submit"  value="De-enroll" name="Enroll"> ';
//        echo '</form>';
//        echo "<br>";
//    }
//}

$conn->close();
?>
<?php
require("back.php");
?>
