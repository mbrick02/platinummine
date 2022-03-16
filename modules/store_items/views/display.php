	<ul class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li><a href="#">Designer Jewellery</a></li>
			<li><a href="#">Watches</a></li>
			<li><a href="#">Citizen Eco_drive AT9013-03H</a></li>
		</ul>
	
		<section class="item">
			<div>
				<?= $item_pic_html ?>
			</div>
			<div>
				<h1><?= $item_obj->item_title ?></h1>
				<p><b>Item Code:</b> <?= $item_obj->item_code ?></p>
				<p><?= $in_stock_html ?></p>
				<p class="price"><span class="smaller"><?= CURRENCY_SYMBOL ?></span><?= $item_obj->item_price ?></p>
				<?= nl2br($item_obj->description) ?>
			</div>
			<div class="add-to-cart"><?= Modules::run('add_to_cart/_draw_add_to_cart', $data) ?></div>
		</section>
		
		<h2  class="center-sub-head">You May Also Like</h2>
		<hr class="hr-3">
				<!-- Items Class -->
		<section class="items other-items">
			<div class="card">
				<img src="<?= BASE_URL ?>images/sample_item_pics/offers/item1.jpg" alt="nice item">
				<div class="card-body">
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
					<a href="#" class="btn btn-secondary">View Item</a>
				</div>
			</div>
			<div class="card">
				<img src="<?= BASE_URL ?>images/sample_item_pics/offers/item2.jpg" alt="nice item">
				<div class="card-body">
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
					<a href="#" class="btn btn-secondary">View Item</a>
				</div>
			</div>
			<div class="card">
				<img src="<?= BASE_URL ?>images/sample_item_pics/offers/item3.jpg" alt="nice item">
				<div class="card-body">
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
					<a href="#" class="btn btn-secondary">View Item</a>
				</div>
			</div>
			<div class="card">
				<img src="<?= BASE_URL ?>images/sample_item_pics/offers/item4.jpg" alt="nice item">
				<div class="card-body">
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
					<a href="#" class="btn btn-secondary">View Item</a>
				</div>
			</div>
			<div class="card">
				<img src="<?= BASE_URL ?>images/sample_item_pics/offers/item5.jpg" alt="nice item">
				<div class="card-body">
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
					<a href="#" class="btn btn-secondary">View Item</a>
				</div>
			</div>
		</section>