<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="payments@yoursite.com">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="https://www.yoursite.com/thankyou">
    <input type="hidden" name="cancel_return" value="https://www.yoursite.com/cancel">

    <!-- first item -->
    <input type="hidden" name="item_name_1" value="Gold Watch">
    <input type="hidden" name="amount_1" value="0.01">
    <input type="hidden" name="quantity_1" value="3">

    <!-- second item -->
    <input type="hidden" name="item_name_2" value="Silver Ring">
    <input type="hidden" name="amount_2" value="0.02">
    <input type="hidden" name="quantity_2" value="5">
    <!-- second item additonal options -->
    <input type="hidden" name="on0_2" value="Item Color">
    <input type="hidden" name="os0_2" value="Blue">
    <input type="hidden" name="on1_2" value="Item Size">
    <input type="hidden" name="os1_2" value="small">

    <!-- shipping -->
    <input type="hidden" name="shipping_2" value="0.21">

    <button type="submit" name="submit" value="Submit">Submit</button>
</form>
