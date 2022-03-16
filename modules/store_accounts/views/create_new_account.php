<section class="stage">
	<h3>Create new Account</h3>
	<?= validation_errors() ?>
	<!-- Defiant password update form -->
	<form class="form-vertical" action="<?= $form_location ?>" method="post">

		<label>Email Address</label>
		<input type="email" name="email" placeholder="Enter your email address here">
		<label>Password</label>
		<input type="password" name="pword" placeholder="Enter your password here">
		<label>Repeat Password</label>
		<input type="password" name="pword_repeat" placeholder="Repeat your password here">
		<input type="submit" name="submit" value="Create Account" class="btn btn-primary">
		<a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancel</a>
	</form>
</section>