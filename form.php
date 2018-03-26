<form class="form-horizontal" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Регистрация пользователя</legend>

<!-- Text input-->
<div class="form-group<?php if (isset($errors['username'])) {
	echo ' has-error';
  } ?>">
  <label class="col-md-4 control-label" for="username">Имя пользователя</label>  
  <div class="col-md-4">
  <input
	id="username"
	name="username"
	type="text"
	placeholder=""
	class="form-control input-md"
	value="<?php if (isset($_POST['username'])) {
		echo htmlspecialchars($_POST['username']);
	}?>"
  >
    <?php if (isset($errors['username'])) {
		foreach ($errors['username'] as $error) {
			echo '<div class="help-block">' .
				htmlspecialchars($error) . '</div>';
		}
	} ?>
  </div>
</div>

<!-- Text input-->
<div class="form-group<?php if (isset($errors['email'])) { echo ' has-error';} ?>">
  <label class="col-md-4 control-label" for="email">E-mail</label>  
  <div class="col-md-4">
  <input
	id="email"
	name="email"
	type="text"
	placeholder=""
	class="form-control input-md"
	value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>"
  >
	<?php if (isset($errors['email'])) {
		foreach ($errors['email'] as $error) {
			echo '<div class="help-block">' .
				htmlspecialchars($error) . '</div>';
		}
	} ?>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Сохранить</button>
  </div>
</div>

</fieldset>
</form>
