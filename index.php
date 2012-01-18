<!DOCTYPE html>
<html>
	<head>
		<title>BugKick API usage example</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
			label{
				font-weight: bold;
				font-size: 12px;
				display:block;
				margin-top:7px;
				color:#444;
			}
		</style>
	</head>
	<body>
		<div>
		<?php
		require_once './lib/BugKick.php';
		$types=array(
			TicketType::BUG,
			TicketType::FEATURE_REQUEST,
			TicketType::SUGGESTION
		);
		if(!empty($_POST['ticketText'])
			&& !empty($_POST['ticketType'])
			&& in_array($_POST['ticketType'], $types)) {
			$config=require('config.php');
			$bk=BugKick::api();
			$bk->setApiKey($config['apiKey']);
			$bk->selectProject($config['projectID']);
			$responseStr=$bk->createTicket($_POST['ticketText'], $_POST['ticketType']);
			$responseObj=json_decode($responseStr);
			if(empty($responseObj->success)) {
				echo 'Error: "', $responseObj->error, '".';
			}
			else {
				echo 'Ticket created.';
			}
		}
		?>
			<br />
			<form id="createTicketForm" name="createTicketForm" action="" method="post">
				<label for="ticketType">Type of ticket:</label>
				<select id="ticketType" name="ticketType">
					<?php foreach($types as $type) { ?>
					<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
					<?php } ?>
				</select>
				<br />
				<label for="ticketText">Text of ticket:</label>
				<textarea id="ticketText" name="ticketText" cols="60" rows="10"></textarea>
				<br />
				<input type="submit" name="submit" value="Create ticket" />
			</form>
		</div>
	</body>
</html>