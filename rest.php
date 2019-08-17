<?php
require_once "contact.class.php";
$book = new Contact();
/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      //Mostrar un post
      $prod = $con->select("SELECT idproducto,nombre FROM hl_productos WHERE linea_tipo_id = {$_GET['id']}");
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      echo json_encode($prod);
      exit();
    }
    else {
      //Mostrar lista de post
      $prod = $con->select("SELECT idproducto,nombre FROM hl_productos");
      header("HTTP/1.1 200 OK");
      header('Content-Type: application/json');
      echo json_encode( $prod  );
      exit();
  }
}
// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = filter_input_array(INPUT_POST);
    $data = json_decode($input);
    if($book->saveContact($data))
    {
      header("HTTP/1.1 200 OK");
      echo json_encode("success");
      exit();
    }
}
//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
  $id = filter_input_array(INPUT_POST);
  $data = json_decode($id);
  if ($book->deleteContact($data["idContacto"])){
    header("HTTP/1.1 200 OK");
    echo json_encode("success");
    exit();
  }
//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
  $input = filter_input_array(INPUT_POST);
  $data = json_decode($input);
  if($book->updateContact()($data))
  {
    header("HTTP/1.1 200 OK");
    echo json_encode("success");
    exit();
  }
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");