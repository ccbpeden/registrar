<?php
  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once "src/Course.php";
  require_once "src/Student.php";
  require_once "src/Department.php";

  $server = 'mysql:host=localhost:8889;dbname=registrar_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Course::deleteAll();
        }

        function test_getName()
        {
          //Arrange
          $course_name = "Humanities";
          $course_number = "HUM101";
          $test_course = new Course($course_name, $course_number);

          //Act
          $result = $test_course->getCourseName();

          //Assert
          $this->assertEquals($course_name, $result);
        }

        function test_save()
        {
          $course_name = "Humanities";
          $course_number = "HUM101";
          $test_course = new Course($course_name, $course_number);
          $test_course->save();

          $result = Course::getAll();

          $this->assertEquals([$test_course], $result);
        }

        function test_find()
        {
          $course_name = "Humanities";
          $course_number = "HUM101";
          $test_course = new Course($course_name, $course_number);
          $test_course->save();
          $search_id = $test_course->getId();
          $course_name2 = "Rocks for Jocks";
          $course_number2 = "PSCI101";
          $test_course2 = new Course($course_name2, $course_number2);
          $test_course2->save();


          $result = Course::find($search_id);

          $this->assertEquals($test_course, $result);
        }

        function test_update()
        {
            $course_name = "Humanities";
            $course_number = "HUM101";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();
            $course_name2 = "Rocks for Jocks";
            $course_number2 = "PSCI101";

            $test_course->update($course_name2, $course_number2);
            $result = array($test_course->getCourseName(), $test_course->getCourseNumber());

            $this->assertEquals([$course_name2 , $course_number2], $result);

        }

        function test_delete()
        {
            $course_name = "Jive Turkey";
            $course_number = "Jive101";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();

            $test_course->delete();
            $result = Course::getAll();

            $this->assertEquals([],$result);
        }

        function test_getStudents()
        {
            $course_name = "Jive Turkey";
            $course_number = "Jive101";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();
            $course_id = $test_course->getId();
            $student_name = "Javiar Malfuncas";
            $admission_date = "1902-12-05";
            $test_student = new Student($student_name,$admission_date);
            $test_student->save();
            $test_student->addCourse($course_id);
            $search_id = $test_student->getId();
            $student_name2 = "Juantas Malidas";
            $admission_date2 = "1902-12-05";
            $test_student2 = new Student($student_name2,$admission_date2);
            $test_student2->save();
            $test_student2->addCourse($course_id);

            $result = $test_course->getStudents();

            $this->assertEquals([$test_student, $test_student2], $result);
        }
  }
?>
