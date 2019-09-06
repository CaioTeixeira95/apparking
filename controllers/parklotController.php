<?php

class parklotController {

    public function index() {

        $park_lot = new ParkingLot();

        header("Content-Type: application/json");
        echo json_encode(array("parking_lot" => $park_lot->list()));

    }

    public function add() {

        $data = file_get_contents("php://input");

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['lot_number']) && is_numeric($data['lot_number']) && !empty($data['lot_type'])) {

                $park_lot = new ParginLot();

                $lot_number = addslashes($data['lot_number']);
                $lot_type = addslashes($data['lot_type']);

                if ($park_lot->insertLot($lot_number, $lot_type)) {
                    $error = 0;
                    $message = "Vaga inserida com sucesso.";
                }
                else {
                    $error = 1;
                    $message = "Erro ao alterar status da vaga.";
                }

            }

        }
        else {
            $error = 2;
            $message = "Informações incorretas.";
        }

        header("Content-Type: application/json");
        echo json_encode(
            array(
                "error" => $error,
                "message" => $message,
            )
        );

    }

    public function status() {

        $data = file_get_contents("php://input");

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['lot_number']) && is_numeric($data['lot_number']) && !empty($data['busy'])) {

                $park_lot = new ParginLot();

                $lot_number = addslashes($data['lot_number']);
                $busy = addslashes($data['busy']);

                if ($park_lot->updateStatus($lot_number, $busy)) {
                    $error = 0;
                    $message = "Status da vaga alterado com sucesso.";
                }
                else {
                    $error = 1;
                    $message = "Erro ao alterar status da vaga.";
                }

            }

        }
        else {
            $error = 2;
            $message = "Informações incorretas.";
        }

        header("Content-Type: application/json");
        echo json_encode(
            array(
                "error" => $error,
                "message" => $message,
            )
        );

    }

}