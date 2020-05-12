<?php
require("dbinfo.inc");
require("front.php");
?>

<?php

$conn = mysqli_connect($servername, $username, $password, $database);


echo "<strong>" . "Below are the list of your enrolled courses. Select the courses by clicking the checkbox button and click on Remove button to De-enroll from the courses." . "</strong>";
echo "<br><br>";
$sql = "select * from Course, enrolledCourses where Course.cid = enrolledCourses.cid";
global $conn;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $r2 = $row['cid'];
        echo '<form action="remove.php" method="post">';
        echo "<strong>" . "<input type='checkbox' value='$r2' name='remove[]'/>";
        echo " ";
        echo $row['cid'] . " ";
        echo $row['credits'] . " " . $row['name'] . "</strong><br>";
        echo "<strong>" . "Course Description: " . "</strong>";
        echo $row['description'];
        echo "<br/><br/>";
    }
    echo '<input type="submit"  value="De-enroll" name="De-enroll"> ';
    echo"<input type='button' value='Generate tuition receipt' name='Generate tution receipt' onclick=window.open('pdff.php')>";
    echo '</form>';
    echo "<br>";
}

if (isset($_POST['De-enroll'])) {
    if (isset($_POST['remove'])) {
        $checkbox = $_POST['remove'];
        for ($i = 0; $i < count($checkbox); $i++) {
            $del_id = $checkbox[$i];
            $in_ch1=mysqli_query($conn, "DELETE FROM enrolledCourses WHERE cid='" . $del_id . "'");
            //$message = "Data deleted successfully !";
            //echo $message;
            if ($in_ch1 == 1) {
                echo '<script>alert("You have been de-enrolled from the course")</script>';
                //display();
                //header('Location: remove.php');
            }
        }

    }

}


$conn->close();
?>
<?php
require("back.php");
?>
