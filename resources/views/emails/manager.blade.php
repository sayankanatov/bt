<!DOCTYPE html>
<html>
<head>
	<title>Send Email</title>
</head>
<body>
	<h2>Hello, {!! $user->name!!}</h2>
	<p>You are new Manager in BalaTime Systems</p>
	<p>Your credentials:</p>
	<p>email: {!!$user->email!!}</p>
	<p>login: {!!$user->name!!}</p>
	<p>password: {!!$user->password!!}</p>
</body>
</html>