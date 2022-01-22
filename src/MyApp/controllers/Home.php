<?php
namespace MyApp\controllers;
class Home {

    protected $view;
    
    public function __construct($view){
        $this->view = $view;
    }
    public function index( $request, $response){
        // $view = $this->container->get('View');
        var_dump($this->view);
        return $response->write('Testa isso agora!');
    }
};
?>