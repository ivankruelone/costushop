<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2010 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.4, 2010-08-26
 */

/** Error reporting */
ini_set('memory_limit', '512M');
error_reporting(E_ALL);


date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once 'Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("IVAN ZUÑIGA PEREZ")
							 ->setLastModifiedBy("IVAN ZUÑIGA PEREZ")
							 ->setTitle("Reporte de Ventas")
							 ->setSubject("Reporte de Ventas")
							 ->setDescription("Reporte de Ventas")
							 ->setKeywords("Reporte de Ventas")
							 ->setCategory("Reporte de Ventas");


$ini=4;

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ini, 'Prenda Anterior')
            ->setCellValue('B'.$ini, 'Prenda Nueva')
            ->setCellValue('C'.$ini, 'Servicio Anterior')
            ->setCellValue('D'.$ini, 'Servicio Nuevo')
            ->setCellValue('E'.$ini, 'Precio Anterior')
            ->setCellValue('F'.$ini, 'Precio Nuevo')
            ->setCellValue('G'.$ini, 'Activo Anterior')
            ->setCellValue('H'.$ini, 'Activo Nuevo')
            ->setCellValue('I'.$ini, 'Modificado')
;            

$num = 5;


//serie, folio, rec_rfc, rec_razon, subtotal, estatus
foreach ($query->result() as $row)
{

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$num, $row->prenda1)
            ->setCellValue('B'.$num, $row->prenda2)
            ->setCellValue('C'.$num, $row->nombre_anterior)
            ->setCellValue('D'.$num, $row->nombre_nuevo)
            ->setCellValue('E'.$num, $row->precio_anterior)
            ->setCellValue('F'.$num, $row->precio_nuevo)
            ->setCellValue('G'.$num, $row->activo_antes)
            ->setCellValue('H'.$num, $row->activo_despues)
            ->setCellValue('I'.$num, $row->fecha)
;
            $num++;

}
        $num3 = $num + 2;

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$num3, date('Y-m-d H:i:s'))
            ;


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', TITULO_WEB);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $titulo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'PERIODO DEL '.$f1.' AL '.$f2);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="servicios_'.date('YmdHsi').'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;