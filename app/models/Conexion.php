<?php 
require_once '../config/Server.php';

const METHOD = "AES-256-CBC";
const SECRET_KEY ="_S3N@t1";
const SECRET_IV="037970";
class Conexion{
  protected static function getConexion(): PDO{
    try{
      $pdo=new PDO(SGBD, USER , PASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
  public static function ejecutarConsulaSimple($consulta){
    $sql = self::getConexion()->prepare($consulta);
    $sql->execute();
    return $sql;
  }
}