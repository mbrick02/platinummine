<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="payments@yoursite.com"> <!-- eg. payments@bluehorn" -->
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="https://www.yoursite.com/thankyou">
    <input type="hidden" name="cancel_return" value="https://www.yoursite.com/cancel">

    <?php
    	$count = 0;
    	foreach($rows as $item) {
    		$count++;
    		echo '<input type="hidden" name="item_name_'.$count.'" value="'.$item->item_title.'">';
    		echo '<input type="hidden" name="amount_'.$count.'" value="'.$item->item_price.'">';
    		echo '<input type="hidden" name="quantity_'.$count.'" value="'.$item->item_qty.'">';

    		if (isset($item->item_color)) {
    			echo '<input type="hidden" name="on0_'.$count.'" value="Item Color">';
    			echo '<input type="hidden" name="os0_'.$count.'" value="'.$item->item_color.'">';
    		}

    		if (isset($item->item_size)) {
    			echo '<input type="hidden" name="on1_'.$count.'" value="Item size">';
    			echo '<input type="hidden" name="os1_'.$count.'" value="'.$item->item_size.'">';
    		}
    	}
     ?>



    <!-- shipping -->
    <input type="hidden" name="shipping_<?= $count ?>" value="<?= $shipping ?>">
    <input type="hidden" name="custom" value="<?= $custom ?>">

    <p style="text-align: center; margin-top: 3em;">
		<!-- Defiant CSS standard buttons -->
		<buttontype="submit" class="btn btn-success" name="submit" value="Submit">Goto Checkout</button>
	</p>
</form>