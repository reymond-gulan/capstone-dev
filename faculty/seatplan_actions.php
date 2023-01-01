<?php
    @require("../config/config.php");

    if(isset($_POST['class_id']) && !isset($_POST['student_id'])) {
        $class_id = filter($_POST['class_id']);

        $stmt = $conn->prepare("SELECT tblstudentinfo.*
                                FROM
                                    class_list
                                    INNER JOIN tblstudentinfo 
                                        ON (class_list.student_id = tblstudentinfo.id)
                                        WHERE tblstudentinfo.is_deleted = false AND class_list.class_id = ? 
                                        AND class_list.student_id 
                                    NOT IN (SELECT fk_student_id FROM tblseatplan)");
        $stmt->bind_param('i', $class_id);
        $stmt->execute();

        $result     = $stmt->get_result();

        $html = "";

        $html .= '<table class="table table-sm table-condensed table-borderless table-hover" id="dt">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($result as $row) {
                        $html .= '<tr style="cursor:pointer;"
                                class="assign-student"
                                data-student_id="'.$row['id'].'">';
                        $html .= '<td>'.$row['stud_id'].'</td>';
                        $html .= '<td>'.strtoupper($row['lname'].', '.$row['fname'].' '.$row['mname']).'</td>';
                        $html .= '</tr>';
                    }
        $html .= '</tbody>
                </table>
        <script>
            $("#dt").DataTable({
                paging: false,
                ordering:  false,
                info:false
            });
        </script>';

        exit(json_encode($html));
    } elseif(isset($_POST['seat_id'])){

        $id     = $_POST['seat_id'];
        $delete     = $conn->prepare("DELETE FROM tblseatplan WHERE id = ?");
        $delete->bind_param('i', $id);

        if($delete->execute()) {
            $message = 'success';
        } else {
            $message = "Unexpected server error occured. Please reload page.";
        }

        exit(json_encode($message));

    } else {
        $subject_id = $_POST['class_id'];
        $student_id = $_POST['student_id'];
        $seat_number = $_POST['seat_number'];

        $message = "";

        $select = $conn->prepare("SELECT * FROM tblseatplan WHERE seat_number = ?");
        $select->bind_param('i', $seat_number);
        $select->execute();

        $result = $select->get_result();

        $select2 = $conn->prepare("SELECT * FROM tblseatplan WHERE fk_student_id = ? AND fk_subject_id = ?");
        $select2->bind_param('ii', $student_id, $subject_id);
        $select2->execute();

        $result2 = $select2->get_result();
        
        if(mysqli_num_rows($result) > 0) {
            $message = "Seat was already taken. Vacate seat first.";
            exit(json_encode($message));
        } else if(mysqli_num_rows($result2) > 0) {
            $message = "Selected student already have assigned seat. Delete record first.";
            exit(json_encode($message));
        }

        $query = $conn->prepare("INSERT INTO tblseatplan(fk_subject_id, fk_student_id, seat_number) VALUES(?,?,?)");
        $query->bind_param('iii', $subject_id, $student_id, $seat_number);
        
        if($query->execute()) {
            exit(json_encode('success'));
        } else {
            exit(json_encode('error'));
        }
    }
?>