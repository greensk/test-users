<html>
	<head>
		<script
			src="https://code.jquery.com/jquery-3.3.1.js"
			integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
			crossorigin="anonymous"
		></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</head>
	
	<body>
		<?php
			require 'vendor/autoload.php';
				
			$dbParams = require('db.php');
			$db = new PDO(
				$dbParams['connection'],
				$dbParams['username'],
				$dbParams['password']
			);
				
			if (count($_POST) > 0)  {
				Valitron\Validator::addRule(
					'unique',
					function ($field, $value, $params) use ($db) {
						$sql = "
							SELECT Count(*) count
							FROM user
							WHERE email = :email
						";
						if (isset($params[0])) {
							$sql .= ' AND id <> :id';
						}
						$query = $db->prepare($sql);
						$sqlParams = ['email' => $value];
						if (isset($params[0])) {
							$sqlParams['id'] = $params[0];
						}
						$query->execute($sqlParams);
						$record = $query->fetch();
						return $record['count'] == 0;
					},
					'Пользователь с таким e-mail уже зарегистрирован!'
				);

				$validator = new Valitron\Validator($_POST);
				if (isset($_GET['id'])) {
					$validator->rule(
						'unique',
						'email',
						$_GET['id']
					);
				} else {
					$validator->rule(
						'unique',
						'email'
					);
				}
				$validator->rule(
					'required',
					['name', 'email']
				)->message(
					'Поле обязательно для заполнения'
				);
				
				$validator->rule(
					'email',
					'email'
				)->message(
					'Неверный формат e-mail!'
				);

				if($validator->validate()) {
					if (isset($_GET['id'])) {
						$sql = "
							UPDATE `user`
							SET
								`name` = :name,
								`email` = :email
							WHERE id = :id
						";
					} else {						
						$sql = "
							INSERT INTO `user`
							(`name`, `email`)
							VALUES
							(:name, :email)
						";
					}
					$query = $db->prepare($sql);
					$params = [
						'name' => $_POST['name'],
						'email' => $_POST['email']
					];
					if (isset($_GET['id'])) {
						$params['id'] = $_GET['id'];
					}
					$result = $query->execute($params);
					if ($result) {
						echo '<div class="alert alert-success" role="alert">Готово!</div>';
					} else {
						var_dump($query->errorInfo());
					}
				} else {
					$errors = $validator->errors();
					$user = $_POST;
					require 'form.php';
				}

			} else {
				if (isset($_GET['id'])) {
					// загрузка данных из БД
					$sql = 'SELECT * FROM user
							WHERE id = :id';
					$query = $db->prepare($sql);
					$query->execute(['id' => $_GET['id']]);
					$user = $query->fetch();
					if ($user) {
						require 'form.php';
					} else {
						require 'notfound.php';
					}
				} else {
					require 'form.php';
				}
			}
		?>
	</body>
</html>