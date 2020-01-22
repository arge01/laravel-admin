<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Referanslar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ReferansController extends Controller
{
    public function kategori()
    {
        $kategoriler = Referanslar::all();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required', 'img' => 'required']);
            $request = request()->all();
            $data = [
            	'name' => stripcslashes($request['name']),
                'slug' => stripcslashes(str_slug($request['name'])),
                'img'  => '',
                'text'  => stripcslashes($request['text']),
            ];
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                Image::make($resim->getRealPath())->fit(700, 525)->save(public_path('images/' . $resim_adi));
                $data['img'] = $resim_adi;
            }
            Referanslar::create($data);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.referans.ekle', compact('kategoriler'));
    }

    public function listele()
    {
        $kategoriler = Referanslar::all();
        return view('yonetim.referans.listele', compact('kategoriler'));
    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['ID' => 'required']);
            $ID = request('ID');
            $delete = Referanslar::where('id', $ID)->firstOrFail();
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        }
        return back();
    }

    public function duzenle($ID)
    {
        $kategoriler = Referanslar::all();
        $gelen = Referanslar::where('id', $ID)->firstOrFail();
        if ( request()->isMethod('post') )
        {
            $this->validate(request(), ['name' => 'required']);
            $data = request()->all();
            $gelen->update(['name' => stripcslashes($data['name']), 'url' => $data['url']]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.referans.duzenle', compact('kategoriler', 'gelen'));
    }
}
