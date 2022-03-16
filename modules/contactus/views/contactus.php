<section class="stage">
	<h1>Contact Us</h1>
	<?= validation_errors() ?>
	<div class="contact">
		<div>
			<p>To get in touch, please fill out the form below and then press 'Submit'.</p>
			<!-- Defiant form example -->
			<form class="form-vertical" action="<?= $form_location ?>" method="post">

				<label>Your Name</label>
				<input type="text" name="your_name" value="<?= $your_name ?>" placeholder="Enter your name here">

				<label>Your Email Address</label>
				<input type="email" name="your_email" value="<?= $your_email ?>" placeholder="Enter your email address here">

				<label>Your Telephone Number</label>
				<input type="text" name="your_telnum" value="<?= $your_telnum ?>" placeholder="Enter your telephone number here">				

				<label>Your Message</label>
				<textarea name="your_message" placeholder="Enter your message here"><?= $your_message ?></textarea>
				<input type="submit" name="submit" value="Submit" class="btn btn-primary">
				<a href="<?= BASE_URL ?>" class="btn btn-secondary">Cancel</a>

			</form>
		</div>
		<div>
			<p>Alternatively, you can write to us at the following address:</p>
			<h3><?= OUR_NAME ?></h3>
			<p><?= OUR_ADDRESS ?></p>
			<p><?= OUR_TELNUM ?></p>
		</div>
	</div>
</section>

<style type="text/css">
	.form-vertical, h3 {
		margin-top: 3rem;
	}
	.contact {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
	}
	.contact div {
		width: 48%;
	}
</style>