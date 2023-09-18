<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de IMC!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        .center_div{
            margin: auto;
            width: 50%;
        }
    </style>
</head>
<body class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <header class="text-center col-md-12 mt-4">
                <h1 class="">Calcule seu IMC!</h1>
            </header>

            <div class="center_div">
                <form method="POST">
                    <div class="form-group">
                        <label for="altura">Altura</label>
                        <input type="number" class="form-control" id="altura" name="altura"  placeholder="Digite sua altura em centímetros. Ex: 180">
                    </div>
                    <div class="form-group">
                        <label for="peso">Peso</label>
                        <input type="text" class="form-control" id="peso" name="peso" placeholder="Digite seu peso em kilos. Ex: 80.5">
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary">Descobrir IMC!</button>
                    </div>
                </form>


                <?php 

                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_POST['altura'], $_POST['peso'])){
                            $altura = $_POST['altura'];
                            $peso = $_POST['peso'];
                            if(is_numeric($altura) && is_numeric($peso)){
                                $msg = calcular_imc($altura, $peso);
                            }else{
                                $msg = "<span class='text-danger'>Por favor, insira valores válidos em centímetros (cm) e kilos (kg)!</span>";
                            }
                        }
                    }

                    function calcular_imc($altura, $peso){
                        $imc = $peso / pow($altura, 2);
                        $imc = str_replace('.', '' , $imc); // remove "."
                        $imc = ltrim($imc, "0"); // remove os zeros à esquerda
                        $imc = substr($imc, 0, 4); // seleciona os 4 primeiros números correspondentes ao IMC
                        $imc_formatado = "";
                        for ($i=0; $i < strlen($imc); $i++) { 
                            // ternario para adicionar "." entre as dezenas, ex: 24.75
                            $imc_formatado = ($i == 2 )? $imc_formatado . "." . $imc[$i] : $imc_formatado . $imc[$i];
                        }
                        return descobrir_faixa_imc($imc_formatado);
                    }

                    function descobrir_faixa_imc($imc){
                        $faixa_e_classificacao_imc = array(
                            "18.5" => "Magreza",
                            "24.9" => "Saudável",
                            "29.9" => "Sobrepeso",
                            "34.9" => "Obesidade grau I",
                            "39.9" => "Obesidade grau II",
                            "40.0" => "Obesidade grau III"
                        );
            
                        if($imc >= 40){ // Evita loop caso IMC maior que 40
                            return "<span class='text-danger'>Atenção, seu IMC é $imc e está classificado como: Obesidade grau III.</span>";
                        }else{
                            $classificacao_final = "";
                            foreach($faixa_e_classificacao_imc as $valor_imc_temp => $classificacao_imc_temp){
                                if($imc <= $valor_imc_temp){
                                    $classificacao_final = $classificacao_imc_temp;
                                    break;
                                }    
                            }
                            
                            $text_color = "";
                            switch($classificacao_final){
                                case "Saudável":
                                    $text_color = "text-success";
                                    break;
                                case "Sobrepeso":
                                    $text_color = "text-warning";
                                    break;
                                case "Magreza" || "Obesidade grau I" || "Obesidade grau II" || "Obesidade grau III":
                                    $text_color ="text-danger";
                                    break;
                            }
                            return "<span class='$text_color'>Seu IMC é $imc e está classificado como: $classificacao_final.</span>";
                        }
                    }
                ?>

                <div>
                    <?php echo $msg; ?>
                </div>

                <div>
                    <p>Tabela de referencia</p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Faixa</th>
                            <th>Classificação</th>
                        </tr>
                        </thead>
                            <tbody>
                            <tr>
                                <td>Até 18.5</td>
                                <td>Magreza</td>
                            </tr>
                            <tr>
                                <td>De 18.51 a 24.9</td>
                                <td>Saudável</td>
                            </tr>
                            <tr>
                                <td>De 25.0 a 29.9</td>
                                <td>Sobrepeso</td>
                            </tr>
                            <tr>
                                <td>De 30.0 a 34.9</td>
                                <td>Obesidade Grau I</td>
                            </tr>
                            <tr>
                                <td>De 35.0 a 39.9</td>
                                <td>Obesidade Grau II</td>
                            </tr>
                            <tr>
                                <td>Acima de 39.9</td>
                                <td>Obesidade Grau III</td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>