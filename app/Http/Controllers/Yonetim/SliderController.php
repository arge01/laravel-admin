<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function slider()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required', 'img' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                $thump = 'thump-' . $resim_adi;
                Image::make($resim->getRealPath())->fit(1920, 1080)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(1024, 768)->save(public_path('images/' . $thump));
            }
            $data = [
                'name'   => stripcslashes(request('name')),
                'slug'   => str_slug(stripcslashes(request('name'))),
                'label'  => stripcslashes(request('label')),
                'link'   => request('linki'),
                'icerik' => stripcslashes(request('icerik')),
                'img'    => $resim_adi
            ];
            if ( request('link_ata') == 'evet' )
            {
                $data['icerik'] = NULL;
            } else {
                $data['link'] = NULL;
            }
            $ekle = Slider::create($data);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right',
                'data'      => $ekle
            ]);
        }
        return view('yonetim.slider.ekle');
    }

    public function listele()
    {
        $sliderlar = Slider::all();
        return view('yonetim.slider.listele', compact('sliderlar'));
    }

    public function duzenle($ID)
    {
        $gelen = Slider::where('id', $ID)->firstORFail();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = $gelen->img;
                $thump = 'thump-' . $resim_adi;
                Image::make($resim->getRealPath())->fit(1920, 1080)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(1024, 768)->save(public_path('images/' . $thump));
            } else {
                $resim_adi = $gelen->img;
            }
            $data = [
                'name'   => stripcslashes(request('name')),
                'slug'   => str_slug(stripcslashes(request('name'))),
                'label'  => stripcslashes(request('label')),
                'link'   => request('linki'),
                'icerik' => stripcslashes(request('icerik')),
                'img'    => $resim_adi
            ];
            if ( request('link_ata') == 'evet' )
            {
                $data['icerik'] = NULL;
            } else {
                $data['link'] = NULL;
            }
            $guncelle = $gelen->update($data);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right',
                'data'      => $guncelle
            ]);
        }
        return view('yonetim.slider.duzenle', compact('gelen'));
    }

    public function sil()
    {
        if ( request()->isMethod('post') ) {
            $ID = request('ID');
            $delete = Slider::where('id', $ID)->firstOrfail();
            $delete->delete();
            $path = public_path('images/'.$delete->img);
            if (file_exists($path)) {
                unlink($path);
            }
            $path = public_path('images/'.'thump-'.$delete->img);
            if (file_exists($path)) {
                unlink($path);
            }
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        } else {
            return back();
        }
    }
}
