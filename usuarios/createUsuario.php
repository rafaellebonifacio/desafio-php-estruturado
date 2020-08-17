<?php
require_once 'classe-usuario.php';
$usuario = New Usuario("CRUDPDO","localhost","root","")


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="\desafio-php-estruturado\produtos\estilo-produto.css">
</head>
<body>
    <?php
    
// -------------------------------HEADER------------------------------------//
    
      $path = 'C:\xampp\htdocs\desafio-php-estruturado\header.php';
  
      //Retornará true se o arquivo existir
      if (file_exists($path)) {
          
          //Se o arquivo existir podemos incluí-lo.
          include($path);}
  

    
if(isset($_POST['nome'])) // se a pessoa clicou no botão cadastrar ou editar//
{

//----------------------------------EDITAR----------------------------------//
if(isset($_GET['id_atualizar']) && !empty($_GET['id_atualizar']))
{
    $id_att =  addslashes($_GET['id_atualizar']);
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = base64_encode(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING));
    $confirmarSenha = addslashes($_POST['confirmar-senha']);
       
    
    // validação email//
    if (filter_var ($_POST['email'],FILTER_VALIDATE_EMAIL) === false){
        echo "<b>Erro</b>: Verifique o formato do seu e-mail.  <br/>";
     }
    //validação senha//
    if ($senha !== $confirmarSenha){
        $mensagem = "<b>Erro</b>: As senhas não conferem!";
    }
    if ($senha >= 6) {
        $mensagem = "<b>Aviso</b>: O Campo senha precisa conter pelo menos 6 caracteres";
    } 
        
       
    if(!empty($nome)&& !empty($telefone) && !empty($email) && !empty($senha))
    {
    $usuario->atualizarDadosUsuario( $id_att, $nome, $telefone, $email, $senha);
    header("location: createUsuario.php");
    }
    else 
    {
        echo "Preencha todos os campos";
    }
}

//-------------------------------CADASTRAR--------------------------//
else 
{
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    $senha = base64_encode(filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING));
    $confirmarSenha = addslashes($_POST['confirmar-senha']);
      
    // validação email//
    if (filter_var ($_POST['email'],FILTER_VALIDATE_EMAIL) === false){
        echo "<b>Erro</b>: Verifique o formato do seu e-mail.  <br/>";
     }
    //validação senha//
    if ($senha !== $confirmarSenha){
        $mensagem = "<b>Erro</b>: As senhas não conferem!";
    }
    if ($senha >= 6) {
        $mensagem = "<b>Aviso</b>: O Campo senha precisa conter pelo menos 6 caracteres";
    } 
        
       
    if(!empty($nome)&& !empty($telefone) && !empty($email) && !empty($senha))
    
    if (!$usuario->cadastrarUsuario($nome, $telefone, $email, $senha))
    {
    
    echo "Este email já está cadastrado";
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
$resultado = $usuario->buscarDadosUsuario($id_atualizar);

}

 ?>

<h2>Cadastre-se aqui </h2> 
<hr>
<section id ="formulario">

   <form action=" " method="post" enctype = "multipart/form-data">
    <label for="nome">Nome</label> <br>
    <input type="text" name="nome" id="nome" value = "<?php if(isset($resultado)){echo $resultado['nome'];}?>" placeholder="Paula Francine" class="form-control" > 
    <br>
    
    <label for="telefone">Telefone</label><br>
    <input type="number" name="telefone" id="telefone" value = "<?php if(isset($resultado)){echo $resultado['telefone'];}?>"class="form-control">
    <br>

    <label for="email">Email</label>
    <br>
    <input type="email" name="email" id="email" value = "<?php if(isset($resultado)){echo $resultado['email'];}?>"class="form-control">
    <br>

    <label for="senha">Senha</label><br>
    <input type="password" name="senha" id="senha" class="form-control">
    <br>

    <label for="confirmar-senha">Confirme sua senha</label><br>
    <input type="password" name="confirmar-senha" class="form-control">
    <br>
    
    <button type="submit" class="btn btn-success btn-lg btn-block"><?php if(isset($resultado)){echo"Atualize seus dados ";}else{echo"Cadastre-se";}?></button>
    </form>
</section>

<section id = "usuarios">
<table>
<tr id="titulo">
<td>Nome</td>
<td>Telefone</td>
<td>Email</td>
</tr>

<?php
$dados = $usuario->buscarDados();
if(count($dados)>0){ //se tem dados no banco de dados//
    for ($i=0;$i < count($dados);$i++){
        echo "<tr>";
        foreach ($dados[$i] as $key => $value)
        {
            if ($key != "id" && $key != "senha")
            {
                echo "<td>". $value. "</td>";
        }
        }
        ?><td>
            <a href="createUsuario.php?id_atualizar= <?php echo $dados[$i]['id'];?>">Editar</a>
            
            <a href="createUsuario.php?id= <?php echo $dados[$i]['id'];?>">Excluir</a>
        
        </td>

    <?php
        echo "</tr>";
    }
}
else {
    echo "Ainda nao consegui cadastrar voce";
}




?>
</table>
</section>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>

<?php

if(isset($_GET['id'])){
    $id_usuario = addslashes($_GET['id']);
    $usuario->excluirUsuario($id_usuario);
    header("location: createUsuario.php");

}
?>