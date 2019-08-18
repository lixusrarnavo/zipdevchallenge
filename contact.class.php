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
        $data = $arr[0];

        try {
            $this->beginTransaction();
            $sql = "INSERT INTO Contact (firstName, surNames) VALUES (:firstName, :surName)";
            $this->prepare($sql);
            $this->bindValue(":firstName", $data["firstName"]);
            $this->bindValue(":surName", $data["surNames"]);
            $this->exec();
            $idContact = $this->lastInsertId();

            $sql2 = "INSERT INTO Phones (phoneNumber, idContacto) VALUES (:phoneNumber, :idContacto)";
            $this->prepare($sql2);
            foreach ($data["phones"] as $phone){
                $this->bindValue(":phoneNumber", $phone);
                $this->bindValue(":idContacto", $idContact);
                $this->exec();
            }

            $sql3 = "INSERT INTO Emails (email, idContacto) VALUES (:email, :idContact)";
            $this->prepare($sql3);
            foreach ($data["emails"] as $email){
                $this->bindValue(":email", $email);
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
        $data = $arr[0];

        try {
            $this->beginTransaction();
            $sql = "UPDATE Contact SET firstName = :firstName, surNames = :surNames WHERE idContacto = :idContacto";
            $this->prepare($sql);
            $this->bindValue(":firstName", $data["firstName"]);
            $this->bindValue(":surNames", $data["surNames"]);
            $this->bindValue(":idContacto", $data["idContacto"]);
            $this->exec();

            $sql2 = "UPDATE Phones SET  phoneNumber = :phoneNumber WHERE idContacto = :idContacto AND idPhoneNumber = :idPhoneNumber";
            $this->prepare($sql2);
            foreach ($data["phones"] as $phone){
                $this->bindValue(":phoneNumber", $phone["phoneNumber"]);
                $this->bindValue(":idContacto", $data["idContacto"]);
                $this->bindValue(":idPhoneNumber", $phone["idPhoneNumber"]);
                $this->exec();
            }

            $sql3 = "UPDATE Emails SET email = :email WHERE idContacto = :idContacto AND idEmail = :idEmail";
            $this->prepare($sql3);
            foreach ($data["emails"] as $email){
                $this->bindValue(":email", $email["email"]);
                $this->bindValue(":idContacto", $data["idContacto"]);
                $this->bindValue(":idEmail", $email["idEmail"]);
                $this->exec();
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
            $this->beginTransaction();
            $sql = "UPDATE Contact SET estatus = 0 WHERE idContacto = :idContacto";
            $this->prepare($sql);
            $this->bindValue(":idContacto", $idContact);
            $this->exec();

            $sql2 = "UPDATE Phones SET estatus = 0 WHERE idContacto = :idContacto";
            $this->prepare($sql2);
            $this->bindValue("idContacto", $idContact);
            $this->exec();

            $sql3 = "UPDATE Emails SET estatus = 0 WHERE idContacto = :idContacto";
            $this->prepare($sql3);
            $this->bindValue("idContacto", $idContact);
            $this->exec();

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

    function getContact(){
        $arr = func_get_args();
        $res = array();
        $data = $arr[0];

        try {
            $this->beginTransaction();
            if ($data["idContacto"]){
                $sql = "SELECT * FROM Contact WHERE idContacto = :idContacto";
                $this->prepare($sql);
                $this->bindValue(":idContacto", $data["idContacto"]);
                $this->exec();
                $res = $this->fetchOne();
            }
            elseif ($data["surNames"]){
                $sql = "SELECT * FROM Contact WHERE surNames like :surNames";
                $this->prepare($sql);
                $this->bindValue(":surNames", "'%".$data["surNames"]."%'");
                $this->exec();
                $res = $this->fetchOne();
            }
            elseif ($data["firstName"]){
                $sql = "SELECT * FROM Contact WHERE firstName like :firstName";
                $this->prepare($sql);
                $this->bindValue(":firstName", "'%".$data["firstName"]."%'");
                $this->exec();
                $res = $this->fetchOne();
            }

            $sql2 = "SELECT * FROM Phones WHERE idContacto = :idContacto";
            $this->prepare($sql2);
            $this->bindValue(":idContacto", $res["idContacto"]);
            $this->exec();
            $res["phones"] = $this->fetchAll();

            $sql3 = "SELECT * FROM Emails WHERE idContacto = :idContacto";
            $this->prepare($sql3);
            $this->bindValue(":idContacto", $res["idContacto"]);
            $this->exec();
            $res["emails"] = $this->fetchAll();
            /*if ($data["phoneNumber"]){
                $sql = "SELECT * FROM Contact WHERE firstName like :firstName";
                $this->prepare($sql);
                $this->bindValue(":firstName", "'%".$data["firstName"]."%'");
                $this->exec();
                $res = $this->fetchOne();
            }*/
            return $res;
        }
        catch (Excepton $e){
            $this->regresar();
            echo json_encode([
                "error" => $e->getMessage()
            ]);
            exit();
        }
    }
}