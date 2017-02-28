<?php
  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once "src/Course.php";
  require_once "src/Student.php";

  $server = 'mysql:host=localhost:8889;dbname=registrar_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }

        function test_constructorAndGetters()
        {
            $student_name = "Humbert Humbert";
            $admission_date = "1943-06-24";
            $test_student = new Student($student_name, $admission_date);

            $result = array($test_student->getName(), $test_student->getAdmissionDate());

            $this->assertEquals([$student_name, $admission_date], $result);
        }

        function test_setters()
        {
            $student_name = "Vasily Raskolnikov";
            $admission_date = "1897-03-04";
            $new_student = new Student($student_name, $admission_date);
            $new_name = "Boris Badinoff";
            $new_admission_date = "1956-06-14";

            $new_student->setName($new_name);
            $new_student->setAdmissionDate($new_admission_date);
            $result = array($new_student->getName(), $new_student->getAdmissionDate());

            $this->assertEquals([$new_name, $new_admission_date], $result);
        }
    }
?>
