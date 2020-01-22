<?php

namespace App\Http\Controllers\Yonetim;

use App\Uyeler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class UyeController extends Controller
{
    public function uye_ekle()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required|min:3|max:500', 'mail' => 'required|email']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            } else {
                $resim_adi = NULL;
            }
            $sifre = '123';
            $data = [
                'adsoyad' => str_slug(request('name')),
                'email' => request('mail'),
                'img' => $resim_adi,
                'sifre' => Hash::make($sifre)
            ];
            $ekle = Uyeler::create($data);
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı.',
                'status'    => 'success',
                'pos'       => 'top-right',
                'data'      => $ekle
            ]);
        }
        return view('yonetim.uyeler.uye_ekle');
    }

    public function listele()
    {
        $uyeler = Uyeler::where('rutbeler', 0)->get();
        return view('yonetim.uyeler.listele', compact('uyeler'));
    }

    public function sil()
    {
        if ( request()->isMethod('post') ) {
            $ID = stripcslashes(request('ID'));
            $delete = Uyeler::where('rutbeler', 0)->where('id', $ID)->firstOrfail();
            if ( $delete->img != NULL )
            {
                unlink(public_path('images/'.$delete->img));
            }
            $delete->delete();
            return response()->json(['mesaj_tur' => 'success', 'mesaj' => 'Silindi', 'data' => $delete]);
        } else {
            return back();
        }
    }

    public function yonetici_ekle()
    {
        if ( request()->isMethod('POST') )
        {
            $this->validate(request(), ['name' => 'required|min:3|max:500', 'mail' => 'required|email']);
            if (request()->hasFile('img')) {
                $this->validate(request(), ['img' => 'image|mimes:jpeg,png,gif,jpg,JPEG|max:4096']);
                $resim = request()->file('img');
                $resim_adi = time().'-'.stripcslashes(str_slug(request('name'))).'.'.$resim->extension();
                Image::make($resim->getRealPath())->save(public_path('images/' . $resim_adi));
            } else {
                $resim_adi = NULL;
            }
            $sifre = str_random(6);
            $data = [
                'adsoyad' => request('name'),
                'email' => request('mail'),
                'img' => $resim_adi,
                'sifre' => Hash::make($sifre),
                'rutbeler' => 1,
            ];
            $ekle = Uyeler::create($data);
            $data = [
                'adsoyad' => $ekle->adsoyad,
                'email' => $ekle->email,
                'mesaj' => 'Web sitenizin kullanıcı bilgileri',
                'icerik' => config('app.url').'yonetim'.'<br>'.'Giriş Ayarları:<br>'.'Kullanıcı Adı: '.$ekle->email.'<br>'.'Kullanıcı Şifresi: '.$sifre,
            ];
            Mail::send('yonetim.uyeler.mail', $data, function ($mesaj) use ($data) {
                $mesaj->from(auth()->guard('yonetim')->user()->email);
                $mesaj->to($data['email']);
                $mesaj->subject($data['mesaj']);
            });
            return back()->with([
                'mesaj_tur' => 'message',
                'mesaj'     => 'Ekleme işlemi başarılı. Yöneticinin mail adresine şifre gönderildi',
                'status'    => 'success',
                'pos'       => 'top-right',
                'data'      => $ekle
            ]);
        }
        return view('yonetim.uyeler.yonetici_ekle');
    }

    public function mail()
    {
        return back();
    }

    public function ayarlar()
    {
        $yonetici = Uyeler::where('id', auth()->guard('yonetim')->user()->id)->firstOrFail();
        if ( request()->isMethod('POST') )
        {

            $this->validate(request(), ['name' => 'required|min:3|max:500', 'mail' => 'required|email', 'confirm-password' => 'required|min:6|max:500']);
            if ( request('confirm-password') == request('password') ) {
                $data = [
                    'email' => request('mail'),
                    'adsoyad' => request('name'),
                    'sifre' => request('old-password'),
                    'yeni_sifre' => Hash::make(request('password')),
                    'yeni_sifre_tekrar' => Hash::make(request('confirm-password')),
                ];
                $giris = ['email' => $data['email'], 'password' => $data['sifre'], 'rutbeler' => 1];
                if ( Auth::guard('yonetim')->attempt($giris) ) {
                    $yonetici->update([
                        'email' => $data['email'],
                        'adsoyad' => $data['adsoyad'],
                        'sifre' => $data['yeni_sifre_tekrar'],
                    ]);
                    $send = [
                        'adsoyad' => $yonetici->adsoyad,
                        'email' => $yonetici->email,
                        'mesaj' => 'Web sitenizin kullanıcı bilgileri',
                        'icerik' => config('app.url').'yonetim'.'<br>'.'Giriş Ayarları:<br>'.'Kullanıcı Adı: '.$yonetici->email.'<br>'.'Kullanıcı Şifresi: '.request('confirm-password'),
                    ];
                    Mail::send('yonetim.uyeler.mail', $send, function ($mesaj) use ($send) {
                        $mesaj->from($send['email']);
                        $mesaj->to($send['email']);
                        $mesaj->subject($send['mesaj']);
                    });
                } else {
                    return back()->with([
                        'mesaj_tur' => 'message',
                        'mesaj'     => 'Şifre uyuşmuyor.',
                        'status'    => 'danger',
                        'pos'       => 'top-right',
                    ]);
                }
                return back()->with([
                    'mesaj_tur' => 'message',
                    'mesaj'     => 'Yönetici şifre ayarları güncellendi.',
                    'status'    => 'info',
                    'pos'       => 'top-right',
                ]);
            } else {
                return back()->with([
                    'mesaj_tur' => 'message',
                    'mesaj'     => 'Şifre tekrarı aynı değil.',
                    'status'    => 'danger',
                    'pos'       => 'top-right',
                ]);
            }
        }
        return view('yonetim.uyeler.ayarlar', compact('yonetici'));
    }

    public function yoneticiler()
    {
        $uyeler = Uyeler::where('rutbeler', 1)->get();
        if ( request()->isMethod('POST') ) {

            $yonetici = Uyeler::where('id', auth()->guard('yonetim')->user()->id)->firstOrFail();
            if ( $yonetici->id == 1 ) {
                $ID = stripcslashes(request('ID'));
                $delete = Uyeler::where('id', $ID)->firstOrfail();
                if ( $delete->img != NULL )
                {
                    unlink(public_path('images/'.$delete->img));
                }
                if ( $delete->id != 1 ) {
                    $delete->delete();
                }
                return response()->json(['success' => 'Yönetici başarıyla silindi!.', 'data' => $delete]);
            } else {
                return response()->json(['info' => 'Bu yöneticiyi silme yetkiniz yok!..']);
            }

        }
        return view('yonetim.uyeler.yonetici_listele', compact('uyeler'));
    }
}
