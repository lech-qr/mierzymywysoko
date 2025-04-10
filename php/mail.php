<?php

    $geo_imie 	= $_POST["geo_imie"];
    $geo_tel 	= $_POST["geo_tel"];
    $geo_mail 	= $_POST["geo_mail"];
    $geo_tresc 	= $_POST["geo_tresc"];

    $nadawca        =       'formularz@serwer044295.home.pl';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: ' .$nadawca . "\r\n" .
                'BCC: hugo@czuby.net';

    $title = 'Formularz - mierzymywysoko.com';
    
    $message = <<<EOD

<!DOCTYPE html>
<html>
<head>
<title>Formularz - mierzymywysoko.com</title>
</head>

<body style="width: 800px; display: block; margin: 0 auto;">
            
    <p style="font-size: 120%; font-weight: bold; text-align: center;">Formularz kontaktowy z mierzymywysoko.com:</p>        
            
    <dl style="line-height: 1.6em;">
        <dt style="display: inline; margin: 0; font-weight: bold; width: 30%; float: left;">Imię i nazwisko:</dt><dd style="display: inline; margin: 0; width: 70%; float: left;">$geo_imie</dd>
        <dt style="display: inline; margin: 0; font-weight: bold; width: 30%; float: left;">Telefon:</dt><dd style="display: inline; margin: 0; width: 70%; float: left;">$geo_tel</dd>
        <dt style="display: inline; margin: 0; font-weight: bold; width: 30%; float: left;">Email:</dt><dd style="display: inline; margin: 0; width: 70%; float: left;">$geo_mail</dd>
        <dt style="display: inline; margin: 0; font-weight: bold; width: 30%; float: left;">Wiadomość:</dt><dd style="display: inline; margin: 0; width: 70%; float: left;">$geo_tresc</dd>
    </dl>
            
</body>

</html>            
                
EOD;
        
// if (strlen($geo_imie) == 0  || $_POST['fax'] != 'Nr faxu') {
if (!empty($_POST['fax'])) {
    
        echo ("<script language='JavaScript'>
	    window.alert('Co\u015b posz\u0142o nie tak. Spr\u00f3buj ponownie.')
	    window.location.href='http://mierzymywysoko.com/#kontakt';
	    </script>");
    
}
else {
    
    mail( 'biuro@mierzymywysoko.com', $title, $message, $headers);

        echo ("<script language='JavaScript'>
	    window.alert('Formularz zosta\u0142 wys\u0142any. Dzi\u0119kujemy!')
	    window.location.href='http://mierzymywysoko.com/#kontakt';
	    </script>");

}
