<?php

class Users extends Model {

    public function list() {

        $sql  = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();

    }

    public function login($email, $password) {

        $password = md5($password);

        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);

        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetch() : array();

    }

    public function getUser($email) {

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":email", $email);

        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetch() : array();

    }

    public function getUserById($id) {

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetch() : array();

    }

    public function signIn($name, $email, $password) {

        $password = md5($password);

        if ($this->verifyEmail($email)) {

            try {

                $sql  = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
                $stmt = $this->pdo->prepare($sql);

                $stmt->bindValue(":name", $name);
                $stmt->bindValue(":email", $email);
                $stmt->bindValue(":password", $password);

                $stmt->execute();

                return true;

            } catch(PDOException $e) {
                echo "Falhou: " . $e->getMessage();
                exit;
            }

        }

        return false;

    }

    public function edit($id, $password, $name) {

        try {

            $password = md5($password);

            $sql = " UPDATE users
                        SET password = :password,
                            name = :name
                      WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":password", $password);

            $stmt->execute();

            return true;

        } catch(PDOException $e) {
            echo "Falhou: " . $e->getMessage();
            exit;
        }

        return false;

    }

    public function verifyEmail($email) {

        $sql  = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":email", $email);

        $stmt->execute();

        return $stmt->rowCount() == 0;

    }

}