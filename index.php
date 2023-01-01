<?php
    include('config/config.php');

    date_default_timezone_set("Asia/Manila");

    if(isset($_POST['student_id'])) {
        $student_id     = filter($_POST['student_id']);

        $query = $conn->prepare("SELECT * FROM tblstudentinfo WHERE stud_id = ?");
        $query->bind_param('s', $student_id);
        $query->execute();

        $result = $query->get_result();

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            
            $query2 = $conn->prepare("SELECT * FROM classes INNER JOIN class_list ON (classes.class_id = class_list.class_id)
                                        WHERE student_id = ?");
            $query2->bind_param('i', $row['id']);
            $query2->execute();

            

            $result2 = $query2->get_result();
            if(mysqli_num_rows($result2) > 0) {
                $row2 = mysqli_fetch_array($result2);
                $schedule = str_replace(array('[',']',"\"") ,'', $row2['schedules']);
                $day = date('l');
                
                $query3 = $conn->prepare("SELECT * FROM schedules WHERE day_of_the_week = ? AND schedule_id IN (?)");
                $query3->bind_param('ss',$day, $schedule);
                $query3->execute();
                
                $result3 = $query3->get_result();
                $row3 = mysqli_fetch_array($result3);
            } else {
                echo "ERROR2!";
            }
        } else {
            echo "ERROR!";
        }
    }
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

 
    <script>
        $(document).ready(function() {
            $('#dataTable_1').DataTable();
        });
    </script>

    <title>CCSICT Attendance System</title>
</head>
<nav class="navbar navbar-expand-lg" style="background-color: coral">
    <a class="navbar-brand" href="#"><strong style="color: #fff"><i class='fa fa-user-clock'></i> Smart Student Class Attendance Monitoring System </strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="user-login.php" style="color: #fff"><b><i class="fa fa-user"></i> LOGIN </b></a>
            </li>

        </ul>

    </div>
</nav><br>

<body onload="startTime()"><br>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <center>
                    <p style="border: 1px solid coral;background-color:coral;color: #fff"><i class="fas fa-qrcode"></i> TAP HERE</p>
                </center>
                <video id="preview" width="100%"></video>
                <!-- Getting the process of attendance -->
                <hr>
                </hr>
            </div>
            <div class="col-md-8">
                <center>
                    <div id="clockdate" style="border: 1px solid coral;background-color: coral">
                        <div class="clockdate-wrapper">
                            <div id="clock" style="font-weight: bold; color: #fff;font-size: 40px"></div>
                            <div id="date" style="color: #fff"><i class="fas fa-calendar"></i> <?php echo date('l, F j, Y'); ?></div>
                        </div>
                    </div>
                </center>
                <form action="" method="POST" class="form-harizontal">

                    <label><b>SCAN QR CODE</b></label>
                    <input type="text" name="student_id" id="student_id" readonly="" placeholder="Scan Qr Code" class="form-control">
                </form>
                <hr>
                </hr>  <div class="table-responsive">
                    <table id="dataTable_1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>STUDENT-ID NO.</th>
                                <th>TIME IN</th>
                                <th>LOGDATE</th>
                                <th>SUBJECT</th>
                            </tr>
                        </thead>
                        <tbody>  <!--PHP CODE HERE -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found');
            }

        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c) {
            document.getElementById('student_id').value = c;
            
            document.forms[0].submit();
        });

        $('.form-harizontal').on('submit', function(e){
            e.preventDefault();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="javascript/script.js"></script>
</body>

</html>