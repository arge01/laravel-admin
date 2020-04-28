<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Ayarlar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AnasayfaController extends Controller
{
    public function anasayfa()
    {
        $ayarlar = Ayarlar::all();
        $keywords = Ayarlar::where('name', 'keywords')->first();
        $keyword = explode(',', $keywords['value']);
        if ( request()->isMethod('POST') ) {
            $this->validate(request(), ['baslik' => 'required', 'description' => 'required']);
            $data = request()->all();
            $data['keywords'] = implode(',', $data['keywords']);
            Ayarlar::where('name', 'baslik')->update(['value' => stripcslashes($data['baslik'])]);
            Ayarlar::where('name', 'description')->update(['value' => stripcslashes($data['description'])]);
            Ayarlar::where('name', 'keywords')->update(['value' => stripcslashes($data['keywords'])]);
            Ayarlar::where('name', 'mail')->update(['value' => stripcslashes($data['mail'])]);
            Ayarlar::where('name', 'tel')->update(['value' => stripcslashes($data['tel'])]);
            Ayarlar::where('name', 'adres')->update(['value' => stripcslashes($data['adres'])]);
            Ayarlar::where('name', 'map')->update(['value' => stripcslashes($data['map'])]);
            Ayarlar::where('name', 'facebook')->update(['value' => stripcslashes($data['facebook'])]);
            Ayarlar::where('name', 'twitter')->update(['value' => stripcslashes($data['twitter'])]);
            Ayarlar::where('name', 'instagram')->update(['value' => stripcslashes($data['instagram'])]);
            Ayarlar::where('name', 'youtube')->update(['value' => stripcslashes($data['youtube'])]);
            request()->has('ssl') ? Ayarlar::where('name', 'ssl')->update(['value' => stripcslashes($data['ssl'])]) : Ayarlar::where('name', 'ssl')->update(['value' => 'off']) ;
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.anasayfa', compact('ayarlar', 'keyword'));
    }
}
