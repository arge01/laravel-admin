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
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
        ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 2)->where('visible', 1)->first();
        if ($hakkimizda == NULL) {
            $hakkimizda = new Icerikler();
        }
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $alt_slider = Altslider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $yeni_urun = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')
            ->with(array('galerisi' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))
            ->first();
        if ( $yeni_urun == NULL ) {
            $yeni_urun = new Projeler();
        }
        $kurumsal = Icerikler::where('id', 1)->where('visible', 1)->first();
        if ($kurumsal == NULL) {
            $kurumsal = new Icerikler();
        }
        $kurumsalIMG = Galeri::where('sayfa', $kurumsal->sayfasi)->first();
        if ($kurumsalIMG  == NULL) {
            $kurumsalIMG  = new Galeri();
        }
        $vizyon = Icerikler::where('id', 3)->where('visible', 1)->first();
        if ($vizyon == NULL) {
            $vizyon = new Icerikler();
        }
        $misyon = Icerikler::where('id', 4)->where('visible', 1)->first();
        if ($misyon == NULL) {
            $misyon = new Icerikler();
        }
        $galeri = Galeri::where('sayfa', null)->where('proje', null)->where('urun', null)->orderBy('sortable', 'ASC')->get();
        return view('anasayfa', compact('alt_slider', 'galeri', 'kurumsalIMG' ,'yeni_urun' ,'vizyon','misyon' ,'kurumsal' ,'slider', 'menuler', 'projeler', 'referanslar', 'kategoriler', 'hakkimizda'));
    }

    public function proje($slug)
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Projeler::where('visible', 1)->where('slug', $slug)
            ->with(array('galerisi' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))
            ->firstOrFail();
        $gelenKategori = Kategoriler::where('visible', 1)->where('id', $gelen->kategorisi->id)->first();

        $sonraki = Projeler::where('visible', 1)->where('kategori', $gelen->kategori)->where('id', '<', $gelen->id)->orderBy('id', 'DESC')->first();
        $onceki = Projeler::where('visible', 1)->where('kategori', $gelen->kategori)->where('id', '>', $gelen->id)->orderBy('id', 'ASC')->first();
        return view('proje', compact('sonraki', 'hakkimizda' ,'projeler' ,'onceki', 'alt_slider', 'slider', 'menuler', 'referanslar', 'anasayfa', 'gelen', 'kategoriler', 'gelenKategori'));
    }

    public function projeler()
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        #sabitler

        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->get();
        return view('projeler', compact('alt_slider', 'kategoriler', 'hakkimizda' ,'projeler' ,'slider', 'menuler', 'referanslar', 'anasayfa', 'projeler'));

    }

    public function kategori($slug)
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        #sabitler

        $gelen = Kategoriler::where('visible', 1)->where('slug', $slug)->firstOrFail();
        $projeler = Projeler::where('visible', 1)->where('kategori', $gelen->id)->orderBy('sortable', 'ASC')->get();
        return view('kategoriler', compact('gelen', 'hakkimizda', 'kategoriler', 'slider', 'menuler', 'referanslar', 'anasayfa', 'projeler'));

    }

    public function icerik($slug)
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Sayfalar::where('visible', 1)->with('icerigi')->where('slug', $slug)
            ->with(array('galerisi' => function($query){
                $query->orderBy('sortable', 'ASC');
            }))
            ->firstOrFail();
        $alt_icerik = Sayfalar::where('belong', $gelen->id)->with('icerigi')->orderBy('sortable', 'ASC')->get();
        
        //return count($gelen->galerisi);
        
        //return $gelen;

        if ( $gelen->belong == 5 )
        {
            return view('new-menu', compact('alt_slider',
            'slider',
            'kategoriler',
            'menuler',
            'referanslar',
            'hakkimizda',
            'projeler',
            'gelen',
            'alt_icerik'));
        } else {
            return view('icerik', compact('alt_slider',
            'slider',
            'kategoriler',
            'menuler',
            'referanslar',
            'hakkimizda',
            'projeler',
            'gelen',
            'alt_icerik'));
        }
    }

    public function deneme()
    {
        return "deneme";
    }

    public function franchise(Request $request)
    {
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
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Sayfalar::where('visible', 1)->with('icerigi')->where('slug', 'franchise')
            ->with(array('galerisi' => function($query){
                $query->orderBy('sortable', 'ASC');
            }))
            ->firstOrFail();
        $alt_icerik = Sayfalar::where('belong', $gelen->id)->with('icerigi')->orderBy('sortable', 'ASC')->get();
        return view('franchise', compact('alt_slider', 'slider', 'kategoriler', 'menuler', 'referanslar', 'hakkimizda', 'projeler', 'gelen', 'alt_icerik'));
    }

    public function menuler()
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Sayfalar::where('visible', 1)->with('icerigi')->where('slug', 'menuler')
            ->with(array('galerisi' => function($query){
                $query->orderBy('sortable', 'ASC');
            }))
            ->firstOrFail();
        $alt_icerik = Sayfalar::where('belong', $gelen->id)->with('icerigi')->orderBy('sortable', 'ASC')->get();
        return view('menu', compact('alt_slider', 'slider', 'kategoriler', 'menuler', 'referanslar', 'hakkimizda', 'projeler', 'gelen', 'alt_icerik'));
    }

    public function menu($slug)
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Sayfalar::where('visible', 1)->with('icerigi')->where('slug', $slug)
            ->with(array('galerisi' => function($query){
                $query->orderBy('sortable', 'ASC');
            }))
            ->firstOrFail();
        $alt_icerik = Sayfalar::where('belong', $gelen->id)->with('icerigi')->orderBy('sortable', 'ASC')->get();
        return view('menuler', compact('alt_slider', 'slider', 'kategoriler', 'menuler', 'referanslar', 'hakkimizda', 'projeler', 'gelen', 'alt_icerik'));
    }

    public function iletisim()
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler
        
        $lojistik = Icerikler::find(78)->icerik;

        return view('iletisim', compact('hakkimizda', 'projeler' ,'slider', 'menuler', 'referanslar', 'kategoriler', 'lojistik'));
    }

    public function referanslar()
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Sayfalar::where('visible', 1)->with('icerigi')->where('slug', 'subeler')
            ->with(array('galerisi' => function($query){
                $query->orderBy('sortable', 'ASC');
            }))
            ->firstOrFail();
        $iller = Iller::with('ilceleri')->orderBy('baslik', 'ASC')->get();
        //return $iller;
        
        $ililcegetir = $this->__ililcegetir(null,null);

        $yorumlar = Yorumlar::where('visible', 1)->get();
        //return $gelen->tablari[0]->icerigi;
        return view('referanslar', compact('iller', 'ililcegetir' ,'hakkimizda', 'gelen' ,'yorumlar' ,'projeler' ,'slider', 'menuler', 'referanslar', 'anasayfa', 'kategoriler'));
    }
    
    public function __ililcegetir($il,$ilce)
    {
        if ( $il && $ilce ){
            $__il = 12;
            $__ilce = 222;
            return "$__il / $__ilce";
        }
    }
    
    public static function ililcegetir($il,$ilce)
    {
        $__il = Iller::find($il)->baslik;
        $__ilce = Ilceler::find($ilce)->baslik;
        return "$__il / $__ilce";
    }

    public function city(Request $request)
    {
        $iller = Iller::with('ilceleri')->with('subeleri')->get();
        if ( request()->isMethod('POST') ){ 
            $ilceler = Ilceler::where('il_id', $request->data)->with('subeleri')->orderBy('baslik', 'ASC')->get();
            return  response()->json( $ilceler );
        }
        return  response()->json( $iller );
    }

    public function branch(Request $request)
    {
        if ( request()->isMethod('POST') ){
            $subeler = Icerikler::where('il', $request->il)->where('ilce', $request->ilce)->with('sayfa')->get();
            return response()->json($subeler);
        }
        return back();
    }

    public function banner($slug)
    {
        #sabitler
        $slider = Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
        $menuler = Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
            ->get();
        $referanslar = Referanslar::all();
        $kategoriler = Kategoriler::where('visible', 1)->whereRaw('belong is null')->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $hakkimizda = Icerikler::where('id', 1)->where('visible', 1)->first();
        $projeler = Projeler::where('visible', 1)->orderBy('sortable', 'ASC')->groupBy('slug')->paginate(5);
        #sabitler

        $gelen = Altslider::where('visible', 1)->where('slug', $slug)->firstOrFail();
        return view('proje', compact('projeler', 'hakkimizda' ,'slider', 'menuler', 'kategoriler', 'referanslar', 'anasayfa', 'gelen'));
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
