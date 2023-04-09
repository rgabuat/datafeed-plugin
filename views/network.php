<div class="wrap" id="dfrapi_networks">
    <h1>Select Network</h1>
    <?php settings_errors(); ?>

    <form method="post">
        <?php
        $dtfc_plugin = new datafeedCustomPlugin();
        $dtfc = $dtfc_plugin->dtfcFetchNetworks();
        $datas = $dtfc_plugin->fetchNetworks();

        $grouped = $dtfc_plugin->array_group_by($dtfc->networks,"group");
            foreach($grouped as $key => $value) :
        ?>
            
            <div class="group" id="group_<?= clean($key) ?>">
                <div class="meta" id="meta_<?= clean($key) ?>">
                    <span><?= $key ?></span>
                    <?php  
                    // $network_cnt = 0;
                    $merchant_cnt = 0;
                    $product_cnt = 0; 

                    foreach($value as $cnt)
                    {
                        // $network_cnt += $cnt;
                        $merchant_cnt += $cnt->merchant_count;
                        $product_cnt += $cnt->product_count;
                    }

                    ?>
                    <!-- <span> <= $network_cnt ?> network</span> -->
                    <!-- <span  class="sep">/</span> -->
                    <span> <?= $merchant_cnt ?> merchants</span>
                    <span class="sep">/</span>
                    <span> <?= number_format($product_cnt) ?> products </span>
                </div>
                <div class="networks hidden networks_<?= clean($key) ?>">
                    <table class="wp-list-table widefat fixed networks_table" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="checkbox_head"> &nbsp; </th>
                                <th class="networks_head">Network</th>
                                <th class="type_head">Type</th>
                                <th class="aid_head">Affiliate ID</th>
                                <th class="tid_head">Tracking ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                           
                            $net_id = array();
                            $afid = array();
                            $tid = array();
                            foreach($datas as $data)
                            {
                                $net_id[] = $data->nid;
                                $afid[$data->nid] = array('afid'=>$data->affiliate_id);
                                $trkid[$data->nid] = array('tid'=>$data->tracking_id);
                            }

                            foreach($value as $val):

                            $checked   = ( in_array( $val->_id, (array) $net_id ) ) ? ' checked="checked"' : '';
                            $aid = ( array_key_exists( $val->_id, (array) $afid ) ) ? $afid[$val->_id]['afid'] : '';
                            $tid = ( array_key_exists( $val->_id, (array) $afid ) ) ? $trkid[$val->_id]['tid'] : '';
                            ?>
                            
                            <tr class="network" id="network_id_<?= $val->_id; ?>">
                                <!-- <td class="network"><= $val->_id ?></td> -->
                                <input type="hidden" id="network_group_<?= $key?>" class="network_group" name="network_group[ids][<?= $val->_id?>]" value="<?= $key?>">
                                <td class="network_checkbox">
                                    <input type="checkbox" id="nid_<?= $val->_id?>" class="check_network" name="nid[ids][<?= $val->_id?>]" <?= $checked ?>  value="<?= $val->_id?>">
                                </td>
                                <td class="net_name">
                                    <label for="nid_<?= $val->_id ?>">
                                        <?= $val->name ?>
                                        <input type="hidden" id="net_name_<?= $val->_id?>" class="net_name" name="network_name[ids][<?= $val->_id?>]" value="<?= $val->name?>">
                                        <input type="hidden" id="net_merch_count_<?= $val->_id?>" class="net_merch_count" name="network_merch_count[ids][<?= $val->_id?>]" value="<?= $val->merchant_count?>">
                                        <input type="hidden" id="net_prod_count_<?= $val->_id?>" class="net_prod_count" name="network_prod_count[ids][<?= $val->_id?>]" value="<?= $val->product_count?>">
                                        <div class="network_info">
                                            <span class="num_merchants"><?= $val->merchant_count ?> merchants  
                                                <span class="sep">/</span>
                                                <span class="num_products"><?= number_format($val->product_count) ?> products</span>
                                            </span>
                                        </div>
                                    </label>
                                </td>
                                <input type="hidden" id="network_type_<?= $val->_id?>" class="net_type" name="network_type[ids][<?= $val->_id?>]" value="<?= $val->type?>">
                                <td class="network_type"><?= $val->type ?></td>
                                <td class="aid_input">
                                    <input type="text" id="aid_<?= $val->_id?>" name="dtfc_naid[ids][<?= $val->_id?>]" value="<?= $aid ?>" class="aid_input_field" >
                                </td>
                                <td class="tid_input">
                                    <input type="text" id="tid_<?= $val->_id?>" name="dtfc_ntid[ids][<?= $val->_id?>]" value="<?= $tid ?>" class="tid_input_field" >
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach;?>
        <p class="submit"><input type="submit" name="save_networks" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>
</div>