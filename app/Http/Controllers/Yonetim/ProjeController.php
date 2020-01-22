<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Galeri;
use Illuminate\Support\Facades\Session;
use App\Models\Kategoriler;
use App\Models\Urunler;
use App\Models\Projeler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ProjeController extends Controller
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
                $thump = 'thump-'.$resim_adi;
                Image::make($resim->getRealPath())->fit(370, 370)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(1920, 1080)->save(public_path('images/resized/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(150, 150)->save(public_path('images/thump/' . $thump));
            }
            if (request()->hasFile('pdf')) {
                $this->validate(request(), ['pdf' => 'mimes:pdf|max:4096']);
                $pdf = request()->file('pdf');
                $pdf_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$pdf->extension();
                request()->file('pdf')->move(
                    base_path() . '/public/pdf/', $pdf_adi
                );
            } else {
                $pdf_adi = NULL;
            }
            $data = [
                'name' => request('name'),
                'slug' => str_slug(request('name')),
                'icerik' => stripcslashes(request('icerik')),
                'label' => stripcslashes(request('label')),
                'img' => $resim_adi,
                'kategori' => NULL,
                'katalog' => $pdf_adi,
            ];
            //return $data;
            $kategori = request('kategori');
            if ( $kategori != NULL ) {
                for ( $i = 0; $i < count($kategori); $i++ ) {
                    $data['kategori'] = $kategori[$i];
                    $ekle = Projeler::create($data);
                }
            } else {
                $ekle = Projeler::create($data);
            }
            $resimler = session('resim');
            if ( $resimler != NULL ){
                foreach ( $resimler as $i => $resim ) {
                    //galeri ekle
                    Galeri::create([
                        'name' => $resim,
                        'img' => $resim,
                        'sayfa' => NULL,
                        'proje' => $ekle->id,
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
                'pos'       => 'top-right',
                'data'      => $ekle
            ]);
        }
        return view('yonetim.proje.ekle', compact('kategoriler'));
    }

    public function api()
    {
        $option = Kategoriler::select('id as id', 'name as title', 'slug as url')->get();
        return response()->json($option);
    }

    public function listele()
    {
        $urunler = Projeler::groupBy()->get();
        return view('yonetim.proje.listele', compact('urunler'));
    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $ID = request('ID');
            $delete = Projeler::where('id', $ID)->firstOrfail();
            $son_resim = Projeler::where('img', $delete->img)->get();
            if ( count($son_resim) <= 1 ) {
                $path = public_path('images/'.$delete->img);
                if (file_exists($path)) {
                    unlink($path);
                }
                $thump_path = public_path('images/thump/thump-'.$delete->img);
                if (file_exists($thump_path)) {
                    unlink($thump_path);
                }
            }
            $proje = Projeler::where('id', $ID)->first();
            $galerisi = Galeri::where('proje', $proje->id)->get();
            foreach ($galerisi as $key => $galeri) {
                $path = public_path('images/'.$galeri->img);
                if (file_exists($path)) {
                    unlink($path);
                }
                $thumpPath = public_path('images/thump-'.$galeri->img);
                if (file_exists($thumpPath)) {
                    unlink($thumpPath);
                }
                $galeri->delete();
            }
            $proje->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        }
        return back();
    }

    public function duzenle($ID)
    {
        $gelen = Projeler::where('id', $ID)->firstOrFail();
        $kategoriler = Kategoriler::whereRaw('belong is null')->get();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required|min:3|max:500']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = $gelen->img;
                $thump = 'thump-'.$resim_adi;
                Image::make($resim->getRealPath())->fit(370, 370)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(1920, 1080)->save(public_path('images/resized/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(150, 150)->save(public_path('images/thump/' . $thump));
            } else {
                $resim_adi = $gelen->img;
            }
            if (request()->hasFile('pdf')) {
                $this->validate(request(), ['pdf' => 'mimes:pdf|max:4096']);
                $pdf_adi = $gelen->katalog;
                request()->file('pdf')->move(
                    base_path() . '/public/pdf/', $pdf_adi
                );
            } else {
                $pdf_adi = $gelen->katalog;
            }
            $data = [
                'name' => request('name'),
                'slug' => str_slug(request('name')),
                'icerik' => stripcslashes(request('icerik')),
                'label' => stripcslashes(request('label')),
                'img' => $resim_adi,
                'kategori' => NULL,
                'katalog' => $pdf_adi,
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
        return view('yonetim.proje.duzenle', compact('kategoriler', 'gelen'));
    }
}
