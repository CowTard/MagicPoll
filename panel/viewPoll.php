<?php
	session_start();
	require 'dashboard_header.php';
  	$db = new PDO('sqlite:../db/polls.db');
	$dbPrepared = $db->prepare('SELECT * FROM Poll WHERE EncodedID = ?');
	$dbPrepared->execute(array($_GET['id']));
	$poll = $dbPrepared->fetch();
	$indice = $poll['ID'];

	$dbPrepared = $db->prepare('SELECT * FROM Options WHERE IDPoll = ?');
	$dbPrepared->execute(array($indice));
	$options = $dbPrepared->fetchAll();
	$numberOfOption = 0;
?>

	<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h3 class="panel-title text-center"><?= $poll['Title']; ?></h3>
			</div>
		  
		  	<div class="panel-body">
		  		<form method="POST" action="submitAnswer.php">
		  		<input type="hidden" name="id" value= <?= '"' . $indice . '"'?> >
			  	<?php foreach($options as $row) { 
			  			$id = '"' . 'radioOption' . $numberOfOption . '"' ; $value = '"' . 'option' . $numberOfOption . '"'; $numberOfOption += 1; ?>
				    	<div class="radio">
							<label>
						    	<input type="radio" name="radioOption" id=<?= $id ?> value= <?= $value ?> >
						    	<?= $row['OptionText'] ?>
						  	</label>
						</div>
				<?php } ?>

				<div class="center-block pull-right">
					<button id="vote" type="submit" class="btn btn-primary btn-sm btn-success">Vote</button>
					<button id="resetButton" type="button" class="btn btn-primary btn-sm btn-danger">Reset</button>
				</div>
		  	</div>
		</div>
	</div>

<?php
	require 'dashboard_footer.php';
?>