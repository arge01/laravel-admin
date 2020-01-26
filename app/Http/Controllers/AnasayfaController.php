<?php

namespace App\Http\Controllers;

use App\Models\Altslider;
use App\Models\Ayarlar;
use App\Models\Galeri;
use App\Models\Kategoriler;
use App\Models\Projeler;
use App\Models\Referanslar;
use App\Models\Sayfalar;
use App\Models\Slider;
use App\Models\Urunler;
use App\Models\Yorumlar;
use App\Models\Iller;
use App\Models\Ilceler;
use App\Models\Icerikler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AnasayfaController extends Controller
{
    public function mailgonder(Request $request){
        $ayarlar = Ayarlar::where('id', 6)->first();
        if ( request()->isMethod('post') ) {
            
            $ayarlar = Ayarlar::where('id', 6)->first();
            $data = $request->all();
            
            Mail::send('email.icerik', ['data' => $data], function ($mesaj) use ($data ,$ayarlar, $request) {
                $mesaj->from($request->email);
                $mesaj->to($ayarlar->value);
                $mesaj->subject($request->message);
            });
            
            return response()->json(['success' => 'Mesajınız bize ulaştı en kısa zamanda cevap gelecektir!', 'data' => $data]);
        }
        return back();
    }

    public function anasayfa()
    {
        $title = "";
        return view('anasayfa', compact("title"));
    }

    public function get_view($view_name)
    {
        $title = "";
        return view($view_name, compact("title"));
    }

    public function api()
    {
        $data = Ayarlar::pluck('value', 'name')->all();
        return response()->json($data);
    }

    public function sitemap()
    {
        $menuler = Sayfalar::where('visible', 1)->get();
        $kategoriler = Kategoriler::whereRaw('belong is null')->with('alt_kategorileri')->get();
        $urunler = Projeler::all();
        $versiyon = '<?xml version="1.0" encoding="utf-8"?>';

        $content = view('sitemap', compact('menuler', 'kategoriler', 'urunler', 'versiyon'));
        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function rss()
    {
        $menuler = Sayfalar::where('visible', 1)->get();
        $kategoriler = Kategoriler::whereRaw('belong is null')->with('alt_kategorileri')->get();
        $urunler = Projeler::all();
        $versiyon = '<?xml version="1.0" encoding="utf-8"?>';

        $content = view('rss', compact('menuler', 'kategoriler', 'urunler', 'versiyon'));
        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
    
}
