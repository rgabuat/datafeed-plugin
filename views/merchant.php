<div class="wrap" id="dfrapi_merchants" >
    <h1>Select Merchants</h1>
    <?php settings_errors(); ?>

    <form method="post" action="">
        <?php 
            $dtfc_plugin = new datafeedCustomPlugin();
            $dtfc = $dtfc_plugin->dftcFetchMerchants();
            if(!empty($dtfc))
            {
                $merchs = $dtfc->merchants;
                $grouped = $dtfc_plugin->array_group_by($dtfc->merchants,"source");
                $total_product = 0;
                $merchant_cnt = 0;
            }
        ?>

        <table class="form-table">
            <tbody>
                <?php 
                if(!empty($grouped)):
                    foreach($grouped as $key => $val) : 
                        foreach($val as $k => $vl)
                        {
                            // $merchant_cnt += $vl[0];
                            // echo '<pre>'; print_r($merch);
                            $total_product += $vl->product_count;
                        }
                    ?>
                <tr>
                    <th class="" style="display:none;">Merchants</th>
                    <td style="padding:0px;">
                        <div class="network network_<?= clean($key) ?>" style="background-color:#ffff">
                            <div class="meta" id="network_<?= clean($key) ?>">
                                <span class="name"><?= $key ?></span>
                                <span class="sep">/</span>
                                <span><?= $merchant_cnt ?> merchants</span>
                                <span class="sep">/</span>
                                <span><?= $total_product ?> products </span>
                            </div>
                            <div class="merchants hidden network_<?= clean($key) ?>" id="merchants_<?= $v->_id ?>" >
                                <div class="merchant_actions">

                                </div>
                                <div class="dfrapi_panes">
                                    <div class="dfrapi_pane_left">
                                        <div class="dfrapi_pane_title">
                                            <span>Merchants</span>
                                        </div>
                                        <div class="dfrapi_pane_content">
                                            <?php
                                                foreach($val as $v): ?>
                                                <div class="merchant" id="merchant_id_<?= $v->_id ?>" style="display:<?= $v->product_count == 0 ? 'none' : '' ?>">
                                                    <div class="merchant_name">
                                                        <?= $v->name ?>
                                                    </div>
                                                    <div class="merchant_info">
                                                        <span class="num_products">
                                                         <?= $v->product_count ?> products
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="dfrapi_pane_right">
                                        <div class="dfrapi_pane_title">
                                            <span>Selected Merchants</span>
                                        </div>
                                        <div class="dfrapi_pane_content">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td>
                            No networks selected
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

