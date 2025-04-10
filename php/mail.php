<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pobieranie i filtrowanie danych z formularza
    $imie = filter_input(INPUT_POST, "geo_imie", FILTER_SANITIZE_STRING);
    $telefon = filter_input(INPUT_POST, "geo_tel", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "geo_mail", FILTER_VALIDATE_EMAIL);
    $tresc = htmlspecialchars($_POST["geo_tresc"]);

    // Walidacja serwera
    if (empty($imie) || empty($telefon) || empty($email) || empty($tresc)) {
        http_response_code(400); // Błąd - brak wymaganych pól
        echo "Proszę wypełnić wszystkie wymagane pola.";
        exit;
    }

    if (!$email) {
        http_response_code(400); // Błąd walidacji e-maila
        echo "Podano nieprawidłowy adres email.";
        exit;
    }

    // Adres odbiorcy oraz nadawcy
    $to = "lech@jet-it.pl"; // Główne e-mail odbiorcy
    $subject = "Formularz ze strony mierzymywysoko.com";
    
    // Przygotowanie treści wiadomości
    $message = "
Imię i nazwisko: $imie\n
Numer telefonu: $telefon\n
Adres email: $email\n\n
Treść wiadomości:\n$tresc\n
    ";

    // Ustawienie nagłówków wiadomości
    $from = "formularz@serwer044295.home.pl"; // Adres nadawcy
    $bcc = "info@jet-it.pl"; // Adres do ukrytej kopii (BCC)
    
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $email\r\n"; // Jeśli ktoś odpowie, wiadomość trafi do nadawcy wiadomości
    $headers .= "BCC: $bcc\r\n"; // Dodanie adresu BCC
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Wysyłka e-mail
    if (mail($to, $subject, $message, $headers)) {
        http_response_code(200); // Sukces
        echo "Wiadomość została wysłana pomyślnie!";
    } else {
        http_response_code(500); // Błąd serwera
        echo "Nie udało się wysłać wiadomości. Spróbuj ponownie.";
    }
} else {
    http_response_code(405); // Metoda nieobsługiwana
    echo "Niewłaściwa metoda zapytania.";
}
