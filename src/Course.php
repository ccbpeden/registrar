<?php
    class Course
    {
        private $course_name;
        private $admittance;
        private $id;

        function __construct($course_name,$admittance,$id=null)
        {
            $this->course_name = $course_name;
            $this->admittance = $admittance;
            $this->id = $id;
        }

        function getName()
        {
            return $this->course_name;
        }
        static function deleteAll()
        {
           $GLOBALS['DB']->exec("DELETE FROM courses;");
        }
    }




?>
