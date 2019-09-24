<?php

class notfoundController {

    public function index() {
        http_response_code(404);
        echo json_encode(array("message" => "Page not found."));
    }

}
