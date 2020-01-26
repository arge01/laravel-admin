<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ConstantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AnasayfaController extends Controller
{
    private $constant;
    private $request;
    private $ayarlar;

    public function __construct(
        ConstantController $constant,
        Request $request)
    {
        $this->constant = $constant;
        $this->request = $request;
        $this->ayarlar = $this->constant->settings(true);
    }

    public function mailgonder()
    {
        if ( request()->isMethod('post') ) {
            $data = $this->request->all();
            
            Mail::send('email.icerik', ['data' => $data], function ($mesaj) use ($data) {
                $mesaj->from($this->request->email);
                $mesaj->to($this->ayarlar["mail"]);
                $mesaj->subject($this->request->message);
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

    public function icerikler($view_name)
    {
        $title = "";
        return view($view_name, compact("title"));
    }

    public function api()
    {
        return response()->json($this->ayarlar);
    }

    public function sitemap()
    {
        $menuler = $this->constant->all_pages();
        $kategoriler = $this->constant->categories();
        $urunler = $this->constant->products();
        $versiyon = '<?xml version="1.0" encoding="utf-8"?>';

        $content = view('sitemap', compact(
            'menuler', 'kategoriler', 'urunler', 'versiyon'
        ));
        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function rss()
    {
        $menuler = $this->constant->all_pages();
        $kategoriler = $this->constant->categories();
        $urunler =$this->constant->products();
        $versiyon = '<?xml version="1.0" encoding="utf-8"?>';
        
        $content = view('rss', compact(
            'menuler', 'kategoriler', 'urunler', 'versiyon'
        ));
        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
    
}
