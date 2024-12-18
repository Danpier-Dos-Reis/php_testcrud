<?php
namespace Database;

require_once 'Models/BoletaVenta.php';
use Models\BoletaVenta;
use PDO;
use PDOException;

class DAL {
    private $pdo;

    /**
     * Constructor que inicializa la conexión a la base de datos.
     */
    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=db_ventas;charset=utf8mb4';
        $user = 'dan';
        $password = '12345678';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Obtiene todas las boletas de la tabla BoletaVenta.
     *
     * @return array Array de objetos BoletaVenta.
     */
    public function GetBoletasVenta() {

        try {
            $stmt = $this->pdo->query("SELECT * FROM BoletaVenta");

            // Recorrer cada fila del resultado
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $boleta = new BoletaVenta(
                    $row['Id'],
                    $row['Objeto'],
                    $row['Cantidad'],
                    $row['Precio']
                );

                $boletas[] = $boleta; // Agregar al array
            }
        } catch (PDOException $e) {
            die("Error al obtener las boletas: " . $e->getMessage());
        }

        return $boletas;
    }

    /**
     * Inserta los valores de un array de BoletaVenta en la base de datos MySQL.
     *
     * @param array $boletas Array de objetos BoletaVenta.
     * @return void
     */
    function saveBoletasVenta($boletas) {

        try {
            $stmt = $this->pdo->prepare("INSERT INTO BoletaVenta (Objeto, Cantidad, Precio) VALUES (:objeto, :cantidad, :precio)");

            foreach ($boletas as $boleta) {
                $stmt->execute([
                    ':objeto' => $boleta->Objeto,
                    ':cantidad' => $boleta->Cantidad,
                    ':precio' => $boleta->Precio
                ]);
            }

            echo "Datos insertados correctamente en la base de datos.\n";

        } catch (PDOException $e) {
            die("Error al conectar o insertar en la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Elimina un registro de la tabla BoletaVenta en la base de datos.
     *
     * @param int $id Id del registro a eliminar.
     * @return void
     */
    function deleteBoletaVenta($id) {
        try {
            // Preparar la consulta SQL para eliminar
            $stmt = $this->pdo->prepare("DELETE FROM BoletaVenta WHERE Id = :id");

            // Ejecutar la consulta pasando el Id como parámetro
            $stmt->execute([':id' => $id]);

            echo "Registro con Id $id eliminado correctamente de la base de datos.\n";

        } catch (PDOException $e) {
            die("Error al eliminar el registro de la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Actualiza el valor de la columna "Objeto" en el registro con el Id especificado.
     *
     * @param int $id El Id del registro a actualizar.
     * @param string $nuevoObjeto El nuevo valor para la columna "Objeto".
     * @return void
     */
    function updateBoletaVenta($id, $nuevoObjeto) {
        try {
            // Preparar la consulta SQL para actualizar
            $stmt = $this->pdo->prepare("UPDATE BoletaVenta SET Objeto = :objeto WHERE Id = :id");
        
            // Ejecutar la consulta pasando parámetros seguros
            $stmt->execute([
                ':objeto' => $nuevoObjeto,
                ':id'     => $id
            ]);
        
            echo "Registro con Id $id actualizado correctamente. Nuevo valor: $nuevoObjeto\n";
        
        } catch (PDOException $e) {
            die("Error al actualizar el registro: " . $e->getMessage());
        }
    }
}