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
            ->setCellValue('A'.$ini, 'ID Orden')
            ->setCellValue('B'.$ini, 'Fecha')
            ->setCellValue('C'.$ini, 'Forma de Pago')
            ->setCellValue('D'.$ini, 'Importe')
;            

$num = 5;

            $importe = 0;
            
            $efe = 0;
            $che = 0;
            $tar = 0;
            $cli = 0;
            $val = 0;

//serie, folio, rec_rfc, rec_razon, subtotal, estatus
foreach ($query->result() as $row)
{

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$num, $row->id)
            ->setCellValue('B'.$num, $row->fecha)
            ->setCellValue('C'.$num, $row->forma_de_pago)
            ->setCellValue('D'.$num, $row->abono)
;
            $num++;
            
            $importe = $importe + $row->abono;
            
            if($row->pago == 1)
            {
                $efe = $efe + $row->abono;
            }
            elseif($row->pago == 2)
            {
                $che = $che + $row->abono;
            }
            elseif($row->pago == 3)
            {
                $tar = $tar + $row->abono;
            }
            elseif($row->pago == 4)
            {
                $cli = $cli + $row->abono;
            }
            elseif($row->pago == 5)
            {
                $val = $val + $row->abono;
            }

}
        $num2 = $num - 1;
$objPHPExcel->getActiveSheet()->setCellValue('C'.$num,'Total Caja');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$num,'=SUM(D5:D'.$num2.')');

        $num3 = $num + 2;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num3, 'Total Efectivo');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num3, $efe);

        $num3 = $num3 + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num3, 'Total Cheque');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num3, $che);

        $num3 = $num3 + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num3, 'Total Tarjeta');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num3, $tar);

        $num3 = $num3 + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num3, 'Total Cliente Frecuiente');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num3, $cli);

        $num3 = $num3 + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num3, 'Total Vales');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num3, $val);

        $num3 = $num3 + 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num3, 'Total Venta');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num3, $venta);

        $num3 = $num3 + 2;

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$num3, date('Y-m-d H:i:s'))
            ;


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);


$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:D3');

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', TITULO_WEB);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $titulo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'PERIODO DEL '.$f1.' AL '.$f2);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="caja_'.date('YmdHsi').'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;