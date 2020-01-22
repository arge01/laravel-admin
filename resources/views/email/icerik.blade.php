<h1>Web adresi üzerinden, yeni bir mesajınız var.</h1>
<ul>
    <h3>Gönderen</h3>
    <li>Mail Adresi: {{ $data["email"] }}</li>
    <li>Adı Soyadı: {{ $data["name"] }}</li>
    @if(!empty( $data["subject"] ) )
    <li>Konu: {{ $data["subject"] }}</li>
    @endif
</ul>
<br>
@if( $data["franchise"] )
<ul>
    <li><b>FRANCHISE BİLGİLERİ</b></li>
    <li>Telefon Numarası: {{ $data["tel"] }}</li>
    <li>Açılacak Yer: {{ $data["map"] }}</li>
</ul>
@endif
<p>
    <h3>Mesaj içeriği:</h3>
    {{ $data["message"] }}
</p>