<?php
    class Course
    {
        private $course_name;
        private $course_number;
        private $id;

        function __construct($course_name,$course_number,$id=null)
        {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function setCourseName($course_name)
        {
            $this->course_name = $course_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = $new_course_number;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
           $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $all_courses = array();
            foreach($returned_courses as $returned_course)
            {
                $course_name = $returned_course['course_name'];
                $course_number = $returned_course['course_number'];
                $id = $returned_course['id'];
                $new_course = new Course($course_name, $course_number, $id);
                array_push($all_courses, $new_course);
            }
            return $all_courses;
        }

        static function find($input_id)
        {
            $returned_courses = Course::getAll();
            foreach($returned_courses as $returned_course)
            {
                $returned_id = $returned_course->getId();
                if($returned_id == $input_id)
                {
                    return $returned_course;
                }
            }
        }

        function update($new_course_name, $new_course_number)
        {
            $GLOBALS ['DB']->exec("UPDATE courses SET course_name = '{$new_course_name}', course_number = '{$new_course_number}' WHERE id = {$this->getId()};");
            $this->setCourseName($new_course_name);
            $this->setCourseNumber($new_course_number);
        }
    }




?>
