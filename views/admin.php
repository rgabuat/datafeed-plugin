<div class="wrap">
    <h1>Datafeedr Custom API Settings</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php 
            settings_fields('dtfc_options_group'); //get settings field id from setSettings function
            do_settings_sections('datafeedCustom_plugin'); //set section slug from setSections function
            submit_button();
        ?>
    </form>
</div>