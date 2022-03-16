<?php $cancel_url = ''; ?>
<div class="w3-row">
    <div class="w3-container">   
        <h1><?= $headline ?> <span class="w3-medium">(ID: <?= $update_id ?>)</span></h1>
        <?= flashdata() ?>
        <div class="w3-card-4">
            <div class="w3-container primary">
                <h4>Options</h4>
            </div>

            <div class="w3-container">
            <p>
                <a href="<?= BASE_URL ?>store_accounts/manage"><button class="w3-button w3-white w3-border"><i class="fa fa-list-alt"></i> VIEW ALL STORE ACCOUNTS</button></a> 
                <a href="<?= BASE_URL ?>store_accounts/create/<?= $update_id ?>"><button class="w3-button w3-white w3-border"><i class="fa fa-pencil"></i> UPDATE DETAILS</button></a>
                <button onclick="document.getElementById('delete-record-modal').style.display='block'" class="w3-button w3-red w3-hover-black w3-border w3-right"><i class="fa fa-trash-o"></i> DELETE</button>

                <div id="delete-record-modal" class="w3-modal w3-center" style="padding-top: 7em;">
                    <div class="w3-modal-content w3-animate-right w3-card-4" style="width: 30%;">
                        <header class="w3-container w3-red w3-text-white">
                            <h4><i class="fa fa-trash-o"></i> DELETE RECORD</h4>
                        </header>
                        <div class="w3-container">
                            <?php 
                            echo form_open('store_accounts/submit_delete/'.$update_id);
                            ?>
                            <h5>Are you sure?</h5>
                            <p>You are about to delete a store account record.  This cannot be undone. <br>
                                        Do you really want to do this?</p>
                            <p class="w3-right modal-btns">
                                <button onclick="document.getElementById('delete-record-modal').style.display='none'" type="button" name="submit" value="Submit" class="w3-button w3-small 3-white w3-border">CANCEL</button> 
                                <button type="submit" name="submit" value="Submit" class="w3-button w3-small w3-red w3-hover-black">YES - DELETE IT NOW!</button> 
                            </p>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </p>        
            </div>
        </div>
    </div>
</div>

<div class="w3-row">
    <div class="w3-half w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Store Account Details</h4>
            </div>
            <div class="edit-block-content">
              <div class="w3-border-bottom"><b>Date Created:</b> <span class="w3-right w3-text-grey"><?= $date_created ?></span></div>
              <div class="w3-border-bottom"><b>First Name:</b> <span class="w3-right w3-text-grey"><?= $first_name ?></span></div>
              <div class="w3-border-bottom"><b>Last Name:</b> <span class="w3-right w3-text-grey"><?= $last_name ?></span></div>
              <div class="w3-border-bottom"><b>Company:</b> <span class="w3-right w3-text-grey"><?= $company ?></span></div>
              <div class="w3-border-bottom"><b>Street Address:</b> <span class="w3-right w3-text-grey"><?= $street_address ?></span></div>
              <div class="w3-border-bottom"><b>Address Line 2:</b> <span class="w3-right w3-text-grey"><?= $address_line_2 ?></span></div>
              <div class="w3-border-bottom"><b>City:</b> <span class="w3-right w3-text-grey"><?= $city ?></span></div>
              <div class="w3-border-bottom"><b>State:</b> <span class="w3-right w3-text-grey"><?= $state ?></span></div>
              <div class="w3-border-bottom"><b>Zip Code:</b> <span class="w3-right w3-text-grey"><?= $zip_code ?></span></div>
              <div class="w3-border-bottom"><b>Telephone Number:</b> <span class="w3-right w3-text-grey"><?= $telephone_number ?></span></div>
              <div class="w3-border-bottom"><b>Email:</b> <span class="w3-right w3-text-grey"><?= $email ?></span></div>              
            </div>
        </div>
    </div>
    <div class="w3-half w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Comments</h4>
            </div>
            <div class="w3-container w3-center edit-block-content">
                <?php
                echo Modules::run('comments/_display_comments_block', $token);
                ?>
            </div>
        </div>
    </div>
</div>