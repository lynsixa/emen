<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Orden;
use ZipArchive;

class GerenteInformeControllerV2 extends Controller  // Renombrado para evitar conflicto
{
    // Los métodos siguen igual
    public function index()
    {
        return view('gerente.informes.index');
    }

    public function generarInformeUsuarios()
    {
        $usuarios = Usuario::with('tipoDeDocumento', 'roles')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usuarios');

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

    public function generarInformeOrdenes()
    {
        $ordenes = Orden::all(); // Obtener todas las órdenes

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Órdenes');

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

    public function generarTodosLosInformes()
    {
        $zipFile = public_path('informes/informes.zip');
        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            // Generación de informes y adición a archivo ZIP (igual como ya estaba)
            // ...
            $zip->close();
        } else {
            die("No se pudo crear el archivo ZIP.");
        }

        return response()->download($zipFile)->deleteFileAfterSend(true);
    }
}
