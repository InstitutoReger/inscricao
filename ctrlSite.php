<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

require_once('class.PDO.php');

    if($_POST){
        parse_str(urldecode($_POST['frm']), $data);
        $pdo = Database::conexao();

        $cpf = $pdo->prepare('SELECT COUNT(cpf) FROM inscricao WHERE cpf = :cpf');
        $cpf->bindValue(':cpf', $data['cpf']);
        $cpf ->execute();
        $numResult = $cpf->fetchColumn();
        
        if($numResult > 0){
            $result = array(
                'msg' => 'O CPF informado já está inscrito no Workshop.',
                'status' => 0
            );
        } else {

            $cad = $pdo->prepare('
            INSERT INTO inscricao (nome, cpf, email, instituicao, curso, cidade, estado, celular, horainscricao) 
            VALUES(:nome, :cpf, :email, :instituicao, :curso, :cidade, :estado, :celular, NOW())');

            $cad->bindValue(':nome', $data['nome']);
            $cad->bindValue(':cpf', $data['cpf']);
            $cad->bindValue(':email', $data['email']);
            $cad->bindValue(':instituicao', $data['instituicao']);
            $cad->bindValue(':curso', $data['curso']);
            $cad->bindValue(':cidade', $data['cidade']);
            $cad->bindValue(':estado', $data['estado']);
            $cad->bindValue(':celular', $data['celular']);
        

            if($cad->execute()){

                $mail = new PHPMailer(true);

                try{
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'mail.itego.com.br';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'workshop@itego.com.br';                     // SMTP username
                    $mail->Password   = 'd,Q&Yl*+#IQy';                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                
                    //Recipients
                    $mail->setFrom('workshop@itego.com.br', 'Workshop ITEGO');
                    $mail->addAddress($data['email'], $data['nome']);     // Add a recipient
                    $mail->addReplyTo($data['email'], $data['nome']);
               
                    $nome = $data['nome'];
                    $email = $data['email'];
                    $cpf = $data['cpf'];
                    $celular = $data['celular'];
                    $instituicao = $data['instituicao'];
                    $curso = $data['curso'];
                    $cidade = $data['cidade'];
                    $estado = $data['estado'];
                	$aviso = "<h3>O certificado só será emitido com a verificação da presença on-line do inscrito. Essa presença será verificada pela participação no chat do Youtube (<a href='https://www.youtube.com/channel/UCHcBavF0Uf4iMwXwrj9LI7A' target='_blank'>do canal da Regional 3</a>), em cada palestra. Tem que participar com o mesmo e-mail que realizou a inscrição.</h3>";
                	
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmação de inscrição';
                    $mail->Body    = "Nome: $nome <br> CPF: $cpf <br> Celular: $celular <br> Email: $email <br> Instituição: $instituicao <br> Curso: $curso<br> Cidade: $cidade <br> Estado: $estado<br><br>$aviso";
                    
                
                    if($mail->send()){
                        $result = array(
                            'msg' => 'Sua inscrição foi realizada. A confirmação foi enviada para o email informado.',
                            'status' => 1
                        );
                    }   
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
        echo json_encode($result);
    }
?>