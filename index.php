
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
        <h1>Adicione os produtos:</h1>
        <!-- ID, NOME, VALOR -->
        <table>
            <tr>
                <th>ID</th>
                <th>PRODUTO</th>
                <th>VALOR</th>
            </tr>
            <?php 
                //Inicializando as variáveis 
                error_reporting(0);

                $arqProdutos = fopen("Produtos.txt", "r") or die("Erro ao abrir arquivo");

                //Inicializando o x
                $x = 1;
                $linha[] = fgets($arqProdutos);
                
                //Criando um loop para as linhas do arquivo
                while(!feof($arqProdutos)){

                    $linha[] = fgets($arqProdutos);
                    $colunaDados = explode(";", $linha[$x]);
                    $id = $colunaDados[0];
                    $nome = $colunaDados[1];
                    $valor = $colunaDados[2];
                    
                    //Criando uma tabela com os produtos
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $nome . "</td>";
                    echo "<td>" . $valor . "</td>";
                    echo "</tr>";
                    //Incrementando o x
                    $x++;
                }
                //Ao finalizar o loop, fechar o arquivo
                fclose($arqProdutos);
            ?>
        </table>
        <br>
        <hr>
        <h2>Selecione o ID do produto desejado e sua quantidade:</h2>
        <form action="index.php" method="POST">
            <lable>
                ID:
            <input type="text" name="ID">
            </lable>
            <lable>
                Qntd:
            <input type="number" name="qntd" min="1">
            </lable>
            <input type="submit" value="Comprar">
        </form>
        <?php
        // Criar um arquivo carrinho.txt, que irá receber cada produto, e criar um loop que tenha uma variavel que 
        //faça (qntd * valor)     
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $idCompra = $_POST["ID"];
                $qntd = $_POST['qntd'];
                $total = 0;
                $id = "";
                $nome = "";
                $valor = "";
                $arqProdutos = fopen("Produtos.txt", "r") or die ("Erro ao abrir arquivo!");
                $arqCarrinho = fopen("carrinho.txt", "w") or die ("Erro ao criar arquivo");

                $x = 1;
                $linha[] = fgets($arqProdutos);
                

                while(!feof($arqProdutos)){
                    $linha[] = fgets($arqProdutos);
                    $colunaDados = explode(";", $linha[$x]);
                    $id = $colunaDados[0];

                    if($id == $idCompra){
                        $nome = $colunaDados[1];
                        $valor = $colunaDados[2];
                        $total = $valor * $qntd;
                        $texto = $id . ";" . $nome . ";" . $qntd . ";" . $total . "\n";
                        $arqCarrinho = fopen("carrinho.txt", "a");
                        fwrite($arqCarrinho, $texto);
                        echo "<h3> Produto adicionado.</h3>";
                    }
                    $x++;
                }
                fclose($arqCarrinho);
                fclose($arqProdutos);
            }
        
        ?>
        <br>
        <hr>
        <h2><a href="carrinho.php"> <!-- Carrinho -->
            Carrinho
        </a></h2>
    </body>
</html>