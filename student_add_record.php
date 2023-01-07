<?php
@include 'config/config.php';
include('functions.php');
$active = semester(1, $conn);
@include 'phpqrcode/qrlib.php';

if (isset($_POST["Add"])) {
  $stud_id = $_POST["txtstudid"];
  $fname = mysqli_real_escape_string($conn, $_POST['txtfname']);
  $sex = mysqli_real_escape_string($conn, $_POST["txtsex"]);
  $course = mysqli_real_escape_string($conn,  $_POST["txtcourse"]);
  $year_and_section = mysqli_real_escape_string($conn, $_POST["year_and_section"]);
  $semester_id = $active['id'];
  $cys = strtoupper($course).' '.$year_and_section;
 
// Generating qr code image
    $codeContents = $stud_id;
    QRcode::png($codeContents, 'qrcode_images/'.$stud_id.'.png', QR_ECLEVEL_L, 5);

  

  $select = " SELECT * FROM tblstudentinfo WHERE stud_id = '$stud_id' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {

    //$error[] = 'Student Id No. is Aleady Exist!';

    echo "<script>alert('Student Id No. is Aleady Exist!'); window.location = 'student.php';</script>";
  }else{
    $insert = "INSERT INTO tblstudentinfo (stud_id, fname, sex, fk_course_id, fk_section_id, fk_year_id, qrname,course, year_and_section, cys,semester_id) 
    VALUES('$stud_id', '$fname', '$sex', '0', '0', '0', '$codeContents','$course','$year_and_section','$cys','$semester_id')";
   mysqli_query($conn, $insert);
   echo "<script>alert('Record has been saved');</script>";
}
}
?>

