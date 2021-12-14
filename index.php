<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome_func = (isset($_POST["nome_func"]) && $_POST["nome_func"] != null) ? $_POST["nome_func"] : "";
    $data_nasc = (isset($_POST["data_nasc"]) && $_POST["data_nasc"] != null) ? $_POST["data_nasc"] : "";
    $telefone = (isset($_POST["telefone"]) && $_POST["telefone"] != null) ? $_POST["telefone"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
    $id_empresa = (isset($_POST["id_empresa"]) && $_POST["id_empresa"] != null) ? $_POST["id_empresa"] : "";
    $id_cargo = (isset($_POST["id_cargo"]) && $_POST["id_cargo"] != null) ? $_POST["id_cargo"] : "";
	$data_admissao = (isset($_POST["data_admissao"]) && $_POST["data_admissao"] != null) ? $_POST["data_admissao"] : "";
	$data_demissao = (isset($_POST["data_demissao"]) && $_POST["data_demissao"] != null) ? $_POST["data_demissao"] : "";
	$id_status = (isset($_POST["id_status"]) && $_POST["id_status"] != null) ? $_POST["id_status"] : "";
	$valor = (isset($_POST["valor"]) && $_POST["valor"] != null) ? $_POST["valor"] : "";
} else if (!isset($id)) {
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome_func = NULL;
    $data_nasc = NULL;
	$telefone = NULL;
    $email = NULL;
    $id_empresa = NULL;
    $id_cargo = NULL;
    $data_admissao = NULL;
	$data_demissao = NULL;
	$id_status = NULL;
	$valor = NULL;
}

try {
    $conexao = new PDO("mysql:host=localhost;dbname=rh", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão:".$erro->getMessage();
}
 
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome_func != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE funcionario SET nome_func=?, data_nasc=?, telefone=? email=? , id_empresa=? , id_cargo=?, data_admissao=?, data_demissao=?, id_status=?, valor=? WHERE id = ?");
            $stmt->bindParam(11, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO funcionario (nome_func, data_nasc, telefone, email, id_empresa, id_cargo, data_admissao, data_demissao, id_status, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        }
        $stmt->bindParam(1, $nome_func);
        $stmt->bindParam(2, $data_nasc);
        $stmt->bindParam(3, $telefone);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $id_empresa);
		$stmt->bindParam(6, $id_cargo);
		$stmt->bindParam(7, $data_admissao);
		$stmt->bindParam(8, $data_demissao);
		$stmt->bindParam(9, $id_status);
		$stmt->bindParam(10, $valor);
 
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $id = null;
                $nome_func = null;
                $data_nasc = null;
                $telefone = null;
                $email = null;
                $id_empresa = null;
				$id_cargo = null;
				$data_admissao = null;
				$data_demissao = null;
				$id_status = null;
				$valor = null;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM funcionaio WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Registo foi excluído com êxito";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
?>

<html>

<head>
	<meta charset="utf-8">
	<title>PROJETO RH</title>
	<link rel="stylesheet" type="text/css" href="../Estilos/css.css"></link>
</head>

<body bgcolor="white">

	<div class="div1">
		<div class="div2" align="center">CADASTRAR FUNCIONARIO</div>
		
		<form action="?act=save" method="POST" name="form1">
		<div class="botao1" align="center">Nome do Funcionário
			<input type="text" class="input1" name="nome_func"
				<?php
					if (isset($nome_func) && $nome_func != null || $nome_func != ""){
					echo "value=\"{$nome_func}\"";
					}
				?>>
		</div>
		
		<div class="botao2" align="center">Data de Nascimento
		<input type="date" class="input1" name="data_nasc"
				<?php
					if (isset($data_nasc) && $data_nasc != null || $data_nasc != ""){
					echo "value=\"{$data_nasc}\"";
					}
				?>>
		</div>
		
		<div class="botao3" align="center">Telefone
			<input type="text" class="input1" name="telefone"
				<?php
					if (isset($telefone) && $telefone != null || $telefone != ""){
					echo "value=\"{$telefone}\"";
					}
				?>>
		</div>
		
		<div class="botao4" align="center">Email
		<input type="text" class="input1" name="email"
				<?php
					if (isset($email) && $email != null || $email != ""){
					echo "value=\"{$email}\"";
					}
				?>>
		</div>
		

		<div class="botao5" align="center">Nome da Empresa
			<select class="input1" name="id_empresa">
				<option>Selecione</option>
				<option value="1" <?php
					if (isset($id_empresa) && $id_empresa != null || $id_empresa != ""){
					echo "value=\"{$id_empresa}\"";
					}
				?>>KELVIN CONSTRUCAO CIVIL LTDA</option>
				<option value="2" <?php
					if (isset($id_empresa) && $id_empresa != null || $id_empresa != ""){
					echo "value=\"{$id_empresa}\"";
					}
				?>>KELVIN LOGISTICA LTDA</option>
			</select>		
		</div>

		<div class="botao6" align="center">Cargo do Funcionário
			<select type="text" class="input1" name="id_cargo">
				<optgroup label="KELVIN CONSTRUÇÃO CIVIL LTDA">
					<option value="0" selected>SELECIONE</option>
					<option value="1" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>PEDREIRO</option>
					<option value="2" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>CARPINTEIRO</option>
					<option value="3" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>MARCENEIRO</option>
					<option value="4" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>ELETRECISTA</option>
					<option value="5" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>AJUDANTE</option>
					<option value="6" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>SERRALHEIRO</option>
					<option value="7" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>GERENTE</option>
					<option value="8" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>SUPERVISOR</option>
					<option value="9" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>ASSISTENTE</option>
					<option value="10" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>ENCARREGADO</option>
					<option value="11" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>DIRETOR</option>
					<option value="12" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>DONO</option>
				</optgroup>
				<optgroup label="KELVIN LOGISTICA LTDA">
					<option value="13" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>MOTORISTA</option>
					<option value="14" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>MOTOBOY</option>
					<option value="15" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>AJUDANTE</option>
					<option value="16" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>OPERADOR DE EMPILHADEIRA</option>
					<option value="17" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>OPERADOR DE MAQUINAS</option>
					<option value="18" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>GERENTE</option>
					<option value="19" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>SUPERVISOR</option>
					<option value="20" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>ASSISTENTE</option>
					<option value="21" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>DIRETOR</option>
					<option value="23" <?php
					if (isset($id_cargo) && $id_cargo != null || $id_cargo != ""){
					echo "value=\"{$id_cargo}\"";
					}?>>DONO</option>
				</optgroup>
			</select>
		</div>
		
		<div class="botao7" align="center">Data de Admissão
			<input type="date" class="input1" name="data_admissao"
				<?php
					if (isset($data_admissao) && $data_admissao != null || $data_admissao != ""){
					echo "value=\"{$data_admissao}\"";
					}
				?>>
		</div>
		
		<div class="botao8" align="center">Data de Demissão
			<input type="date" class="input1" name="data_demissao"
				<?php
					if (isset($data_demissao) && $data_demissao != null || $data_demissao != ""){
					echo "value=\"{$data_demissao}\"";
					}
				?>>
		</div>
		
		<div class="botao9" align="center">Status do Funcionário
			<select class="input1" name="id_status">
				<option value="0">Selecione</option>
				<option value="1" <?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>ATIVO</option>
				<option value="2" <?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>DEMITIDO</option>
				<option value="3" <?php
					if (isset($id_status) && $id_status != null || $id_status != ""){
					echo "value=\"{$id_status}\"";
					}
				?>>AFASTADO</option>
			</select>
		</div>
		
		<div class="botao10" align="center">Salário Mensal
			<input type="number" class="input1" name="valor"
				<?php
					if (isset($valor) && $valor != null || $valor != ""){
					echo "value=\"{$valor}\"";
					}
				?>>
		</div>
		
		<input type="submit" value="CADASTRAR" class="botao_cadastrar">
		<input type="reset" value="LIMPAR DADOS" class="botao_reset">

		</form>

	<div class="pesquisar">
		<input type="search" class="pesquisar1" placeholder="PESQUISAR">
	</div>
	<div class="titulo_tabela">
		<b>TABELA DE TODOS OS FUNCIONÁRIOS</b>
	</div>
	
	</div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rh";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão ao MySQL mal Sucedida: " . $conn->connect_error);
}

$select = "SELECT funcionario.NOME_FUNC, funcionario.DATA_NASC, funcionario.TELEFONE, funcionario.EMAIL, empresa.NOME_EMPRESA, empresa.CNPJ,
cargos.NOME_CARGO, DATE_FORMAT(funcionario.DATA_ADMISSAO, '%d/%m/%Y'), DATE_FORMAT(funcionario.DATA_DEMISSAO, '%d/%m/%Y'), status.NOME_STATUS, funcionario.VALOR FROM funcionario
INNER JOIN empresa ON funcionario.ID_EMPRESA = empresa.ID
INNER JOIN cargos ON funcionario.ID_CARGO = cargos.ID
INNER JOIN status ON funcionario.ID_STATUS = status.ID;";
$result = $conn->query($select);
	
	echo "<table class='tabela1'>";
	echo "<thead>";
	echo "<th class='tabela2'>Ações</th>";
	echo "<th class='tabela2'>Nome Funcionário</th>";
	echo "<th class='tabela2'>Data Nascimento</th>";
	echo "<th class='tabela2'>Telefone</th>";
	echo "<th class='tabela2'>Email</th>";
	echo "<th class='tabela2'>Empresa</th>";
	echo "<th class='tabela2'>CNPJ</th>";
	echo "<th class='tabela2'>Cargo</th>";
	echo "<th class='tabela2'>Admissão</th>";
	echo "<th class='tabela2'>Demissão</th>";
	echo "<th class='tabela2'>Status</th>";
	echo "<th class='tabela2'>Salário Mensal</th>";
	echo "</thead>";
		
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo "<tr class='tabela4'>";
		echo "<td class='tabela2'>"."</td>";
		echo "<td class='tabela3'>".$row["NOME_FUNC"]."</td>";
		echo "<td class='tabela3'>".$row["DATA_NASC"]."</td>";
		echo "<td class='tabela3'>".$row["TELEFONE"]."</td>";
		echo "<td class='tabela3'>".$row["EMAIL"]."</td>";
		echo "<td class='tabela3'>".$row["NOME_EMPRESA"]."</td>";
		echo "<td class='tabela3'>".$row["CNPJ"]."</td>";
		echo "<td class='tabela3'>".$row["NOME_CARGO"]."</td>";
		echo "<td class='tabela3'>".$row["DATE_FORMAT(funcionario.DATA_ADMISSAO, '%d/%m/%Y')"]."</td>";
		echo "<td class='tabela3'>".$row["DATE_FORMAT(funcionario.DATA_DEMISSAO, '%d/%m/%Y')"]."</td>";
		echo "<td class='tabela3'>".$row["NOME_STATUS"]."</td>";
		echo "<td class='tabela3'>"."R$ ".$row["VALOR"]."</td>";
		echo "</tr>"; 
    }
}

$conn->close();

		echo "</table>";
?>

	<div class="div3">
		<div class="div4" align="center">ALTERAR DADOS FUNCIONARIO</div>
		
		<form action="?act=save" method="POST" name="form1">
		<div class="estilo1">Nome do Funcionário
				<input type="text" class="input2" name="busca">
				<input type="submit" class="input3" value="PESQUISAR">
		</div>
		
		                <?php
                try {
                    $stmt = $conexao->prepare("SELECT funcionario.NOME_FUNC, DATE_FORMAT(funcionario.DATA_NASC, '%d/%m/%Y') as 'DATA_NASC2', funcionario.TELEFONE, funcionario.EMAIL, empresa.NOME_EMPRESA, empresa.CNPJ,cargos.NOME_CARGO,DATE_FORMAT(funcionario.DATA_ADMISSAO,'%d/%m/%Y') as 'DATA_ADMISSAO2', DATE_FORMAT(funcionario.DATA_DEMISSAO, '%d/%m/%Y') as 'DATA_DEMISSAO2', status.NOME_STATUS, funcionario.VALOR FROM funcionario INNER JOIN empresa ON funcionario.ID_EMPRESA = empresa.ID INNER JOIN cargos ON funcionario.ID_CARGO = cargos.ID INNER JOIN status ON funcionario.ID_STATUS = status.ID WHERE NOME_FUNC LIKE '%'");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo 
								"<table class='tabela11'>".
									"<tr>".
										"<td>"."NOME"."</td>".
										"<td>"."DATA<BR>NASCIMENTO"."</td>".
										"<td>"."TELEFONE"."</td>".
										"<td>"."EMAIL"."</td>".
										"<td>"."EMPRESA"."</td>".
										"<td>"."CNPJ"."</td>".
										"<td>"."CARGO"."</td>".
										"<td>"."DATA<BR>ADMISSAO"."</td>".
										"<td>"."DATA<BR>DEMISSAO"."</td>".
										"<td>"."STATUS"."</td>".
										"<td>"."SALARIO<BR>MENSAL"."</td>".
									"</tr>".
									"<tr class='teste1'>".
										"<td>"."<textarea type='text' class='teste'>".$rs->NOME_FUNC."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste2'>".$rs->DATA_NASC2."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste'>".$rs->TELEFONE."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste'>".$rs->EMAIL."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste'>".$rs->NOME_EMPRESA."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste'>".$rs->CNPJ."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste'>".$rs->NOME_CARGO."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste2'>".$rs->DATA_ADMISSAO2."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste2'>".$rs->DATA_DEMISSAO2."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste3'>".$rs->NOME_STATUS."</textarea>"."</td>".
										"<td>"."<textarea type='text' class='teste4'>".$rs->VALOR."</textarea>"."</td>".
										"<td>"."<input type='submit' value='' class='btnalt' title='Clique aqui para salvar os dados alterados'>"."</td>".
									"</tr>".
								"</table";
                        }
                    } else {
                        echo "Erro:";
                    }
                } catch (PDOException $erro) {
                    echo "Erro: ".$erro->getMessage();
                }
                ?>
		</form>

	</div>

	<div class="copy" align="center">Developed by Kelvin Henrique | Copyright © 2020 - Todos os direitos reservados</div>

</body>

</html>