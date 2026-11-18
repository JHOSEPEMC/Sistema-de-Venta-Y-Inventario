<?php
// app/controllers/ReporteControlador.php

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteControlador {
    
    // Muestra la vista principal de reportes
    public function index() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=Login&action=index");
            exit;
        }
        require_once APP_PATH . '/views/reportes/index.php';
    }

    // Generar Reporte en PDF
    public function pdf() {
        if (!isset($_SESSION['usuario_id'])) { exit; }

        // Capturamos las fechas del formulario (si no hay, ponemos el mes actual)
        $fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');

        $db = Database::getConnection();
        // Consulta para traer las ventas en ese rango de fechas
        $stmt = $db->prepare("SELECT v.id_venta, v.fecha_venta, v.tipo_pago, v.monto_total, c.razon_social as cliente, u.nombre_completo as vendedor 
                              FROM ventas v 
                              LEFT JOIN clientes c ON v.id_cliente = c.id_cliente 
                              LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario 
                              WHERE DATE(v.fecha_venta) BETWEEN :inicio AND :fin 
                              ORDER BY v.fecha_venta ASC");
        $stmt->execute([':inicio' => $fecha_inicio, ':fin' => $fecha_fin]);
        $ventas = $stmt->fetchAll();

        // Calcular el total recaudado
        $total_recaudado = 0;
        foreach ($ventas as $v) { $total_recaudado += $v['monto_total']; }

        // Construir el HTML del PDF
        $html = '
        <h1 style="text-align: center;">' . NOMBRE_NEGOCIO . '</h1>
        <h2 style="text-align: center;">Reporte de Ventas</h2>
        <p><strong>Desde:</strong> ' . $fecha_inicio . ' | <strong>Hasta:</strong> ' . $fecha_fin . '</p>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #0056b3; color: white;">
                <tr>
                    <th>ID</th><th>Fecha</th><th>Cliente</th><th>Vendedor</th><th>Tipo Pago</th><th>Total</th>
                </tr>
            </thead>
            <tbody>';
        
        foreach ($ventas as $v) {
            $html .= '<tr>
                <td>' . $v['id_venta'] . '</td>
                <td>' . date('d/m/Y H:i', strtotime($v['fecha_venta'])) . '</td>
                <td>' . htmlspecialchars($v['cliente'] ?? 'Cliente Genérico') . '</td>
                <td>' . htmlspecialchars($v['vendedor']) . '</td>
                <td>' . $v['tipo_pago'] . '</td>
                <td>' . MONEDA . ' ' . number_format($v['monto_total'], 2) . '</td>
            </tr>';
        }

        $html .= '</tbody></table>
        <h3 style="text-align: right;">Total Recaudado: ' . MONEDA . ' ' . number_format($total_recaudado, 2) . '</h3>';

        // Generar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Horizontal para que quepa la tabla
        $dompdf->render();
        $dompdf->stream("reporte_ventas_" . date('Ymd') . ".pdf", ["Attachment" => true]);
        exit;
    }

    // Generar Reporte en Excel
    public function excel() {
        if (!isset($_SESSION['usuario_id'])) { exit; }

        $fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-d');

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT v.id_venta, v.fecha_venta, v.tipo_pago, v.monto_total, c.razon_social as cliente 
                              FROM ventas v 
                              LEFT JOIN clientes c ON v.id_cliente = c.id_cliente 
                              WHERE DATE(v.fecha_venta) BETWEEN :inicio AND :fin 
                              ORDER BY v.fecha_venta ASC");
        $stmt->execute([':inicio' => $fecha_inicio, ':fin' => $fecha_fin]);
        $ventas = $stmt->fetchAll();

        // Crear el archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'ID Venta');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Cliente');
        $sheet->setCellValue('D1', 'Tipo Pago');
        $sheet->setCellValue('E1', 'Total');

        // Estilo para los encabezados
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0056B3');
        $sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB('FFFFFFFF');

        // Llenar datos
        $row = 2;
        foreach ($ventas as $v) {
            $sheet->setCellValue('A' . $row, $v['id_venta']);
            $sheet->setCellValue('B' . $row, date('d/m/Y H:i', strtotime($v['fecha_venta'])));
            $sheet->setCellValue('C' . $row, $v['cliente'] ?? 'Cliente Genérico');
            $sheet->setCellValue('D' . $row, $v['tipo_pago']);
            $sheet->setCellValue('E' . $row, $v['monto_total']);
            $row++;
        }

        // Autoajustar el ancho de las columnas
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Descargar Excel
        $writer = new Xlsx($spreadsheet);
        $filename = "reporte_ventas_" . date('Ymd') . ".xlsx";
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($filename) .'"');
        $writer->save('php://output');
        exit;
    }
}