<?php

class datafeedCustomPlugin
{
    public $plugin;

    function __construct()
    {
        $this->plugin = plugin_basename(__FILE__);
    }

    function register()
    {
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
        add_action('admin_menu',array($this,'add_admin_pages'));
        add_action('admin_init',array($this,'registerCustomFields'));
        add_filter("plugin_action_links_".$this->plugin, array($this,'settings_link'));
    }

    function createApiSettingsTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix.'datafeed_api_custom_settings';
        $charset_collate = $wpdb->get_charset_collate();
        $query = "CREATE TABLE $table_name(
             id mediumint(9) NOT NULL AUTO_INCREMENT,
            access_id varchar(255)  NULL,
            access_key varchar(255)  NULL,
            PRIMARY KEY  (id)
        ) $charset_collate";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($query);
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=datafeedCustom_plugin">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }

    public function add_admin_pages()
    {
        $aid = esc_attr(get_option('access_id'));
        $aik = esc_attr(get_option('access_key'));

        add_menu_page('DatafeedCustom Plugin',
                        'DatafeedCustom',
                        'manage_options',
                        'datafeedCustom_plugin',
                        array($this,'admin_index'),
                        'dashicons-store',110
                    );
        //check if access key and access id is provided
        if(isset($aid) && $aid != '' && isset($aik) && $aik != '')
        {
            add_submenu_page("datafeedCustom_plugin",
            'Networks',
            'Networks',
            'manage_options',
            'dtfc-networks',
            array($this,'network_page'),
            );
            add_submenu_page("datafeedCustom_plugin",
                'Merchants',
                'Merchants',
                'manage_options',
                'dtfc-merchants',
                array($this,'merchant_page'),
            );
        }
        
    }

    public function admin_index()
    {
        require_once plugin_dir_path(__FILE__).'views/admin.php';
    }

    public function network_page()
    {
        require_once plugin_dir_path(__FILE__).'views/network.php';
    }

    public function merchant_page()
    {
        require_once plugin_dir_path(__FILE__).'views/merchant.php';
    }


    public function registerCustomFields()
    {
       
        $settings = array(
            array(
                'option_group' => 'dtfc_options_group',
                'option_name' => 'access_id',
                'callback' => array($this,'dtfcOptionsGroup'),
            ),
            array(
                'option_group' => 'dtfc_options_group',
                'option_name' => 'access_key',
                'callback' => array($this,'dtfcOptionsGroup'),
            )
        );


        foreach($settings as $setting)
        {
            register_setting($setting['option_group'],$setting['option_name'],(isset($setting['callback']) ? $setting['callback'] : '' ));
        }

        $sections = array(
            array(
                'id' => 'dtfc_admin_index',
                'title' => 'API Settings',
                'callback' => array($this,'dtfcAdminSection'), 
                'page' => 'datafeedCustom_plugin'
            )
        );

       
        foreach($sections as $section)
        {
            add_settings_section($section['id'],$section['title'],(isset($section['callback']) ? $section['callback'] : '' ),$section['page']);
        }

        $fields = array(
            array(
                'id' => 'access_id',
                'title' => 'API Access ID',
                'callback' => array($this,'dtfcFieldAID'), 
                'page' => 'datafeedCustom_plugin',
                'section' => 'dtfc_admin_index',
                'args' => array(
                    'label_for' => 'access_id',
                    'class' => 'example-class',
                )
            ),
            array(
                'id' => 'access_key',
                'title' => 'API Access Key',
                'callback' => array($this,'dtfcFieldAK'), 
                'page' => 'datafeedCustom_plugin',
                'section' => 'dtfc_admin_index',
                'args' => array(
                    'label_for' => 'access_key',
                    'class' => 'example-class',
                )
            ),
        );

        foreach($fields as $field)
        {
            add_settings_field($field['id'],$field['title'],(isset($field['callback']) ? $field['callback'] : '' ),$field['page'],$field['section'],(isset($field['args']) ? $field['args']  : '' ));
        }

    }

    //call backs
    
    function dtfcOptionsGroup($input)
    {
        return $input;
    }

    function dtfcAdminSection()
    {
        echo 'Add your <a href="https://members.datafeedr.com/api?utm_source=plugin&utm_medium=link&utm_campaign=dfrapiconfigpage" target="_blank">Datafeedr API Keys.</a>';
    }

    function dtfcFieldAID()
    {
        $value = esc_attr(get_option('access_id'));
        echo '<input type="text" name="access_id" class="regular-text" value="'.$value.'" placeholder="ACCESS ID">';
    }

    function dtfcFieldAK()
    {
        $value = esc_attr(get_option('access_key'));
        echo '<input type="text" name="access_key" class="regular-text" value="'.$value.'" placeholder="ACCESS KEY">';
    }

    function dtfcFetchNetworks()
    {
        $api_url = "https://api.datafeedr.com/networks";

        $prop = json_encode([
            'aid'  => $value = esc_attr(get_option('access_id')),
            'akey' => $value = esc_attr(get_option('access_key'))
        ]);

        $args = array(
            'body' => $prop,
            'timeout' => 100
        );

        $response = wp_remote_post($api_url,$args);

        if (is_wp_error($response)) 
        {
            return '<p>Error retrieving data from API: ' . $response->get_error_message() . '</p>';
        }
        else 
        {
            // Get JSON response body using wp_remote_retrieve_body()
            $data = json_decode(wp_remote_retrieve_body($response));
            return $data;
        }
    }

    function dftcFetchMerchants()
    {
        $api_url = "https://api.datafeedr.com/merchants";

        $prop = json_encode([
            'aid'  => $value = esc_attr(get_option('access_id')),
            'akey' => $value = esc_attr(get_option('access_key')),
            'source_ids' => array(15)
        ]);

        $args = array(
            'body' => $prop,
            'timeout' => 100
        );

        $response = wp_remote_post($api_url,$args);

        if (is_wp_error($response)) 
        {
            return '<p>Error retrieving data from API: ' . $response->get_error_message() . '</p>';
        }
        else 
        {
            // Get JSON response body using wp_remote_retrieve_body()
            $data = json_decode(wp_remote_retrieve_body($response));
            
            return $data;
        }
    }

    function dtfcTblCreate()
    {
        global $wpdb; //Call for wordpress database
        
        $dtfcTble = $wpdb->prefix."dtfc_networks";

        $dtfcQuery = "CREATE TABLE $dtfcTble(
                id int(10) NOT NULL AUTO_INCREMENT,
                nid VARCHAR(30) DEFAULT '',
                network_type VARCHAR(100) DEFAULT '',
                network_name VARCHAR(100) DEFAULT '',
                network_group VARCHAR(100) DEFAULT '',
                merchant_count VARCHAR(100) DEFAULT '',
                product_count VARCHAR(100) DEFAULT '',
                affiliate_id VARCHAR(100) DEFAULT '',
                tracking_id VARCHAR(100) DEFAULT '',
                PRIMARY KEY (id)
        )";
  
        require_once(ABSPATH ."wp-admin/includes/upgrade.php");
        dbDelta($dtfcQuery);
            
    }

    function insertNetworks()
    {
        global $wpdb;
        $dtfcTble = $wpdb->prefix."dtfc_networks";
        if(isset($_POST['save_networks']))
        {
            $checked_array = $_POST['nid']['ids'];
            $network_names = $_POST['network_name']['ids'];
         
            foreach($network_names as $k => $v)
            {
                if(in_array($k,$checked_array))
                {
                    $count = count($checked_array);
                    if($_POST['nid']['ids'][$k] != FALSE)
                    {
                        $net_nid = $_POST['nid']['ids'][$k];
                        $data = [
                            'nid' => $net_nid,
                            'network_type' => $_POST['network_type']['ids'][$k],
                            'network_name' => $_POST['network_name']['ids'][$k],
                            'network_group' => $_POST['network_group']['ids'][$k],
                            'merchant_count' => $_POST['network_merch_count']['ids'][$k],
                            'product_count' => $_POST['network_prod_count']['ids'][$k],
                            'affiliate_id' => $_POST['dtfc_naid']['ids'][$k],
                            'tracking_id' => $_POST['dtfc_ntid']['ids'][$k],
                        ];

                        for($i=0;$i<$count;$i++)
                        {
                            if($net_nid != 0)
                            {
                                $id = $wpdb->get_row("SELECT * FROM $dtfcTble WHERE nid = $net_nid");
                                if(!$id)
                                {
                                    $wpdb->insert($dtfcTble,$data);
                                }
                            }
                        } 
                    }
                }
            }

            if ($wpdb->last_error === '') 
            {
                // Insertion was successful
                echo '<script>alert("Data inserted successfully")</script>';
            } 
            else 
            {
            // Insertion failed
                echo 'Error inserting data: ' . $wpdb->last_error;
            }
        }
    }

    function updateNetworksTable()
    {
        global $wpdb;
        $data_to_update = array();
        $id = $wpdb->get_row("SELECT * FROM");
    }

    function fetchNetworks()
    {
        global $wpdb;
        $dtfcTble = $wpdb->prefix."dtfc_networks";
        $results = $wpdb->get_results("SELECT * FROM $dtfcTble");

        return $results;
    }
    

    function array_group_by(array $array, $key)
    {
        if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key) ) {
            trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
            return null;
        }

        $func = (!is_string($key) && is_callable($key) ? $key : null);
        $_key = $key;

        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($array as $value) {
            $key = null;

            if (is_callable($func)) {
                $key = call_user_func($func, $value);
            } elseif (is_object($value) && property_exists($value, $_key)) {
                $key = $value->{$_key};
            } elseif (isset($value[$_key])) {
                $key = $value[$_key];
            }

            if ($key === null) {
                continue;
            }

            $grouped[$key][] = $value;
        }

        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();

            foreach ($grouped as $key => $value) {
                $params = array_merge([ $value ], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }

        return $grouped;
    }
    

    function activate()
    {
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    function uninstall()
    {

    }

    function enqueue()
    {
        wp_enqueue_style('pluginstyle',plugins_url('/assets/style.css',__FILE__));
        wp_enqueue_script('pluginscript',plugins_url('/assets/script.js',__FILE__));
    }
}


$dtfc_plugin = new datafeedCustomPlugin();
$dtfc_plugin->register();
$dtfc_plugin->dtfcTblCreate();
$dtfc_plugin->insertNetworks();
?>