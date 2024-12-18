<?php
require_once 'Engine/Engine.php';
require_once 'Database/DAL.php';

use Engine\Engine;
use Database\DAL;

$filePath = __DIR__ . '/Test_Ventas.xlsx';
$sheetName = 'Hoja1'; // Nombre de la hoja en tu Excel

$engine = new Engine($filePath);
$dal = new DAL();

// Guardar en la db la información
// $boletas = $engine->arrayBoletaVenta($filePath, $sheetName);

// $dal->saveBoletasVenta($boletas);

// Obtener las boletas de la DB
// $boletas = $dal->GetBoletasVenta();
// foreach($boletas as $boleta){
//     echo "Id: {$boleta->Id} || Objeto: {$boleta->Objeto} || Precio: {$boleta->Precio}";
// }

// Borrar un registro
// $dal->deleteBoletaVenta(1);

// Actualizar un registro
$id=5;
$valor="sombrero";
$dal->updateBoletaVenta($id,$valor);
?>