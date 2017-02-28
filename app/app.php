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



    return $app;
?>
