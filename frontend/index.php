<?php

/* -------------------------------------------------------------------------- */
/*                                CONTROLADORES                               */
/* -------------------------------------------------------------------------- */

require_once 'controladores/plantilla.controlador.php';
require_once 'controladores/productos.controlador.php';
require_once 'controladores/slide.controlador.php';
require_once 'controladores/usuarios.controlador.php';
require_once 'controladores/carrito.controlador.php';
require_once 'controladores/visitas.controlador.php';

/* ------------------------------ CONTROLADORES ----------------------------- */

/* -------------------------------------------------------------------------- */
/*                                   MODELOS                                  */
/* -------------------------------------------------------------------------- */

require_once 'modelos/plantilla.modelo.php';
require_once 'modelos/productos.modelo.php';
require_once 'modelos/slide.modelo.php';
require_once 'modelos/usuarios.modelo.php';
require_once 'modelos/carrito.modelo.php';
require_once 'modelos/visitas.modelo.php';

require_once 'modelos/rutas.php';

/* --------------------------------- MODELOS -------------------------------- */

/* -------------------------------------------------------------------------- */
/*                                 EXTENSIONES                                */
/* -------------------------------------------------------------------------- */

require_once 'extensiones/phpmailer/vendor/autoload.php';
require_once 'extensiones/google/vendor/autoload.php';

/* ------------------------------- EXTENSIONES ------------------------------ */

$plantilla = new ControladorPlantilla();
$plantilla->plantilla();
