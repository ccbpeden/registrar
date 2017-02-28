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
          $admittance = "2017/02/28";
          $test_name = new Course($course_name, $admittance);

          //Act
          $result = $test_name->getName();

          //Assert
          $this->assertEquals($course_name, $result);
      }

  }
?>
