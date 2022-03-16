<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Starter Template</title>
	<link rel="icon" href="<?= BASE_URL ?>favicon.ico" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css2?family=Crimson+Text&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons&amp;_cacheOverride=1553632958093" rel="stylesheet">
	<link rel="stylesheet" href="<?= BASE_URL ?>css/defiant.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>css/jewellery.css">
</head>
<body>
	<header>
		<div>
			<div><i class="material-icons">my_location</i> Store Locator</div>
			<div><i class="material-icons">account_box</i> Customer Log In</div>
		</div>
		<div>
			<div id="logo"><a href="#">Platinummine</a></div>
			<div id="descriptor">~ Established in 1872 ~</div>
		</div>
		<div>
			<div>Your Shopping Basket Is Empty</div>
			<div>
				<a href="<?= BASE_URL ?>store_basket/display"><button class="btn btn-small btn-basket">View Basket  <i class="material-icons">shopping_basket</i></button></a>
			</div>
		</div>
	</header>
	<!-- Navbar -->
	<nav class="navbar">
		<a href="#" class="navbar-link">Gold Jewellery</a>
		<a href="#" class="navbar-link">Silver Jewellery</a>
		<div class="dropdown">
			<button class="navbar-link dropdown-toggle">Rings</button>
			<div class="dropdown-menu">
				<a href="#" class="dropdown-menu-link">Engagement Rings</a>
				<a href="#" class="dropdown-menu-link">Wedding Rings</a>
			</div>
		</div>
		<div class="dropdown">
			<button class="navbar-link dropdown-toggle">Designer Jewellery</button>
			<div class="dropdown-menu">
				<a href="#" class="dropdown-menu-link">Schlukt Von Shangle</a>
				<a href="#" class="dropdown-menu-link">Shablom</a>
				<a href="#" class="dropdown-menu-link">Julie Andrews</a>
			</div>
		</div>
		<a href="#" class="navbar-link">Watches</a>
		<i class="material-icons nav-toggle">menu</i>
	</nav>
	
	<!-- Mobile Navigation -->
	<nav class="side-nav">
		<a href="" class="logo">Logo</a>
		<a href="" class="side-nav-link">Home</a>
		<a href="#" class="side-nav-link">About</a>
		<button class="side-nav-link submenu-toggle">Projects<i class="material-icons">chevron_right</i></button>
		<div class="submenu">
			<a href="#" class="submenu-link">Project 1</a>
			<a href="#" class="submenu-link">Project 2</a>
			<a href="#" class="submenu-link">Project 3</a>
		</div>
		<button class="side-nav-link submenu-toggle">Services<i class="material-icons">chevron_right</i></button>
		<div class="submenu">
			<a href="#" class="submenu-link">Service 1</a>
			<a href="#" class="submenu-link">Service 2</a>
			<a href="#" class="submenu-link">Service 3</a>
		</div>
		<a href="index.html" class="side-nav-link">Contact</a>
	</nav>
	
	<!-- Main Content -->
	<main class="main"><?= Template::display($data) ?></main>

	<style>
		main {
			width: 100%;
			min-height: 100vh;
		}
		
		ul.breadcrumb {
			border-bottom: 0;
			margin: 0.2em 1em;
		}
		
		.breadcrumb a {
			text-decoration: underline;
		}
		
		.image-gallery {
			grid-template-columns: repeat(5, 1fr);
		}
		
		.image-gallery .thumb {
			border: 1px silver solid;
		}
		
		.item {
			display: flex; /* "div"s horizontal */
			width: 98%;
			margin: 1em auto;
			justify-content: space-between; /* center divs - no space outside other than margin */
			align-items: flex-start; /* move items to top of contain div */
		}
		
		.item h1 {
			line-height: 1em;
			font-size: 1.4em;
		}
		
		.item .tick {
			color: green;
		}
		
		.item .price {
			font-size: 2em;
		}
		
		.item .smaller {
			font-size: 0.8em;
		}
		
		.item > div {
			margin: 0.5em;
		}
		
		.item > div:nth-child(1) {
			width: 41%;
		}
		
		.item > div:nth-child(2) {
			width: 37%;
		}
		
		.item > div:nth-child(3) {
			width: 22%;
			border: 1px silver solid;
		}
		
		.add-to-cart {
			padding: 0 0.5em;
			display: flex;
			flex-direction: column; /* stack cart parts */
		}
		
		.add-to-cart .price {
			line-height: 1em;
			font-size: 1.4em;
			font-weight: bold;
		}
		
		.add-to-cart label {
			margin: 0;
		}
		
		.add-to-cart .btn {
			width: 100%;
			letter-spacing: 1px;
		}
		
		.add-to-cart-info {
			font-size: 0.9em;
			letter-spacing: 1px;
		}
		
		.center-sub-head {
			text-align: center;
			font-size: 2.4em;
			margin-top: 3em;
			text-transform: uppercase;
			font-weight: normal;
		}
		
		.other-items {
			grid-template-columns: repeat(5, 1fr);
		}

		.page-btm {
			border-top: 5px #ffc107 solid;
			background-color: #333;
			color: #ddd;
			padding: 3em;
		}

		.container {
			margin: 0 auto;
			max-width: 128rem;
			display: flex;
			flex-direction: row;
		}

		.container div {
			width: 25%;
			padding: 1em;
		}

		.container h4 {
			font-size: 2.2rem;
		}

		.container ul {
			margin-top: 1em;
		}

		.container a {
			color: #ddd;
			text-decoration: underline;
		}

		.container a: hover {
			color: #fff;
		}

		.container .btn-secondary {
			width: 100%;
			border-radius: 4px;
		}
	</style>

	<section class="page-btm">
<div class="container">
		<div>
			<h4>Get In Touch</h4>
			<p><?= OUR_NAME ?></p>
			<p><?= OUR_ADDRESS ?></p>
			<p><?= OUR_TELNUM ?></p>
		</div>
		<div>
			<h4>Information</h4>
			<ul>
				<li><?= anchor('#', 'About Us') ?></li>
				<li><?= anchor('#', 'Privacy Policy') ?></li>
				<li><?= anchor('#', 'Refund Policy') ?></li>
				<li><?= anchor('#', 'Help &amp; FAQs') ?></li>
				<li><?= anchor('#', 'Contact Us') ?></li>
			</ul>
		</div>
		<div>
			<h4>Your Account</h4>
			<ul>
				<li><?= anchor('#', 'Your Details') ?></li>
				<li><?= anchor('#', 'Your Orders') ?></li>
				<li><?= anchor('#', 'Your Messages') ?></li>
				<li><?= anchor('#', 'Your Invoices') ?></li>
			</ul>
		</div>
		<div>
			<h4>Join Our Mailing LIst</h4>
			<p>Sign up for the mailing list and be the first to learn about our latest products and special offers</p>

			<form class="form-vertical"> 
				<input type="email" name="email" placeholder="Enter your email address">
				<input type="submit" name="submit" value="SIGN UP NOW" class="btn">
			</form>
		</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="footer">
		<p>Copyright &copy; <a href="https://martynmasson.com" target="_blank">Martyn Masson</a></p>
		<p>Proudly powered by the <a href="https://trongate.io" target="_blank">Trongate Framework</a></p>
	</footer>

	<script src="<?= BASE_URL ?>js/side-nav.js"></script>
	<script src="<?= BASE_URL ?>js/dropdown.js"></script>
	<script src="<?= BASE_URL ?>js/image-gallery.js"></script>
</body>
</html>