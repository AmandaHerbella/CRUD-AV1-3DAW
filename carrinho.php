<!DOCTYPE html>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
        <style>
            body{
                background-color: #8aaade;
                color: white;
                font-family: 'Montserrat', sans-serif;
            }
            hr{
                color: white;
                height: 5px;
                background-color: white;
                border-width:0;
                border-radius: 25px;
            }
            a:link {
                color: white;
            }
            a:visited {
                color: #f0e922;
            }
            a:hover {
                color: black;
            }
            a:active {
                color: black;
            }
            table, td, th {
            border: 4px solid;
            }
            table {
            width: 50%;
            border-collapse: collapse;
            }
            input[type=submit]{
                background-color: #28317a;
                border: none;
                border-radius: 10px;
                color: white;
                padding: 4px 8px;
                text-decoration: none;
                margin: 4px 2px;
                cursor: pointer;
            }
        </style>
        <title>LOJA ONLINE</title>
    </head>
    <body>
        <h1>Seu Carrinho:</h1>
        <!-- ID, NOME, VALOR -->
        <table>
            <tr>
                <th>ID</th>
                <th>PRODUTO</th>
                <th>QTD</th>
                <th>VALOR</th>
            </tr>
        <?php 
                //Inicializando as variáveis 
                error_reporting(0);

                $arqCarrinho = fopen("carrinho.txt", "r") or die("Erro ao abrir arquivo");

                //Inicializando o x
                $x = 0;
                $linha[] = fgets($arqCarrinho);
                
                //Criando um loop para as linhas do arquivo
                while(!feof($arqCarrinho)){

                    $linha[] = fgets($arqCarrinho);
                    $colunaDados = explode(";", $linha[$x]);
                    $id = $colunaDados[0];
                    $nome = $colunaDados[1];
                    $qntd = $colunaDados[2];
                    $valor = $colunaDados[3];
                    
                    //Criando uma tabela com os produtos
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $nome . "</td>";
                    echo "<td>" . $qntd . "</td>";
                    echo "<td>" . $valor . "</td>";
                    echo "</tr>";
                    //Incrementando o x
                    $x++;
                }
                //Ao finalizar o loop, fechar o arquivo
                fclose($arqCarrinho);
            ?>
        </table>
        <br>
        <hr>
        <br>
        <h1>Deseja excluir algum produto?</h1>
        <form action="carrinho.php" method="POST">
            <lable>
                ID:
            <input type="text" name="ID_Excluir">
            </lable>
            <input type="submit" value="Excluir">
        </form>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_excluir = $_POST["ID_Excluir"];
                $arqCarrinho = fopen("carrinho.txt", "r") or die ("Erro ao abrir arquivo!");
                //Criando um arquivo temporario
                $arqTemp = fopen("arqTemp.txt", "w") or die ("Erro ao criar arquivo temporario!");
                $linhas[] = fgets($arqCarrinho);

                $x = 0;
                while(!feof($arqCarrinho)){
            
                    $linhas[] = fgets($arqCarrinho);
                    $colunaDados = explode(";", $linhas[$x]);
                    $id = $colunaDados[0];
        
                    if($id_excluir == $id){
                        $msg = "O produto foi excluido com sucesso.";
                    }else{
                        $produto = $colunaDados[1];
                        $qntd = $colunaDados[2];
                        $valor = $colunaDados[3];
        
                        $texto = $id . ";" . $produto .
                        ";" . $valor . ";" . $qntd . ";" .  "\n";
                        fwrite($arqTemp, $texto);
                    } 
                    $x++;
                }
                //Copiando os dados do arquivo temporario no arquivo principal
                copy("arqTemp.txt", "carrinho.txt");
                fclose($arqCarrinho);
                fclose($arqTemp);
                // Excluindo o arquivo temporario
                unlink("arqTemp.txt");
            }
        ?>
        <hr>
        <h1><a href="index.php">Voltar</a></h1>
    </body>
</html>