<?php
include ROOT . '/resources/views/layouts/auth/header.php';
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					Register
				</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/user/register">

						<div class="form-group<?= isset($errors['firstName']) ? ' has-error' : '' ?>">
							<label class="col-md-4 control-label">First Name</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="firstName" value="<?= (isset($_POST['firstName'])) ? trim($_POST['firstName']) : '' ?>">

								<?php if(isset($errors['firstName'])) {?>
								<span class="help-block"> <strong><?= $errors['firstName']; ?></strong> </span>
								<?php } ?>
							</div>
						</div>
						<div class="form-group<?= isset($errors['middleName']) ? ' has-error' : '' ?>">
							<label class="col-md-4 control-label">Middle Name</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="middleName" value="<?= (isset($_POST['middleName'])) ? trim($_POST['middleName']) : '' ?>">

								<?php if(isset($errors['middleName'])) {?>
									<span class="help-block"> <strong><?= $errors['middleName']; ?></strong> </span>
								<?php } ?>
							</div>
						</div>
						<div class="form-group<?= isset($errors['lastName']) ? ' has-error' : '' ?>">
							<label class="col-md-4 control-label">Last Name</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="lastName" value="<?= (isset($_POST['lastName'])) ? trim($_POST['lastName']) : '' ?>">

								<?php if(isset($errors['lastName'])) {?>
									<span class="help-block"> <strong><?= $errors['lastName']; ?></strong> </span>
								<?php } ?>
							</div>
						</div>

						<div class="form-group<?= isset($errors['email']) ? ' has-error' : '' ?>">
							<label class="col-md-4 control-label">E-Mail Address</label>

							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="<?= (isset($_POST['email'])) ? trim($_POST['email']) : '' ?>">

								<?php if(isset($errors['email'])) {?>
								<span class="help-block"> <strong><?= $errors['email']; ?></strong> </span>
								<?php } ?>
							</div>
						</div>

						<div class="form-group<?= isset($errors['password']) ? ' has-error' : '' ?>">
							<label class="col-md-4 control-label">Password</label>

							<div class="col-md-6">
								<input type="password" class="form-control" name="password">

								<?php if(isset($errors['password'])) {?>
								<span class="help-block"> <strong><?= $errors['password']; ?></strong> </span>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Gender</label>

							<div class="col-md-2" >
								<select class="form-control" name="gender">
									<option>male</option>
									<option>female</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" name="submit" class="btn btn-primary">
									<i class="fa fa-btn fa-user"></i>Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include ROOT . '/resources/views/layouts/auth/footer.php';
?>

