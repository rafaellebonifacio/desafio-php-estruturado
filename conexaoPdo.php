<?php 

// ----conexão-----//
try{
    $pdo = new PDO("mysql:dbname=CRUDPDO;host=localhost", "root", "");
    
}catch(PDOException $e){
echo "NÃO FOI POSSIVEL REALIZAR A CONEXÃO DO BANCO DE DADOS!" .$e->getMessage();
}
catch(Exception $e){
echo "NÃO FOI POSSIVEL REALIZAR A CONEXÃO DO BANCO DE DADOS!" .$e->getMessage();  
}


//  --- INSERT---

// inserir e substituir

// $comando = $pdo->prepare("INSERT INTO produto(Nome, descricao, preco, quantidade) VALUES (:n, :d, :p, :q)");

// // // aceita variaveis e informações individuais// ele precisa inserir todos os parametros
// $comando->bindValue(":n", "tapete");
// $comando->bindValue(":d", "Um tapete vermelho");
// $comando->bindValue(":p", "55,00");
// $comando->bindValue(":q", "2");
// $comando->execute();

// // // so aceita variavel//
// // // $nome = "Tapete"
// // // $comando -> bindparam (":n", "$nome");

// // // 2º forma quando é um dado que nao precisa de substituição
// // // _________________________________
// $comando = $pdo->query ("INSERT INTO produto(Nome, descricao, preco, quantidade) VALUES ('tapete', 'Um tapede vermelho', '55.00', '2')");


//  --- DELETE---

// $comando = $pdo->prepare("DELETE FROM produto WHERE id = :id");
// $id = 2;
// $comando->bindValue(":id", $id);
// $comando->execute();

// com o query é uma linha de codigo

// $comando = $pdo->query ("DELETE FROM produto WHERE id = '3'");

//-------UPDATE--------
// $comando = $pdo->prepare("UPDATE produto SET descricao = :d WHERE id = :id");
// $comando->bindValue(":d","Um tapete azul");
// $comando->bindValue(":id",4);
// $comando->execute();

// $comando = $pdo->query ("UPDATE produto SET descricao = 'Um tapete verde' WHERE id = '5'");



// ------- SELECT-------
// $comando = $pdo->prepare("SELECT * FROM produto WHERE id = :id");
// $comando->bindValue(":id",5);
// $comando->execute();
// // para transformar o que vem no banco de dados em array//
// $resultadoBancoDados = $comando->fetch(PDO::FETCH_ASSOC);
// // echo "<pre>";
// // print_r($resultadoBancoDados);
// // echo "</pre>";
// //ou quando vem mais de um registro do banco de dados//
// // $comando-> fetchAll(PDO::FETCH_ASSOC);

// foreach ($resultadoBancoDados as $key => $value){
//     echo $key. ":".$value. "<br>";
// }




$comando = $pdo->query ("INSERT INTO usuario(nome, telefone, email, senha) VALUES ('Rafaelle', '8978798978', 'rafaelle@rafaelle.com.br', '123456')");
?>