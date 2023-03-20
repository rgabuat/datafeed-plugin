<div class="wrap">
    <h1>Select Network</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <!-- <php 
            settings_fields('dtfc_options_group'); //get settings field id from setSettings function
            do_settings_sections('datafeedCustom_plugin'); //set section slug from setSections function
            submit_button();
        ?> -->
        <?php
        $dtfc_plugin = new datafeedCustomPlugin();
        $dtfc_plugin->dtfcFetchNetworks();
        ?>
    </form>
</div>