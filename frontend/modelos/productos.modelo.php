<?php

require_once 'conexion.php';

class ModeloProductos
{

  /* -------------------------------------------------------------------------- */
  /*                             MOSTRAR CATEGORIAS                             */
  /* -------------------------------------------------------------------------- */

  static public function mdlMostrarCategorias($tabla, $item, $valor)
  {

    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    $stmt = null;
  }

  /* --------------------------- MOSTRAR CATEGORIAS --------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                           MOSTRAR SUB CATEGORIAS                           */
  /* -------------------------------------------------------------------------- */

  static public function mdlMostrarSubCategorias($tabla, $item, $valor)
  {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
      $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
      $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    $stmt = null;
  }

  /* ------------------------- MOSTRAR SUB CATEGORIAS ------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                              MOSTRAR PRODUCTOS                             */
  /* -------------------------------------------------------------------------- */

  static public function mdlMostrarProductos($tabla, $ordenar, $item, $valor, $base, $tope, $modo)
  {
    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND estado = 1 ORDER BY $ordenar $modo LIMIT $base, $tope");
      $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1 ORDER BY $ordenar $modo LIMIT $base, $tope");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    $stmt = null;
  }

  /* ---------------------------- MOSTRAR PRODUCTOS --------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                           MOSTRAR INFO PRODUCTOS                           */
  /* -------------------------------------------------------------------------- */

  static public function mdlMostrarInfoProducto($tabla, $item, $valor)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
    $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt = null;
  }

  /* ------------------------- MOSTRAR INFO PRODUCTOS ------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                              LISTAR PRODUCTOS                              */
  /* -------------------------------------------------------------------------- */

  static public function mdlListarProductos($tabla, $ordenar, $item, $valor)
  {

    if ($item != null) {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
      $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetchAll();
    } else {
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $ordenar DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }

    $stmt = null;
  }

  /* ---------------------------- LISTAR PRODUCTOS ---------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                               MOSTRAR BANNER                               */
  /* -------------------------------------------------------------------------- */

  static public function mdlMostrarBanner($tabla, $ruta)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta = :ruta");
    $stmt->bindParam(':ruta', $ruta, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt = null;
  }

  /* ----------------------------- MOSTRAR BANNER ----------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                                  BUSCADOR                                  */
  /* -------------------------------------------------------------------------- */

  static public function mdlBuscarProductos($tabla, $busqueda, $ordenar, $modo, $base, $tope)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
    WHERE ruta like '%$busqueda%' OR 
    titulo like '%$busqueda%' OR 
    titular like '%$busqueda%' OR 
    descripcion like '%$busqueda%' ORDER BY $ordenar $modo LIMIT $base, $tope");
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt = null;
  }

  /* -------------------------------- BUSCADOR -------------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                          LISTAR PRODUCTOS BUSCADOR                         */
  /* -------------------------------------------------------------------------- */

  static public function mdlListarProductosBusqueda($tabla, $busqueda)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE 
    ruta like '%$busqueda%' OR 
    titulo like '%$busqueda%' OR 
    titular like '%$busqueda%' OR 
    descripcion like '%$busqueda%'");
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt = null;
  }

  /* ------------------------ LISTAR PRODUCTOS BUSCADOR ----------------------- */

  /* -------------------------------------------------------------------------- */
  /*                          ACTUALIZAR VISTA PRODUCTO                         */
  /* -------------------------------------------------------------------------- */

  static public function mdlActualizarProducto($tabla, $item1, $valor1, $item2, $valor2)
  {
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
    $stmt->bindParam(':' . $item1, $valor1, PDO::PARAM_STR);
    $stmt->bindParam(':' . $item2, $valor2, PDO::PARAM_STR);

    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }

    $stmt = null;
  }

  /* ------------------------ ACTUALIZAR VISTA PRODUCTO ----------------------- */

  /* -------------------------------------------------------------------------- */
  /*                        ACTUALIZAR STOCK DE PRODUCTOS                       */
  /* -------------------------------------------------------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                       LIMPIAR LOS SIGUIENTES METODOS                       */
  /* -------------------------------------------------------------------------- */

  static public function mdlActualizarStock($tabla, $item3, $valor3, $item4, $valor4, $item5, $valor5)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item3 = $item3 - :$valor3 WHERE $item4 = :$item4");
    //$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_STR);
    $stmt->bindParam(":" . $valor3, $valor3, PDO::PARAM_STR);
    $stmt->bindParam(":" . $item4, $valor4, PDO::PARAM_STR);
    // $stmt -> bindParam(":".$item5, $valor5, PDO::PARAM_STR);

    if ($stmt->execute()) {
      return 'ok';
    } else {
      return 'error';
    }

    $stmt = null;
  }

  /* ---------------------- ACTUALIZAR STOCK DE PRODUCTOS --------------------- */
}
