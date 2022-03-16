<div class="w3-row">
    <div class="w3-thxird w3-container">
        <h1><?= $headline ?></h1>
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4><?= $target_module_desc ?> Details</h4>
            </div>
            <div class="edit-block-content" style="padding: 1em;     height: 70vh;">

                <p> 
                    <a href="<?= $previous_url ?>" class="w3-button w3-white w3-border">
                        <i class="fa fa-arrow-left"></i> Go Back
                    </a>
                </p>

                <!-- We'll transform this input into a pond -->
                <input type="file" name="file" class="filepond" multiple>

                <!-- image preview -->
                <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
                <!-- exif -->
                <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
                <!-- Load FilePond library -->
                <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

                <!-- Turn all file input elements into ponds -->
                <script>
                // We want to preview images, so we register
                // the Image Preview plugin, We also register
                // exif orientation (to correct mobile image
                // orientation) and size validation, to prevent
                // large files from being added
                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginImageExifOrientation
                    // FilePondPluginFileValidateSize
                );

                FilePond.setOptions({
                    server: {
                        url: '<?= $api_url ?>',
                        headers: {
                            'trongatetoken': '<?= $token ?>'
                        }
                    }
                });

                FilePond.create(
                    document.querySelector('.filepond'),
                );
                </script>

            </div>
        </div>
    </div>
</div>

<style>

@media (min-width: 30em) {
    .filepond--item {
        width: calc(50% - .5em);
    }
}

@media (min-width: 50em) {
    .filepond--item {
        width: calc(33.33% - .5em);
    }
}

@media (min-width: 70em) {
    .filepond--item {
        width: calc(25% - .5em);
    }
}

@media (min-width: 90em) {
    .filepond--item {
        width: calc(20% - .5em);
    }
}

@media (min-width: 110em) {
    .filepond--item {
        width: calc(16.66% - .5em);
    }
}

</style>