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