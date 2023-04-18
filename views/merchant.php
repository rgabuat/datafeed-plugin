<div class="wrap" id="dfrapi_merchants" >
    <h1>Select Merchants</h1>
    <?php settings_errors(); ?>
    <form method="post" action="">
        <?php 
            $dtfc_plugin = new datafeedCustomPlugin();
            $dtfc = $dtfc_plugin->dftcFetchMerchants();
            $datas = $dtfc_plugin->fetchMerchants();
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
                        // echo '<pre>';
                        // print_r($val);

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
                            <div class="merchants hidden network_<?= clean($key) ?>" id="merchants_for_nid_<?= $vl->source_id ?>" >
                                <div class="merchant_actions">
                                </div>
                                <div class="dfrapi_panes">
                                    <div class="dfrapi_pane_left">
                                        <div class="dfrapi_pane_title">
                                            <span>Merchants</span>
                                        </div>
                                        <div class="dfrapi_pane_content">
                                            <?php
                                                foreach($val as $v): 

                                                $mid_id = array();
                                                $afid = array();
                                                $tid = array();
                                                foreach($datas as $data)
                                                {
                                                    $mid_id[] = $data->mid;
                                                    // $afid[$data->nid] = array('afid'=>$data->affiliate_id);
                                                    // $trkid[$data->nid] = array('tid'=>$data->tracking_id);
                                                    $checked   = ( in_array( $v->_id, (array) $mid_id ) ) ? ' checked="checked"' : '';
                                                }
                                                ?>

                                                
                                                <div class="merchant" id="merchant_id_<?= $v->_id ?>" style="display:<?= $v->product_count == 0 ? 'none' : 'flex; align-items:center; padding-left:10px;' ?>">
                                                    <div class="check_merchant_box">
                                                        <input type="checkbox"  id="nid_<?= $v->_id?>" class="check_merchant" name="mid[ids][<?= $v->_id?>]"  <?= $checked ?> value="<?= $v->_id?>">
                                                        <input type="hidden"  class="network_group_<?= $v->source_id?>" name="network_id[ids][<?= $v->_id?>]" value="<?= $v->source_id ?>">
                                                    </div>
                                                    <div class="merchant_name">
                                                        <input type="hidden" id="merch_name_<?= $v->_id?>" class="merch_name" name="merchant_name[ids][<?= $v->_id?>]" value="<?= $v->name?>">
                                                        <?= $v->name ?>
                                                    </div>
                                                    <div class="merchant_info">
                                                        <span class="num_products">
                                                        <input type="hidden" id="merch_prod_count_<?= $v->_id?>" class="merch_prod_count" name="merchant_prod_count[ids][<?= $v->_id?>]" value="<?= $v->product_count?>">
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
        <p class="submit"><input type="submit" name="save_merchants" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>
</div>

