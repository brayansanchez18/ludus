<?php

require_once 'conexion.php';

class ModeloCarrito
{

  /* -------------------------------------------------------------------------- */
  /*                               MOSTRAR TARIFAS                              */
  /* -------------------------------------------------------------------------- */

  static public function mdlMostrarTarifas($tabla)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();
    $stmt = null;
  }

  /* ----------------------------- MOSTRAR TARIFAS ---------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                               NUEVAS COMPRAS                               */
  /* -------------------------------------------------------------------------- */

  static public function mdlNuevasCompras($tabla1, $tabla2, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla1 (id_usuario, id_producto, metodo, email, direccion, pais, cantidad, detalle, pago)
    VALUES (:id_usuario, :id_producto, :metodo, :email, :direccion, :pais, :cantidad, :detalle, :pago)");
    $stmt->bindParam(':id_usuario', $datos['idUsuario'], PDO::PARAM_INT);
    $stmt->bindParam(':id_producto', $datos['idProducto'], PDO::PARAM_INT);
    $stmt->bindParam(':metodo', $datos['metodo'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $datos['email'], PDO::PARAM_STR);
    $stmt->bindParam(':direccion', $datos['direccion'], PDO::PARAM_STR);
    $stmt->bindParam(':pais', $datos['pais'], PDO::PARAM_STR);
    $stmt->bindParam(':cantidad', $datos['cantidad'], PDO::PARAM_STR);
    $stmt->bindParam(':detalle', $datos['detalle'], PDO::PARAM_STR);
    $stmt->bindParam(':pago', $datos['pago'], PDO::PARAM_STR);

    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }

    $stmt = null;
  }

  /* ----------------------------- NUEVAS COMPRAS ----------------------------- */

  /*====================================================
	=            VERIFICAR PRODUCTO ADQUIRIDO            =
	====================================================*/

  static public function mdlVerificarProducto($tabla, $datos)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
    $stmt->bindParam(':id_usuario', $datos['idUsuario'], PDO::PARAM_INT);
    $stmt->bindParam(':id_producto', $datos['idProducto'], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
    $tmt = null;
  }

  /*=====  End of VERIFICAR PRODUCTO ADQUIRIDO  ======*/
}
