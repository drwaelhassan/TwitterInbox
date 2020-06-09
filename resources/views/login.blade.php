<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="{{asset('/css/login.css')}}">
</head>
<body>
	<div class="login-container">
		<div class="login-central">
			<div class="login-left">
				<div class="login-left-central">
					<img src="{{asset('/img/ki-logo.png')}}" alt="asd" height="150">
					<span>KI Social</span>
				</div>
			</div>
			<div class="login-right">
				<div class="login-right-central">
					<div class="login-twitter-button" id="twLogin">
						<div>
							<img src="{{asset('/img/twitter-logo-white.png')}}" alt="">
						</div>
						<div>
							<span>Sign in with twitter</span>
						</div>
					</div>
					<div class="description">
						By signin in, you agree to our <br>
						<span>Terms</span> and <span>Conditions</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" value="{{ url('/') }}" id="baseUrl">
</body>
<script src="{{asset('/js/login.js')}}"></script>
</html>