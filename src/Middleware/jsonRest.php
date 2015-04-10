<?php

Class jsonRest extends \Slim\Middleware{

    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        $app = $this->app;

        $urlSploded = explode("/", $app->request->getResourceUri());

        if(in_array("sites",$urlSploded)){
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST');
            $app->response->headers->set('Content-Type', 'application/json');
        }
        $this->next->call();
    }

}


?>