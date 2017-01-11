<!Doctype HTML>
<html>
	<head>
		<title>Dashboard | Dera Money Management System</title>
	</head>
	<style type="text/css">
	</style>
	<body>
		<table border="5" cellpadding="10">
			<tr>
				<th>User</th>
				<th>Balance</th>
			</tr>
			<?php $total=0; foreach ($users as $data_item) { ?>
			<tr>
				<td><?php echo $data_item['usr_fullname']; ?></td>
				<td><?php echo $data_item['usr_curr_balance']; ?></td>
			</tr>
			<?php $total=$total+$data_item['usr_curr_balance']; } ?>
			<tr>
				<th>Total</th>
				<th><?php echo $total; ?></th>
			</tr>
		</table>
		<br><hr><hr><br>
		<form action="process" method="post">
			<table border="1" cellpadding="10">
				<tr>
					<th>Username</th>
					<th>Amount</th>
				</tr>
				<tr>
					<td>
						<select name="user_id">
							<?php foreach ($users as $data_item) { ?>
							<option value="<?php echo $data_item['usr_id']; ?>"><?php echo $data_item['usr_fullname']; ?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type="number" name="amount"></td>
				</tr>
			</table>
			<input type="submit" value="Submit" name="submit"><input type="submit" name="withdraw" value="Withdraw">
		</form>
		<hr>
		<center>
			<a href="logout">Logout</a>
		</center>
	</body>
</html>