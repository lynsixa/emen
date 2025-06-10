<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Orden;
use ZipArchive;

class InformeController extends Controller
{
    // Esta es la función que debe existir para mostrar la vista de informes
    public function index()
    {
        // Retorna la vista del index de informes donde el usuario puede seleccionar los informes a descargar
        return view('admin.informes.index'); // Cambia esta vista si la ruta es diferente
    }

    // Generar Informe de Usuarios
    public function generarInformeUsuarios()
    {
        $usuarios = Usuario::with('tipoDeDocumento', 'roles')->get(); // Asegúrate de cargar las relaciones necesarias

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usuarios');

        // Encabezados
        $sheet->setCellValue('A1', 'Nombres');
        $sheet->setCellValue('B1', 'Apellidos');
        $sheet->setCellValue('C1', 'Documento');
        $sheet->setCellValue('D1', 'Correo');
        $sheet->setCellValue('E1', 'Rol');
        $sheet->setCellValue('F1', 'Tipo Documento');

        // Insertar los datos
        $row = 2;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue("A$row", $usuario->Nombres);
            $sheet->setCellValue("B$row", $usuario->Apellidos);
            $sheet->setCellValue("C$row", $usuario->Documento);
            $sheet->setCellValue("D$row", $usuario->Correo);
            $sheet->setCellValue("E$row", $usuario->roles->Descripcion);
            $sheet->setCellValue("F$row", $usuario->tipoDeDocumento->Descripcion);
            $row++;
        }

        // Cabeceras HTTP para archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="informe_usuarios.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // Generar Informe de Órdenes
    public function generarInformeOrdenes()
    {
        $ordenes = Orden::all(); // Obtener todas las órdenes, ajusta según necesites

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Órdenes');

        // Encabezados
        $sheet->setCellValue('A1', 'ID Orden');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Descripción Orden');
        $sheet->setCellValue('D1', 'Precio Final');

        // Insertar los datos
        $row = 2;
        foreach ($ordenes as $orden) {
            $sheet->setCellValue("A$row", $orden->idOrden);
            $sheet->setCellValue("B$row", $orden->Fecha);
            $sheet->setCellValue("C$row", $orden->Descripcion);
            $sheet->setCellValue("D$row", $orden->PrecioFinal);
            $row++;
        }

        // Cabeceras HTTP para archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="informe_ordenes.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // Descargar todos los informes como un archivo ZIP
    public function generarTodosLosInformes()
    {
        $zipFile = public_path('informes/informes.zip');
        $zip = new ZipArchive();

        // Crea un archivo ZIP
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            // Informe de usuarios
            $usuariosSpreadsheet = new Spreadsheet();
            $usuariosSheet = $usuariosSpreadsheet->getActiveSheet();
            $usuariosSheet->setTitle('Usuarios');
            $usuariosSheet->setCellValue('A1', 'Nombres');
            // Completar con datos de usuarios
            $usuariosFile = public_path('informes/informe_usuarios.xlsx');
            $writerUsuarios = new Xlsx($usuariosSpreadsheet);
            $writerUsuarios->save($usuariosFile);
            $zip->addFile($usuariosFile, 'informe_usuarios.xlsx');

            // Informe de órdenes
            $ordenesSpreadsheet = new Spreadsheet();
            $ordenesSheet = $ordenesSpreadsheet->getActiveSheet();
            $ordenesSheet->setTitle('Órdenes');
            $ordenesSheet->setCellValue('A1', 'ID Orden');
            // Completar con datos de órdenes
            $ordenesFile = public_path('informes/informe_ordenes.xlsx');
            $writerOrdenes = new Xlsx($ordenesSpreadsheet);
            $writerOrdenes->save($ordenesFile);
            $zip->addFile($ordenesFile, 'informe_ordenes.xlsx');

            $zip->close();
        } else {
            die("No se pudo crear el archivo ZIP.");
        }

        // Enviar el archivo ZIP al navegador
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }
}
