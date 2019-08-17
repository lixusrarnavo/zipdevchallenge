<?php
require_once 'db/conexion.php';

class Contact extends Conexion {
    private $firstNames;
    private $surNames;
    private $phoneNumbers;
    private $emails;

    function __construct()
    {
        parent::__construct();
    }

    function saveContact(){
        $arr = func_get_args();
        var_dump($arr);die();
        $firstNames = $arr[0];
        $surNames = $arr[1];
        $phoneNumbers = $arr[2];
        $emails = $arr[3];

        try {
            $this->beginTransaction();
            $sql = "INSERT INTO Contact (firstName, surNames) VALUES (:firstName, :surName)";
            $this->prepare($sql);
            $this->bindValue(":firstName", $firstNames);
            $this->bindValue(":surName", $surNames);
            $this->exec();
            $idContact = $this->lastInsertId();

            $sql2 = "INSERT INTO Phones (phoneNumber, idContact) VALUES (:phoneNumber, :idContacto)";
            $this->prepare($sql2);
            for ($i = 0; $i < count($phoneNumbers); $i++){
                $this->bindValue(":phoneNumber", $phoneNumbers[$i]);
                $this->bindValue(":idContacto", $idContact);
                $this->exec();
            }

            $sql3 = "INSERT INTO Emails (email, idContact) VALUES (:email, :idContact)";
            $this->prepare($sql3);
            for ($i = 0; $i < count($emails); $i++){
                $this->bindValue(":email", $emails[$i]);
                $this->bindValue(":idContact", $idContact);
                $this->exec();
            }

            $this->hacerCommit();
            return true;
        }
        catch (Exception $e) {
            $this->regresar();
            echo json_encode([
                "error" => $e->getMessage()
            ]);
            exit();
        }
    }

    function updateContact(){
        $arr = func_get_args();
        $firstNames = $arr[0];
        $surNames = $arr[1];
        $idContact = $arr[2];
        $phoneNumbers = $arr[3];
        $emails = $arr[4];

        try {
            $sql = "UPDATE Contact SET firstName = :firstName, surNames = :surNames WHERE idContact = :idContact";
            $this->prepare($sql);
            $this->bindValue(":firstName", $firstNames);
            $this->bindValue(":surNames", $surNames);
            $this->bindValue(":idContact", $idContact);
            $this->exec();

            $sql2 = "UPDATE Phones SET  phoneNumber = :phoneNumber WHERE idContacto = :idContacto AND idPhoneNumber = :idPhoneNumber";
            $this->prepare($sql2);
            if (is_array($phoneNumbers)){
                for ($i = 0; $i < count($phoneNumbers); $i++){
                    $this->bindValue(":phoneNumber", $phoneNumbers[$i][0]);
                    $this->bindValue(":idContacto", $idContact);
                    $this->bindValue(":idPhoneNumber", $phoneNumbers[$i][1]);
                    $this->exec();
                }
            }

            $sql3 = "UPDATE Emails SET email = :email WHERE idContact = :idContact AND idEmail = :idEmail";
            $this->prepare($sql3);
            if (is_array($emails)){
                for ($i = 0; $i < count($emails); $i++){
                    $this->bindValue(":email", $emails[$i][0]);
                    $this->bindValue(":idContact", $idContact);
                    $this->bindValue(":idEmail", $emails[$i][1]);
                    $this->exec();
                }
            }

            $this->hacerCommit();
            return true;
        }
        catch (Exception $e){
            $this->regresar();
            echo json_encode([
                "error" => $e->getMessage()
            ]);
            exit();
        }
    }

    function deleteContact(){
        $arr = func_get_args();
        $idContact = $arr[0];
        
        try {
            $sql = "UPDATE Contact SET estatus = 0 WHERE idContact = :idContact";
            $this->prepare($sql);
            $this->bindValue(":idContact", $idContact);
            $this->exec();

            $sql2 = "UPDATE Phones SET estatus = 0 WHERE idContact = :idContact";
            $this->prepare($sql2);
            $this->bindValue("idContacto", $idContact);
            $this->exec();

            $this->hacerCommit();
        }
        catch (Exception $e){
            $this->regresar();
            echo json_encode([
                "error" => $e->getMessage()
            ]);
            exit();
        }
    }
}