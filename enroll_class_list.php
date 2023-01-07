<?php
include('config/config.php');
include('functions.php');

$active = semester(1, $conn);
$semester = semester(0, $conn);

include('header.php');

if(isset($_GET['id'])) {
    $class_id   = filter($_GET['id']);

    $query  = $conn->prepare("SELECT * FROM classes WHERE class_id = ?");
    $query->bind_param('i', $class_id);
    $query->execute();

    $r  = $query->get_result();
    if(mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_array($r);
        $semester = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tblsemester WHERE id = '".$row['semester_id']."'"));
        $subject = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tblsubject WHERE id = '".$row['subject_id']."'"));
        $instructor_r = mysqli_query($conn, "SELECT * FROM tblinstructor WHERE id = '".$row['instructor_id']."'");
        $instructor = mysqli_fetch_array($instructor_r);
        $course_r = mysqli_query($conn, "SELECT * FROM tblcourse WHERE id = '".$row['course_id']."'");
        $course = mysqli_fetch_array($course_r);
    }else {
        header('Location: enroll.php');
        exit;
    }
} else {
    header('Location: enroll.php');
    exit;
}

$stmt   = $conn->prepare("SELECT * FROM tblstudentinfo WHERE is_deleted = false AND semester_id = ?");
$stmt->bind_param('i', $active['id']);
$stmt->execute();
$result = $stmt->get_result();

$c = $conn->prepare("SELECT * FROM tblstudentinfo WHERE is_deleted = false AND semester_id = ? GROUP BY cys");
$c->bind_param('i', $active['id']);
$c->execute();
$c_result = $c->get_result();
?>
<div class="container-fluid p-0">
<div class="sidebar">
    <div class="logo-details">
      <span class="logo_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Administrator</span>
    </div>
    <?php navItems("Class Management") ?>
  </div>
  <section class="home-section">
    <div class="header">
      <h5>COLLEGE OF COMPUTING STUDIES, INFORMATION AND COMMUNICATION TECHNLOGY</h5>
    </div>
    <nav>
        <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Class List </span>
        </div>

      
    </nav>

<div class="home-content attendance px-3">
    <div class="container attendance-list px-3"
    style="text-transform:none;">
        Class List for <b class="text-transform: !important;"><?=$subject['subject_code']?> - <?=$subject['subject_description']?></b>
        <table>
            <tr>
                <td>Semester : <b><?=$semester['semester_code']?> - <?=$semester['semester_year']?></b></td>
            </tr>
            <tr>
                <td>Schedule</td>
            </tr>
            <tr>
                <td class="pl-5">
                    <ul class="small">
                    <?php
                        $schedule = json_decode($row['schedules']);

                        if($row['schedules'] !== 'null') {
                            foreach($schedule as $sched){
                                $sch = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM schedules WHERE schedule_id = '".$sched."'"));

                                ?>
                                <li style="text-transform:none;">
                                <?=$sch['day_of_the_week'] ?? ''?> | 
                                <?= (isset($sch['start_time'])) ? $sch['start_time'].' to ' : '';?>
                                <?= (isset($sch['end_time'])) ? $sch['end_time'].' to ' : '';?>
                                |
                                <?=strtoupper($sch['room_details'] ?? '')?>
                                </li>
                                <?php
                            }
                        }
                    ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <?php if(mysqli_num_rows($instructor_r) > 0):?>
                        INSTRUCTOR :
                        <b><?=strtoupper($instructor['lname'].', '.$instructor['fname'].' '.$instructor['mname'])?></b>
                    <?php else:?>
                        No Instuctor
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php if(mysqli_num_rows($course_r) > 0):?>
                        <b><?=strtoupper($course['coursecode'].'- '.$course['coursedescription'])?> <?=$row['yr_and_section']?><b>
                    <?php else:?>
                        No Course
                    <?php endif;?>
                </td>
            </tr>
        </table>
    </div>
</div>
    <section class="attendance">
      <div class="attendance-list">
        <a href="#" class="btn load-students" data-toggle="modal" data-target="#modal"> Add Students</a>

        <a href="#" class="btn remove-multiple"> Remove From Class List</a>
        <div id="class-list" class="pt-5">

        </div>
      </div>
    </section>
</section>
</div>
<!--- MODAL -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal"><b>
            SELECT STUDENTS
        </b></h6></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php foreach($c_result as $cys):?>
            <button type="button" class="btn btn-info cys-btn" data-value="<?=strtoupper($cys['cys'])?>">
            <?=strtoupper($cys['cys'])?>
            </button>
        <?php endforeach;?>
        <div id="student-list"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--- MODAL -->

<script>
function load(class_id){
    $.ajax({
        url:'enrollment_actions.php',
        method:'POST',
        data:{
            load:'load',
            class_id:class_id
        },
        dataType:'json',
        success:function(html){
            $('#class-list').html(html);
        }
    });
}
function load_class(class_id){
    $.ajax({
        url:'enrollment_actions.php',
        method:'POST',
        data:{
            class_id:class_id,
            load_class:'load'
        },
        dataType:'json',
        success:function(html){
            $('#student-list').html(html);
        }
    });
}
    $(function(){
        $('#dt').DataTable({
            paging: false,
            ordering:  false,
            info:false
        });
        var class_id = <?=$class_id?>;

        load(class_id);

        $(document).on('click','.load-students', function(){
            load_class(class_id);
        });

        $(document).on('click','.cys-btn', function(){
            var value = $(this).data('value');
            $('#data_filter input').val(value);
            $('#data_filter input').trigger('focus');
            $('#data_filter input').trigger('keyup');
        });

        $(document).on('click','#select-all', function(){
            var checkbox = $('#select-all');

            if(checkbox.prop('checked')) {
                $('.student-record').prop('checked', true);
            } else {
                $('.student-record').prop('checked', false);
            }
        });

        $(document).on('click','.remove-multiple', function(){
            var list_id = [];
            $('input[name="list_id"]:checked').each(function() {
                list_id.push(this.value);
            });

            if(list_id.length > 0) {
                Swal.fire({
                title: 'Are you sure?',
                text: "Once deleted, it cannot be undone. Proceed anyway?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajax({
                            url:'enrollment_actions.php',
                            method:'POST',
                            data:{
                                list_id:list_id,
                                remove_multiple:`delete`
                            },
                            dataType:'json',
                            success:function(response){
                                if(response == 'success') {
                                    Swal.fire("SUCCESS!",'Record/s has been removed!','success');
                                    load(class_id);
                                }
                            }
                        });
                    }
                });
            } else {
                Swal.fire("ERROR!",'Select record first!','error');
            }
        });

        $(document).on('click','.add-to-class-list', function(){
            var id = $(this).data('id');

            $.ajax({
                url:'enrollment_actions.php',
                method:'POST',
                data:{
                    id:id,
                    class_id:class_id,
                    add_to_class_list:'save',
                },
                dataType:'json',
                success:function(response){
                    if(response == 'success') {
                        load(class_id);
                        load_class(class_id);
                    } else {
                        Swal.fire("ERROR!",'Server Error. Reload page.','error');
                    }
                }
            });
        });

        $(document).on('click','.remove-from-class-list', function(){
            var list_id = $(this).data('list_id');
            var class_id = $(this).data('class_id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Once deleted, it cannot be undone. Proceed anyway?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                        url:'enrollment_actions.php',
                        method:'POST',
                        data:{
                            list_id:list_id,
                            remove_from_class_list:`delete`
                        },
                        dataType:'json',
                        success:function(response){
                            if(response == 'success') {
                                Swal.fire("SUCCESS!",'Record has been removed!','success');
                                load(class_id);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
<?php include('footer.php');?>