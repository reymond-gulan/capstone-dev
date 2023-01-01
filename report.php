<?php
session_start();
if($_SESSION['user_id'] == "")
{
    $_SESSION['user_id'];
    header('location:user-login.php');
    exit;
}

include('config/config.php');
include('header.php');
$today = date('Y-m-d');
if(isset($_POST['search'])) {
    $from = filter($_POST['date_from']);
    $to = filter($_POST['date_to']);
    $query  = $conn->prepare("SELECT tblstudentinfo.*
                                FROM
                                    tblattendance
                                    INNER JOIN classes 
                                        ON (tblattendance.fk_subject_id = classes.class_id)
                                    INNER JOIN tblsemester 
                                        ON (classes.semester_id = tblsemester.id)
                                    INNER JOIN tblsubject 
                                        ON (classes.subject_id = tblsubject.id)
                                    INNER JOIN tblstudentinfo 
                                        ON (tblattendance.fk_student_id = tblstudentinfo.id)
                                    WHERE tblattendance.logdate BETWEEN ? AND ?
                                    GROUP BY tblattendance.fk_student_id");
    $query->bind_param('ss', $from, $to);

    $date = 'Report dated from <b>'.date('F j, Y', strtotime($from)).'</b> to <b>'.date('F j, Y', strtotime($to)).'</b>';
} else {
    $query  = $conn->prepare("SELECT tblstudentinfo.*
                            FROM
                                tblattendance
                                INNER JOIN classes 
                                    ON (tblattendance.fk_subject_id = classes.class_id)
                                INNER JOIN tblsemester 
                                    ON (classes.semester_id = tblsemester.id)
                                INNER JOIN tblsubject 
                                    ON (classes.subject_id = tblsubject.id)
                                INNER JOIN tblstudentinfo 
                                    ON (tblattendance.fk_student_id = tblstudentinfo.id)
                                WHERE tblattendance.logdate = ?
                                GROUP BY tblattendance.fk_student_id");
    $query->bind_param('s', $today);

    $date = 'Report dated : <b>'.date('F j, Y', strtotime($today)).'</b>';
}

$query->execute();
$result = $query->get_result();
?>
<div class="container-fluid p-0">
<div class="sidebar">
    <div class="logo-details">
      <span class="logo_name"></span>
    </div>
    <ul class="nav-links">
      <li>
        <?php if($_SESSION['user_type'] == 'Faculty'):?>
        <a href="faculty/faculty_page.php">
        <?php else:?>
            <a href="dashboard.php">
        <?php endif;?>
        <i class='bx bx-arrow-back'></i>
          <span class="links_name">Back</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="header">
      <h3>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNOLOGY</h3>
    </div>
    <nav>
        <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Attendance Report </span>
        </div>
        <section>
            <form action="" method="POST">
            <input type="date" class="p-3" name="date_from" required>
            <input type="date" class="p-3" name="date_to" required>
            <button type="submit" name="search" class="btn btn-primary p-3 px-4">
                <i class="fa fa-search"></i>
            </button>
            </form>
        </section>
    </nav>

<div class="home-content attendance px-3">
</div>
    <section class="attendance">
      <div class="attendance-list">
            <center>
                <p><?=$date?></p>
            </center>
            <table class="table" id="dt">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $key => $row):?>
                        <tr>
                            <td><?=$row['stud_id']?></td>
                            <td><?=strtoupper($row['lname'].', '.$row['fname'].' '.$row['mname'])?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
      </div>
    </section>
</section>
</div>

<script>
    $(function(){
        $('#dt').DataTable();
    });
</script>
<?php include('footer.php');?>