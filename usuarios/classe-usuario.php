<?php
Class Usuario {
private $pdo;
//6funccoes

//conexao com banco de dados//
public function __construct ($dbname,$host,$user,$senha)
{
try{
    $this->pdo = new PDO ("mysql:dbname=".$dbname.";host=".$host, $user,$senha);
 }
catch(PDOException $e){
echo "NÃO FOI POSSIVEL REALIZAR A CONEXÃO DO BANCO DE DADOS!" .$e->getMessage();
exit();
}
catch(Exception $e){
echo "ERRO" .$e->getMessage(); 
exit(); 
}
}
// função para buscar os dados e colocar no canto direito da tela//

public function buscarDados()
{
    $resultadoBancoDados= array();
    $comando = $this->pdo->query("SELECT * FROM usuario ORDER BY nome");
    $resultadoBancoDados = $comando->fetchAll(PDO::FETCH_ASSOC);
    return $resultadoBancoDados;
}


public function cadastrarUsuario($nome, $telefone, $email, $senha)
{
    $comando = $this->pdo->prepare("SELECT id FROM usuario WHERE email = :e");
    $comando->bindValue(":e",$email);
    $comando->execute();

    if ($comando->rowCount()>0) // verifica antes de cadastrar//
    {
        return false;
    }else{
        $comando = $this->pdo->prepare("INSERT INTO usuario (nome,telefone,email,senha) VALUES (:n,:t,:e,:s)");
        $comando->bindValue(":n",$nome);
        $comando->bindValue(":t",$telefone);
        $comando->bindValue(":e",$email);
        $comando->bindValue(":s",$senha);
        $comando->execute();
        return true;
    }
}


public function excluirUsuario($id)
{
    $comando = $this->pdo->prepare("DELETE  FROM usuario WHERE id = :id");
    $comando->bindValue(":id",$id);
    $comando->execute();
}


//buscar dados de uma pessoa

public function buscarDadosUsuario($id)
{
    $resultadoBancoDados= array();
    $comando = $this->pdo->prepare("SELECT * FROM usuario WHERE id = :id");
    $comando->bindValue(":id",$id);
    $comando->execute();
    $resultadoBancoDados = $comando->fetch(PDO::FETCH_ASSOC); // economiza espaço e mostra apenas o necessario dentro da array//
    return $resultadoBancoDados;
}



///atualizar dados no banco///

public function atualizarDadosUsuario( $id, $nome, $telefone, $email, $senha){

// antes de atualizar, verificar se email ja está cadastrado
    // $comando = $this->pdo->prepare("SELECT id FROM usuario WHERE email = :e");
    // $comando->bindValue(":e",$email);
    // $comando->execute();

    // if ($comando->rowCount()>0) // verifica antes de cadastrar//
    // {
    //     return false;
    // }else{
    $comando = $this->pdo->prepare("UPDATE usuario SET nome = :n, telefone = :t, email = :e, senha = :s WHERE id = :id");
    $comando->bindValue(":n",$nome);
    $comando->bindValue(":t",$telefone);
    $comando->bindValue(":e",$email);
    $comando->bindValue(":s",$senha);
    $comando->bindValue(":id",$id);
    $comando->execute();
//     return true;
// }
}

// manter esse fechamento, senao dá erro//
}
?>
