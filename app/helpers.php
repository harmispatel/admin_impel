<?php



// Get Admin Settings



use App\Models\AdminSetting;
use Illuminate\Support\Str;


function getAdminSettings()

{

    $settings = [];

    $settings_array = AdminSetting::get();

    if(count($settings_array) > 0){

        foreach($settings_array as $setting){

            $settings[$setting['setting_key']] = $setting->value;

        }

    }

    return $settings;

}

function OrderNumberRandom()
{
    $order_number = rand(10000, 99999);
    return $order_number;
}

function seqaulCredentials()
{
    $admin_settings = getAdminSettings();
    $sequel_live = (isset($admin_settings['sequel_live']) && !empty($admin_settings['sequel_live'])) ? $admin_settings['sequel_live'] : 0;

    if ($sequel_live == 1) {
        $sequel_cred['sequel_api_token'] = (isset($admin_settings['sequel_live_api_token'])) ? $admin_settings['sequel_live_api_token'] : '';
        $sequel_cred['sequel_api_url'] = (isset($admin_settings['sequel_live_api_url'])) ? $admin_settings['sequel_live_api_url'] : '';
    } else {
        $sequel_cred['sequel_api_token'] = (isset($admin_settings['sequel_test_api_token'])) ? $admin_settings['sequel_test_api_token'] : '';
        $sequel_cred['sequel_api_url'] = (isset($admin_settings['sequel_test_api_url'])) ? $admin_settings['sequel_test_api_url'] : '';
    }

    return $sequel_cred;
}