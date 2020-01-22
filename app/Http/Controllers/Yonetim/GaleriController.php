<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Galeri;
use App\Models\Projeler;
use App\Models\Sayfalar;
use App\Models\Urunler;
use foo\bar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class GaleriController extends Controller
{
    public function ekle()
    {
        $input = Input::get('data');
        if ( $input == 'sayfa' ){
            $data = Sayfalar::where('visible', 1)->where('content', 0)->get();
        } else if ( $input == 'proje' ) {
            $data = Projeler::where('visible', 1)->get();
        } else if ( $input == 'urun' ) {
            $data = Urunler::where('visible', 1)->get();
        }
        $key = Input::get('key');
        //return $key;
        if ( request()->isMethod('POST') ){
            $data = request();
            $jsonData = response()->json($data);
            $resim = request()->file('file');
            $resim_adi = $resim->hashName();
            $thump = 'thump-'.$resim_adi;
            Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            Image::make($resim->getRealPath())->fit(327, 327)->save(public_path('images/' . $thump));
            Galeri::create([
                'name'  => $resim_adi,
                'img'   => $resim_adi,
                'sayfa' => $data->sayfa,
                'proje' => $data->proje,
                'urun'  => $data->urun,
                'data'   => $jsonData,
            ]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right',
                'data'      => $resim
            ]);
        }
        return view('yonetim.galeri.ekle', compact( 'input', 'key', 'data'));
    }

    public function listele()
    {
        $data = stripcslashes(Input::get('data'));
        $bagimsizlar = Galeri::where('visible', 1)->whereRaw('urun is null')->whereRaw('proje is null')->whereRaw('sayfa is null')->orderBy('sortable', 'ASC')->get();
        $sayfalar = Sayfalar::with(array('galerisi' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $projeler = Projeler::with(array('galerisi' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        $urunler = Urunler::with(array('galerisi' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        if ( $data == NULL ) {
            return view('yonetim.galeri.listele', compact('bagimsizlar', 'sayfalar', 'projeler', 'urunler'));
        } else {
            $key = stripcslashes(Input::get('key'));
            $galeriler = Galeri::where($data, $key)->OrderBy('sortable', 'ASC')->get();
            //return $galeriler;
            return view('yonetim.galeri.tekliste', compact('galeriler', 'key', 'data'));
        }
    }
    public function sil()
    {
        if ( request()->isMethod('post') ) {
            $ID = request('ID');
            $delete = Galeri::where('id', $ID)->firstOrfail();
            $path = public_path('images/'.$delete->img);
            if (file_exists($path)) {
                unlink($path);
            }
            $thumpPath = public_path('images/thump-'.$delete->img);
            if (file_exists($thumpPath)) {
                unlink($thumpPath);
            }
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        } else {
            return back();
        }
    }
    public function sortable()
    {
        if ( request()->isMethod('POST') )
        {
            $data = request()->all();
            if ( $data['id'] != NULL )
            {
                $INtable = Galeri::where('id', $data['id'])->first();
                $guncelle = $INtable->update(['sortable' => $data['sortable']]);
                return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
            }
        }
        return back();
    }
    public function duzenle($gelen)
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['img' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = $gelen;
                Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            } else {
                $resim_adi = $gelen;
            }
            return redirect()->route('yonetim.galeri.listele')->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.galeri.duzenle', compact('gelen'));
    }
    public function session_al()
    {
        if ( request()->isMethod('POST') )
        {
            $resim = request()->file('file');
            $resim_adi = $resim->hashName();
            $thump = 'thump-'.$resim_adi;
            Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            Image::make($resim->getRealPath())->fit(327, 327)->save(public_path('images/' . $thump));
            //Session::forget('resim');
            Session::push(
                'resim', $resim_adi
            );
            return 'true';
        }
        return back();
    }
}
