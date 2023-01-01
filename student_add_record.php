<?php
@include 'config/config.php';
@include 'phpqrcode/qrlib.php';

if (isset($_POST["Add"])) {
  $stud_id = $_POST["txtstudid"];
  $fname = mysqli_real_escape_string($conn, $_POST['txtfname']);
  $mname = mysqli_real_escape_string($conn, $_POST["txtmname"]);
  $lname = mysqli_real_escape_string($conn, $_POST["txtlname"]);
  $sex = mysqli_real_escape_string($conn, $_POST["txtsex"]);
  $fk_course_id = mysqli_real_escape_string($conn,  $_POST["txtcourse"]);
  $fk_section_id = mysqli_real_escape_string($conn, $_POST["txtsection"]);
  $fk_year_id = mysqli_real_escape_string($conn, $_POST["txtyear"]);
 
// Generating qr code image
    $codeContents = $stud_id;
    QRcode::png($codeContents, $pathDir.'qrcode_images/'.$stud_id.'.png', QR_ECLEVEL_L, 5);

  

  $select = " SELECT * FROM tblstudentinfo WHERE stud_id = '$stud_id' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {

    //$error[] = 'Student Id No. is Aleady Exist!';

    echo "<script>alert('Student Id No. is Aleady Exist!'); window.location = 'student.php';</script>";
  }else{
    $insert = "INSERT INTO tblstudentinfo (stud_id, fname, mname, lname, sex, fk_course_id, fk_section_id, fk_year_id, qrname) 
    VALUES('$stud_id', '$fname', '$mname', '$lname', '$sex', '$fk_course_id', '$fk_section_id', '$fk_year_id', '$codeContents')";
   mysqli_query($conn, $insert);
   echo "<script>alert('Record has been saved'); window.location = 'student.php';</script>";
}
}
?>

