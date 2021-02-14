<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>3º Workshop de Formação Continuada em Tecnologia da Gestão para a Educação Profissional e Tecnológica on-line</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="style.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@531;600;900&display=swap" rel="stylesheet">

</head>
<body>
    <header class="container text-center">
        <h1>3º Workshop de Formação Continuada em Tecnologia da Gestão para a Educação Profissional e Tecnológica on-line</h1>
        
        <div class="boxLocal text-center w-75 mx-auto my-3 py-2">
            Promovido pela Regional 3<br>
            17, 18 e 19 de novembro de 2020
        </div>

        <img src="logos.png" />
    </header>


    <main class="container mt-5">
        <form method="POST" action="" id="frmInscricao">
            <h1 class="sep">Dados Pessoais</h1>
                
            <div class="form-row pt-5">
                <div class="form-group col-sm-9">
                    <label>Nome:</label>
                    <input type="text" class="form-control" name="nome" id="nome" required>
                </div>

                <div class="form-group col-sm-3">
                    <label>CPF:</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <label>E-mail:</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>

                <div class="form-group col">
                    <label>Celular:</label>
                    <input type="text" class="form-control" name="celular" id="celular" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <label>Instituição:</label>
                    <input type="text" class="form-control" name="instituicao" id="instituicao" required>
                </div>

                <div class="form-group col">
                    <label>Curso ou profissão:</label>
                    <input type="text" class="form-control" name="curso" id="curso" required>
                </div>
            </div>

            <div class="form-row pb-5">
                <div class="form-group col">
                    <label>Cidade:</label>
                    <input type="text" class="form-control" name="cidade" id="cidade" required>
                </div>

                <div class="form-group col">
                    <label>Estado:</label>
                    <input type="text" class="form-control" name="estado" id="estado" required>
                </div>
            </div>
            
            
            <p class="avisos">
                <b>Atenção:</b><br>
                - Para receber o certificado do Workshop, você deverá se inscrever e participar de <b>todas as palestras em todos os dias.</b><br>
                - Caso participe somente de alguns dias, você receberá o certificado <b>somente do dia.</b><br>
                - <b>O certificado só será emitido com a verificação da presença on-line do inscrito. Essa presença será verificada pela participação no chat do youtube (<a href='https://www.youtube.com/channel/UCHcBavF0Uf4iMwXwrj9LI7A' target='_blank'>do canal COTECs Regional 3</a>), em cada palestra. Tem que participar com o mesmo e-mail que realizou a inscrição.</b><br>
                - A idade mínima para participar do Workshop é de 16 anos.
            </p>


            <div class="form-row">
                <div class="form-group col-sm-12">
                    <input type="submit" class="btnFinalizaInscricao" value="Finalizar Inscrição">
                </div>
            </div>
        </form>
    </main>

    <footer class="text-center mt-5 pb-5">
        
    <h1>Organização</h1>
        Drª Maria Beatriz de Oliveira Monteiro 
        <a href="http://lattes.cnpq.br/3536508606110259" target="_blank">http://lattes.cnpq.br/3536508606110259</a><br>
        Ma. Rosana Resende Nogueira Chaves 
        <a href="http://lattes.cnpq.br/6108516212819208" target="_blank">http://lattes.cnpq.br/6108516212819208</a>

        <br><br>
    <h1>Comunicação e Infraestrutura da Transmissão do Evento</h1>
    Me. Douglas Araújo Falcão 
        <a href="http://lattes.cnpq.br/4011537951302777" target="_blank">http://lattes.cnpq.br/4011537951302777</a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="jquery.mask.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00', {reverse: true});
        $('#celular').mask('(00) 0.0000-0000');

        
        $("#frmInscricao").submit(function(e){
            e.preventDefault();

            var frm = $(this).serialize();

            $.ajax({
                url:'ctrlSite.php',
                type: 'POST',
                data: {frm: frm},
                dataType: 'json',
                success: function(result){
                    if(result['status'] == 1){
                        $('main').html('<h1 class="text-center py-5">'+result['msg']+'</h1>');
                    }
                    else{
                        alert(result['msg']);
                    }
                }
            });
        });
    });
    </script>
</body>
</html>