<p class="price"><span class="smaller"><?= CURRENCY_SYMBOL ?></span><?= $item_obj->item_price ?></p>
<?= flashdata() ?>
<form class="form-vertical" action="<?= $form_location ?>" method="post">			
	<?php 
		if (count($item_colors)>0) {
	?>
			<label>Color</label>
			<select name="item_color_id">
				<option value="0">Select Color...</option>
				<?php 
					foreach ($item_colors as $item_color) {
						echo '<option value="'.$item_color['id'] .'">'.$item_color['item_color'] .'</option>';
					}
				 ?>
			</select>
	<?php 
		}
	 ?>

	<?php 
		if (count($item_sizes)>0) {
	?>
			<label>Size</label>
			<select name="item_size_id">
				<option value="0">Select Size...</option>
				<?php 
					foreach ($item_sizes as $item_size) {
						echo '<option value="'.$item_size['id'] .'">'.$item_size['item_size'] .'</option>';
					}
				 ?>
			</select>
	<?php 
		}
	 ?>
	<label>Quantity</label>
	<select name="item_qty">
		<option value="0">Select Quantity...</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>
			
	<input type="submit" name="submit" value="Add To Basket" class="btn btn-gold">
	<p  class="add-to-cart-info">This item is eligible for free delivery in Europe and the USA but never in Ireland.</p>
	<!-- PayPal Logo -->
	<table border="0" cellpadding="10" cellspacing="0" align="center">
		<tr>
			<td align="center"></td>
		</tr>
		<tr>
			<td align="center"><a href="https://www.paypal.com/uk/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/uk/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">
				<img src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_SbyPP_mc_vs_ms_ae_UK.png" border="0" alt="PayPal Acceptance Mark"></a>
			</td>
		</tr>
	</table><!-- PayPal Logo -->

	<?= form_hidden('item_id', $item_obj->id) ?>
</form>