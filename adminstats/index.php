<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
	<title>BLOG ADMIN STATISTICS</title>
	<link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
		<div class="row">
			<!--unique visitors count-->
			<div class="alert alert-success">
				<strong><?php 
				require_once('conn.php');
				$sql = "SELECT COUNT(DISTINCT ip_address) AS alias FROM visitor_info";
				$query = $db->prepare($sql);
				$query->execute();
				$unique_visitors = $query->fetch()['alias'];
				echo "TOTAL NUMBER OF UNIQUE VISITORS:".$unique_visitors;

				?></strong>
			</div>
			<!--get most viewed page-->
			<div class="alert alert-info">
				<strong><?php 
				require_once('conn.php');
				$sql = "SELECT MAX(count) AS maximum FROM page_hits";
				$query = $db->prepare($sql);
				$query->execute();
				$maxcount = $query->fetch()['maximum'];
				echo "HIGHEST PAGE VIEWS :".$maxcount;

				?></strong>
			</div><br>
			<div class="panel panel-primary">
				<div class="panel-heading text-center">LATEST PAGE VIEWS&nbsp;&nbsp;(TOTAL PAGES VIEWED:<?php require_once("count_pages.php"); ?>)</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">
								<th>Page Name</th>
								<th>Total Views</th>
							</tr>
							<?php 
							include("connect.php");
							try {
//connect to mysql
								$con=new PDO($dsn,$username,$password);
								$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
								
							} catch (Exception $ex) {
								echo 'Not Connected '.$ex->getMessage();
							}

//mysql select query
							$stmt=$con->prepare('SELECT * FROM page_hits LIMIT 30');
							$stmt->execute();
							$resources=$stmt->fetchAll();
							$row_count=$stmt->rowCount();
							if ($row_count==0) {
		# code...
								$jibu="No content Yet";
							}
							foreach ($resources as $resource) {
								echo '
								<tr>
								<td>'.$resource['page'].'</td>
								<td>'.$resource['count'].'</td>
								</tr>';


							}
							?>
						</table>
					</div> 
				</div>
			</div>
		</div><!--row-->
	
	</div>
	<footer class="footer footer-inverse">
      <div class="container">
        <div class="text-center">
          <small><p> <span>&copy;&nbsp;</span>Infiniti Software Solutions <?php $current=date("Y"); print_r($current);?> </p></small>
        </div>
      </div>
    </footer>
</body>
</html>