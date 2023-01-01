<?php
require("config/db_connect.php");

if (isset($_POST["btnsave"])) {
  $id = $_POST["id"];
  $stud_id = $_POST["txtstudid"];
  $fname = $_POST["txtfname"];
  $mname = $_POST["txtmname"];
  $lname = $_POST["txtlname"];
  $sex = $_POST["txtsex"];
  $fk_course_id = $_POST["txtcourse"];
  $fk_section_id = $_POST["txtsection"];
  $fk_year_id = $_POST["txtyear"];

  if ($stud_id == "") {
    echo "Please input valid Student ID!";
  } elseif ($fname == "") {
    echo "Please input valid Name!";
  } elseif ($mname == "") {
    echo "Please input valid Name!";
  } elseif ($lname == "") {
    echo "Please input valid Name!";
  } elseif ($sex == "") {
    echo "Please input valid sex!";
  } elseif ($fk_course_id == "") {
    echo "Please input valid Course!";
  } else {


    $sql = "UPDATE tblstudentinfo SET stud_id=:stud_id, fname=:fname, mname=:mname, lname=:lname, sex=:sex, fk_course_id = :fk_course_id, fk_year_id = :fk_year_id, fk_section_id = :fk_section_id WHERE id = :recordid";

    $result = $conn->prepare($sql);
    $values = array(":stud_id" => $stud_id, ":fname" => $fname, ":mname" => $mname, ":lname" => $lname, ":sex" => $sex, ":fk_course_id" => $fk_course_id, ":fk_year_id" => $fk_year_id, ":fk_section_id" => $fk_section_id, ":recordid" => $id);

    $result->execute($values);

    if ($result->rowCount() > 0) {
      echo "<script>alert('Record has been saved'); window.location = 'student.php';</script>";
    } else {
      echo "<script>alert('No record has been saved');</script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit & Update Student Record</title>
  <link rel="stylesheet" href="css/add_record.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
  <div class="container">

    <!--main page-->
    <section class="main">
      <div class="main-top">
        <h1>College of Computing Studies, Information and Communication Technology</h1>
      </div>

      <div class="form-container">
        <!--php code-->
        <?php

        $sql = "SELECT * FROM tblstudentinfo WHERE id = :recordid";

        $id = "";
        $stud_id = "";
        $fname = "";
        $mname = "";
        $lname = "";
        $sex = "";
        $fk_course_id = "";
        $fk_year_id = "";
        $fk_section_id = "";

        try {
          $res = $conn->prepare($sql);
          $value = array(":recordid" => $_REQUEST["id"]);

          try {
            $res->execute($value);
            if ($res->rowCount() > 0) {

              $row = $res->fetch(PDO::FETCH_ASSOC);
              $id = $row["id"];
              $stud_id  = $row["stud_id"];
              $fname = $row["fname"];
              $mname = $row["mname"];
              $lname = $row["lname"];
              $sex = $row["sex"];
              $fk_course_id = $row["fk_course_id"];
              $fk_year_id = $row["fk_year_id"];
              $fk_section_id = $row["fk_section_id"];
            }
          } catch (PDOException $e) {
            die("An Error has been occured!");
          }
        } catch (PDOException $e) {
          die("An Error has been occured!");
        }
        ?>
        <form action="student_edit_record.php" method="post">
          <input type="hidden" name="id" value="<?php echo "$id" ?>">
          <h3>Edit & Update Student Record</h3>
          <label>Student ID Number:<br>
          <input type="text" value="<?php echo "$stud_id" ?>" name="txtstudid" required placeholder="Enter student ID #">
          <label>First Name:<br>
          <input type="text" value="<?php echo "$fname" ?>" name="txtfname" required placeholder="Enter student first name">
          <label>Middle Name:<br>
          <input type="text" value="<?php echo "$mname" ?>" name="txtmname" required placeholder="Enter student middle name">
          <label>Last Name:<br>
          <input type="text" value="<?php echo "$lname" ?>" name="txtlname" required placeholder="Enter student last name">
          <label>Sex:<br>
          <select name="txtsex" value="<?php echo "$sex" ?>">
            <option value="Sex">Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <label>Course:<br>
          <select name="txtcourse" value="<?php echo "$fk_course_id" ?>">
            <option value="">Course</option>
            <?php
            function courseOption()
            {
              require("config/db_connect.php");

              $course = $conn->prepare("SELECT id, coursecode FROM tblcourse WHERE is_deleted = '0'");
              $course->execute();

              $ans = $course->setFetchMode(PDO::FETCH_ASSOC);

              while ($courseid = $course->fetch()) {
                extract($courseid);
                echo "<option value='$id'>$coursecode</option>";
              }
            }
            courseOption();
            ?>
          </select>
          <label>Year:<br>

          <select name="txtyear" value="<?php echo "$fk_year_id" ?>">
            <option value="">Year</option>
            <?php
            function yearOption()
            {
              require("config/db_connect.php");

              $year = $conn->prepare("SELECT id, year_code FROM tblyear");
              $year->execute();

              $ans = $year->setFetchMode(PDO::FETCH_ASSOC);

              while ($yearid = $year->fetch()) {
                extract($yearid);
                echo "<option value='$id'>$year_code</option>";
              }
            }
            yearOption();
            ?>
          </select>
          <label>Section:<br>
          <select name="txtsection" value="<?php echo "$fk_section_id" ?>">
            <option value="">Section</option>
            <?php
            function sectionOption()
            {
              require("config/db_connect.php");

              $section = $conn->prepare("SELECT id, section_code FROM tblsection");
              $section->execute();

              $ans = $section->setFetchMode(PDO::FETCH_ASSOC);

              while ($sectionid = $section->fetch()) {
                extract($sectionid);
                echo "<option value='$id'>$section_code</option>";
              }
            }
            sectionOption();
            ?>
          </select>

          <input type="submit" name="btnsave" value="Save" class="form-btn">
          <li>
            <a href="student.php">
              <i class='bx bx-arrow-back'></i>
              <span class="links_name"> Back</span>
            </a>
          </li>
        </form>
      </div>
</body>

</html>