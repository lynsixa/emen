<?php
require 'vendor/autoload.php';
require 'conexion.php'; // Asegúrate que este archivo establece la conexión como $conexion

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ---------------------
// 1. Generar Excel de Usuarios
// ---------------------
$usuarios = new Spreadsheet();
$usuariosSheet = $usuarios->getActiveSheet();
$usuariosSheet->setTitle('Usuarios');

// Encabezados
$usuariosSheet->setCellValue('A1', 'Nombres');
$usuariosSheet->setCellValue('B1', 'Apellidos');
$usuariosSheet->setCellValue('C1', 'Documento');
$usuariosSheet->setCellValue('D1', 'Correo');
$usuariosSheet->setCellValue('E1', 'Rol');
$usuariosSheet->setCellValue('F1', 'Tipo Documento');

// Consulta
$sqlUsuarios = "
    SELECT 
        u.Nombres, u.Apellidos, u.Documento, u.Correo,
        r.Descripcion AS Rol,
        td.Descripcion AS TipoDocumento
    FROM Usuario u
    LEFT JOIN Roles r ON u.Roles_idRoles = r.idRoles
    LEFT JOIN `Tipo de documento` td ON u.`Tipo de documento_idTipodedocumento` = td.idTipodedocumento
";

$resUsuarios = $conexion->query($sqlUsuarios);
$fila = 2;
while ($row = $resUsuarios->fetch_assoc()) {
    $usuariosSheet->setCellValue("A$fila", $row['Nombres']);
    $usuariosSheet->setCellValue("B$fila", $row['Apellidos']);
    $usuariosSheet->setCellValue("C$fila", $row['Documento']);
    $usuariosSheet->setCellValue("D$fila", $row['Correo']);
    $usuariosSheet->setCellValue("E$fila", $row['Rol']);
    $usuariosSheet->setCellValue("F$fila", $row['TipoDocumento']);
    $fila++;
}
$usuariosFile = __DIR__ . '/informe_usuarios.xlsx';
$writerUsuarios = new Xlsx($usuarios);
$writerUsuarios->save($usuariosFile);

// ---------------------
// 2. Generar Excel de Órdenes
// ---------------------
$ordenes = new Spreadsheet();
$ordenSheet = $ordenes->getActiveSheet();
$ordenSheet->setTitle('Órdenes');

// Encabezados
$ordenSheet->setCellValue('A1', 'ID Orden');
$ordenSheet->setCellValue('B1', 'Fecha');
$ordenSheet->setCellValue('C1', 'Descripción Orden');
$ordenSheet->setCellValue('D1', 'Precio Final');
$ordenSheet->setCellValue('E1', 'Precio Producto');
$ordenSheet->setCellValue('F1', 'Categoría');
$ordenSheet->setCellValue('G1', 'Solicitud');
$ordenSheet->setCellValue('H1', 'Entrega');

// Consulta
$sqlOrdenes = "
    SELECT 
        o.idOrden, 
        o.Fecha, 
        o.Descripcion AS DescripcionOrden, 
        o.PrecioFinal,
        p.Precio AS PrecioProducto, 
        c.Nombre AS Categoria,
        s.Descripcion AS Solicitud,
        e.Descripcion AS Entrega
    FROM Orden o
    LEFT JOIN Producto p ON o.Producto_idProducto = p.idProducto
    LEFT JOIN Categoria c ON p.idProducto = c.Producto_idProducto
    LEFT JOIN Solicitud s ON o.Solicitud_idSolicitud = s.idSolicitud
    LEFT JOIN Entrega e ON s.Entrega_idEntrega = e.idEntrega
";

$resOrdenes = $conexion->query($sqlOrdenes);
$fila = 2;
while ($row = $resOrdenes->fetch_assoc()) {
    $ordenSheet->setCellValue("A$fila", $row['idOrden']);
    $ordenSheet->setCellValue("B$fila", $row['Fecha']);
    $ordenSheet->setCellValue("C$fila", $row['DescripcionOrden']);
    $ordenSheet->setCellValue("D$fila", $row['PrecioFinal']);
    $ordenSheet->setCellValue("E$fila", $row['PrecioProducto']);
    $ordenSheet->setCellValue("F$fila", $row['Categoria']);
    $ordenSheet->setCellValue("G$fila", $row['Solicitud']);
    $ordenSheet->setCellValue("H$fila", $row['Entrega']);
    $fila++;
}
$ordenesFile = __DIR__ . '/informe_ordenes.xlsx';
$writerOrdenes = new Xlsx($ordenes);
$writerOrdenes->save($ordenesFile);

// ---------------------
// 3. Crear ZIP
// ---------------------
$zipFile = __DIR__ . '/informes.zip';
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
    $zip->addFile($usuariosFile, 'informe_usuarios.xlsx');
    $zip->addFile($ordenesFile, 'informe_ordenes.xlsx');
    $zip->close();
} else {
    die("No se pudo crear el archivo ZIP.");
}

// ---------------------
// 4. Descargar el ZIP
// ---------------------
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="informes.zip"');
header('Content-Length: ' . filesize($zipFile));
readfile($zipFile);

// ---------------------
// 5. Limpiar archivos temporales
// ---------------------
unlink($usuariosFile);
unlink($ordenesFile);
unlink($zipFile);
exit;
