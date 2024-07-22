<?php



// Get Admin Settings



use App\Models\AdminSetting;



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

