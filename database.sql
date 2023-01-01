/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.5-10.4.19-MariaDB : Database - dbcapstone
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbcapstone` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `dbcapstone`;

/*Table structure for table `class_list` */

DROP TABLE IF EXISTS `class_list`;

CREATE TABLE `class_list` (
  `list_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4;

/*Data for the table `class_list` */

insert  into `class_list`(`list_id`,`class_id`,`student_id`) values (84,9,395),(85,9,396),(86,9,421),(87,9,423),(88,9,397),(89,9,398),(90,9,399),(91,9,400),(92,9,401),(93,9,402),(94,9,403),(95,9,404),(96,9,405),(97,9,406),(98,9,407),(99,9,420),(101,9,408),(102,9,409),(103,9,410),(104,9,411),(105,9,412),(106,9,413),(107,9,414),(108,9,415),(109,9,416),(110,9,417),(111,9,418),(112,9,419),(113,9,422),(114,10,395),(115,10,396),(116,10,421),(117,10,423),(118,10,397),(119,10,398),(120,10,399),(121,10,400),(122,10,401),(123,10,402),(124,10,403),(125,10,404),(126,10,405),(127,10,406),(128,10,407),(129,10,420),(130,10,425),(131,10,408),(132,10,409),(133,10,410),(134,10,411),(135,10,412),(136,10,413),(137,10,414),(138,10,415),(139,10,416),(140,10,417),(141,10,418),(142,10,419),(143,10,422),(144,11,420),(148,13,423),(149,13,397),(150,13,395),(151,13,396);

/*Table structure for table `classes` */

DROP TABLE IF EXISTS `classes`;

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `semester_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `schedules` varchar(255) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `yr_and_section` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT 0,
  `is_archived` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `classes` */

insert  into `classes`(`class_id`,`semester_id`,`subject_id`,`schedules`,`instructor_id`,`course_id`,`yr_and_section`,`is_deleted`,`is_archived`) values (7,7,21,'[\"24\",\"25\"]',39,1,'3-1',0,0),(8,7,21,'[\"25\"]',40,3,'4-1',0,0),(9,7,21,'[\"26\",\"25\"]',12,3,'4',0,0),(10,7,24,'[\"27\"]',39,1,'3-1',0,0),(11,7,21,'[\"23\",\"24\"]',12,1,'3-1',0,0),(12,7,21,'[\"26\",\"28\"]',12,1,'3',0,0),(13,7,24,'[\"27\"]',12,1,'2',0,0);

/*Table structure for table `schedules` */

DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) DEFAULT NULL,
  `day_of_the_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `room_details` varchar(255) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT 0,
  `is_archived` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

/*Data for the table `schedules` */

insert  into `schedules`(`schedule_id`,`subject_id`,`day_of_the_week`,`start_time`,`end_time`,`room_details`,`semester_id`,`is_deleted`,`is_archived`) values (23,21,'Monday','07:30:00','09:30:00','ict lab 1',7,0,0),(24,21,'Wednesday','07:30:00','09:30:00','room 3',7,0,0),(25,21,'Friday','10:00:00','12:00:00','room 1',7,0,0),(26,21,'Thursday','00:00:00','23:59:00','room 1',7,0,0),(27,24,'Thursday','00:00:00','23:59:00','Room 1',7,0,0),(28,21,'Tuesday','07:00:00','09:00:00','r3',7,0,0);

/*Table structure for table `tbl_faculty_add_subject` */

DROP TABLE IF EXISTS `tbl_faculty_add_subject`;

CREATE TABLE `tbl_faculty_add_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_instructor_id` int(11) NOT NULL,
  `fk_subject_id` int(11) NOT NULL,
  `time` varchar(11) NOT NULL,
  `duration` varchar(11) NOT NULL,
  `fk_course_id` int(11) NOT NULL,
  `fk_year` int(11) NOT NULL,
  `fk_section` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_instructorID` (`fk_instructor_id`),
  KEY `fksubjectID` (`fk_subject_id`),
  KEY `course` (`fk_course_id`),
  KEY `year` (`fk_year`),
  KEY `section` (`fk_section`),
  CONSTRAINT `course` FOREIGN KEY (`fk_course_id`) REFERENCES `tblcourse` (`id`),
  CONSTRAINT `fk_instructorID` FOREIGN KEY (`fk_instructor_id`) REFERENCES `tblinstructor` (`id`),
  CONSTRAINT `fksubjectID` FOREIGN KEY (`fk_subject_id`) REFERENCES `tblsubject` (`id`),
  CONSTRAINT `section` FOREIGN KEY (`fk_section`) REFERENCES `tblsection` (`id`),
  CONSTRAINT `year` FOREIGN KEY (`fk_year`) REFERENCES `tblyear` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_faculty_add_subject` */

insert  into `tbl_faculty_add_subject`(`id`,`fk_instructor_id`,`fk_subject_id`,`time`,`duration`,`fk_course_id`,`fk_year`,`fk_section`) values (23,12,21,'7:00 AM','30 minutes',1,1,1);

/*Table structure for table `tbl_student_add_subject` */

DROP TABLE IF EXISTS `tbl_student_add_subject`;

CREATE TABLE `tbl_student_add_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_student_id` int(11) NOT NULL,
  `fk_subject_id` int(11) NOT NULL,
  `time_id` varchar(11) NOT NULL,
  `duration_id` varchar(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_studentID` (`fk_student_id`),
  KEY `fk_subjectID` (`fk_subject_id`),
  CONSTRAINT `fk_studentID` FOREIGN KEY (`fk_student_id`) REFERENCES `tblstudentinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_subjectID` FOREIGN KEY (`fk_subject_id`) REFERENCES `tblsubject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbl_student_add_subject` */

insert  into `tbl_student_add_subject`(`id`,`fk_student_id`,`fk_subject_id`,`time_id`,`duration_id`) values (89,395,21,'05:00 PM','1 hour'),(91,420,21,'7:00 AM','1 hour'),(92,422,21,'07:00 PM','2 hours');

/*Table structure for table `tblattendance` */

DROP TABLE IF EXISTS `tblattendance`;

CREATE TABLE `tblattendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_student_id` varchar(50) NOT NULL,
  `fk_subject_id` varchar(11) NOT NULL,
  `time_in` text NOT NULL,
  `logdate` text NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `is_late` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblattendance` */

insert  into `tblattendance`(`id`,`fk_student_id`,`fk_subject_id`,`time_in`,`logdate`,`schedule_id`,`is_late`) values (272,'422','9','01:53 pm','2022-12-30',25,1),(273,'397','9','01:53 pm','2022-12-30',25,1),(274,'396','9','01:53 pm','2022-12-30',25,1),(275,'395','9','01:53 pm','2022-12-30',25,1);

/*Table structure for table `tblcourse` */

DROP TABLE IF EXISTS `tblcourse`;

CREATE TABLE `tblcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coursecode` varchar(50) NOT NULL,
  `coursedescription` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblcourse` */

insert  into `tblcourse`(`id`,`coursecode`,`coursedescription`,`is_deleted`) values (1,'BSIT','Bachelor of Science in Information Technology',0),(2,'BSCS','Bachelor of Science in Computer Science',0),(3,'BSIS','Bachelor of Science in Information System',0),(4,'BLIS','Bachelor of Science in Library Information System',0),(25,'BSHM','Bachelor of hospitality management',1);

/*Table structure for table `tblcourseyearsection` */

DROP TABLE IF EXISTS `tblcourseyearsection`;

CREATE TABLE `tblcourseyearsection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_year` int(11) NOT NULL,
  `fk_section` int(11) NOT NULL,
  `fk_course` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courseID` (`fk_course`),
  KEY `sectionID` (`fk_section`),
  KEY `yearID` (`fk_year`),
  CONSTRAINT `courseID` FOREIGN KEY (`fk_course`) REFERENCES `tblcourse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sectionID` FOREIGN KEY (`fk_section`) REFERENCES `tblsection` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yearID` FOREIGN KEY (`fk_year`) REFERENCES `tblyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblcourseyearsection` */

insert  into `tblcourseyearsection`(`id`,`fk_year`,`fk_section`,`fk_course`,`description`) values (1,1,1,1,'');

/*Table structure for table `tblfaculty-subject` */

DROP TABLE IF EXISTS `tblfaculty-subject`;

CREATE TABLE `tblfaculty-subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_subject_section_id` int(11) NOT NULL,
  `fk_instructor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `instructorID` (`fk_instructor_id`),
  KEY `subject-sectionID` (`fk_subject_section_id`),
  CONSTRAINT `instructorID` FOREIGN KEY (`fk_instructor_id`) REFERENCES `tblinstructor` (`id`),
  CONSTRAINT `subject-sectionID` FOREIGN KEY (`fk_subject_section_id`) REFERENCES `tblsubject-section` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblfaculty-subject` */

/*Table structure for table `tblinstructor` */

DROP TABLE IF EXISTS `tblinstructor`;

CREATE TABLE `tblinstructor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_number` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `user_type` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblinstructor` */

insert  into `tblinstructor`(`id`,`employee_number`,`fname`,`mname`,`lname`,`password`,`date_created`,`user_type`,`is_deleted`) values (10,192776,'Czarina Joy','Taberna','Evangelista','0192023a7bbd73250516f069df18b500','2022-12-01','Admin',1),(12,190310,'Wills Sheyne','Del Rosario','Aradanas','0192023a7bbd73250516f069df18b500','2022-12-01','Faculty',0),(36,654345,'King','B','Moo','0192023a7bbd73250516f069df18b500','2022-12-21','',0),(37,132996,'admin','admin','admin','0192023a7bbd73250516f069df18b500','2022-12-25','Admin',0),(38,131313,'fn','mn','ln','0192023a7bbd73250516f069df18b500','2022-12-25','',0),(39,12345,'Faculty','Info','One','0192023a7bbd73250516f069df18b500','2022-12-25','Faculty',0),(40,123456,'fn','mn','ln','0192023a7bbd73250516f069df18b500','2022-12-27','Faculty',0);

/*Table structure for table `tblseatplan` */

DROP TABLE IF EXISTS `tblseatplan`;

CREATE TABLE `tblseatplan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_subject_id` int(11) DEFAULT NULL,
  `fk_student_id` int(11) DEFAULT NULL,
  `seat_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblseatplan` */

insert  into `tblseatplan`(`id`,`fk_subject_id`,`fk_student_id`,`seat_number`) values (85,13,396,2),(86,13,423,3),(87,13,397,4),(88,13,395,1),(89,9,398,5);

/*Table structure for table `tblsection` */

DROP TABLE IF EXISTS `tblsection`;

CREATE TABLE `tblsection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblsection` */

insert  into `tblsection`(`id`,`section_code`) values (1,'1'),(2,'2'),(3,'3'),(4,'4'),(5,'5'),(6,'6');

/*Table structure for table `tblsemester` */

DROP TABLE IF EXISTS `tblsemester`;

CREATE TABLE `tblsemester` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester_code` varchar(50) NOT NULL,
  `semester_description` varchar(50) NOT NULL,
  `semester_year` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblsemester` */

insert  into `tblsemester`(`id`,`semester_code`,`semester_description`,`semester_year`,`is_active`,`is_deleted`) values (7,'1st','1st semester school year 2022-2023','2022-2023',1,0),(10,'2nd','2nd semester school year 2022-2023','2022-2023',0,0),(11,'Mid Year','2022-2023','2nd Semeste',0,1),(13,'Midyear','Mid Year School Year 2022-2023','2022-2023',0,0),(14,'2022-2023','1st sem 22 - 23','2022-2023',0,0);

/*Table structure for table `tblstudent-subject` */

DROP TABLE IF EXISTS `tblstudent-subject`;

CREATE TABLE `tblstudent-subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_student_id` int(11) NOT NULL,
  `fk_subject_section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject-section_ID` (`fk_subject_section_id`),
  KEY `studentID` (`fk_student_id`),
  CONSTRAINT `studentID` FOREIGN KEY (`fk_student_id`) REFERENCES `tblstudentinfo` (`id`),
  CONSTRAINT `subject-section_ID` FOREIGN KEY (`fk_subject_section_id`) REFERENCES `tblsubject-section` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblstudent-subject` */

/*Table structure for table `tblstudentinfo` */

DROP TABLE IF EXISTS `tblstudentinfo`;

CREATE TABLE `tblstudentinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stud_id` varchar(20) NOT NULL,
  `fk_course_id` int(11) NOT NULL,
  `fk_section_id` int(11) NOT NULL,
  `fk_year_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `qrname` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_course_id` (`fk_course_id`),
  KEY `fk_section_id` (`fk_section_id`),
  KEY `fk_year_id` (`fk_year_id`),
  CONSTRAINT `fk_courseId` FOREIGN KEY (`fk_course_id`) REFERENCES `tblcourse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sectionId` FOREIGN KEY (`fk_section_id`) REFERENCES `tblsection` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yearId` FOREIGN KEY (`fk_year_id`) REFERENCES `tblyear` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=574 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblstudentinfo` */

insert  into `tblstudentinfo`(`id`,`stud_id`,`fk_course_id`,`fk_section_id`,`fk_year_id`,`fname`,`mname`,`lname`,`sex`,`qrname`,`is_deleted`) values (395,'21-1508',2,1,2,'VENNON','CALICDAN','ACOSTA','M','21-1508',0),(396,'21-1480',2,1,2,'ADRIAN','TINTERO','AGUSTIN','M','21-1480',0),(397,'21-2003',2,1,2,'MIGUEL','MIGUEL','ANDRES JR.','M','21-2003',0),(398,'21-1490',2,1,2,'DANIEL LORETO','DELA CRUZ','AZURIN ','M','21-1490',0),(399,'21-1507',2,1,2,'JOSHUA DAVE','BARRERAS','BANAGALE','M','21-1507',0),(400,'21-1489',2,1,2,'JAN AISONLEI ','CALIMAG','BUENO','M','21-1489',0),(401,'21-1484',2,1,2,'IRESH ','LACUMBO','CABAN','F','21-1484',0),(402,'21-2063',2,1,2,'NORIEL ','VILLARUZ','CADELIA','F','21-2063',0),(403,'21-1485',2,1,2,'RONALYN JOY ','ANDRES','CALPITO','F','21-1485',0),(404,'21-1483',2,1,2,'CHRISTIAN ','UTLEG','CARAUI','M','21-1483',0),(405,'21-2061',2,1,2,'JAMES NICO ','VALENCIA','CASABAR','M','21-2061',0),(406,'21-1488',2,1,2,' ANGELINE','LORENA','CHING SAI','F','21-1488',0),(407,'21-1478',2,1,2,' JONELL','DAYAG','DELA CRUZ','M','21-1478',0),(408,'21-2005',2,1,2,'ANGELYN ','BRIONES','GUMPLA','F','21-2005',0),(409,'21-2162',2,1,2,'REIGHN DANIELLE','ANN','GUMTANG','F','21-2162',0),(410,'21-1493',2,1,2,'EDMAR JAN','BUGAON','GUMTANG','M','21-1493',0),(411,'21-1502',2,1,2,'MARK CERNAN','MERCADO','GUTAY','M','21-1502',0),(412,'21-1476',2,1,2,'CZAR ERSON','SUBA','ISLA','M','21-1476',0),(413,'21-1475',2,1,2,'MARK CHRISTIAN','EUGENIO','LABUANAN','M','21-1475',0),(414,'21-1501',2,1,2,'MAGBANUA, KAIZEN TERCERO','TERCERO','MAGBANUA','F','21-1501',0),(415,'21-1494',2,1,2,'CARL RAINIER ','MAMURI','MANALILI','M','21-1494',0),(416,'21-2004',2,1,2,'SAMIRA AUBREY','DELA CRUZ','MANZANO','F','21-2004',0),(417,'21-1487',2,1,2,'JAY DANE','LAZATIN','MENDOZA','M','21-1487',0),(418,'21-1481',2,1,2,'JAYLORD','GARCIA','MENDOZA','M','21-1481',0),(419,'21-1492',2,1,2,'ROSEL','VILLANUEVA','MINA','F','21-1492',0),(420,'192773',1,1,4,'CZARINA JOY','TABERNA','EVANGELISTA','Female','192773',0),(421,'19-6546',2,1,2,'ADRIAN','TINTERO','AGUSTIN','M','19-6546',0),(422,'231',1,4,1,'King','B','Moo','Male','231',0),(423,'18-8765',2,1,2,'ADRIAN','TINTERO','AGUSTIN','M','18-8765',0),(425,'132996',3,1,4,'reymond','angel','gulan','Male','132996',0);

/*Table structure for table `tblsubject` */

DROP TABLE IF EXISTS `tblsubject`;

CREATE TABLE `tblsubject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(50) NOT NULL,
  `subject_description` varchar(50) NOT NULL,
  `fk_semester_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `semesterID` (`fk_semester_id`),
  CONSTRAINT `semesterID` FOREIGN KEY (`fk_semester_id`) REFERENCES `tblsemester` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblsubject` */

insert  into `tblsubject`(`id`,`subject_code`,`subject_description`,`fk_semester_id`,`is_deleted`) values (21,'IT411','System Administration and maintenance',7,0),(24,'it101','IT Network and Maintenance',10,0);

/*Table structure for table `tblsubject-section` */

DROP TABLE IF EXISTS `tblsubject-section`;

CREATE TABLE `tblsubject-section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cys_id` int(11) NOT NULL,
  `fk_subject_id` int(11) NOT NULL,
  `time` text NOT NULL,
  `duration` text NOT NULL,
  `day` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cysID` (`fk_cys_id`),
  KEY `subjectID` (`fk_subject_id`),
  CONSTRAINT `fk_cysID` FOREIGN KEY (`fk_cys_id`) REFERENCES `tblcourseyearsection` (`id`),
  CONSTRAINT `subjectID` FOREIGN KEY (`fk_subject_id`) REFERENCES `tblsubject` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblsubject-section` */

/*Table structure for table `tblsubjectassign` */

DROP TABLE IF EXISTS `tblsubjectassign`;

CREATE TABLE `tblsubjectassign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_instructor_id` int(11) NOT NULL,
  `fk_subject_id` int(11) NOT NULL,
  `fk_course_id` int(11) NOT NULL,
  `fk_year_id` int(11) NOT NULL,
  `fk_section_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_year_id` (`fk_year_id`),
  KEY `fk_course_id` (`fk_course_id`),
  KEY `fk_section_id` (`fk_section_id`),
  KEY `fk_instructor_id` (`fk_instructor_id`),
  KEY `fk_subjectprof_id` (`fk_subject_id`),
  CONSTRAINT `fk_course_id` FOREIGN KEY (`fk_course_id`) REFERENCES `tblcourse` (`id`),
  CONSTRAINT `fk_instructor_id` FOREIGN KEY (`fk_instructor_id`) REFERENCES `tblinstructor` (`id`),
  CONSTRAINT `fk_section_id` FOREIGN KEY (`fk_section_id`) REFERENCES `tblsection` (`id`),
  CONSTRAINT `fk_subjectprof_id` FOREIGN KEY (`fk_subject_id`) REFERENCES `tblsubject` (`id`),
  CONSTRAINT `fk_year_id` FOREIGN KEY (`fk_year_id`) REFERENCES `tblyear` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblsubjectassign` */

/*Table structure for table `tblsubjecttostudent` */

DROP TABLE IF EXISTS `tblsubjecttostudent`;

CREATE TABLE `tblsubjecttostudent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_subjectassign_id` int(11) NOT NULL,
  `fk_studentassign_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subjectassign_id` (`fk_subjectassign_id`),
  KEY `fk_studentassign_id` (`fk_studentassign_id`),
  CONSTRAINT `fk_studentassign_id` FOREIGN KEY (`fk_studentassign_id`) REFERENCES `tblstudentinfo` (`id`),
  CONSTRAINT `fk_subjectassign_id` FOREIGN KEY (`fk_subjectassign_id`) REFERENCES `tblsubjectassign` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblsubjecttostudent` */

/*Table structure for table `tbltime` */

DROP TABLE IF EXISTS `tbltime`;

CREATE TABLE `tbltime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_code` time NOT NULL,
  `time_description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tbltime` */

insert  into `tbltime`(`id`,`time_code`,`time_description`) values (1,'07:00:00','AM'),(2,'07:30:00','AM'),(3,'08:00:00','AM'),(4,'08:30:00','AM'),(5,'09:00:00','AM'),(6,'09:30:00','AM'),(7,'10:00:00','AM'),(8,'10:30:00','AM'),(9,'11:00:00','AM'),(10,'11:30:00','AM'),(11,'12:00:00','PM'),(12,'12:30:00','PM'),(13,'01:00:00','PM'),(14,'01:30:00','PM'),(15,'02:00:00','PM'),(16,'02:30:00','PM'),(17,'03:00:00','PM'),(18,'03:30:00','PM'),(19,'04:00:00','PM'),(20,'04:30:00','PM'),(21,'05:00:00','PM'),(22,'05:30:00','PM'),(23,'06:00:00','PM');

/*Table structure for table `tblyear` */

DROP TABLE IF EXISTS `tblyear`;

CREATE TABLE `tblyear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_code` varchar(50) NOT NULL,
  `year_description` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tblyear` */

insert  into `tblyear`(`id`,`year_code`,`year_description`) values (1,'1','1st year'),(2,'2','2nd year'),(3,'3','3rd year'),(4,'4','4th year'),(5,'5','5th year'),(6,'6','6th year');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
