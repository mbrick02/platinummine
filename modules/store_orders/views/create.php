<p><h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="w3-card-4">
    <div class="w3-container primary">
        <h4>Store Order Details</h4>
    </div>
    <form class="w3-container" action="<?= $form_location ?>" method="post">

        <p>
            <label class="w3-text-dark-grey"><b>Tracking URL</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="tracking_url" value="<?= $tracking_url ?>" class="w3-input w3-border w3-sand" placeholder="Enter Tracking URL">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Store Order Status Levels ID</b></label>
            <?php
            $attributes['class'] = 'w3-select w3-border w3-sand';
            echo form_dropdown('store_order_status_levels_id', $store_order_status_levels_options, $store_order_status_levels_id, $attributes);
            ?>
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