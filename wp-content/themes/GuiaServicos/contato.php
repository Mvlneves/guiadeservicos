<?php 
	
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Content-Type");
	require_once('base-config.php');

	if ($_POST) {

		parse_str($_POST['dados'], $dados);

		foreach($dados as $key => $value){
			$_POST[$key]=utf8_decode($value);
		}

		extract($_POST);

	    date_default_timezone_set('America/Sao_Paulo');
	    $data = date('Y-m-d H:i:s', time());

		$sql="INSERT INTO gsa_contato VALUES
				(NULL,
				'$nome',
				'$email',
				'$assunto',
				'$telefone',
				'$mensagem',
				'$data')";	
		mysqli_query($conexao,$sql);
	}
?>