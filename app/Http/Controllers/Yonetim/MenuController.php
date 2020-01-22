<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategoriler;
use App\Models\Projeler;
use App\Models\Sayfalar;
use App\Models\Urunler;
use App\Models\Icerikler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MenuController extends Controller
{
    public function menu()
    {
        $kategoriler = Sayfalar::whereRaw('belong is null')->where('content', 0)->get();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['belong' => 'required', 'name' => 'required']);
            $data = request()->all();
            if ( $data['belong'] == 0 ) {
                Sayfalar::create(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name']))]);
            } else {
                Sayfalar::create(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name'])), 'belong' => $data['belong']]);
            }
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.menu.ekle', compact('kategoriler'));
    }
    public function listele()
    {
        $id = Input::get('id');
        if ( $id == NULL ) {
            $name = 'Menüler';
            $kategoriler = Sayfalar::whereRaw('belong is null')->with('icerigi')->get();
            return view('yonetim.menu.listele', compact('kategoriler', 'name'));
        } else {
            $kategori = Sayfalar::where('id', $id)->FirstOrFail();
            $kategoriler = Sayfalar::where('belong', $kategori->id)->with('icerigi')->get();
            $name = $kategori->name.' '.'Alt Menüleri';
            return view('yonetim.menu.listele', compact('kategoriler', 'name'));
        }
    }
    public function duzenle($ID)
    {
        $kategoriler = Sayfalar::whereRaw('belong is null')->get();
        $gelen = Sayfalar::where('id', $ID)->firstOrFail();
        if ( request()->isMethod('post') )
        {
            $this->validate(request(), ['belong' => 'required', 'name' => 'required']);
            $data = request()->all();
            if ( $data['belong'] == 0 ) {
                $gelen->update(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name'])), 'belong' => NULL]);
            } else {
                $gelen->update(['name' => stripcslashes($data['name']), 'slug' => stripcslashes(str_slug($data['name'])), 'belong' => $data['belong']]);
            }
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.menu.duzenle', compact('kategoriler', 'gelen'));
    }
    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['ID' => 'required']);
            $ID = request('ID');
            $delete = Sayfalar::where('id', $ID)->first();
            $icerik = Icerikler::where('sayfasi', $delete->id)->first();
            $galerisi = NULL;
            if ( $delete->content == 0 ) {
                if ($galerisi != NULL) {
                    foreach ($galerisi as $key => $galeri) {
                        $path = public_path('images/'.$delete->img);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                        $galeri->delete();
                    }
                }
                if ($icerik != NULL) {
                    $icerik->delete();
                }
                if (count($delete->tablari) > 0) {
                    for ($i = 0; $i < count($delete->tablari); $i++) {
                        if ($delete->tablari[$i]->icerigi != NULL) {
                            $delete->tablari[$i]->icerigi->delete();
                        }
                        $delete->tablari[$i]->delete();
                    }
                    if ($icerik != NULL) {
                        $icerik->delete();
                    }
                    $delete->delete();
                }
                $delete->delete();
                return response()->json(['success' => 'Menü başarıyla silindi!.', 'data' => $delete]);
            } else {
                return response()->json(['info' => 'Bu menüyü silemezsiniz! İçerik ilişkisi bulunmamakta.']);
            }
        }
        return back();
    }
    public function api()
    {
        $input = Input::get('data');
        if ( $input == NULL ) {
            $veriler = Sayfalar::all();
            $data = collect();
            foreach ($veriler as $i => $veri)
            {
                if ( $veri->sahibi == NULL ) {
                    $data->push([
                        'id' => $veri->id,
                        'title' => $veri->name,
                        'url' => $veri->slug,
                    ]);
                } else {
                    $data->push([
                        'id' => $veri->id,
                        'title' => $veri->sahibi->name.' / '.$veri->name,
                        'url' => $veri->slug,
                    ]);
                }
            }
            return response()->json($data);
        } else if ( $input == 'kategori' ) {
            $data = Kategoriler::select('id as id', 'name as title', 'slug as url')->get();
            return response()->json($data);
        } else if ( $input == 'proje') {
            $data = Projeler::select('id as id', 'name as title', 'slug as url')->get();
            return response()->json($data);
        } else if ( $input == 'urun' ) {
            $data = Urunler::select('id as id', 'name as title', 'slug as url')->get();
            return response()->json($data);
        } else {
            $veriler = Sayfalar::all();
            $data = collect();
            foreach ($veriler as $i => $veri)
            {
                if ( $veri->sahibi == NULL ) {
                    $data->push([
                        'id' => config('app.url').$veri->slug.'.html',
                        'title' => $veri->name,
                        'url' => $veri->slug,
                    ]);
                } else {
                    $data->push([
                        'id' => config('app.url').$veri->slug.'.html#'.$veri->sahibi->slug,
                        'title' => $veri->sahibi->name.' / '.$veri->name,
                        'url' => $veri->slug,
                    ]);
                }
            }
            return response()->json($data);
        }
    }
    public function iliski()
    {
        $input = Input::get('data');
        if ( $input == NULL ) {
            $neyle = 'yok';
        } else if ( $input == 'kategori' ) {
            $neyle = 'kategori';
        } else if ( $input == 'proje') {
            $neyle = 'proje';
        } else if ( $input == 'urun' ) {
            $neyle = 'urun';
        } else if ( $input == 'menu' ) {
            $neyle = 'menu';
        } else {
            $neyle = 'menu';
        }
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['menu' => 'required', 'url' => 'required', 'neyle' => 'required']);
            if ( request('iliskilendir') == 'on' ) {
                $data = request()->all();
                $neyle = $data['neyle'];
                $update = Sayfalar::where('id', $data['menu'])->firstOrFail();
                //return $data['target'];
                if ( $neyle == 'menu' ) {
                    $data['url'] = request('url');
                    $update->update(['url' => $data['url'], 'target' => $data['target'],]);
                } else if ( $neyle == 'yok' ) {
                    $data['url'] = request('url');
                    $update->update(['url' => $data['url'], 'target' => $data['target'],]);
                } else if ( $neyle == 'kategori' ) {
                    $veri = Kategoriler::where('id', $data['url'])->first();
                    $data['url'] = config('app.url').'kategoriler/'.$veri->slug;
                    $update->update(['url' => $data['url'], 'target' => $data['target'],]);
                } else if ( $neyle == 'proje' ) {
                    $veri = Projeler::where('id', $data['url'])->first();
                    $data['url'] = config('app.url').'proje/'.$veri->slug;
                    $update->update(['url' => $data['url'], 'target' => $data['target'],]);
                } else if ( $neyle == 'urun' ) {
                    $veri = Urunler::where('id', $data['url'])->first();
                    $data['url'] = config('app.url').'urun/'.$veri->slug;
                    $update->update(['url' => $data['url'], 'target' => $data['target'],]);
                }
                return back()->with([
                    'mesaj_tur' => 'message',
                    'mesaj'     => 'İlişkilendirme işlemi başarılı.',
                    'status'    => 'success',
                    'pos'       => 'top-right'
                ]);
            }
        }
        return view('yonetim.menu.iliski', compact('input', 'neyle'));
    }
}
