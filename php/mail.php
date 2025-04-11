<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pobierz klucz prywatny reCAPTCHA
    $secretKey = "6Le7MrodAAAAANPxzqCU9cQ6JJD6lOHbc_5jpp2l"; // Klucz prywatny z Google

    // Pobierz token reCAPTCHA od użytkownika
    $recaptchaToken = $_POST['recaptcha_token'] ?? '';

    // Weryfikacja reCAPTCHA z serwerem Google
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaToken,
        'remoteip' => $_SERVER['REMOTE_ADDR'], // Opcjonalny adres IP klienta
    ];

    // Wyślij żądanie POST do serwera Google
    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result, true);

    // Sprawdź wynik weryfikacji
    if ($response['success'] === true && $response['score'] >= 0.5 && $response['action'] === 'submit') {
        // Jeśli weryfikacja spowodzeniem - kontynuuj obsługę formularza
        $imie = filter_input(INPUT_POST, 'geo_imie', FILTER_SANITIZE_STRING);
        $tel = filter_input(INPUT_POST, 'geo_tel', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'geo_mail', FILTER_VALIDATE_EMAIL);
        $tresc = filter_input(INPUT_POST, 'geo_tresc', FILTER_SANITIZE_STRING);

        // Walidacja danych formularza
        if (!$imie || !$tel || !$email || !$tresc) {
            echo "Wszystkie pola formularza są wymagane!";
            exit;
        }

    // Wysyłanie maila
    $to = "karolina@everestmarketing.pl";
    $from = "formularz@serwer044295.home.pl";
    $subject = "Formularz ze strony mierzymywysoko.com";
    $message = "Imię: $imie\nTelefon: $tel\nEmail: $email\n\nWiadomość: $tresc";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "BCC: info@jet-it.pl\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Wiadomość została wysłana pomyślnie!";
    } else {
        echo "Nie udało się wysłać wiadomości. Spróbuj ponownie później.";
    }
} else {
    // reCAPTCHA nie zdała testu
    echo "Nie udało się zweryfikować reCAPTCHA. Możesz być botem. Spróbuj ponownie.";
    exit;
}

}