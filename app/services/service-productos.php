<?php
require_once "../models/Producto.php";
$producto = new Producto();

$metodo=$_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin");
header("Access-control-Allow-Methodos:GET, POST");
header("Allow:GET, POST");
header("Content-type: application/json; charset=utf-8");

if($metodo== 'GET'){
  $registros=[];
  if(isset($_GET['q'])){
    switch($_GET['q']){
      case 'findById':$registros =$producto->getById(['id'=>$_GET['id']]);break;
      case 'showAll':$registros = $producto->getAll();break;
    }
  }
  header('HTTP/1.1 200 Listo');
  echo json_encode($registros);
}else if($metodo== 'POST'){
  $imputJson = file_get_contents('php://input');
  $datos=json_decode($imputJson,true);
  $registro=[
    "tipo"=>$datos["tipo"],
    "genero"=>$datos["genero"],
    "talla"=>$datos["talla"],
    "precio"=>$datos["precio"]
  ];
  $status = $producto->add($registro);//true:false

  //informa el estado del servidor
  header('HTTP/1.1 200 Listo');
  echo json_encode(['status'=>$status]);

}else if ($metodo == 'PUT') {
    $inputJSON = file_get_contents('php://input');
    $datos = json_decode($inputJSON, true);
    
    if(isset($datos['id'], $datos['tipo'], $datos['genero'], $datos['talla'], $datos['precio'])) {
        $registro = [
            'id' => $datos['id'],
            'tipo' => $datos['tipo'],
            'genero' => $datos['genero'],
            'talla' => $datos['talla'],
            'precio' => $datos['precio']
        ];

        $status = $producto->update($registro);

        header('HTTP/1.1 200 OK');
        echo json_encode(['status' => $status]);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['status' => false, 'message' => 'Datos incompletos']);
    }
}


else if ($metodo == 'DELETE') {
  if(isset($_GET['id'])) {
      $idEliminar = intval($_GET['id']);
      $status = $producto->delete(['id' => $idEliminar]);

      header('HTTP/1.1 200 OK');
      echo json_encode(['status' => $status]);
  } else {
      header('HTTP/1.1 400 Bad Request');
      echo json_encode(['status' => false, 'message' => 'ID no proporcionado']);
  }
}
