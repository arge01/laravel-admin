<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Sayfalar;
use App\Models\Slider;
use App\Models\Urunler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GorunumController extends Controller
{
    public function sayfalar()
    {
        $data = Sayfalar::all();
        if ( request()->isMethod('POST') )
        {
            $Pdata = request()->all();
            $data = $Pdata['data'];
            for ($i = 0; count($data) > $i; $i++) {
                $INtable = Sayfalar::where('id', $data[$i]['id'])->first();
                $guncelle = $INtable->update(['visible' => $data[$i]['check']]);
            }
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.gorunum.sayfalar', compact('data'));
    }

    public function urunler()
    {
        $data = Urunler::all();
        if ( request()->isMethod('POST') )
        {
            $Pdata = request()->all();
            $data = $Pdata['data'];
            for ($i = 0; count($data) > $i; $i++) {
                $INtable = Urunler::where('id', $data[$i]['id'])->first();
                $guncelle = $INtable->update(['visible' => $data[$i]['check']]);
            }
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.gorunum.urunler', compact('data'));
    }

    public function slider()
    {
        $data = Slider::all();
        if ( request()->isMethod('POST') )
        {
            $Pdata = request()->all();
            $data = $Pdata['data'];
            for ($i = 0; count($data) > $i; $i++) {
                $INtable = Slider::where('id', $data[$i]['id'])->first();
                $guncelle = $INtable->update(['visible' => $data[$i]['check']]);
            }
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.gorunum.slider', compact('data'));
    }
}
