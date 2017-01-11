<!Doctype HTML>
<html>
	<head>
		<title>Login | Dera Money Management System</title>
	</head>
	<style type="text/css">
	</style>
	<body onload="showLoginForm()">
		<form id="loginForm" action="doLogin" method="POST">
			<label>
				Username: <input type="text" id="uName" name="uName">
			</label>
			<br>
			<label>
				Password: <input type="password" id="pWord" name="pWord">
			</label><span id="pWordAlert"></span>
			<br>
		</form>
		<button onclick="validatePassword()" id="loginFormSubmit">Login</button>
		<form id="changePassword" action="changepass" method="POST" onsubmit="alert('submitted')">
			<label>
				Username: <input type="text" id="usName" name="usName">
			</label>b
			<br>
			<label>
				Old Password: <input type="password" id="opWord" name="opWord">
			</label>
			<br>
			<label>
				New Password: <input type="password" id="npWord" name="npWord">
			</label>
			<br>
			<label>
				Retype Password: <input type="password" id="rpWord" name="rpWord" onblur="passWordMatch()">
			</label><span id="matchAlert"></span>
			<br>
			<input type="submit" value="Login">
		</form>
		<a href="#" onclick="showLoginForm()">Login Form</a> | <a href="#" onclick="showChangePassword()">Change Password</a>
		<script type="text/javascript">
		function showChangePassword() {
			document.getElementById('loginForm').style.display='none';
			document.getElementById('loginFormSubmit').style.display='none';
			document.getElementById('changePassword').style.display='block';
		}
		function showLoginForm(){
			document.getElementById('changePassword').style.display='none';
			document.getElementById('loginForm').style.display='block';
		}
		function passWordMatch() {
			if (document.getElementById('npWord').value!=document.getElementById('rpWord').value) {
				document.getElementById('matchAlert').innerHTML="<span style='color:red'>Password donot match</span>";
				return false;
			} 
			else if(document.getElementById('npWord').value==''){
				document.getElementById('matchAlert').innerHTML="<span style='color:red'>Enter New Password</span>";
				return false;
			}
			else if(document.getElementById('opWord').value==document.getElementById('npWord').value&&document.getElementById('npWord').value==document.getElementById('rpWord').value){
				document.getElementById('matchAlert').innerHTML="<span style='color:red'>New Password should be different from old one.</span>";
				return false;
			}
			else {
				document.getElementById('matchAlert').innerHTML="<span style='color:green'>Good to Go</span>";
				return true;
			}
		}
		function validatePassword() {
			if(document.getElementById('pWord').value==''||document.getElementById('uName').value==''){
				document.getElementById('pWordAlert').innerHTML="<span style='color:red'>Fill all fields</span>";
			}else{
				document.getElementById('loginForm').submit();
			}
		}
		</script>
	</body>
</html>