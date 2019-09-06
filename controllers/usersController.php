<?php

class usersController {

    public function index() {

        $users = new Users();

        header("Content-Type: application/json");
        echo json_encode(array("users" => $users->list()));

    }

    public function signin() {

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
                    $error = 0;
                    $message = "Usuário cadastrado com sucesso.";
                    $user = $users->getUser($email);
                }
                else {
                    $error = 1;
                    $message = "E-mail já cadastrado.";
                }

            }

        }
        else {
            $error = 2;
            $message = "Informe corretamente e-mail e senha.";
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

    public function login() {

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
                    $error = 0;
                    $message = "Login efetuado com sucesso.";
                }
                else {
                    $error = 1;
                    $message = "Usuário ou senha incorretos.";
                }

            }

        }
        else {
            $error = 2;
            $message = "Informe corretamente e-mail e senha.";
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