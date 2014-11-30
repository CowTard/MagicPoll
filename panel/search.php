<?php
	session_start();
	require 'generalFunctions.php';
	require 'dashboard_header.php';
  	$db = new PDO('sqlite:../db/polls.db');
	$dbPrepared = $db->prepare('SELECT COUNT(*) FROM Poll WHERE IDuser != ?');
	$dbPrepared->execute(array($_SESSION['ID']));
	$pollNum = $dbPrepared->fetchAll();

	$limit_per_page = 10;
	$number_of_pages = ceil( $pollNum[0][0] / $limit_per_page);

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
		$indice = $page*$limit_per_page;
	}
	else {
		$page = 0;
		$indice = 1;
	}

	$offset = $page*$limit_per_page + $limit_per_page;

	$dbPrepared = $db->prepare('SELECT * FROM Poll WHERE IDuser != ? LIMIT ?,?');
	$dbPrepared->execute(array($_SESSION['ID'],$page*$limit_per_page,$offset));
	$item = $dbPrepared->fetchAll();

?>

<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
		<table class="table table-hover">
		  <thead>
		  	<tr>
		  	<th>Indice</th>
		  	<th>Creator</th>
		  	<th>Title</th>
		  	<th>Voting</th>
		  	</tr>
		  </thead>
		  <tbody>

	  		<?php foreach($item as $row) { ?>
	  			<tr>
	  			<td><?= $indice ?></td>
	  			<td><?= getName($row['IDuser']) ?></td>
	  			<td><?= $row['Title'] ?></td>
	  			<td><form action="viewPoll.php" method="GET">
	  					<input type="hidden" name="id" value=<?= '"'.sha1($row['ID']) . '"'?>  >
	  					<button type="submit" class="btn btn-default btn-sm" aria-label="Left Align">
  							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						</button>
					</form>
				</td>
	  			</tr>
	  		<?php $indice++;} ?>
		  </tbody>
		</table>
		<nav>
	  		<ul class="pagination">
			    <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
			    <? for ($i=0; $i < $number_of_pages; $i++) { ?>
				    	<li><a class="pages" id=<?= '"'.$i .'"' ?> href="#"> <?= $i ?></a></li>
				    </form>
				<? } ?>
	  		</ul>
		</nav>
	</div>

<?php require 'dashboard_footer.php'; ?>
