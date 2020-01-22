<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Videolar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function kategori()
    {
        $kategoriler = Videolar::all();
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['url' => 'required', 'name' => 'required']);
            $data = request()->all();
            Videolar::create(['name' => stripcslashes($data['name']), 'url' => $data['url']]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.video.ekle', compact('kategoriler'));
    }

    public function listele()
    {
        $kategoriler = Videolar::all();
        return view('yonetim.video.listele', compact('kategoriler'));
    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['ID' => 'required']);
            $ID = request('ID');
            $delete = Videolar::where('id', $ID)->firstOrFail();
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        }
        return back();
    }

    public function duzenle($ID)
    {
        $kategoriler = Videolar::all();
        $gelen = Videolar::where('id', $ID)->firstOrFail();
        if ( request()->isMethod('post') )
        {
            $this->validate(request(), ['url' => 'required', 'name' => 'required']);
            $data = request()->all();
            $gelen->update(['name' => stripcslashes($data['name']), 'url' => $data['url']]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'info',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.video.duzenle', compact('kategoriler', 'gelen'));
    }
}
