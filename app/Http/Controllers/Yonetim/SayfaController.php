<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Galeri;
use App\Models\Sayfalar;
use App\Models\Icerikler;
use JildertMiedema\LaravelPlupload\Facades\Plupload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class SayfaController extends Controller
{
    public function sayfa()
    {
        //Session::forget('resim');
        $input = Input::get('id');
        $sayfalar = Sayfalar::whereRaw('belong is null')->where('content', 0)->get();
        if ( request()->isMethod('POST') )
        {
            //sayfa ekle
            $this->validate(request(), ['belong' => 'required', 'name' => 'required']);
            $data = request()->all();
            //return $data;
            if ( request('alt_menu') == 'evet' ) {
                $sayfa = Sayfalar::create(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name'])), 'belong' => $data['belong']]);
                Icerikler::create(['sayfasi' => $sayfa->id, 'name' => $data['name'], 'icerik' => stripcslashes($data['icerik'])]);
            } else {
                if ($data['belong'] != 0) {
                    $varmi = Sayfalar::where('id', $data['belong'])->with('icerigi')->first();
                    if ($varmi->icerigi == NULL) {
                        Icerikler::create(['sayfasi' => $data['belong'], 'name' => $data['name'], 'icerik' => stripcslashes($data['icerik'])]);
                    } else {
                        return back()->with([
                            'mesaj_tur' => 'message',
                            'mesaj' => 'Ekleme işlemi yapılamadı.',
                            'status' => 'danger',
                            'pos' => 'top-right'
                        ]);
                    }
                } else if ( $data['belong'] == 'menu' ) {
                    $sayfa = Sayfalar::create(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name'])), 'belong' => NULL]);
                    Icerikler::create(['sayfasi' => $sayfa->id, 'name' => $data['name'], 'icerik' => stripcslashes($data['icerik'])]);
                } else {
                    $sayfa = Sayfalar::create(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name'])), 'belong' => $data['belong'], 'link' => 1]);
                    Icerikler::create(['sayfasi' => $sayfa->id, 'name' => $data['name'], 'icerik' => stripcslashes($data['icerik'])]);
                }
            }
            $resimler = session('resim');
            if ( $resimler != NULL ){
                foreach ( $resimler as $i => $resim ) {
                    //galeri ekle
                    Galeri::create([
                        'name' => $resim,
                        'img' => $resim,
                        'sayfa' => $sayfa->id,
                        'proje' => NULL,
                        'urun' => NULL,
                        'data' => $i,
                    ]);
                }
            }
            Session::forget('resim');
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.sayfalar.ekle', compact('sayfalar', 'input'));
    }

    public function listele()
    {
        $sayfalar = Sayfalar::whereRaw('belong is null')->where('link', 0)->get();
        $bagimsizlar = Sayfalar::whereRaw('belong is null')->where('link', 1)->get();
        $icerikler = Icerikler::all();
        return view('yonetim.sayfalar.listele', compact('sayfalar', 'bagimsizlar', 'icerikler'));
    }

    public function duzenle($ID)
    {
        $sayfalar = Sayfalar::whereRaw('belong is null')->where('content', 0)->get();
        $gelen = Icerikler::where('id', $ID)->firstOrFail();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['belong' => 'required', 'name' => 'required']);
            $data = request()->all();
            $gelen->update(['sayfasi' => $data['belong'] ,'name' => stripcslashes($data['name']), 'icerik' => stripcslashes($data['icerik'])]);
            $sayfa = Sayfalar::where('id', $gelen->sayfasi)->first();
            $sayfa->update(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name']))]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.sayfalar.duzenle', compact('sayfalar', 'gelen'));
    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['ID' => 'required']);
            $ID = request('ID');
            $delete = Icerikler::where('id', $ID)->firstOrFail();
            $sayfalar = Sayfalar::where('id', $delete->sayfasi)->first();
            $galerisi = Galeri::where('sayfa', $sayfalar->id)->get();
            foreach ($galerisi as $key => $galeri) {
                $path = public_path('images/'.$galeri->img);
                if (file_exists($path)) {
                    unlink($path);
                }
                $galeri->delete();
            }
            $delete->delete();
            $sayfalar->delete();
            return response()->json(['success' => 'Menü başarıyla silindi!.', 'data' => $delete]);
        }
        return back();
    }
}