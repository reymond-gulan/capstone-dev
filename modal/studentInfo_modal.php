<div class="modal fade" id="modal-studentinfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <div class="span3 hidden-phone"></div>
                      
        <form action="student_add_record.php" method="post">
          <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
          <div class = "form-group">
          <label>Student ID #:</label>
          <input type="text" name="txtstudid" required placeholder="Enter student ID #" class = "form-control">
          </div>
          <div class = "form-group">
          <label>First Name:</label>
          <input type="text" name="txtfname" required placeholder="Enter student first name"class = "form-control">
          </div>
          <div class = "form-group">
            <label>Middle Name:</label>
          <input type="text" name="txtmname" required placeholder="Enter student middle name"class = "form-control">
          </div>
          <div class = "form-group">
            <label>Last Name:</label>
          <input type="text" name="txtlname" required placeholder="Enter student last name" class = "form-control">
          </div>
          <div class = "form-group">
            <label>Sex</label>
          <select name="txtsex" class = "form-control">
            <option value="cboSex">Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          </div>
          <div class = "form-group">
          <label>Course</label>
          <select name="txtcourse" class = "form-control">
            <option value="cbocourse">Course</option>
            <?php
            require("config/db_connect.php");

            $course = $conn->prepare("SELECT id, coursecode FROM tblcourse WHERE is_deleted = '0'");
            $course->execute();

            $ans = $course->setFetchMode(PDO::FETCH_ASSOC);

            while ($courseid = $course->fetch()) {
              extract($courseid);
              echo "<option value='$id'>$coursecode</option>";
            }
            ?>
          </select>
          </div>
          <div class = "form-group">
          <label>Year</label>
          <select name="txtyear" class = "form-control">
            <option value="cboyear">Year</option>
            <?php
            function yearOption()
            {
              require("config/db_connect.php");

              $year = $conn->prepare("SELECT id, year_code FROM tblyear");
              $year->execute();

              $ans = $year->setFetchMode(PDO::FETCH_ASSOC);

              while ($yearid = $year->fetch()) {
                extract($yearid);
                echo "<option value='$id'>$year_code</option>";
              }
            }
            yearOption();
            ?>
          </select>
          </div>
          <div class = "form-group" class = "form-control">
          <label>Section</label>
          <select name="txtsection" class = "form-control">
            <option value="cbosection">Section</option>
            <?php
            function sectionOption()
            {
              require("config/db_connect.php");

              $section = $conn->prepare("SELECT id, section_code FROM tblsection");
              $section->execute();

              $ans = $section->setFetchMode(PDO::FETCH_ASSOC);

              while ($sectionid = $section->fetch()) {
                extract($sectionid);
                echo "<option value='$id'>$section_code</option>";
              }
            }
            sectionOption();
            ?>
          </select>
          </div>
					</fieldset>
          <div class="modal-footer">
                      <button type="submit" id="submit" name="Add" class="btn btn-primary button-loading" data-loading-text="Loading...">Add</button>
                      </div>
				</form>

                      </div>
                    
                    </div>
                  </div>
                </div>