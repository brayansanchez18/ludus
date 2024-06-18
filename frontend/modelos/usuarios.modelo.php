<?php

require_once 'conexion.php';

class ModeloUsuario
{

  /*===========================================
	=            REGISTRO DE USUARIO            =
	===========================================*/

  static public function mdlRegistroUsuario($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, password, email, foto, modo, verificacion, emailEncriptado) VALUES (:nombre, :password, :email, :foto, :modo, :verificacion, :emailEncriptado)");

    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
    $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
    $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
    $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
    $stmt->bindParam(":modo", $datos["modo"], PDO::PARAM_STR);
    $stmt->bindParam(":verificacion", $datos["verificacion"], PDO::PARAM_INT);
    $stmt->bindParam(":emailEncriptado", $datos["emailEncriptado"], PDO::PARAM_STR);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    $stmt = null;
  }

  /*=====  End of REGISTRO DE USUARIO  ======*/

  /*=======================================
	=            MOSTRAR USUARIO            =
	=======================================*/

  static public function mdlMostrarUsuario($tabla, $item, $valor)
  {

    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
    $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
    $stmt = null;
  }

  /*=====  End of MOSTRAR USUARIO  ======*/

  /*==========================================
	=            ACTUALIZAR USUARIO            =
	==========================================*/

  static public function mdlActualizarUsuario($tabla, $id, $item, $valor)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE id = :id");
    $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_STR);

    if ($stmt->execute()) {

      return 'ok';
    } else {

      return 'error';
    }

    $stmt = null;
  }

  /*=====  End of ACTUALIZAR USUARIO  ======*/

  /*=========================================
	=            ACTUALIZAR PERFIL            =
	=========================================*/

  static public function mdlActualizarPerfil($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, password = :password, foto = :foto WHERE id = :id");
    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
    $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
    $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
    $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

    if ($stmt->execute()) {

      return 'ok';
    } else {

      return 'error';
    }

    $stmt = null;
  }

  /*=====  End of ACTUALIZAR PERFIL  ======*/

  /*=======================================
	=            MOSTRAR COMPRAS            =
	=======================================*/

  static public function mdlMostrarCompras($tabla, $item, $valor)
  {

    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
    $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt = null;
  }

  /*=====  End of MOSTRAR COMPRAS  ======*/

  /*=====================================================
	=            MOSTRAR COMENTARIOS EN PERFIL            =
	=====================================================*/

  static public function mdlMostrarComentariosPerfil($tabla, $datos)
  {

    if ($datos['idUsuario'] != '') {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
      $stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
      $stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetch();
    } else {

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto ORDER BY Rand()");
      $stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll();
    }

    $stmt = null;
  }

  /*=====  End of MOSTRAR COMENTARIOS EN PERFIL  ======*/

  /*=============================================
	=            ACTUALIZAR COMENTARIO            =
	=============================================*/

  static public function mdlActualizarComentario($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET calificacion = :calificacion, comentario = :comentario WHERE id = :id");
    $stmt->bindParam(":calificacion", $datos["calificacion"], PDO::PARAM_STR);
    $stmt->bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

    if ($stmt->execute()) {

      return 'ok';
    } else {

      return 'error';
    }

    $stmt = null;
  }

  /*=====  End of ACTUALIZAR COMENTARIO  ======*/

  /*=================================================
	=            AGREGAR A LISTA DE DESEOS            =
	=================================================*/

  static public function mdlAgregarDeseo($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) total FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
    $stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
    $stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    if ($total > 0) {

      return 'existe';
    } else {

      $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto) VALUES (:id_usuario, :id_producto)");
      $stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
      $stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);

      if ($stmt->execute()) {

        return 'ok';
      } else {

        return 'error';
      }

      $stmt = null;
    }

    $stmt = null;
  }

  /*=====  End of AGREGAR A LISTA DE DESEOS  ======*/

  /*===============================================
	=            MOSTRAR LISTA DE DESEOS            =
	===============================================*/

  static public function mdlMostrarDeseos($tabla, $item)
  {

    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario ORDER BY id DESC");
    $stmt->bindParam(":id_usuario", $item, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
    $stmt = null;
  }

  /*=====  End of MOSTRAR LISTA DE DESEOS  ======*/

  /*==========================================================
	=            QUITAR PRODUCTO DE LISTA DE DESEOS            =
	==========================================================*/

  static public function mdlQuitarDeseo($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return 'ok';
    } else {

      return 'error';
    }

    $stmt = null;
  }

  /*=====  End of QUITAR PRODUCTO DE LISTA DE DESEOS  ======*/

  /*========================================
	=            ELIMINAR USUARIO            =
	========================================*/

  static public function mdlEliminarUsuario($tabla, $id)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    $stmt = null;
  }

  /*=====  End of ELIMINAR USUARIO  ======*/

  /*=======================================================
	=            ELIMINAR COMENTARIOS DE USUARIO            =
	=======================================================*/

  static public function mdlEliminarComentarios($tabla, $id)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario = :id_usuario");
    $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    $stmt = null;
  }

  /*=====  End of ELIMINAR COMENTARIOS DE USUARIO  ======*/

  /*===================================================
	=            ELIMINAR COMPRAS DE USUARIO            =
	===================================================*/

  static public function mdlEliminarCompras($tabla, $id)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario = :id_usuario");
    $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    $stmt = null;
  }

  /*=====  End of ELIMINAR COMPRAS DE USUARIO  ======*/

  /*===========================================================
	=            ELIMINAR LISTA DE DESEOS DE USUARIO            =
	===========================================================*/

  static public function mdlEliminarListaDeseos($tabla, $id)
  {

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario = :id_usuario");
    $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }

    $stmt = null;
  }

  /*=====  End of ELIMINAR LISTA DE DESEOS DE USUARIO  ======*/

  /*===========================================
	=            INGRESO COMENTARIOS            =
	===========================================*/

  static public function mdlIngresoComentarios($tabla, $datos)
  {

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto, calificacion, comentario) VALUES (:id_usuario, :id_producto, 0, '')");

    $stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_INT);
    $stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_INT);

    if ($stmt->execute()) {

      return "ok";
    } else {

      return "error";
    }


    $tmt = null;
  }

  /*=====  End of INGRESO COMENTARIOS  ======*/
}
