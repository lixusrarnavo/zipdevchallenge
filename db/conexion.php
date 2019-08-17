<?php
require("config.php");

class Conexion {

    public $_db;
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $database = DB_NAME;

    public function __construct() {
        try {
            $dns = "mysql:host=$this->host;port=$this->port;
            dbname=$this->database";
            $this->_db = new PDO($dns, DB_USER, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'')); 
            $this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);           
        } catch (Exception $ex) {
            print "Hubo un error: " . $ex->getMessage();
            die();
        }
    }
    
    public function beginTransaction(){
        $this->_db->beginTransaction();
    }
    
    public function execute(){
        $this->_db->execute();
    }
    
    public function regresar(){
        $this->_db->rollBack();
    }
    
    public function hacerCommit(){
        $this->_db->commit();
    }
    
    public function selectOne($sql){
        return $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    
    public function select($sql){
        return $this->_db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchOne(){
        return $this->stat->fetch(PDO::FETCH_ASSOC);
    }
    
    public function fetch($sql){
        return $this->_db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    
    public function query($sql){
        return $this->_db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function queryU($sql){
        $this->_db->query($sql);
    }
    
    public function queryI($sql){
        $this->_db->query($sql);
    }
    
    public function lastInsertId(){
        return $this->_db->lastInsertId();
    }
    
    public function fetchAll(){
        return $this->stat->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function bindValue($value,$data){
        $this->stat->bindValue($value, $data);
    }
    
    public function bindParam($value, $key){
        $this->stat->bindParam($value, $key);
    }
    
    public function exec(){
        $this->stat->execute();
    }
    
    public function prepare($sql){
        $this->stat = $this->_db->prepare($sql);
    }
    
    public function prepareU($sql){
        $this->update = $this->_db->prepare($sql);
    }
    
    public function rowCount(){
        return $this->stat->rowCount();
    }
}