<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('class.PDO.php');
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$pdo = Database::conexao();

$xls = $pdo->prepare('select * from inscricao');
$xls -> execute();

$i=2;
$sheet->setCellValue('A1','ID');
$sheet->setCellValue('B1','NOME');
$sheet->setCellValue('C1','CPF');
$sheet->setCellValue('D1','EMAIL');
$sheet->setCellValue('E1','INSTITUICAO');
$sheet->setCellValue('F1','CURSO');
$sheet->setCellValue('G1','CIDADE');
$sheet->setCellValue('H1','ESTADO');
$sheet->setCellValue('I1','CELULAR');
$sheet->setCellValue('J1','HORAINSCRICAO');


while($r = $xls->fetch(PDO::FETCH_ASSOC)){
	$sheet->setCellValue('A'.$i, $r['id']);
	$sheet->setCellValue('B'.$i, $r['nome']);
	$sheet->setCellValue('C'.$i, $r['cpf']);
	$sheet->setCellValue('D'.$i, $r['email']);
	$sheet->setCellValue('E'.$i, $r['instituicao']);
	$sheet->setCellValue('F'.$i, $r['curso']);
	$sheet->setCellValue('G'.$i, $r['cidade']);
	$sheet->setCellValue('H'.$i, $r['estado']);
	$sheet->setCellValue('I'.$i, $r['celular']);
	$sheet->setCellValue('J'.$i, $r['horainscricao']);
$i++;
}
$filename = 'inscritos-'.uniqid().'-'.date('dmy').'.xlsx';

$writer = new Xlsx($spreadsheet);
$writer->save($filename);

$attachment = $_SERVER['DOCUMENT_ROOT'].'/workshop/'.$filename;


$mail = new PHPMailer(true);

                
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'mail.itego.com.br';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'contato@itego.com.br';                     // SMTP username
                    $mail->Password   = 'itego@8102';                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                
                    //Recipients
                    $mail->setFrom('contato@itego.com.br', '3º Workshop');
                    $mail->addAddress('maria.beatriz@institutoreger.org.br', 'Maria Beatriz');     // Add a recipient
                    $mail->addAddress('carina.savastano@institutoreger.org.br', 'Carina');     // Add a recipient
                    $mail->addAddress('elianeleao.secretaria@gmail.com', 'Eliane');     // Add a recipient
                    $mail->addAddress('luan.oloco@institutoreger.org.br', 'Luan');     // Add a recipient
                    $mail->addAddress('coordpedagogica.itegacn@gmail.com', 'Coord. Pedagógica');     // Add a recipient
                    

                    $mail->addBCC('matsutani@gmail.com', 'Marcus');
                    
                                    	
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Lista de Inscritos';
                    $mail->Body    = "$attachment";
                    $mail->AddAttachment($attachment);
                    
                
                    $mail->send();

                    echo $xls->rowCount(). " inscritos encontrados. A planilha com as informações foi enviada para os emails dos responsáveis";
?>