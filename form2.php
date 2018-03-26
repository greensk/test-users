<form class="form-horizontal" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Регистрация пользователя</legend>

<!-- Text input-->
<div class="form-group">
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
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">E-mail</label>  
  <div class="col-md-4">
  <input
	id="email"
	name="email"
	type="text"
	placeholder=""
	class="form-control input-md"
	value="<?php if (isset($_POST['email'])){
		echo htmlspecialchars($_POST['email']);
	}?>"
  >
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
