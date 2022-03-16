<div class="w3-third w3-container">
    <div class="w3-card-4 edit-block" style="margin-top: 1em;">
        <div class="w3-container primary">
            <h4>Picture Gallery</h4>
        </div>
        <div class="edit-block-content">

            <p class="w3-center">
                <a href="<?= BASE_URL ?>picture_uploader_multi/uploader/<?= $target_module ?>/<?= $update_id ?>"><button class="w3-button w3-white w3-border">
                    <i class="fa fa-image"></i> UPLOAD PICTURES
                </button></a>
            </p>

            <div style="padding: 1em;">
                <?php
                if (count($pictures) == 0) {
                    echo '<p class="w3-center">There are currently no gallery pictures for this record.</p>';
                } else {
                ?>

                    <div id="gallery-pics">
                        <?php
                        foreach ($pictures as $picture) {
                            $picture_path = $target_directory.$picture;
                            echo '<div onclick="previewPic(\''.$picture_path.'\')"><img src="'.$picture_path.'" class="w3-border" alt="<?= $picture ?>"></div>';
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    #gallery-pics {
        display: grid;
        grid-gap: 1em;
    }

    #gallery-pics div {
        text-align: center;
    }

    #gallery-pics div img {
        max-width: 100%;
        max-height: auto;
        padding: 0.1em;
        cursor: pointer;
    }

    #preview-pic {
        text-align: center;
    }

    #preview-pic img {
        max-width: 100%;
        max-height: 450px;
    }

    @media (min-width: 30em) {
        #gallery-pics {
            grid-template-columns: repeat(1, 1fr);
        }
    }

    @media (min-width: 50em) {
        #gallery-pics {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 70em) {
        #gallery-pics {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 90em) {
        #gallery-pics {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>

<div id="preview-pic-modal" class="w3-modal" style="padding-top: 7em;">
    <div class="w3-modal-content w3-animate-bottom w3-card-4" style="width: 30%;">
        <header class="w3-container primary w3-text-white w3-center">
            <h4><i class="fa fa-image"></i> PICTURE PREVIEW</h4>
        </header>
        <div class="w3-container">
            <p id="preview-pic"></p>
            <p class="w3-right modal-btns">
                <button onclick="document.getElementById('preview-pic-modal').style.display='none'" type="button" name="submit" value="Submit" class="w3-button w3-small 3-white w3-border">CANCEL</button>

                <button onclick="ditchPreviewPic()" class="w3-button w3-small  w3-red w3-hover-black w3-border">
                    <i class="fa fa-trash"></i> DELETE THIS PICTURE
                </button>               
            </p>
        </div>
    </div>
</div>

<script>

    var picturePath = '';
    var pictureName = '';

    function previewPic(clickedPicture) {
        document.getElementById('preview-pic-modal').style.display='block';
        var imageCode = '<img src="' + clickedPicture + '" >';
        document.getElementById('preview-pic').innerHTML=imageCode;
        picturePath = clickedPicture;

        var segmentArray = clickedPicture.split('/');
        pictureName = segmentArray[segmentArray.length-1];
    }

    function ditchPreviewPic() {
        document.getElementById('preview-pic-modal').style.display='none';
        var removePicUrl = '<?= BASE_URL ?>picture_uploader_multi/upload/<?= $target_module ?>/<?= $update_id ?>';
        const http = new XMLHttpRequest();
        http.open('DELETE', removePicUrl);
        http.setRequestHeader('Content-type', 'application/json');
        http.setRequestHeader('trongateToken', '<?= $token ?>');
        http.send(pictureName);
        http.onload = function() {
            refreshPictures(http.responseText);
        }
    }

    function refreshPictures(pictures) {
        var pics = JSON.parse(pictures);
        var currentPicsHtml = '';
        var imageCode = '';

        for (var i = 0; i < pics.length; i++) {
            imageCode = '<div onclick="previewPic(\'<?= $target_directory ?>' + pics[i] + '\')">';
            imageCode+= '<img src="<?= $target_directory ?>' + pics[i] + '" alt="' + pics[i] + '"></div>';
            currentPicsHtml+=imageCode;
        }

        if (currentPicsHtml == '') {
            currentPicsHtml = '<p class="w3-center">There are currently no gallery pictures for this record.</p>';
            document.getElementById('gallery-pics').style.gridTemplateColumns = 'repeat(1, 1fr)';
        }

        document.getElementById('gallery-pics').innerHTML=currentPicsHtml;
    }

</script>