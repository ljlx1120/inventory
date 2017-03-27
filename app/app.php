<?php
  date_default_timezone_set('America/Los_Angeles');
  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/../src/Inventory.php';

  $app = new Silex\Application();

  $server = 'mysql:host=localhost:8889;dbname=inventory';
  $username = 'root';
  $pass = 'root';
  $db = new PDO($server,$username,$pass);


  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  $app->get("/", function () use ($app) {
    return $app['twig']->render('index.html.twig');
  });

  $app->post("/create", function () use ($app){
    $new_collection = new Inventory($_POST['collection']);
    $new_collection->save();
    return $app['twig']->render('index.html.twig', array('results'=>Inventory::getAll()));
  });

  $app->post("/find", function () use ($app) {
    $results = Inventory::find($_POST['find']);
    return $app['twig']->render('result.html.twig', array('results'=>$results));
  });

  $app->post("/delete", function () use ($app) {
    Inventory::deleteAll();
    return $app['twig']->render('index.html.twig');
  });

  return $app;
?>
