<?php
require_once "contact.class.php";
$book = new Contact();
/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
  $input = json_decode(file_get_contents("php://input"), true);
  $res = $book->getContact($input);

  header('Content-Type: application/json');
  header("HTTP/1.1 200 OK");
  echo json_encode($res);
  exit();
}
// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = json_decode(file_get_contents("php://input"), true);
    if($book->saveContact($input))
    {
      header('Content-Type: application/json');
      header("HTTP/1.1 200 OK");
      echo json_encode("success");
      exit();
    }
}
//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
  $input = json_decode(file_get_contents("php://input"), true);
  if ($book->deleteContact($input["idContacto"])){
    header('Content-Type: application/json');
    header("HTTP/1.1 200 OK");
    echo json_encode("success");
    exit();
  }
}
//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
  $input = json_decode(file_get_contents("php://input"), true);
  if($book->updateContact($input))
  {
    header('Content-Type: application/json');
    header("HTTP/1.1 200 OK");
    echo json_encode("success");
    exit();
  }
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");