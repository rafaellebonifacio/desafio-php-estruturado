<?php
require_once 'classe-produto.php';
$produto = New Produto("CRUDPDO","localhost","root","")
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre seu Produto</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php
  //-----------------------------HEADER--------------------------------------------//  
    $path = 'C:\xampp\htdocs\desafio-php-estruturado\header.php';

    //Retornará true se o arquivo existir
    if (file_exists($path)) {
    //Se o arquivo existir podemos incluí-lo.
        include($path);
    }
    if (isset($_POST['nome'])) // se a pessoa clicou no botão cadastrar ou editar//
{

//----------------------------------EDITAR----------------------------------//

if(isset($_GET['id_atualizar']) && !empty($_GET['id_atualizar']))
{
    $id_att =  addslashes($_GET['id_atualizar']);
    $nome = addslashes($_POST['nome']);
    $descricao = addslashes($_POST['descricao']);
    $preco = addslashes($_POST['preco']);
    $quantidade = addslashes($_POST['quantidade']);
    $nome_imagem = $_FILES['imagem']['name'];
    $tamanho_imagem = $_FILES['imagem']['size'];
    $tipo_imagem = $_FILES['imagem']['type'];
    $imagem = $_FILES ['imagem']['tmp_name'];

//-------------------validacoes--------------------------///

    if (strlen($_POST["nome"])==0){
        echo "O campo nome do produto não pode ser vazio. <br/>";
    }
    if (strlen($_POST["descricao"])<0){
        echo "Campo da descrição deve ter no minino 30 caracteres. <br/>";
    }
    if (is_numeric($_POST["preco"])==false){
        echo "O preço deve ser numerico. <br/>";
    }



    if(!empty($nome)&& !empty($preco) && !empty($quantidade) && !empty($imagem))
    {
    $produto->atualizarDadosProduto($id,$nome, $descricao, $preco, $quantidade,$nome_imagem,$tamanho_imagem,$tipo_imagem, $imagem);
    header("location: showProduto.php");
    }
    else 
    {
        echo "Preencha todos os campos";
    }
}
}

// get para id_atualizar//

if(isset($_GET['id_atualizar'])){ /// se clicou no botao editar/// 
    $id_atualizar = addslashes($_GET['id_atualizar']);
    $resultado = $produto->buscarDadosProduto($id_atualizar);
    
    }

    ?> 



<h2>Produtos Lojinha</h2> 
<section id = "itens">
<table>
<tr id="titulo">
<td>Itens</td>
<td>Descrição</td>
<td>Preço</td>
<td>Quantidade</td>
<td>Arquivo</td>
</tr>

<?php
$dados = $produto->buscarDados();
if(count($dados)>0){ //se tem dados no banco de dados//
    for ($i=0;$i < count($dados);$i++){
        echo "<tr>";
        foreach ($dados[$i] as $key => $value)
        {
            if ($key != "id" )
            if ($key != "imagem" )
            {
                echo "<td>". $value. "</td>";
        }
        }
        ?><td>
            
            <a href="createProduto.php?id_atualizar= <?php echo $dados[$i]['id'];?>">Editar</a>
            
            <a href="showProduto.php?id= <?php echo $dados[$i]['id'];?>">Excluir</a>
        
        
        </td>
    <?php
        echo "</tr>";
    }
}
else {
    echo "Voce ainda nao cadastrou nenhum produto!";
}
?>
</table>

<a class = "seguir" href="/desafio-php-estruturado\usuarios\createUsuario.php">Seguir</a>
</section>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>

<?php

if(isset($_GET['id'])){
    $id_produto = addslashes($_GET['id']);
    $produto->excluirProduto($id_produto);
    // header("location:createProduto.php");

}

?>