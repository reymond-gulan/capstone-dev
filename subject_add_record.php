<?php


if(isset($_POST["btnsave"])){
    $subject_code = $_POST["txtsubject_code"];
    $subject_description = $_POST["txtsubject_description"];


    if($subject_code == ""){
      echo "Please input valid Student ID!";
    }elseif($subject_description == ""){
      echo "Please input valid Name!";
    }else{

    
     require("config/config.php");
      $query = $conn->prepare("SELECT * FROM tblsemester WHERE is_active = true");
      $query->execute();
      $result = $query->get_result();
      $row = mysqli_fetch_array($result);

      require("config/db_connect.php");

      $sql = "INSERT INTO tblsubject (subject_code, subject_description, fk_semester_id)
       VALUES(:subject_code, :subject_description, :semester_id)";
        
        $result = $conn->prepare($sql);
        $values = array("subject_code" => $subject_code, "subject_description" => $subject_description, "semester_id" => $row['id']);
    
        $result->execute($values);
    
        if($result->rowCount()>0){
            echo "<script>alert('Record has been saved'); window.location = 'subject.php';</script>";
        }else{
            echo "<script>alert('No record has been saved');</script>";
        }
    }
  }
?>


