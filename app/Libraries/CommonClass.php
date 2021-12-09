<?php
/**
 * Created by PhpStorm.
 * User: COMPUTER
 * Date: 4/25/2018
 * Time: 2:11 PM
 */

namespace App\Libraries;


use App\Booking;
use App\BookingItem;
use App\FacilityDay;
use App\Setting;
use Carbon\Carbon;

class CommonClass
{

    /**
     * Booking no will return
     * @return string
     */
    public static function getNextOrderNumber(){
        // Get the last created order
        $lastBooking = Booking::orderBy('booking_no', 'desc')->first();
        if (!$lastBooking)
            // We get here if there is no booking at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        else
            $number = substr($lastBooking->booking_no, 3);

        // If we have LLM000001 in the database then we only want the number
        // So the substr returns this 000001
        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.
        return 'LLM' . sprintf('%06d', intval($number) + 1);
    }

    /**
     * @param $facility_id
     * @param $date
     * @return bool
     */
    public static function checkFacilityBlock($facility_id, $date){

        $dt = new Carbon($date);

        $date = $dt->toDateString();
        $day = $dt->format('l');
        $time = date('H:i:s');

        $booking = BookingItem::where(['facility_id' => $facility_id])
            ->whereDate('date' , $date)
            ->where('payment_status' , 'succeed')
            ->where(function($query){
                $query->where(['status' => 'pending'])->orWhere(['status' => 'accepted']);
            })->first();

        if($booking != null){
            return true;
        }

        $working = FacilityDay::where('day', '=',$day)
            ->whereFacilityId($facility_id)->where('is_closed', '=', 0)->first();

        if($working == null){
            return true;
        }

        if($working != null && $date == date('Y-m-d')){
            if($time > $working->end_time){
                return true;
            }
        }


        return false;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function getSettingValue($key){
        $setting = Setting::whereDataKey($key)->first();
        if($setting != null)
            return $setting->value;

        return false;
    }
}