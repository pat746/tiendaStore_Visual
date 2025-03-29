<?php
require_once 'Conexion.php';
class Producto extends Conexion{
  private $conexion;
  public function __construct(){
    $this->conexion = parent::getConexion();
  }
  public function add($params=[]):bool{
    $saveStatus=false;
    try{
      $sql="INSERT INTO productos(tipo,genero,talla,precio)VALUES (?,?,?,?)";
      $consulta=$this->conexion->prepare($sql);
      $saveStatus=$consulta->execute(array(
        $params['tipo'],
        $params['genero'],
        $params['talla'],
        $params['precio'],
        ));
        return $saveStatus;
    }
    catch(Exception $e){
      return false;
    }
  }
  public function getAll(): array {
    try {
      $sql = "SELECT * FROM productos";
      $consulta = $this->conexion->prepare($sql);
      $consulta->execute();
      $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
      return $productos;
    } catch (Exception $e) {
      return [];
    }
  }
  public function getById($param=[]){

    try{
      $sql= "SELECT id,tipo,genero,talla,precio FROM productos WHERE id = ?";
      $consulta = $this->conexion->prepare( $sql );
      $consulta->execute(array(
        $param["id"]
      ));
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
      return ['code'=> 0,'msg'=> $e->getMessage()];

    }
  }
  public function update($params = []): bool {
    $saveStatus = false;
    try {
        $sql = "UPDATE productos SET tipo = ?, genero = ?, talla = ?, precio = ? WHERE id = ?";
        $consulta = $this->conexion->prepare($sql);
        $saveStatus = $consulta->execute(array(
            $params['tipo'],
            $params['genero'],
            $params['talla'],
            $params['precio'],
            $params['id']
        ));
        return $saveStatus;
    } catch (Exception $e) {
        return false;
    }
}


public function delete($params=[]):bool{
  $saveStatus=false;
  try{
    $sql= "DELETE FROM productos WHERE id=?";
    $consulta=$this->conexion->prepare($sql);
    $saveStatus=$consulta->execute(array(
      $params['id']
      ));
      return $saveStatus;
  }
  catch(Exception $e){
    return false;
  }
}
}

?>