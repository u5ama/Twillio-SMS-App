<?php
namespace App\Utility;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use  Ixudra\Curl\Facades\Curl;
use Mockery\Exception;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class Utility
{

    public static function sendSMS($sms_body,$user_number){

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($user_number, [
                'from' => $twilio_number,
                'body' => $sms_body]);
            Log::info('message sent');
        } catch (ConfigurationException $e) {
            dd("Error: ". $e->getMessage());
        }
    }

    public static function timeAndDistance($lat1,$long1,$lat2,$long2){

        $response = \Curl::to('https://maps.googleapis.com/maps/api/directions/json?origin='.$lat1.','.$long1.'&destination='.$lat2.','.$long2.'&sensor=false&mode=driving&key=AIzaSyDOiaz6o-zN2bBUxzQLkdkGEC3_JU8BY2Q')
            ->get();

        return json_decode($response) ;

    }

    public static function paymentGateWay($request,$invoice,$user,$rate,$pc_source_type,$paymentGatWay,$testmode){

        // Send a POST request to: http://www.foo.com/bar with arguments 'foz' = 'baz' using JSON and return as associative array

        $response = \Curl::to($paymentGatWay->pgs_base_url)
            ->withHeader('Authorization: Bearer hWFfEkzkYE1X691J4qmcuZHAoet7Ds7ADhL')
//            ->withHeader('Cookie: XSRF-TOKEN=eyJpdiI6IkFtR1FMbnNsellWTlR1dTdvXC84Yk1nPT0iLCJ2YWx1ZSI6IlcwY001VUpTb2hQUEx5eW93WXZaWHQ0blhMWWZuK0lGeVRRUmNyWW0ycXpNWlYxRTVObVBqbGZycGtDWkNIWjkxYzJmdlhqenBETFBZYjNqbEhUU3lnPT0iLCJtYWMiOiJkN2RmNWIyM2ViNTk2YjBjZTJlZmMwNjU3OTE4MmFhMjVkZjE4NGNlYzVjYWI1YjdhZWEwNjUzMWU1N2EzODk1In0%3D; laravel_session=eyJpdiI6Im5oWG13MUdSSHRCeEtJaENSZjNqbUE9PSIsInZhbHVlIjoiQW9hWnROdVFkT1NHWXIzY0hORlltZllQUkZKUnMzbE1BRjdqVHFpN1k1RnU5U1wvaTZkaVBWNmVLTUw3Rk5vSUtXVXVvdVFxRUFOOHpVdkZkSjh4SVhnPT0iLCJtYWMiOiJhNzEyZjExYzZmNjIxNzRiMTlkMTQxNmFlZDhlYjJlZjQ3NGRlYjE3ZDZhYmEwZmNlMzkyN2EyM2I0OGViNGFmIn0%3D')
            ->withData( array('merchant_id' => $paymentGatWay->pgs_merchant_id,
                'username' => $paymentGatWay->pgs_username,
                'password' => $paymentGatWay->pgs_password,
                'api_key' => $paymentGatWay->pgs_api_key,
                'order_id' => $invoice->id,
                'total_price' => $rate,
                'CurrencyCode ' => 'KWD',
                'success_url' => $paymentGatWay->pgs_success_url,
                'error_url' => $paymentGatWay->pgs_error_url,
                'test_mode' => $testmode,
                'CstFName'=>$user->name,
                'CstEmail'=>$user->email,
                'CstMobile'=>$user->country_code.$user->mobile_no,
                'payment_gateway'=>$pc_source_type,
                'whitelabled' => $paymentGatWay->pgs_whitelabled,
                'ProductTitle'=>"['Ride']",
                'ProductName'=>"['Ride']",
                'ProductPrice'=>"['1']",
                'ProductQty'=>"['1']",
                'Reference'=>'123456789',
                'notifyURL'=>$paymentGatWay->pgs_notifyURL) )
            ->asJson( true )
            ->post();
        return $response;
    }

    public static function getRate($passengerId,$destination,$wait,$vehicles_type_id,$id,$selected_for_estimate_rate_km,$selected_for_estimate_rate_mint)
    {

        $passenger = PassengerCurrentLocation::where('pcl_passenger_id', $passengerId)->first();

        $country = Country::listsTranslations('name')->where('country_translations.name', $passenger->pcl_country)->first();
        $passenger = RideBookingSchedule::where('id', $id)->first();

        $getrates = FarePlanHead::leftjoin('fare_plan_details', 'fare_plan_head.id', '=', 'fare_plan_details.fpd_head_id_ref')->where(['fare_plan_head.fph_status'=>1,'fare_plan_head.fph_country_id'=>$country->id,'fare_plan_details.id' => $passenger->rbs_fare_plan_detail_id])->first();

        $KM_rate = $getrates->fpd_per_km_fare * $destination['distance'];

        $Time_rate = $getrates->fpd_per_minute_fare	 * $destination['time'];

        // New Calculations Updated

        $km_distance = BaseAppControl::where('bac_meta_key','driver_km_b4_customer_pickup')->first()->bac_meta_value;
        $mint_distance = BaseAppControl::where('bac_meta_key','driver_mintue_b4_customer_pickup')->first()->bac_meta_value;
        $dist = 0;
        if ($selected_for_estimate_rate_km > $km_distance){
            $dist = $selected_for_estimate_rate_km - $km_distance;
            $KM_rate_before = $getrates->fdp_per_km_fare_before_pickup * $dist;
        }else{
            $KM_rate_before = 0;
        }
        $time = 0;
        if ($selected_for_estimate_rate_mint > $mint_distance){
            $time = $selected_for_estimate_rate_mint - $mint_distance;
            $Time_rate_before = $getrates->fpd_per_minutes_fare_before_pickup * $time;
        }else{
            $Time_rate_before = 0;
        }


        $finalRate = $getrates->fpd_base_fare + $KM_rate + $Time_rate;


        $finalRate_before = $KM_rate_before + $Time_rate_before;

     //   $TotalRate = $finalRate + $finalRate_before;

        $finalRate_wait = 0 + ($getrates->fpd_wait_cost_per_minute_fare	 * $wait);

        $TotalRate = $finalRate + $finalRate_wait + $finalRate_before;

        if($vehicles_type_id->ban_promo_id != null &&  PromoCode::where('id',$vehicles_type_id->ban_promo_id)->exists()){
            $promo = PromoCode::find($vehicles_type_id->ban_promo_id);
            if($promo->pco_promo_value_type == 'value'){
                $discount = $promo->pco_promo_value;
            }if($promo->pco_promo_value_type == 'percentage'){
                $discount = $TotalRate * $promo->pco_promo_value / 100;
            }
        }else{
            $discount = 0;
        }
        $rateData = [
            'drop_off_distance'=>$destination['distance'],
            'drop_off_time'=>$destination['time'],
            'fare_rate_drop_off_distance'=>$getrates->fpd_per_km_far,
            'fare_rate_drop_off_time'=>$getrates->fpd_per_minute_fare,
            'before_pick_up_total_distance'=>$selected_for_estimate_rate_km,
            'free_before_pick_up_total_distance'=>$km_distance,
            'before_pick_up_distance_charge'=>$dist,
            'before_pick_up_total_time'=>$selected_for_estimate_rate_mint,
            'free_before_pick_up_total_time'=>$mint_distance,
            'before_pick_up_time_charge'=>$time,
            'before_pick_up_total_distance_rate'=>$getrates->fpd_per_minutes_fare_before_pickup,
            'before_pick_up_total_time_rate'=>$getrates->fpd_per_minutes_fare_before_pickup,
            'wait_after_arrived'=>$wait,
            'wait_charges'=>$getrates->fpd_wait_cost_per_minute_fare,
            'destination_final_KM_rate'=>$KM_rate,
            'destination_final_time_rate'=>$Time_rate,
            'destination_base_charges'=>$getrates->fpd_base_fare,
            'destination_total_with_out_pick_up_and_wait'=>$finalRate,
            'destination_total_pick_up'=>$finalRate_before,
            'destination_total_wait'=>$finalRate_wait,
            'total_bill'=>$TotalRate,
            'discount_if_voucher'=>$discount
        ];

        return [$TotalRate - $discount,$getrates->fpd_base_fare,$finalRate_before,$finalRate_wait,$getrates->fph_vat_per,$getrates->fph_tax_per,$rateData];
    }

   public static function getCCType($cardNumber) {
// Remove non-digits from the number
        $cardNumber = preg_replace('/\D/', '', $cardNumber);

// Validate the length
        $len = strlen($cardNumber);
        if ($len < 12 || $len > 19) {
            return "Invalid credit card number. Length does not match";
        }else{
            switch($cardNumber) {
                case(preg_match ('/^4/', $cardNumber) >= 1):
                    return ['type'=>'Visa','image'=>'assets/creditCard/Visa.png'];
                case(preg_match ('/^5[1-5]/', $cardNumber) >= 1):
                    return ['type'=>'Mastercard','image'=>'assets/creditCard/Master.png'];
                case(preg_match ('/^3[47]/', $cardNumber) >= 1):
                    return ['type'=>'Amex','image'=>'assets/creditCard/Amex.png'];
                case(preg_match ('/^3(?:0[0-5]|[68])/', $cardNumber) >= 1):
                    return ['type'=>'Diners Club','image'=>'assets/creditCard/DinersClub.png'];
                case(preg_match ('/^6(?:011|5)/', $cardNumber) >= 1):
                    return ['type'=>'Discover','image'=>'assets/creditCard/Discover.png'];
                case(preg_match ('/^(?:2131|1800|35\d{3})/', $cardNumber) >= 1):
                    return ['type'=>'JCB','image'=>'assets/creditCard/JCB.png'];
                default:
                    return "Could not determine the credit card type.";

            }
        }
    }


    public static function has_permission($name,$role_id)
    {
        $permission = DB::table('permissions')
            ->where('permission', $name)
            ->where('role_id', $role_id)
            ->get();
        if ( ! $permission->isEmpty() ) {
            return true;
        }
        return false;
    }

    public static function distance($lat1, $lon1, $lat2, $lon2,$unit) {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;

        if ($unit == "K") {
            return $kilometers;
        } else if ($unit == "N") {
            return $miles;
        } else {
            return $miles;
        }
    }

    public static function create_at_time($date, $lagTime)
    {

        $year_ago = $lagTime["year_ago"];
        $month_ago = $lagTime["month_ago"];
        $day_ago = $lagTime["day_ago"];
        $hour_ago = $lagTime["hour_ago"];
        $minute_ago = $lagTime["minute_ago"];
        $years_ago = $lagTime["years_ago"];
        $months_ago = $lagTime["months_ago"];
        $days_ago = $lagTime["days_ago"];
        $hours_ago = $lagTime["hours_ago"];
        $minutes_ago = $lagTime["minutes_ago"];
        $date = Carbon::parse($date);
        $now = Carbon::now();
        $years = $date->diffInYears($now);
        $months = $date->diffInMonths($now);
        $days = $date->diffInDays($now);
        $hours = $date->diffInHours($now);
        $minutes = $date->diffInMinutes($now);
        switch ($date) {
            case $minutes < 61:
                if ($minutes <= 1) {
                    $times_ago = $minute_ago;
                } else {
                    $times_ago = $minutes_ago;
                }
                $create_at_time = $minutes . ' ' . $times_ago;
                break;
            case $hours < 25:
                if ($hours <= 1) {
                    $times_ago = $hour_ago;
                } else {
                    $times_ago = $hours_ago;
                }
                $create_at_time = $hours . ' ' . $times_ago;
                break;
            case $days < 32:
                if ($days <= 1) {
                    $times_ago = $day_ago;
                } else {
                    $times_ago = $days_ago;
                }
                $create_at_time = $days . ' ' . $times_ago;
                break;
            case $months < 13:
                if ($months <= 1) {
                    $times_ago = $month_ago;
                } else {
                    $times_ago = $months_ago;
                }
                $create_at_time = $months . ' ' . $times_ago;
                break;
            case $months > 12:
                if ($years <= 1) {
                    $times_ago = $year_ago;
                } else {
                    $times_ago = $years_ago;
                }
                $create_at_time = $years . ' ' . $times_ago;
                break;
        }
        return $create_at_time;
    }


    function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
        $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
            : DateTimeZone::listIdentifiers();

        if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

            $time_zone = '';
            $tz_distance = 0;

            //only one identifier?
            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else {

                foreach($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat   = $location['latitude'];
                    $tz_long  = $location['longitude'];

                    $theta    = $cur_long - $tz_long;
                    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                        + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                    $distance = acos($distance);
                    $distance = abs(rad2deg($distance));
                    // echo '<br />'.$timezone_id.' '.$distance;

                    if (!$time_zone || $tz_distance > $distance) {
                        $time_zone   = $timezone_id;
                        $tz_distance = $distance;
                    }

                }
            }
            return  $time_zone;
        }
        return 'none?';
    }

    public static function paginate($data, $request)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($data);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $data = $itemCollection->slice((($currentPage * $perPage) - $perPage), $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($data, count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());
        $datatest = $paginatedItems->toArray();
        $data_keys = $datatest['data'];
        $data = [];
        foreach ($data_keys as $notification) {
            $data[] = $notification;
        }
        $pagination_urls = ['current_page' => $datatest['current_page'], 'first_page_url' => $datatest['first_page_url'], 'from' => $datatest['from'], 'last_page' => $datatest['last_page'],
            'last_page_url' => $datatest['last_page_url'], 'next_page_url' => $datatest['next_page_url'], 'path' => $datatest['path'],
            'per_page' => $datatest['per_page'], 'prev_page_url' => $datatest['prev_page_url'], 'to' => $datatest['to'], 'total' => $datatest['total']];

        return ['data' => $data, 'pagination_urls' => $pagination_urls];
    }

    //this function converts string from UTC time zone to current user timezone
    public static function convertTimeToUTCzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){
        if(empty($str)){
            return '';
        }

        $new_str = new \DateTime($str, new DateTimeZone($userTimezone) );
        $new_str->setTimeZone(new DateTimeZone( 'UTC' ));
        return $new_str->format($format);
    }

}



