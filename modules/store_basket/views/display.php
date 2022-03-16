<section class="your-basket">
	<h3>Your Shopping Basket</h3>
	<p><?= $info ?></p>

	<!-- Defiant CSS alternative table - more examples at; https://defiantcss.com/components/display/tables -->
	<table class="table basket"<?= $additional_table_code ?>>
	    <tbody>
	    	<?php 
	    	$basket_total = 0;
	    	foreach ($rows as $row) {
	    		$picture_path = BASE_URL.$picture_dir.'/'.$row->item_id.'/'.$row->picture;
	    		$remove_url = BASE_URL.'store_basket/remove/'.$row->code;
	    		$row_price = $row->item_price*$row->item_qty;
	    		$basket_total += $row_price;
	    	?>
	    	<tr>
	    		<td><img src="<?= $picture_path ?>" alt="<?= $row->item_title ?>"></td>
	    		<td>
					<p><span class="smaller"><?= $row->item_code ?></span></p>
					<p><b><?= $row->item_title ?></b></p>
					<p>Item Price: <?= CURRENCY_SYMBOL.number_format($row->item_price, 2) ?></p>
					<?php
						if (isset($row->item_color)) {
							echo '<p>Item Color'.$row->item_color.'</p>';
						}
						if (isset($row->item_size)) {
							echo '<p>Item Size'.$row->item_size.'</p>';
						}
					?>
					<p style="margin-top: 1em; ">QUANTITY: <?= $row->item_qty ?></p>
					<p style="margin-top: 1em; ">
						<?= anchor($remove_url, 'Remove'); ?>
					</p>
	    		</td>
	    		<td class="go-right"><?= CURRENCY_SYMBOL.number_format($row_price, 2) ?></td>
	    	</tr>
	    	<?php
	    	}
	    	?>
	    	<tr>
	    		<td colspan="2" style="text-align: right;">Shipping</td>
	    		<td class="go-right"><?= CURRENCY_SYMBOL.number_format($shipping, 2) ?></td>
	    	</tr>
	    	<?php 
	    		$basket_total += $shipping;
	    	 ?>
	    	<tr style="font-weight: bold;">
	    		<td colspan="2" style="text-align: right;">Total</td>
	    		<td class="go-right"><?= CURRENCY_SYMBOL.number_format($basket_total, 2) ?></td>
	    	</tr>
	    </tbody>
	</table>
	<?= Modules::run('store_basket/_attempt_draw_checkout_btn', $data) ?>

</section>
<style type="text/css">
	.your-basket {
		padding: 1em;
	}

	.basket {
		width: 70%;
		margin: 0 auto;
		border: 0;
	}

	.basket tr {
		border: 0;
	}

	.basket td {
		vertical-align: top;
	}

	.basket p {
		line-height: 1em;
		margin: 0.2em;
	}

	.basket img {
		margin: 0 auto;
	}

	.basket a {
		color: blue;
		text-decoration: underline;
	}

	span.smaller {
		font-size: 0.8em;
	}

	.go-right {
		text-align: right !important;
	}
</style>