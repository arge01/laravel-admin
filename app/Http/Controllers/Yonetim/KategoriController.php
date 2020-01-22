<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategoriler;
use App\Models\Urunler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class KategoriController extends Controller
{
    public function kategori()
    {
        $kategoriler = Kategoriler::whereRaw('belong is null')->get();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['belong' => 'required', 'name' => 'required', 'img' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = 'kategori-'.time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                $thump = 'thump-' . $resim_adi;
                Image::make($resim->getRealPath())->fit(532, 368)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(100, 69)->save(public_path('images/' . $thump));
            }
            $data = request()->all();
            if ( $data['belong'] == 0 ) {
                Kategoriler::create([
                    'name' => stripcslashes($data['name']),
                    'slug' => stripcslashes(str_slug($data['name'])),
                    'img'  => $resim_adi,
                ]);
            } else {
                Kategoriler::create([
                    'name'   => stripcslashes($data['name']),
                    'slug'   => stripcslashes(str_slug($data['name'])),
                    'belong' => $data['belong'],
                    'img'    => $resim_adi,
                ]);
            }
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.kategori.ekle', compact('kategoriler'));
    }

    public function listele()
    {
        $id = Input::get('id');
        if ( $id == NULL ) {
            $name = 'Kategoriler';
            $kategoriler = Kategoriler::whereRaw('belong is null')->get();
            return view('yonetim.kategori.listele', compact('kategoriler', 'name'));
        } else {
            $kategori = Kategoriler::where('id', $id)->FirstOrFail();
            $kategoriler = Kategoriler::where('belong', $kategori->id)->get();
            $name = $kategori->name.' '.'Alt Kategorileri';
            return view('yonetim.kategori.listele', compact('kategoriler', 'name'));
        }

    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['ID' => 'required']);
            $ID = request('ID');
            $delete = Kategoriler::where('id', $ID)->firstOrFail();
            $delete_urunler = Urunler::where('kategori', $ID);
            if ( $delete->belong > 0 ) {
                $delete->delete();
                $delete_urunler->delete();
            } else {
                for ( $i = 0; $i < count($delete->alt_kategorileri); $i++ ) {
                    Urunler::where('kategori', $delete->alt_kategorileri[$i]->id)->delete();
                    $delete->alt_kategorileri[$i]->delete();
                }
                $path = public_path('images/'.$delete->img);
                if (file_exists($path)) {
                    unlink($path);
                }
                $thump_path = public_path('images/'.'thump-'.$delete->img);
                if (file_exists($thump_path)) {
                    unlink($thump_path);
                }
                $delete->delete();
                $delete_urunler->delete();
            }
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        }
        return back();
    }

    public function duzenle($ID)
    {
        $kategoriler = Kategoriler::whereRaw('belong is null')->get();
        $gelen = Kategoriler::where('id', $ID)->firstOrFail();
        if ( request()->isMethod('post') )
        {
            $this->validate(request(), ['belong' => 'required', 'name' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                $thump = 'thump-' . $resim_adi;
                Image::make($resim->getRealPath())->fit(532, 368)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(100, 69)->save(public_path('images/' . $thump));
            } else {
                $resim_adi = $gelen->img;
            }
            $data = request()->all();
            if ( $data['belong'] == 0 ) {
                $gelen->update([
                    'name'   => stripcslashes($data['name']),
                    'slug'   => stripcslashes(str_slug($data['name'])),
                    'belong' => NULL,
                    'img'    => $resim_adi,
                ]);
            } else {
                $gelen->update([
                    'name'   => stripcslashes($data['name']),
                    'slug'   => stripcslashes(str_slug($data['name'])),
                    'belong' => $data['belong'],
                    'img'    => $resim_adi,
                ]);
            }
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.kategori.duzenle', compact('kategoriler', 'gelen'));
    }
    public function api()
    {
        $option = Kategoriler::select('id as id', 'name as title', 'slug as url')->get();
        return response()->json($option);
    }
}
