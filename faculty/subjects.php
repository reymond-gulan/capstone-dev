<?php
require("../config/config.php");
include "../shared_faculty/nav-items.php";
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:../index.php');
    exit;
}

if(isset($_SESSION['user_id'])) {
    $faculty_id = $_SESSION['user_id'];

    $query  = $conn->prepare("SELECT *
                                FROM
                                    classes
                                INNER JOIN tblinstructor 
                                    ON (classes.instructor_id = tblinstructor.id)
                                INNER JOIN tblsemester 
                                    ON (classes.semester_id = tblsemester.id)
                                INNER JOIN tblsubject 
                                    ON (classes.subject_id = tblsubject.id)
                                INNER JOIN tblcourse 
                                    ON (classes.course_id = tblcourse.id)
                                WHERE classes.instructor_id = ?");
    $query->bind_param('i', $faculty_id);
    $query->execute();

    $result = $query->get_result();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Student Profile</title>
  <link rel="stylesheet" href="../css/sidebar.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Faculty</span>
    </div>
    <?php navItems("Subject") ?>
  </div>
  <section class="home-section">
    <div class="header">
      <h1>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h1>
    </div>
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard"></span><?php echo $_SESSION['USER_NAME'] ?>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search..." />
        <i class="bx bx-search"></i>
      </div>
    </nav>

    <div class="home-content">
    <section class="attendance">
        <div class="attendance-list">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Course Year & Section</th>
                <th>Subjects</th>
                <th>Schedule</th>
                <th>Attendance</th>
                <th>Attendance Report</th>
                <th>View Student</th>
                <th>Manage Seat Plan</th>
              </tr>
            </thead>
            <tbody>
              <!--PHP CODE HERE -->
                <?php if(mysqli_num_rows($result) > 0):?>
                    <?php foreach($result as $key => $row):?>
                        <tr>
                            <td><?=$key + 1?></td>
                            <td><?=strtoupper($row['coursecode'])?> - <?=strtoupper($row['coursedescription'])?></td>
                            <td><?=strtoupper($row['subject_code'])?> - <?=strtoupper($row['subject_description'])?></td>
                            <td class="small">
                                <ul class="small">
                                    <?php
                                        $schedule = json_decode($row['schedules']);

                                        foreach($schedule as $sched){
                                            $sch = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM schedules WHERE schedule_id = '".$sched."'"));

                                            ?>
                                            <li style="text-transform:none;">
                                            <?=$sch['day_of_the_week']?> | <?=date('h:i a', strtotime($sch['start_time']))?> to <?=date('h:i a', strtotime($sch['end_time']))?> |
                                            <?=strtoupper($sch['room_details'])?>
                                            </li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td><a href="attendance.php?id=<?=$row['class_id']?>">Attendance</a></td>
                            <td><a href="reports.php?id=<?=$row['class_id']?>">Attendance Report</a></td>
                            <td><a href="viewstudents.php?id=<?=$row['class_id']?>">View Students</a></td>
                            <td><a href="seatplan.php?id=<?=$row['class_id']?>">Seat Plan</a></td>
                        </tr>
                    <?php endforeach;?>
                <?php else:?>
                    <tr>
                        <td colspan="7">
                            <center>
                                No assigned subject found.
                            </center>
                        </td>
                    </tr>
                <?php endif;?>
            </tbody>
          </table>
    </div>



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
</body>

</html>