<?php
Class Produto {
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
    $comando = $this->pdo->query("SELECT * FROM produto ORDER BY id");
    $resultadoBancoDados = $comando->fetchAll(PDO::FETCH_ASSOC);
    return $resultadoBancoDados;
}

public function cadastroProduto($nome, $descricao, $preco, $quantidade,$nome_imagem,$tamanho_imagem,$tipo_imagem, $imagem)
{
    $comando = $this->pdo->prepare("SELECT id FROM produto WHERE nome = :n");
    $comando->bindValue(":n",$nome);
    $comando->execute();

    if ($comando->rowCount()>0) // verifica antes de cadastrar//
    {
        return false;
    }else{
        $comando = $this->pdo->prepare("INSERT INTO produto (nome,descricao,preco,quantidade,nome_imagem, tamanho_imagem,tipo_imagem,imagem) VALUES (:n,:d,:p,:q,:ni,:ti,:tpi,:i)");
        $comando->bindValue(":n",$nome);
        $comando->bindValue(":d",$descricao);
        $comando->bindValue(":p",$preco);
        $comando->bindValue(":q",$quantidade);
        $comando->bindValue(":ni",$nome_imagem);
        $comando->bindValue(":ti",$tamanho_imagem);
        $comando->bindValue(":tpi",$tipo_imagem);
        $comando->bindValue(":i",$imagem);
        $comando->execute();
        return true;
    }
}
public function excluirProduto($id)
{
    $comando = $this->pdo->prepare("DELETE  FROM produto WHERE id = :id");
    $comando->bindValue(":id",$id);
    $comando->execute();
}

//buscar dados de um produto

public function buscarDadosProduto($id)
{
    $resultadoBancoDados= array();
    $comando = $this->pdo->prepare("SELECT * FROM produto WHERE id = :id");
    $comando->bindValue(":id",$id);
    $comando->execute();
    $resultadoBancoDados = $comando->fetch(PDO::FETCH_ASSOC); // fetch_assoc economiza espaço e mostra apenas o necessario dentro da array//
    return $resultadoBancoDados;
}

public function atualizarDadosProduto( $id,$nome, $descricao, $preco, $quantidade,$nome_imagem,$tamanho_imagem,$tipo_imagem, $imagem){

    $comando = $this->pdo->prepare("UPDATE produto SET nome = :n, descricao = :d, preco = :p, quantidade = :q, nome_imagem = :ni, tamanho_imagem = :ti, tipo_imagem = :tpi, imagem = :i WHERE id = :id");
        $comando->bindValue(":n",$nome);
        $comando->bindValue(":d",$descricao);
        $comando->bindValue(":p",$preco);
        $comando->bindValue(":q",$quantidade);
        $comando->bindValue(":ni",$nome_imagem);
        $comando->bindValue(":ti",$tamanho_imagem);
        $comando->bindValue(":tpi",$tipo_imagem);
        $comando->bindValue(":i",$imagem);
        $comando->bindValue(":id",$id);
        $comando->execute();
}

public function exibirImagem($imagem){

    $comando = $this->pdo->prepare("SELECT  imagem = :i FROM produto ");
    $comando->bindValue(":i",$imagem);
    $comando->execute();

}

// NUNCA REMOVER ESSE SENÃO DÁ ERRO
}
?>