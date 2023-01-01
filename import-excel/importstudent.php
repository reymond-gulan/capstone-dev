<?php
include '../config/config.php';
include '../phpqrcode/qrlib.php';
if (isset($_POST["Import"])) {


	 $filename = $_FILES["file"]["tmp_name"];


	if ($_FILES["file"]["size"] > 0) {

		$file = fopen($filename, "r");
		while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
			// change course to course_id
			// Generating of QR code image when data has been imported
			$codeContents = $emapData[0];
    QRcode::png($codeContents, $pathDir.'../qrcode_images/'.$emapData[0].'.png', QR_ECLEVEL_L, 5);
			// set to be in all lowercase to match with the data
			$emapData[1] = strtolower($emapData[1]);
			// fetch the ID of the course specified
			$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM tblcourse WHERE coursecode='$emapData[1]'"));
			// prepare to input the data
			$fk_1 = $data['id'];
			//Duplication trapping. If user import data with the same id number it wouldn't be imported
			$select = " SELECT * FROM tblstudentinfo WHERE stud_id = '$emapData[0]' ";
			$result = mysqli_query($conn, $select);

			if (mysqli_num_rows($result) > 0) {
		 session_start();
			  $_SESSION["error"] = 'Student ID No. is Aleady Exist!';
			echo "<script type=\"text/javascript\">
							window.location = \"../student.php\"
					</script>";
			}else {
				//It wiil insert a row to our subject table from our csv file`
				$sql = "INSERT INTO tblstudentinfo (stud_id, fk_course_id, fk_year_id, fk_section_id, fname, mname,lname, sex, qrname) VALUES('$emapData[0]','$fk_1','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$codeContents')";
				//we are using mysql_query function. it returns a resource on true else False on error
				$result = mysqli_query($conn, $sql);
				if (!$result) {
					echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"indexstudent.php\"
							</script>";
							
				}else{
					echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"../student.php\"
					</script>";
				}
			}
	}
		fclose($file);
		//throws a message if data successfully imported to mysql database from excel file
		// echo "<script type=\"text/javascript\">
		// 				alert(\"CSV File has been successfully Imported.\");
		// 				window.location = \"../student.php\"
		// 			</script>";



		//close of connection
		mysqli_close($conn);
	}
}
