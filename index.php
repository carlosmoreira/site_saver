<?php
require 'bootstrap.php';





$app = new \Slim\Slim();

$app->config(array(
    'templates.path' => './pages/',
));



$app->add(new \jsonRest());
$app->get('/', function () use ($entityManager, $app) {

    $sites = $entityManager->getRepository("Site")->findAll();
    //var_dump($sites);
    $app->render('view.sites.all.php', array('sites' => $sites));
});


$app->group('/sites', function () use ($app, $entityManager) {

    //$app->response->headers->set('Content-Type', 'application/json');

    $app->get('', function () use ($entityManager) {

        $sites = $entityManager->getRepository("Site")->findAll();
        //var_dump($sites);
        foreach ($sites as $site) {
            $sitesD[] = array('id' => $site->getId(), 'url' => $site->getUrl(), 'description' => $site->getDescription());
        }
        //var_dump($sitesD);
        echo json_encode($sitesD);

    });

    $app->post('/add', function () use ($entityManager, $app) {

        $url = $app->request->post('url');
        $description = $app->request->post('description');

        if (!$url) {
            echo '{"error": "error", "description": "No Url Sent"}';
            exit;
        }


        $site = new Site();
        $site->setUrl($url);
        $site->setDescription($description);

        $entityManager->persist($site);
        $entityManager->flush();

        echo '{"Result" : 1 }';

    });


    $app->post('/update', function () use ($entityManager, $app) {

        $id = $app->request->post('id');
        $url = $app->request->post('url');
        $description = $app->request->post('description');


        if (!$id) {
            echo '{"error" : "error", "description": "Id not sent"}';
            exit;
        }

        if (!$url) {
            echo '{"error": "error", "description": "No Url Sent"}';
            exit;
        }


        $site = $entityManager->find('Site', $id);

        if ($site === null) {
            echo '{"error" : "error", "description" : "Site $id does not exist."}';
            exit(1);
        }


        $site->setUrl($url);
        $site->setDescription($description);

        $entityManager->flush();

        echo '{"Result" : 1 }';

    });


    $app->post('/delete', function () use ($entityManager, $app) {

        $id = $app->request->post('id');


        if (!$id) {
            echo '{"error" : "error", "description": "Id not Sent"}';
            exit;
        }

        $site = $entityManager->find('Site', $id);

        if ($site === null) {
            echo '{"error" : "error", "description": "Id ' . $id . ' not found"}';
            exit(1);
        }

        $entityManager->remove($site);
        $entityManager->flush();

        echo '{"Result" : 1 }';

    });

});


$app->run();




