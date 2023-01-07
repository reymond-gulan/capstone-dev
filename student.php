<?php
include('config/config.php');
include('functions.php');

$active = semester(1, $conn);
$semester = semester(0, $conn);

@include("config/db_connect.php");
include "./shared/nav-items.php";
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Semester Information</title>
  <meta charset="utf-8">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
 
  <link rel="stylesheet" href="css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <script>
        $(document).ready(function() {
            $('#dataTable_1').DataTable();
        });
    </script>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <?php navItems("Student Profile") ?>
  </div>
  <section class="home-section">
  <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Student Profile</span>
      </div>
    
      <form action="" id="form" method="POST">
        <div class="search-box">
            <?=$semester?>
            <i class="bx bx-search"></i>
        </div>
      </form>
    </nav>

    <div class="home-content">
      <section class="attendance">
        <div class="attendance-list">
          <!-- <a href="student_add_record.php" class="btn"> <i class='bx bx-plus'></i>Add Student Information</a> -->
        
          <!-- This is the import modal -->
          <button type="button" class="btn " data-toggle="modal" data-target="#modal-studentinfo">
              Add Student Information </button>
          <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal">
              Import Student </button><br></br>
              

          <!-- <a href="import-excel/indexstudent.php" class="btn">Import Student</a><BR></BR> -->
         <!-- start of the table -->
         <?php
						
            if (isset($_SESSION["error"])) {
              
              echo '<span style="font-size:24px;color:red" class="error-msg">' . $_SESSION["error"] . '</span>';
              $_SESSION["error"] = null;
              
              };
          ?>
          <table id="dataTable_1" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>QR Image</th>
                <th>Student ID No.</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Course Year & Section</th>
                <!-- <th>Assign Subject</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!--PHP CODE HERE LIST ALL THE DATA AVAILABLE IN DATABASE-->
              <?php
                if(isset($_POST['semester_id'])) {
                    $semester_id = $_POST['semester_id'];
                    
                } else {
                    $semester_id = $active['id'];
                }

                $sql = "SELECT A.id, A.stud_id, A.fname, A.mname, A.lname, A.sex, B.coursecode, C.year_code, D.section_code, A.qrname
                        FROM tblstudentinfo AS A 
                                INNER JOIN tblcourse AS B ON A.fk_course_id = B.id 
                                INNER JOIN tblyear AS C ON A.fk_year_id = C.id
                                INNER JOIN tblsection AS D ON A.fk_section_id = D.id 
                                WHERE A.is_deleted = '0'
                                AND A.semester_id = $semester_id";
              $res = $conn->prepare($sql);
              $res->execute();

              $i = 1;
              if ($res->rowCount() > 0) {
                while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>
                  <td>" . $i . "</td>
                <td><a href='qrcode_images/".$row['qrname'].".png' download/>
                
                <img src='qrcode_images/".$row['qrname'].".png'></a></td>
                <td>" . $row['stud_id'] . "</td>
                <td>" . $row['fname'] . " " . $row['mname'] . " " . $row['lname'] . "</td>
                <td>" . $row['sex'] . "</td>
                
                <td>" . $row['coursecode'] . " " . $row['year_code'] . " - " . $row['section_code'] . "</td>
                <td><a href = 'student_edit_record.php?id=" . $row['id'] . "'><i class='fas fa-edit' style='font-size:24px;color:black'></i></a> | ";
              ?>

                  <a href='student_delete_record.php?id=<?php echo $row['id']; ?>' onClick="return confirm('are you sure you want to delete this?');"><i class='far fa-trash-alt' style='font-size:24px;color:red'></i></a></td>
              <?php

                  $i++;
                }
              } else {
                echo "<tr> <td colspan = '9'> NO RECORDS FOUND</td> </tr>";
              }

              ?>

            </tbody>
          </table>
        </div>
      </section>
      <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
      $(function(){
        $('#semester_id').addClass('form-control h-100');

        $('#semester_id').on('change', function(){
            $('#form').trigger('submit');
        });
      });
    </script>
    <?php if(isset($_POST['semester_id'])):?>
        <script>
            $('#semester_id').val(<?=$_POST['semester_id']?>);
        </script>
    <?php endif;?>
      <?php include 'modal/exportStudent_modal.php';?>
      <?php include 'modal/studentInfo_modal.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="javascript/script.js"></script>
   

</body>

</html>