<?php

namespace App\Console\Commands;

use App\Models\Design;
use App\Models\Design_image;
use App\Models\Tag;
use App\Models\Category;
use Google_Client;
use Google_Service_Sheets;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DesignImportFromGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:design-from-google-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Designs from Google Sheet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try
        {
            // Admin Settings
            $settings = getAdminSettings();
            $sheets_names = (isset($settings['sheets_names'])) ? $settings['sheets_names'] : '';
            $sheets_names = (!empty($sheets_names)) ? explode(',',$sheets_names) : [];
            $sheets_names = array_map(function ($sheets_names) {
                return "'$sheets_names'";
            }, $sheets_names);

            $spread_sheet_id = (isset($settings['spread_sheet_id'])) ? $settings['spread_sheet_id'] : '';
            $developer_key = (isset($settings['developer_key'])) ? $settings['developer_key'] : '';

            $client = new Google_Client();
            $client->setDeveloperKey($developer_key);
            $client->setAuthConfig(base_path('sheet_credentials.json'));
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);
            $spreadsheetId = $spread_sheet_id;

            // Specify the sheets you want to retrieve data from
            $sheets = $sheets_names;
            $sheets_data = [];

            $gold_price = 'GOLDPRICE';
            $response = $service->spreadsheets_values->get($spreadsheetId, $gold_price);
            $gold_response = $response->getValues();

            foreach ($sheets as $sheet)
            {
                $range = $sheet; // You can adjust the range as needed
                $response = $service->spreadsheets_values->get($spreadsheetId, $range);
                $values = $response->getValues();

                // Store the values in an array, associating them with the sheet name
                $sheets_data[$sheet] = $values;
            }

            if(count($sheets_data) > 0)
            {
                foreach($sheets_data as $sheet_data)
                {
                    unset($sheet_data[0]);
                    $items = array_values($sheet_data);
                    if(count($items) > 0)
                    {
                        foreach($items as $item)
                        {
                            $design_no = (isset($item[0])) ? $item[0] : '';
                            $input['code'] = $design_no;
                            $input['name'] = (isset($item[3])) ? $item[3] : '';
                        
                            $input['category_id'] = (isset($item[2])) ? $item[2] : '';
                            $input['gender_id'] = (isset($item[4])) ? $item[4] : '';
                            $input['metal_id'] = (isset($item[5])) ? $item[5] : '';

                            $find_design = Design::where('code',$design_no)->first();
                            $design_id = (isset($find_design['id'])) ? $find_design['id'] : '';

                            // Insert Tags & Update Tags
                            $tags  = [];
                            if(isset($item[6]) && !empty($item[6])){
                                $tags[] = $item[6];
                            }
                            if(isset($item[7]) && !empty($item[7])){
                                $tags[] = $item[7];
                            }
                            if(isset($item[8]) && !empty($item[8])){
                                $tags[] = $item[8];
                            }
                            if(isset($item[9]) && !empty($item[9])){
                                $tags[] = $item[9];
                            }
                            if(isset($item[10]) && !empty($item[10])){
                                $tags[] = $item[10];
                            }
                            if(isset($item[11]) && !empty($item[11])){
                                $tags[] = $item[11];
                            }
                            if(isset($item[12]) && !empty($item[12])){
                                $tags[] = $item[12];
                            }
                            if(isset($item[13]) && !empty($item[13])){
                                $tags[] = $item[13];
                            }
                            if(isset($item[14]) && !empty($item[14])){
                                $tags[] = $item[14];
                            }
                            if(isset($item[15]) && !empty($item[15])){
                                $tags[] = $item[15];
                            }

                            $tag_ids  = [];
                            if(count($tags) > 0){
                                foreach($tags as $tag){
                                    $find_tag = Tag::where('name',$tag)->first();
                                    $tag_id = (isset($find_tag['id'])) ? $find_tag['id'] : '';

                                    // Update Tag
                                    if(isset($tag_id) && !empty($tag_id)){
                                        $update_tag = Tag::find($tag_id);
                                        $update_tag->name = $tag;
                                        $update_tag->update();
                                        $tag_ids[] = $tag_id;
                                    }else{
                                        $new_tag = Tag::create(['name'=>$tag]);
                                        $tag_ids[] = $new_tag->id;
                                    }
                                }
                            }

                            $input['tags'] = json_encode($tag_ids);
                            $input['image'] = $design_no.'.jpg';
                            $input['video'] = $design_no.'.mp4';
                            $input['description'] = (isset($item[27])) ? $item[27] : '';

                            // // Gross Weight
                            // $gross_weight_22k = (isset($item[20])) ? $item[20] : 0;
                            // $gross_weight_20k = (isset($item[21])) ? $item[21] : 0;
                            // $gross_weight_18k = (isset($item[22])) ? $item[22] : 0;
                            // $gross_weight_14k = (isset($item[23])) ? $item[23] : 0;

                            // // Stone
                            // $total_gem_stone_waight = (isset($item[30])) ? $item[30] : 0;
                            // $total_cz_waight = (isset($item[29])) ? $item[29] : 0;

                            // Gross Weight
                            $gross_weight_22k = floatval(isset($item[20]) ? $item[20] : 0);
                            $gross_weight_20k = floatval(isset($item[21]) ? $item[21] : 0);
                            $gross_weight_18k = floatval(isset($item[22]) ? $item[22] : 0);
                            $gross_weight_14k = floatval(isset($item[23]) ? $item[23] : 0);
                            
                            // Stone
                            $total_gem_stone_waight = floatval(isset($item[30]) ? $item[30] : 0);
                            $total_cz_waight = floatval(isset($item[29]) ? $item[29] : 0);

                            // Net Weight
                            $net_weight_14k = number_format($gross_weight_14k - $total_gem_stone_waight - $total_cz_waight,2);
                            $net_weight_18k = number_format($gross_weight_18k - $total_gem_stone_waight - $total_cz_waight,2);
                            $net_weight_20k = number_format($gross_weight_20k - $total_gem_stone_waight - $total_cz_waight,2);
                            $net_weight_22k = number_format($gross_weight_22k - $total_gem_stone_waight - $total_cz_waight,2);

                            $input['gweight1'] = round($gross_weight_14k, 2);
                            $input['gweight2'] = round($gross_weight_18k, 2);
                            $input['gweight3'] = round($gross_weight_20k, 2);
                            $input['gweight4'] = round($gross_weight_22k, 2);

                            $input['less_gems_stone'] = $total_gem_stone_waight;
                            $input['less_cz_stone'] = $total_cz_waight;

                            $input['nweight1'] = $net_weight_14k;
                            $input['nweight4'] = $net_weight_22k;
                            $input['nweight2'] = $net_weight_18k;
                            $input['nweight3'] = $net_weight_20k;

                            $input['percentage'] = (isset($item[67])) ? $item[67] : '';
                            $input['gemstone_price'] = (isset($item[68]) && !empty($item[68])) ? $item[68] : 0.00;

                            $input['gold_price_24k'] = (isset($item[69]) && !empty($item[69])) ? round($item[69], 2) : 0.00;
                            $input['gold_price_22k'] = (isset($item[70]) && !empty($item[70])) ? round($item[70], 2) : 0.00;
                            $input['gold_price_20k'] = (isset($item[71]) && !empty($item[71])) ? round($item[71], 2) : 0.00;
                            $input['gold_price_18k'] = (isset($item[72]) && !empty($item[72])) ? round($item[72], 2) : 0.00;
                            $input['gold_price_14k'] = (isset($item[73]) && !empty($item[73])) ? round($item[73], 2) : 0.00;

                            $input['price_22k'] = (isset($item[74]) && !empty($item[74])) ? round($item[74], 2) : 0.00;
                            $input['price_20k'] = (isset($item[75]) && !empty($item[75])) ? round($item[75], 2) : 0.00;
                            $input['price_18k'] = (isset($item[76]) && !empty($item[76])) ? round($item[76], 2) : 0.00;
                            $input['price_14k'] = (isset($item[77]) && !empty($item[77])) ? round($item[77], 2) : 0.00;

                            $input['cz_stone_price'] = (isset($item[78]) && !empty($item[78])) ? $item[78] : 0.00;
                            $input['making_charge'] = (isset($item[79]) && !empty($item[79])) ? $item[79] : 0.00;

                            $input['total_price_22k'] = (isset($item[80]) && !empty($item[80])) ? $item[80] : 0.00;
                            $input['total_price_20k'] = (isset($item[81]) && !empty($item[81])) ? $item[81] : 0.00;
                            $input['total_price_18k'] = (isset($item[82]) && !empty($item[82])) ? $item[82] : 0.00;
                            $input['total_price_14k'] = (isset($item[83]) && !empty($item[83])) ? $item[83] : 0.00;
                            
                            if(!empty($design_id) || $design_id != ''){
                                // Update Design
                                $update_design = Design::find($design_id)->update($input);
                            }else{
                                // Create New Design
                                $new_design = Design::create($input);

                                // Insert Multiple Image
                                $mul_images = [
                                    '0' => $design_no."A.jpg",
                                    '1' => $design_no."B.jpg",
                                    '2' => $design_no."C.jpg",
                                    '3' => $design_no."D.jpg",
                                    '4' => $design_no."E.jpg",
                                    '5' => $design_no."F.jpg",
                                    '6' => $design_no."G.jpg",
                                    '7' => $design_no."H.jpg",
                                    '8' => $design_no."I.jpg",
                                    '9' => $design_no."J.jpg",
                                   '10' => $design_no."K.jpg",
                                   '11' => $design_no."L.jpg",
                                   '12' => $design_no."M.jpg",
                                   '13' => $design_no."N.jpg",
                                   '14' => $design_no."O.jpg",
                                   '15' => $design_no."P.jpg",
                                ];
                                
                                if(count($mul_images) > 0){
                                    foreach($mul_images as $image){
                                        $new_image = new Design_image();
                                        $new_image->design_id = $new_design->id;
                                        $new_image->image = $image;
                                        $new_image->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            
            $this->info('Design has been Imported SuccessFully.' . now()->format('Y-m-d H:i:s'));
        }
        catch (\Exception $e)
        {
            $errorResponse = json_decode($e->getMessage(), true);
            if (isset($errorResponse['error']['message'])) 
            {
           		$errorMessage = $errorResponse['error']['message'];
            	$this->error('Error: '.$errorMessage);
            } 
          	else 
            {
            	$this->error('An unknown error occurred.' . now()->format('Y-m-d H:i:s'));
            }
        }
    }
}
