<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="w3-card-4">
    <div class="w3-container primary">
        <h4>Store Account Details</h4>
    </div>
    <form class="w3-container" action="<?= $form_location ?>" method="post">

        <p>
            <label class="w3-text-dark-grey"><b>First Name</b></label>
            <input type="text" name="first_name" value="<?= $first_name ?>" class="w3-input w3-border w3-sand" placeholder="Enter First Name">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Last Name</b></label>
            <input type="text" name="last_name" value="<?= $last_name ?>" class="w3-input w3-border w3-sand" placeholder="Enter Last Name">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Company</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="company" value="<?= $company ?>" class="w3-input w3-border w3-sand" placeholder="Enter Company">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Street Address</b></label>
            <input type="text" name="street_address" value="<?= $street_address ?>" class="w3-input w3-border w3-sand" placeholder="Enter Street Address">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Address Line 2</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="address_line_2" value="<?= $address_line_2 ?>" class="w3-input w3-border w3-sand" placeholder="Enter Address Line 2">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>City</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="city" value="<?= $city ?>" class="w3-input w3-border w3-sand" placeholder="Enter City">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>State</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="state" value="<?= $state ?>" class="w3-input w3-border w3-sand" placeholder="Enter State">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Zip Code</b></label>
            <input type="text" name="zip_code" value="<?= $zip_code ?>" class="w3-input w3-border w3-sand" placeholder="Enter Zip Code">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Telephone Number</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="telephone_number" value="<?= $telephone_number ?>" class="w3-input w3-border w3-sand" placeholder="Enter Telephone Number">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Email</b></label>
            <input type="email" name="email" value="<?= $email ?>" class="w3-input w3-border w3-sand" placeholder="Enter Email">
        </p>
        <p> 
            <?php 
            $attributes['class'] = 'w3-button w3-white w3-border';
            echo anchor($cancel_url, 'CANCEL', $attributes);
            ?> 
            <button type="submit" name="submit" value="Submit" class="w3-button w3-medium primary"><?= $btn_text ?></button>
        </p>
    </form>
</div>

<script>
$('.datepicker').datepicker();
$('.datetimepicker').datetimepicker({
    separator: ' at '
});
$('.timepicker').timepicker();
</script>