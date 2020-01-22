<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Takvim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TakvimController extends Controller
{
    public function takvim()
    {
        function month($month){
            if ( $month == "Jan" ) {
                return "01";
            } elseif ( $month == "Feb" ) {
                return "02";
            } elseif ( $month == "Mar" ) {
                return "03";
            } elseif ( $month == "Apr" ) {
                return "04";
            } elseif ( $month == "May" ) {
                return "05";
            } elseif ( $month == "Jun" ) {
                return "06";
            } elseif ( $month == "Jul" ) {
                return "07";
            } elseif ( $month == "Aug" ) {
                return "08";
            } elseif ( $month == "Sep" ) {
                return "09";
            } elseif ( $month == "Oct" ) {
                return "10";
            } elseif ( $month == "Nov" ) {
                return "11";
            } elseif ( $month == "Dec" ) {
                return "12";
            }
        }
        if ( request()->isMethod('POST') )
        {
            $data = request('data');
            $end = $data[0]['end'];
            $start = $data[0]['start'];
            $newData = [
                'title' => $data[0]["title"],
                'color' => $data[0]["color"],
                'year' => NULL,
                'startmonth' => NULL,
                'startday' => NULL,
                'starthour' => NULL,
                'endmonth' => NULL,
                'endday' => NULL,
                'endhour' => NULL,
            ];
            $start = explode(' ', $start);
            $end = explode(' ', $end);
            //günler
            $newData['startday'] = $start[2];
            $newData['endday'] = $end[2];
            //aylar
            $newData['startmonth'] = month($start[1]);
            $newData['endmonth'] = month($end[1]);
            //hour
            $newData['starthour'] = $start[4];
            $newData['endhour'] = $end[4];
            //year
            $newData['year'] = $start[3];

            $ekle = Takvim::create($newData);
            return $ekle;
        }
        $takvimler = Takvim::all();
        return view('yonetim.takvim.takvim', compact('takvimler'));
    }

    public function api()
    {
        $takvim = Takvim::all();
        return response()->json($takvim);
    }

    public function sil()
    {
        if ( request()->isMethod('post') ) {
            $ID = request('ID');
            $delete = Takvim::where('id', $ID)->firstOrfail();
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        } else {
            return back();
        }
    }
}
