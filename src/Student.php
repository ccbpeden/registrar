<?php
    Class Student
    {
        private $name;
        private $admission_date;
        private $id;

        function __construct($name, $admission_date, $id = null)
        {
            $this->name = $name;
            $this->admission_date = $admission_date;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function getAdmissionDate()
        {
            return $this->admission_date;
        }

        function setAdmissionDate($admission_date)
        {
            $this->admission_date = $admission_date;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $all_students = array();
            foreach($returned_students as $returned_student)
            {
                $student_name = $returned_student['name'];
                $admission_date = $returned_student['admission_date'];
                $id = $returned_student['id'];
                $new_student =  new Student($student_name, $admission_date,$id);
                array_push($all_students,$new_student);
            }
            return $all_students;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name,admission_date) VALUES ('{$this->getName()}', '{$this->getAdmissionDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function find($input_id)
        {
            $returned_students = Student::getAll();
            foreach($returned_students as $returned_student)
            {
                $returned_id = $returned_student->getId();
                if($returned_id == $input_id)
                {
                    return $returned_student;
                }
            }
        }

        function update($new_student_name,$new_admission_date)
        {
            $GLOBALS ['DB']->exec("UPDATE students SET name = '{$new_student_name}', admission_date = '{$new_admission_date}' WHERE id = {$this->getId()};");
            $this->setName($new_student_name);
            $this->setAdmissionDate($new_admission_date);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
        }

        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO student_courses (student_id, course_id) VALUES ({$this->getId()}, {$course_id});");
        }

        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query
            ("SELECT courses.* FROM
                students JOIN student_courses ON (student_courses.student_id = students.id) 
                JOIN courses ON (courses.id = student_courses.course_id)
                WHERE students.id = {$this->getId()};");
            $output_courses = array();
            foreach ($returned_courses as $returned_course)
            {
                $course_name = $returned_course['course_name'];
                $course_number = $returned_course['course_number'];
                $course_id = $returned_course['id'];
                $new_course = new Course($course_name, $course_number, $course_id);
                array_push($output_courses, $new_course);
            }
            return $output_courses;
        }
    }
?>
