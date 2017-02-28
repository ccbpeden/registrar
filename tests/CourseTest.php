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

  }
?>
