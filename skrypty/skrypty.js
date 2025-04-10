$(document).ready(function () {
    // Ustal wysokość
    var wysokosc = $(window).height();

    $('body header').css('min-height', wysokosc);
    $('body section').css('min-height', wysokosc);
    $('body section#home #homeIner').css('min-height', wysokosc);

    // Wysokość tła
    //    $('body.row main.col-md-10 section div.col-md-4').css('background-size', 'auto, 0px');

    // Animacja boxu na sttronie głównej
    setTimeout(function () {
        $("#home .txt-blok, #homeIner h2").removeClass("loading");
    }, 200);

    // Menu
    $(document).on("scroll", onScroll);
    $('header a[href^="#"], a.dol[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");

        $('a').each(function () {
            $(this).removeClass('aktywny');
        });
        $(this).addClass('aktywny');

        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top
        }, 1200, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });

    // Na górę
    $(window).scroll(function () {
        toggleToTop();
    });
    function toggleToTop() {
        var scrollPosition = $(this).scrollTop();

        if (scrollPosition >= 300) {
            $('#na-gore').addClass('fade-in');
        } else {
            $('#na-gore').removeClass('fade-in');
        }
    }
    $('#na-gore').click(function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    // Przyklej menu
    $(window).scroll(function () {

        var wMenu = $('.przyklej').height();
        var wScroll = $(this).scrollTop();

        if (wScroll <= wysokosc) {

            $('.przyklej').css({
                'top': - wScroll / (wysokosc / 14) + '%'
            });

        }
    });

    // Pokaż / ukryj menu mobilne
    $("body.row header.col-md-2 .przyklej.col-md-2 nav i.fa-bars").click(function () {
        $("body.row header.col-md-2 .przyklej.col-md-2 nav ul").slideToggle();
    });


});

// Menu
function onScroll(event) {
    var scrollPos = $(document).scrollTop();

    $('nav ul li a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('nav ul li a').removeClass("aktywny");
            currLink.addClass("aktywny");
        }
        else {
            currLink.removeClass("aktywny");
        }
    });
}

document.getElementById("contact-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Zatrzymaj domyślne wysyłanie formularza

    // Pobieranie danych z pól formularza
    const imie = document.getElementById("imie").value.trim();
    const telefon = document.getElementById("telefon").value.trim();
    const email = document.getElementById("email").value.trim();
    const tresc = document.getElementById("tresc").value.trim();

    // Walidacja pól
    if (imie === "" || telefon === "" || email === "" || tresc === "") {
        alert("Proszę wypełnić wszystkie wymagane pola.");
        return;
    }

    // Walidacja e-maila
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Podano nieprawidłowy adres email.");
        return;
    }

    // Walidacja telefonu (opcjonalna)
    const telefonRegex = /^[0-9\-\+]{9,15}$/; // Dopuszcza cyfry, "-", "+"
    if (!telefonRegex.test(telefon)) {
        alert("Podano nieprawidłowy numer telefonu.");
        return;
    }

    // Przygotowanie danych formularza do wysłania
    const formData = new FormData(e.target);

    // Wysłanie formularza za pomocą AJAX
    fetch("php/mail.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            if (!response.ok) {
                // Jeśli serwer zwraca kod HTTP inny niż 200
                throw new Error(`HTTP error! Status: ${response.status} (${response.statusText})`);
            }
            return response.text();
        })
        .then((data) => {
            // Wyświetl wynik z serwera
            console.log("Odpowiedź serwera:", data);
            alert("Wiadomość została wysłana pomyślnie!");
            document.getElementById("contact-form").reset();
        })
        .catch((error) => {
            // Wyświetl szczegółowy błąd w konsoli
            console.error("Błąd podczas wysyłania formularza:", error);
            alert("Wystąpił problem podczas wysyłania wiadomości: Błąd w wysyłaniu formularza");
        });
});