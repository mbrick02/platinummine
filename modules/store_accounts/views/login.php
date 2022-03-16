<section class="stage">
	<h3>Customer Login</h3>
	<?= validation_errors() ?>

	<!-- Defiant login form -->
	<form class="form-vertical" action="<?= $form_location ?>" method="post"> 

		<label>Email Address</label>
		<input type="text" name="email" placeholder="Enter your email address here">

		<label for="password">Password</label>
		<input type="password" name="pword" placeholder="Enter your password here">

		<input type="checkbox" name="remember" value="1">
		<label for="remember">Remember me</label>
		<!-- for is important to uncheck -->

		<div style="margin-top: 3em; clear: both;">
					<input type="submit" name="submit" value="Submit" class="btn btn-primary">
			<a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancel</a>
		</div>
	</form>
</section>