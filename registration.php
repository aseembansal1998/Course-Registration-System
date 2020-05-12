<?php
require("dbinfo.inc");
require("front.php");
?>


    <div class="content-wrap">

        <div class="text-center">
            <form action="registration.php" method="post">
                <input class="searchBar" type="search" id="myInput" placeholder="Search for courses.." name="search"
                       size="100"/>

                <div class="Filters">
                    <select id="field" name="field">
                        <!--                        <option value='Arts'>Arts and Humanities</option>-->
                        <option value='Science'>Computing Science</option>
                        <option value='Management'>Management</option>
                    </select>


                    <select id="year" name="year">
                        <option value='First'>First Year</option>
                        <option value='Second'>Second Year</option>
                        <option value='Third'>Third Year</option>
                        <option value='Fourth'>Fourth Year</option>
                    </select>
                    <input type="submit" value="Search"/>
                </div>
            </form>

        </div>
    </div>

<?php
// Create connection
$qconn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['year']) && isset($_POST['field'])) {
    if (($_POST['field'] == 'Science') && ($_POST['year'] == 'First')) {
        echo "<strong>";
        echo "Below are the Computing Science First Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";
        // query to get all Fitzgerald records
        $sql = "SELECT * FROM Course WHERE cid in (112, 115, 160, 162) ";
    } elseif (($_POST['field'] == 'Science') && ($_POST['year'] == 'Second')) {
        echo "<strong>";
        echo "Below are the Computing Science Second Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (251, 260, 261, 265) ";
    } elseif (($_POST['field'] == 'Science') && ($_POST['year'] == 'Third')) {
        echo "<strong>";
        echo "Below are the Computing Science Third Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (311, 320, 322, 330, 331, 355, 360, 370, 375)";
    } elseif (($_POST['field'] == 'Science') && ($_POST['year'] == 'Fourth')) {
        echo "<strong>";
        echo "Below are the Computing Science Four Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (400, 405)";
    } elseif (($_POST['field'] == 'Management') && ($_POST['year'] == 'First')) {
        echo "<strong>";
        echo "Below are the Management First Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (100, 101)";
    } elseif (($_POST['field'] == 'Management') && ($_POST['year'] == 'Second')) {
        echo "<strong>";
        echo "Below are the Management Second Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (201, 217, 294)";
    } elseif (($_POST['field'] == 'Management') && ($_POST['year'] == 'Third')) {
        echo "<strong>";
        echo "Below are the Management Third Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (317, 335, 336, 340)";
    } elseif (($_POST['field'] == 'Management') && ($_POST['year'] == 'Fourth')) {
        echo "<strong>";
        echo "Below are the Management Fourth Year Courses. Select the courses by clicking the checkbox button and click on Enroll button to enroll into the courses.";
        echo "</strong>";
        echo "<br/>";
        echo "<br/>";

        // query to get all Herring records
        $sql = "SELECT * FROM Course WHERE cid in (410, 421)";
    } else {
        $sql = "SELECT * FROM Course WHERE cid=400";

    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $r1=$row['cid'];
            echo '<form action="enrolled.php" method="post">';
            echo "<strong>" . "<input type='checkbox' value='$r1' name='value[]'/>";
            echo " ";
            echo $row['cid'] . " ";
            echo $row['credits'] . " " . $row['name'] . "</strong><br>";
            echo "<strong>" . "Course Description: " . "</strong>";
            echo $row['description'];
            echo "<br/><br/>";
        }
        
           echo  '<input type="submit"  value="Enroll" name="Enroll"> ';
           echo'<input type="button" value="Generate tuition receipt" name="Generate tution receipt" onclick="createPDF()">';
       echo '</form>';
        echo "<br>";

    }
}
$conn->close();
?>

<?php
require("back.php");
?>