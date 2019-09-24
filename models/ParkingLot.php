<?php

class ParkingLot extends Model {

    public function list() {

        $sql  = "SELECT * FROM parkinglot";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();

    }

    public function insertLot($lot_number, $lot_type) {

        try {

            if ($this->verifyLotNumber($lot_number)) {

                $sql  = "INSERT INTO parkinglot (lot_number, lot_type) VALUES (:lot_number, :lot_type)";
                $stmt = $this->pdo->prepare($sql);

                $stmt->bindValue(":lot_number", $lot_number);
                $stmt->bindValue(":lot_type", $lot_type);

                $stmt->execute();

                return true;

            }

            return false;

        } catch(PDOException $e) {
            echo "Falhou: " . $e->getMessage();
            exit;
        }

        return false;

    }

    public function updateStatus($lot_number, $busy) {

        try {

            $sql = " UPDATE parkinglot
                        SET busy = :busy
                      WHERE lot_number = :lot_number";

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(":busy", $busy);
            $stmt->bindValue(":lot_number", $lot_number);

            $stmt->execute();

            return true;

        } catch(PDOException $e) {
            echo "Falhou: " . $e->getMessage();
            exit;
        }

        return false;

    }

    public function verifyLotNumber($lot_number) {

        $sql  = "SELECT * FROM parkinglot WHERE lot_number = :lot_number";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":lot_number", $lot_number);

        $stmt->execute();

        return $stmt->rowCount() == 0;

    }

}