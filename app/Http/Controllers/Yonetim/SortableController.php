<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategoriler;
use App\Models\Projeler;
use App\Models\Sayfalar;
use App\Models\Slider;
use App\Models\Urunler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SortableController extends Controller
{
    public function sayfalar()
    {
        $data = Sayfalar::whereRaw('belong is null')->with(array('tablari' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->orderBy('sortable', 'ASC')->get();
        if ( request()->isMethod('POST') )
        {
            $data = request()->all();
            $INtable = Sayfalar::where('id', $data['id'])->first();
            $guncelle = $INtable->update(['sortable' => $data['sortable']]);
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.sortable.sayfalar', compact('data'));
    }

    public function urunler()
    {
        $urunler = Projeler::whereRaw('kategori is null')->orderBy('sortable', 'ASC')->get();
        $data = Kategoriler::with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        //return $data;
        if ( request()->isMethod('POST') )
        {
            $data = request()->all();
            $INtable = Projeler::where('id', $data['id'])->first();
            $guncelle = $INtable->update(['sortable' => $data['sortable']]);
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.sortable.urunler', compact('data', 'urunler'));
    }

    public function sec()
    {
        $id = Input::get('id');
        if ( $id == NULL ) {
            $name = 'Kategoriler';
            $kategoriler = Kategoriler::whereRaw('belong is null')->get();
            return view('yonetim.sortable.sec', compact('kategoriler', 'name'));
        } else {
            $kategori = Kategoriler::where('id', $id)->FirstOrFail();
            $kategoriler = Kategoriler::where('belong', $kategori->id)->get();
            $name = $kategori->name.' '.'Alt Kategorileri';
            return view('yonetim.sortable.sec', compact('kategoriler', 'name'));
        }
    }

    public function secilen($id)
    {
        $data = Kategoriler::where('id', $id)->with(array('projeler' => function($query) {
            $query->orderBy('sortable', 'ASC');
        }))->get();
        //return $data;
        if ( request()->isMethod('POST') )
        {
            $data = request()->all();
            $INtable = Projeler::where('id', $data['id'])->first();
            $guncelle = $INtable->update(['sortable' => $data['sortable']]);
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.sortable.getir', compact('data', 'id'));
    }

    public function slider()
    {
        $data = Slider::orderBy('sortable', 'ASC')->get();
        if ( request()->isMethod('POST') )
        {
            $data = request()->all();
            $INtable = Slider::where('id', $data['id'])->first();
            $guncelle = $INtable->update(['sortable' => $data['sortable']]);
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Güncellendi', 'data' => $guncelle]);
        }
        return view('yonetim.sortable.slider', compact('data'));
    }
}
