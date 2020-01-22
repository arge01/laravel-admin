<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Galeri;
use Illuminate\Support\Facades\Session;
use App\Models\Kategoriler;
use App\Models\Urunler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class UrunController extends Controller
{
    public function urun()
    {
        $kategoriler = Kategoriler::whereRaw('belong is null')->get();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required|min:3|max:500', 'img' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            }
            $data = [
                'name' => request('name'),
                'slug' => str_slug(request('name')),
                'icerik' => stripcslashes(request('icerik')),
                'img' => $resim_adi,
                'kategori' => NULL
            ];

            $kategori = request('kategori');
            if ( $kategori != NULL ) {
                for ( $i = 0; $i < count($kategori); $i++ ) {
                    $data['kategori'] = $kategori[$i];
                    $ekle = Urunler::create($data);
                }
            } else {
                $ekle = Urunler::create($data);
            }
            $resimler = session('resim');
            if ( $resimler != NULL ){
                foreach ( $resimler as $i => $resim ) {
                    //galeri ekle
                    Galeri::create([
                        'name' => $resim,
                        'img' => $resim,
                        'sayfa' => NULL,
                        'proje' => NULL,
                        'urun' => $ekle->id,
                        'data' => $i,
                    ]);
                }
            }
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right',
                'data'      => $ekle
            ]);
        }
        return view('yonetim.urun.ekle', compact('kategoriler'));
    }

    public function api()
    {
        $option = Urunler::select('id as id', 'name as title', 'slug as url')->get();
        return response()->json($option);
    }

    public function listele()
    {
        $urunler = Urunler::groupBy()->get();
        return view('yonetim.urun.listele', compact('urunler'));
    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $ID = request('ID');
            $delete = Urunler::where('id', $ID)->firstOrfail();
            $son_resim = Urunler::where('img', $delete->img)->get();
            if ( count($son_resim) <= 1 ) {
                $path = public_path('images/'.$delete->img);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $urun = Urunler::where('id', $ID)->first();
            $galerisi = Galeri::where('urun', $urun->id)->get();
            foreach ($galerisi as $key => $galeri) {
                $path = public_path('images/'.$galeri->img);
                if (file_exists($path)) {
                    unlink($path);
                }
                $galeri->delete();
            }
            $urun->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        }
        return back();
    }

    public function duzenle($ID)
    {
        $gelen = Urunler::where('id', $ID)->firstOrFail();
        $kategoriler = Kategoriler::whereRaw('belong is null')->get();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required|min:3|max:500']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = $gelen->img;
                Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            } else {
                $resim_adi = $gelen->img;
            }
            $data = [
                'name' => request('name'),
                'slug' => str_slug(request('name')),
                'icerik' => stripcslashes(request('icerik')),
                'img' => $resim_adi,
                'kategori' => NULL
            ];

            $kategori = request('kategori');
            if ( $kategori != NULL ) {
                for ( $i = 0; $i < count($kategori); $i++ ) {
                    $data['kategori'] = $kategori[$i];
                    $guncelle = $gelen->update($data);
                }
            } else {
                $guncelle = $gelen->update($data);
            }
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right',
                'data'      => $guncelle
            ]);
        }
        return view('yonetim.urun.duzenle', compact('kategoriler', 'gelen'));
    }
}
