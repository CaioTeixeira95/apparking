<?php

class usersController extends Controller {

    public function index() {

        $users = new Users();

        $this->headers('get');

        try {
            http_response_code(200);
            echo json_encode(array("users" => $users->list()));
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(array("message" => "Server error."));
        }

    }

    public function signin() {

        $this->headers('post');

        $data = file_get_contents("php://input");

        $user = '';

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['name']) && !empty($data['email']) && !empty($data['password'])) {

                $users = new Users();

                $name = addslashes($data['name']);
                $email = addslashes($data['email']);
                $password = addslashes($data['password']);

                if ($users->signIn($name, $email, $password)) {
                    http_response_code(200);
                    $error = 0;
                    $message = "Usuário cadastrado com sucesso.";
                    $user = $users->getUser($email);
                }
                else {
                    http_response_code(200);
                    $error = 1;
                    $message = "E-mail já cadastrado.";
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
            $message = "Informe corretamente e-mail e senha.";
        }

        echo json_encode(
            array(
                "error" => $error,
                "message" => $message,
                "user" => $user,
            )
        );

    }

    public function login() {

        $this->headers('get');

        $data = file_get_contents("php://input");

        $user = '';

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['email']) && !empty($data['password'])) {

                $users = new Users();

                $email = addslashes($data['email']);
                $password = addslashes($data['password']);

                $user = $users->login($email, $password);

                if (count($user) > 0) {
                    http_response_code(200);
                    $error = 0;
                    $message = "Login efetuado com sucesso.";
                }
                else {
                    http_response_code(200);
                    $error = 1;
                    $message = "Usuário ou senha incorretos.";
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
            $message = "Informe corretamente e-mail e senha.";
        }

        echo json_encode(
            array(
                "error" => $error,
                "message" => $message,
                "user" => $user,
            )
        );

    }

    public function edit() {

        $data = file_get_contents("php://input");

        $user = '';

        if (!empty($data)) {

            $data = json_decode($data, true);

            if (!empty($data['id']) && is_numeric($data['id']) && !empty($data['nome']) && !empty($data['password'])) {

                $users = new Users();

                $id = addslashes($data['id']);
                $nome = addslashes($data['nome']);
                $password = addslashes($data['password']);

                if ($users->edit($id, $nome, $password)) {
                    $error = 0;
                    $message = "Usuário editado com sucesso.";
                    $user = $users->getUserById($id);
                }
                else {
                    $error = 1;
                    $message = "Erro ao editar usuário.";
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
                "user" => $user,
            )
        );

    }

}