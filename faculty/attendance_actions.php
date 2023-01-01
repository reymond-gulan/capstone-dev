<?php
    include('../config/config.php');

    date_default_timezone_set("Asia/Manila");
    $response = array();

    if(isset($_POST['student_id'])) {
        $student_id     = filter($_POST['student_id']);
        $class_id     = filter($_POST['class_id']);
        $schedule_id     = filter($_POST['schedule_id']);
        $time_in = date('h:i a');
        $logdate = date('Y-m-d');

        $query = $conn->prepare("SELECT * FROM tblstudentinfo WHERE stud_id = ?");
        $query->bind_param('s', $student_id);
        $query->execute();

        $result = $query->get_result();

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            
            $query2 = $conn->prepare("SELECT * FROM class_list
                                        WHERE class_id = ? AND student_id = ?");
            $query2->bind_param('ii', $class_id, $row['id']);
            $query2->execute();
            $result2 = $query2->get_result();
            if(mysqli_num_rows($result2) > 0) {

                $select = $conn->prepare("SELECT * FROM tblattendance WHERE fk_student_id = ? AND fk_subject_id = ? AND logdate = ?");
                $select->bind_param('iis', $row['id'], $class_id, $logdate);
                $select->execute();
                $r_select = $select->get_result();
                
                if(mysqli_num_rows($r_select) > 0){
                    $response['status'] = 'error';
                    $response['message'] = "You already logged your attendance.";
                    exit(json_encode($response));
                }

                $query3 = $conn->prepare("SELECT * FROM schedules WHERE schedule_id = ?");
                $query3->bind_param('i', $schedule_id);
                $query3->execute();
                $result3 = $query3->get_result();
                $row3 = mysqli_fetch_array($result3);

                $start_time = $row3['start_time'];
                $end_time = $row3['end_time'];

                /***
                 * 
                 *  Time filtering if time in is later than the end of the scheduled time.
                 * 
                 * ***/

                // if(strtotime($time_in) > strtotime($end_time)) {
                //     $response['status'] = 'error';
                //     $response['message'] = "Schedule for this class has already ended. You are not allowed to submit your attendance after the scheduled time.";
                //     exit(json_encode($response));
                // }

                $grace_period = 900; // 15 minutes in seconds

                $time_in_to_filter = strtotime($time_in) + $grace_period;

                if($time_in_to_filter <= strtotime($start_time)) {
                    $is_late = false;
                    $status = "On Time";
                } else {
                    $is_late = true;
                    $status = "Late";
                }

                $insert = $conn->prepare("INSERT INTO tblattendance(fk_student_id, fk_subject_id, time_in, logdate, schedule_id, is_late)
                                            VALUES(?,?,?,?,?,?)");
                $insert->bind_param('iisssi', $row['id'], $class_id, $time_in, $logdate, $schedule_id, $is_late);
                if($insert->execute()) {
                    
                    $response['status'] = 'success';
                    $response['message'] = "Saved!";
                    
                    $html = "";

                    $html .= '<div class="alert alert-info">
                                <center>
                                    <h6>
                                        <b>('.$student_id.') '.strtoupper($row['lname'].', '.$row['fname'].' '.$row['mname']).'</b>
                                    </h6>
                                    <hr class="m-0 p-0">
                                    <p>
                                        Time: <b>'.$time_in.'</b> ('.$status.')<br />
                                        Date: <b>'.date('F j, Y', strtotime($logdate)).'</b>
                                    </p>
                                </center>
                            </div>';
                    $response['html'] = $html;

                    exit(json_encode($response));
                } else {
                    $response['status'] = 'error';
                    $response['message'] = "Server error. Please reload page.";
                    exit(json_encode($response));
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = "You have no record for this class."; 
                exit(json_encode($response));
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Unauthorized server request. Submitted data is not recognized.";
            exit(json_encode($response));
        }
    }

    if(isset($_POST['action'])) {
        $class_id = filter($_POST['class_id']);
        $logdate = date('Y-m-d');
        $html = "";

        $query = $conn->prepare("SELECT *
                FROM
                    tblattendance
                    INNER JOIN classes 
                        ON (tblattendance.fk_subject_id = classes.class_id)
                    INNER JOIN tblstudentinfo 
                        ON (tblattendance.fk_student_id = tblstudentinfo.id)
                    INNER JOIN tblsubject 
                        ON (classes.subject_id = tblsubject.id)
                        WHERE tblattendance.fk_subject_id = ? AND tblattendance.logdate = ?
                        ORDER BY tblattendance.id DESC");
        $query->bind_param('is', $class_id, $logdate);
        $query->execute();
        $result = $query->get_result();
        if(mysqli_num_rows($result) > 0) {
            foreach($result as $row) {
                $html .= '<tr>
                            <td>'.$row['stud_id'].'</td>
                            <td>'.strtoupper($row['lname'].', '.$row['fname'].' '.$row['mname']).'</td>
                            <td>'.$row['time_in'].'</td>
                            <td>'.$row['logdate'].'</td>
                            </tr>'; 
            }
            exit(json_encode($html));
        }
    }
?>