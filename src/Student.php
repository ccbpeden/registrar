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
            
        }
    }
?>
