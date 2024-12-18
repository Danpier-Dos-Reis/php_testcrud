<?php
namespace Engine;

require_once 'Models/BoletaVenta.php';
require 'vendor/autoload.php'; // Asegúrate de cargar PhpSpreadsheet con Composer

use PhpOffice\PhpSpreadsheet\IOFactory;
use Models\BoletaVenta;
use PDO;
use PDOException;

class Engine {
    
    /**
    * Retornar un BoletaVenta[] a partir de una hoja de Excel.
    * BoletaVenta[] = array de objetos BoletaVenta
    *
    * @param string $filePath Ruta del archivo Excel.
    * @param string $sheetName Nombre de la hoja específica en el Excel.
    * @return array Array de objetos BoletaVenta.
    * @throws Exception Si el archivo no se puede procesar o la hoja no existe.
    */
    function arrayBoletaVenta($filePath, $sheetName) {
        $boletas = []; // Array para almacenar objetos BoletaVenta
    
        try {
            // Cargar el archivo Excel
            $spreadsheet = IOFactory::load($filePath);
    
            // Obtener la hoja específica
            $sheet = $spreadsheet->getSheetByName($sheetName);
            if (!$sheet) {
                throw new PDOException("No se encontró la hoja: $sheetName");
            }
    
            // Obtener el número máximo de filas y empezar desde la fila 2 (omitiendo encabezado)
            $highestRow = $sheet->getHighestRow();
    
            for ($row = 2; $row <= $highestRow; $row++) {
                // Leer valores de las celdas de la fila
                $id       = $sheet->getCell("A$row")->getValue();
                $objeto   = $sheet->getCell("B$row")->getValue();
                $cantidad = $sheet->getCell("C$row")->getValue();
                $precio   = $sheet->getCell("D$row")->getValue();
    
                // Crear una instancia de BoletaVenta
                $boleta = new BoletaVenta($id, $objeto, $cantidad, $precio);
    
                // Agregar al array
                $boletas[] = $boleta;
            }
        } catch (\Exception $e) {
            die("Error al procesar el archivo: " . $e->getMessage());
        }
    
        return $boletas;
    }
}