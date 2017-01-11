<!Doctype HTML>
<html>
	<head>
		<title>Dashboard | Dera Money Management System</title>
	</head>
	<style type="text/css">
	</style>
	<body>

				<h1>Welcome <?php echo $user['usr_fullname']; ?></h1>
				<h2>Account Balance: Rs. <?php echo $user['usr_curr_balance']; ?></h2>
		<hr>
		<table border="2"><form action="processAck" method="post">
			<tr>
				<th>Enter Amount</th>
				<th><input type="number" name="moneytodivide"></th>
			</tr>
			<?php foreach ($users as $data_item) { ?>
			<tr>
				<td><input type="checkbox" name="<?php echo $data_item['usr_name']; ?>" id="<?php echo $data_item['usr_name']; ?>"></td>
				<td><label for="<?php echo $data_item['usr_name']; ?>"><?php echo $data_item['usr_fullname']; ?></label></td>
			</tr>
			<?php } ?>
			<tr>
				<td>Description</td>
				<td><input type="text" name="desc"></td>
			</tr>
		</table>
		<input type="submit" name="divide" value="Send Acknowledgements">
		<hr>
	</form>
	<h1>Recieveable Tranasactions</h1>
	<ol>
		<?php if($hosttrans){ foreach ($hosttrans as $data_item) { ?>
		<li><?php foreach ($users as $dat_item) {if ($data_item['client_usr_id']==$dat_item['usr_id']) {echo $dat_item['usr_fullname'];}} ?> will give you Rs. <?php echo $data_item['amount']; ?> of <?php echo $data_item['description']; ?></li>
		<?php }}else{echo "No Data Available";} ?>
	</ol>
		<hr>
		<h1>Payable Tranasactions</h1>
	<ol>
		<?php if($clienttrans){ foreach ($clienttrans as $data_item) { ?>
		<li>You have to give <?php foreach ($users as $dat_item) {if ($data_item['host_usr_id']==$dat_item['usr_id']) {echo $dat_item['usr_fullname'];}} ?> Rs. <?php echo $data_item['amount']; ?> of <?php echo $data_item['description']; ?>. | <a href="transfer/<?php echo $data_item['mt_id']; ?>">Pay Now</a></li>
		<?php }}else{echo "No Data Available";} ?>
	</ol>
		<hr>
		<center>
			<a href="logout">Logout</a>
		</center>
	</body>
</html>