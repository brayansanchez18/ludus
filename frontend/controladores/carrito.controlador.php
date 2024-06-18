<?php

class ControladorCarrito
{

  /* -------------------------------------------------------------------------- */
  /*                               MOSTRAR TARIFAS                              */
  /* -------------------------------------------------------------------------- */

  static public function ctrMostrarTarifas()
  {
    $tabla = 'comercio';
    $respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);
    return $respuesta;
  }

  /* ----------------------------- MOSTRAR TARIFAS ---------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                               NUEVAS COMPRAS                               */
  /* -------------------------------------------------------------------------- */

  static public function ctrNuevasCompras($datos)
  {

    $tabla1 = 'compras';
    $tabla2 = 'productos';
    $respuesta = ModeloCarrito::mdlNuevasCompras($tabla1, $tabla2, $datos);

    if ($respuesta == 'ok') {
      $tabla = 'comentarios';
      ModeloUsuario::mdlIngresoComentarios($tabla, $datos);
    }

    return $respuesta;
  }

  /* ----------------------------- NUEVAS COMPRAS ----------------------------- */

  /* -------------------------------------------------------------------------- */
  /*                        VERIFICAR PRODUCTO ADQUIRIDO                        */
  /* -------------------------------------------------------------------------- */

  static public function ctrVerificarProducto($datos)
  {
    $tabla = 'compras';
    $respuesta = ModeloCarrito::mdlVerificarProducto($tabla, $datos);
    return $respuesta;
  }

  /* ---------------------- VERIFICAR PRODUCTO ADQUIRIDO ---------------------- */
}
