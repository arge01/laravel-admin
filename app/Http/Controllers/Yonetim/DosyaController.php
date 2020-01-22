<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class DosyaController extends Controller
{
    public function dosyalar()
    {
        $datalar = collect([]);

        $dizin = public_path('images');
        $uzanti = 'jpg';
        function ext($text)  {
            $text = strtolower(pathinfo($text, PATHINFO_EXTENSION));
            return $text;
        }
        if ($handle = opendir("$dizin") or die ("Dizin acilamadi!")) {
            while (false !== ($file = readdir($handle))) {
                $filetype = ext($file);
                if(is_file($dizin."/".$file) && $filetype == "$uzanti") {
                    $datalar->push($file);
                }
            }
            closedir($handle);
        }

        $dizin = public_path('images');
        $uzanti = 'png';
        function ext2($text)  {
            $text = strtolower(pathinfo($text, PATHINFO_EXTENSION));
            return $text;
        }
        if ($handle = opendir("$dizin") or die ("Dizin acilamadi!")) {
            while (false !== ($file = readdir($handle))) {
                $filetype = ext2($file);
                if(is_file($dizin."/".$file) && $filetype == "$uzanti") {
                    $datalar->push($file);
                }
            }
            closedir($handle);
        }

        $dizin = public_path('images');
        $uzanti = 'jpeg';
        function ext3($text)  {
            $text = strtolower(pathinfo($text, PATHINFO_EXTENSION));
            return $text;
        }
        if ($handle = opendir("$dizin") or die ("Dizin acilamadi!")) {
            while (false !== ($file = readdir($handle))) {
                $filetype = ext3($file);
                if(is_file($dizin."/".$file) && $filetype == "$uzanti") {
                    $datalar->push($file);
                }
            }
            closedir($handle);
        }
        if ( request()->isMethod('POST') )
        {
            $ID = request('ID');
            unlink(public_path('images/'.$ID));
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $ID]);
        }
        return view('yonetim.dosyalar.dosyalar', compact('datalar'));
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
            return redirect()->route('yonetim.dosya.yonetimi')->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Güncelleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right'
            ]);
        }
        return view('yonetim.dosyalar.duzenle', compact('gelen'));
    }

    public function ekstra()
    {
        if ( request()->isMethod('POST') )
        {
            return back();
        }
        return view('yonetim.dosyalar.sunum');
    }
}
