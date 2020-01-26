<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sayfalar;
use App\Models\Icerikler;
use App\Models\Galeri;
use App\Models\Ayarlar;
use App\Models\Projeler;
use App\Models\Kategoriler;
use App\Models\Urunler;
use App\Models\Slider;
use App\Models\Altslider;
use App\Models\Referanslar;

class ConstantController extends Controller
{
    public function settings($pluk=null)
    {
        if ($pluk)
            return Ayarlar::pluck('value', 'name')->all();
        else
            return Ayarlar::all();
    }

    public function get_setting($id)
    {
        return Ayarlar::where('id', $id)->first();
    }

    public function categories()
    {
        return Kategoriler::whereRaw('belong is null')->with('alt_kategorileri')->get();
    }

    public function projects()
    {
        return Urunler::all();
    }

    public function products()
    {
        return Projeler::all();
    }

    public function navbar()
    {
        return Sayfalar::where('visible', 1)->whereRaw('belong is null')
            ->with(array('tablari' => function($query) {
                $query->orderBy('sortable', 'ASC');
            }))->orderBy('sortable', 'ASC')->where('link', 0)
        ->get();
    }

    public function all_pages()
    {
        return Sayfalar::where('visible', 1)->get();
    }

    public function get_content($id)
    {
        return Icerikler::where('id', $id)->where('visible', 1)->first();
    }

    public function slider()
    {
        return Slider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
    }

    public function alt_slider()
    {
        return Altslider::where('visible', 1)->orderBy('sortable', 'ASC')->get();
    }

    public function referances()
    {
        return Referanslar::all();
    }

    public function get_gallery($id)
    {
        return Galeri::where('sayfa', $id)->first();
    }

    public function footer()
    {

    }
}
