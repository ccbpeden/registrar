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

        function test_saveAndGetAll()
        {
            $student_name = "Maritsi Yanbolivart";
            $admission_date = "2045-05-17";
            $new_student = new Student($student_name, $admission_date);
            $new_student->save();

            $result = Student::getAll();
            var_dump($result);
            $this->assertEquals([$new_student], $result);
        }

        function test_find()
        {
            $student_name = "Javiar Malfuncas";
            $admission_date = "1902-12-05";
            $test_student = new Student($student_name,$admission_date);
            $test_student->save();
            $search_id = $test_student->getId();
            $student_name2 = "Juantas Malidas";
            $admission_date2 = "1902-12-05";
            $test_student2 = new Student($student_name2,$admission_date2);
            $test_student2->save();

            $result = Student::find($search_id);

            $this->assertEquals($test_student, $result);
        }

        function test_student_update()
        {
            $student_name = "Henery";
            $admission_date = "2018--7-10";
            $test_student = new Student($student_name, $admission_date);
            $test_student->save();
            $student_name2 = "Guy Hawk";
            $admission_date2 = "1938-20-10";

            $test_student->update($student_name2,$admission_date2);
            $result = array($test_student->getName(), $test_student->getAdmissionDate());

            $this->assertEquals([$student_name2, $admission_date2], $result);
        }


    }

?>
