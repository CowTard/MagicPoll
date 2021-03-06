<?php
	//require 'dashboard_header.php';
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$db = new PDO('sqlite:../db/polls.db');

		// COMO NAO E POSSIVEL REVERTER O HASH, OBTEM-SE O ID REAL ATRAVES DE UMA BUSCA A BASE DE DADOS.
		$dbPrepared = $db->prepare('SELECT * FROM Poll WHERE EncodedID = ?');
		$dbPrepared->execute(array($_GET['id']));
		$item = $dbPrepared->fetch();

		$realID = $item['ID'];
		
		// ELIMINAR IMAGEM ASSOCIADA
		$imagename = $item['ImageName'];
		if ($imagename != '-1') unlink('../uploadedImages/' . $imagename);

		// APAGAR REGISTO NA TABELA POLL
		$dbPrepared = $db->prepare('DELETE FROM Poll WHERE EncodedID = ?');
		$dbPrepared->execute(array($_GET['id']));
		$item = $dbPrepared->fetch();

		// APAGAR REGISTO NA TABELA OPTIONS
		$dbPrepared = $db->prepare('DELETE FROM Options WHERE IDPoll = ?');
		$dbPrepared->execute(array($realID));
		$item = $dbPrepared->fetch();

		// APAGAR REGISTO NA TABELA VOTES
		$dbPrepared = $db->prepare('DELETE FROM Votes WHERE IDPoll = ?');
		$dbPrepared->execute(array($realID));
		$item = $dbPrepared->fetch();

		// APAGAR REGISTO NA TABELA NOTIFICATIONS

		$dbPrepared = $db->prepare('DELETE FROM Notifications WHERE IDPoll = ?');
		$dbPrepared->execute(array($realID));
		$item = $dbPrepared->fetch();

	}
?>
