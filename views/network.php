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
        $dtfc = $dtfc_plugin->dtfcFetchNetworks();

        // $by_group = $dtfc_plugin->group_by("group",$dtfc->networks);

        $by_group = "<pre>"; print_r($by_group);

        foreach($dtfc->networks as $network):
        ?>

            <div>
                <div class="meta">
                    <span><?= $network->name ?></span>
                    <span class="status">
                        <span> Networks</span>
                    </span>
                </div>
            </div>

        <?php endforeach; ?>
    </form>
</div>