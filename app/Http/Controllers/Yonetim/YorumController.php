<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Yorumlar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YorumController extends Controller
{
    public function ekle()
    {
        $dd = Yorumlar::all();
        if ( request()->isMethod('POST') )
        {
            $data = request()->all();
            Yorumlar::create($data);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.yorum.ekle', compact('dd'));
    }

    public function listele()
    {
        $dd = Yorumlar::all();
        return view('yonetim.yorum.listele', compact('dd'));
    }

    public function sil()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['ID' => 'required']);
            $ID = request('ID');
            $delete = Yorumlar::where('id', $ID)->firstOrFail();
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        }
        return back();
    }

    public function duzenle($ID)
    {
        $gelen = Yorumlar::where('id', $ID)->firstOrFail();
        if ( $gelen->visible == 0 ) {
            $gelen->update(['visible' => 1]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj' => 'Onay verildi.',
                'status' => 'info',
                'pos' => 'top-right'
            ]);
        } else {
            $gelen->update(['visible' => 0]);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj' => 'Onay kaldırıldı.',
                'status' => 'danger',
                'pos' => 'top-right'
            ]);
        }
    }
}
