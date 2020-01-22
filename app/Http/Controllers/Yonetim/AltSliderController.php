<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Altslider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AltSliderController extends Controller
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
                Image::make($resim->getRealPath())->fit(570, 300)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(285, 150)->save(public_path('images/' . $thump));
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
            $ekle = Altslider::create($data);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right',
                'data'      => $ekle
            ]);
        }
        return view('yonetim.altslider.ekle');
    }

    public function listele()
    {
        $sliderlar = Altslider::all();
        return view('yonetim.altslider.listele', compact('sliderlar'));
    }

    public function duzenle($ID)
    {
        $gelen = Altslider::where('id', $ID)->firstORFail();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = $gelen->img;
                $thump = 'thump-' . $resim_adi;
                Image::make($resim->getRealPath())->fit(570, 300)->save(public_path('images/' . $resim_adi));
                Image::make($resim->getRealPath())->fit(285, 150)->save(public_path('images/' . $thump));
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
        return view('yonetim.altslider.duzenle', compact('gelen'));
    }

    public function sil()
    {
        if ( request()->isMethod('post') ) {
            $ID = request('ID');
            $delete = Altslider::where('id', $ID)->firstOrfail();
            $path = public_path('images/'.$delete->img);
            if (file_exists($path)) {
                unlink($path);
            }
            $path = public_path('images/'.'thump-'.$delete->img);
            if (file_exists($path)) {
                unlink($path);
            }
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        } else {
            return back();
        }
    }
}
