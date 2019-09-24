<?php

class Controller {

    public function headers($allowed_method='') {
        
        header("Access-Control-Allow-Origin: " . BASE_URL);
        header("Content-Type: application/json; charset=UTF-8;");

        switch ($allowed_method) {

            case 'get':
                header("Access-Control-Allow-Methods: GET");
                break;

            case 'post':
                header("Access-Control-Allow-Methods: POST");
                break;

            default:
                header("Access-Control-Allow-Methods: GET, POST");
                break;

        }
        
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    }

}