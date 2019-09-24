<?php

class parklotController extends Controller {

    public function index() {

        $park_lot = new ParkingLot();

        $this->headers('get');

        try {
            http_response_code(200);
            echo json_encode(array("parking_lot" => $park_lot->list()));
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(array("message" => "Server error."));
        }

    }

    public function add() {

        $this->headers('post');

        $data = file_get_contents("php://input");

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['lot_number']) && is_numeric($data['lot_number']) && !empty($data['lot_type'])) {

                $park_lot = new ParkingLot();

                $lot_number = addslashes($data['lot_number']);
                $lot_type = addslashes($data['lot_type']);

                if ($park_lot->insertLot($lot_number, $lot_type)) {
                    http_response_code(200);
                    $error = 0;
                    $message = "Vaga inserida com sucesso.";
                }
                else {
                    http_response_code(200);
                    $error = 1;
                    $message = "Número de vaga já existente.";
                }

            }
            else {
                http_response_code(400);
                $error = 2;
                $message = "Informações incorretas.";
            }

        }
        else {
            http_response_code(400);
            $error = 2;
            $message = "Informações incorretas.";
        }

        echo json_encode(
            array(
                "error" => $error,
                "message" => $message,
            )
        );

    }

    public function status() {

        $this->headers('post');

        $data = file_get_contents("php://input");

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['lot_number']) && is_numeric($data['lot_number']) && !empty($data['busy'])) {

                $park_lot = new ParkingLot();

                $lot_number = addslashes($data['lot_number']);
                $busy = addslashes($data['busy']);

                if ($park_lot->updateStatus($lot_number, $busy)) {
                    http_response_code(200);
                    $error = 0;
                    $message = "Status da vaga alterado com sucesso.";
                }
                else {
                    http_response_code(200);
                    $error = 1;
                    $message = "Erro ao alterar status da vaga.";
                }

            }
            else {
                http_response_code(400);
                $error = 2;
                $message = "Informações incorretas.";
            }

        }
        else {
            http_response_code(400);
            $error = 2;
            $message = "Informações incorretas.";
        }

        echo json_encode(
            array(
                "error" => $error,
                "message" => $message,
            )
        );

    }

}