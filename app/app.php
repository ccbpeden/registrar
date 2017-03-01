<?php
    date_default_timezone_set("America/Los_Angeles");

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Student.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app->register(new Silex\Provider\TwigServiceProvider(),
    array('twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/' , function() use ($app) {
        return $app['twig']->render('index.html.twig' , array('courses' => Course::getAll()));
    });

    $app->post("/create_course" , function() use ($app)
    {
        $new_course = new Course($_POST['course_name'], $_POST['course_number']);
        $new_course->save();
        return $app['twig']->render('index.html.twig' , array('courses' => Course::getAll()));
    });

    $app->get("/editcourse/{id}", function($id) use ($app)
    {
        $current_course = Course::find($id);
        $course_students = $current_course->getStudents();
        return $app['twig']->render('course.html.twig', array('course' => $current_course, 'currentstudents' => $course_students, 'allstudents' => Student::getAll()));
    });

    $app->post("/addcurrentstudent", function() use($app)
    {
        $current_student=Student::find($_POST['student_id']);
        $current_student->addCourse($_POST['course_id']);
        $current_course = Course::find($_POST['course_id']);
        $course_students = $current_course->getStudents();
        return $app['twig']->render('course.html.twig', array('course' => $current_course, 'currentstudents' => $course_students, 'allstudents' => Student::getAll()));
    });

    $app->post("/addnewstudent", function() use ($app)
    {
        $new_student = new Student($_POST['student_name'], $_POST['admission_date']);
        $new_student->save();
        return $app['twig']->render('student.html.twig', array('students' => Student::getAll()));
    });

    $app->get("/students", function() use ($app) {
        return $app['twig']->render('student.html.twig', array('students' => Student::getAll()));
    });

    $app->post("/addcourse", function() use ($app) {
        $new_student = Student::find($_POST['student_id']);
        $new_student->addCourse($_POST['addcourse']);
        return $app['twig']-> render('edit_student.html.twig' , array('student' => $new_student , 'courses' => $new_student->getCourses() , 'currentcourses' => Course::getAll()));
    });

    $app->get("/editstudent/{id}" , function($id) use ($app) {
        $new_student = Student::find($id);
        return $app['twig']-> render('edit_student.html.twig' , array('student' => $new_student , 'courses' => $new_student->getCourses() , 'currentcourses' => Course::getAll()));
    });

    return $app;
?>
