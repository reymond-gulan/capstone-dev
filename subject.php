<?php 
  include "./shared/nav-items.php";
  @include './subjecthandler/subject_eventhandler.php';
  @include './config/db_connection.php';

session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}
  
  $_conn = new ConnectionHandler();
  $_subject = new Subject($_conn);
  $result = $_subject->getSubject();
  $number_daw_sabi_ni_czarina = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Semester Information</title>

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
    <?php navItems("Subject") ?>
  </div>
  <section class="home-section">
  <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Subject Record</span>
      </div>
    </nav>

    <div class="home-content">
      <section class="attendance">
        <div class="attendance-list">
        <button type="button" class="btn " data-toggle="modal" data-target="#modal-subject">
              Add Subject Information </button>
           
              <button type="button" class="btn " data-toggle="modal" data-target="#import-modal">
              Import Subject </button><br></br>       
              
              <?php
						
            if (isset($_SESSION["error"])) {
              
              echo '<span style="font-size:24px;color:red" class="error-msg">' . $_SESSION["error"] . '</span>';
              $_SESSION["error"] = null;
              
              };
          ?>
              <!-- This is the start of the table -->
          <table id="dataTable_1" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Subject Code</th>
                <th>Subject Description</th>
                <th>Schedule</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- PHP CODE HERE -->
              <!-- = is equivalent to echo -->
              <?php foreach ($result as $key => $item) { ?>
                <tr>
                  <td><?= $key + 1 ?></td>
                  <td><?= $item["subject_code"] ?></td>
                  <td><?= $item["subject_description"] ?></td>
                  <td>
                    <a href="scheduler.php?id=<?= $item["id"] ?>">
                      View
                    </a>
                  </td>
                  <td>
                    <a href="subject_edit_record.php?id=<?= $item["id"] ?>">
                      <i class='fas fa-edit' style='font-size:24px;color:black'></i>
                    </a>
                    <a href='subject_delete_record.php?id=<?= $item['id']; ?>' 
                       onClick="return confirm('are you sure you want to delete this?');">
                        <i class='far fa-trash-alt' style='font-size:24px;color:red'></i>
                    </a>
                  </td>
                
                </tr>
              <?php } ?>

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
    </script>
      <?php include 'modal/subject_modal.php';?>
      <?php include 'modal/importSubject_modal.php';?>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="javascript/script.js"></script>
</body>

</html>