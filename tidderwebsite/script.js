function bevestigVerwijderen() {
    return confirm("Weet je zeker dat je deze post wilt verwijderen?");
}
var buttons = document.getElementsByClassName('button-toggle-comments');
for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('click', toggleComments);
}

function toggleComments(button) {
    var commentsDiv = button.nextElementSibling;
    if (commentsDiv.classList.contains('comments-hidden')) {
        commentsDiv.classList.remove('comments-hidden');
        button.innerHTML = "Verberg reacties"; // Pas de tekst van de knop aan wanneer de reacties getoond worden
    } else {
        commentsDiv.classList.add('comments-hidden');
        button.innerHTML = "Toon reacties"; // Pas de tekst van de knop aan wanneer de reacties verborgen zijn
    }
}

window.onload = function() {
    // Scrollpositie herstellen na een pagina refresh
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0, sessionStorage.getItem('scrollPosition'));

    // De commentsectie standaard openen
    var buttons = document.getElementsByClassName('button-toggle-comments');
    for (var i = 0; i < buttons.length; i++) {
        toggleComments(buttons[i]);
    }
};

window.onbeforeunload = function() {
    // Scrollpositie opslaan voordat de pagina wordt verlaten
    sessionStorage.setItem('scrollPosition', window.pageYOffset);
};
// Functie om het aanmaken van een communityformulier te tonen
function showCreateCommunityForm() {
    document.querySelector('.create-community-overlay').style.display = 'block';
}

// Functie om het aanmaken van een communityformulier te verbergen
function hideCreateCommunityForm() {
    document.querySelector('.create-community-overlay').style.display = 'none';
}
function goBack() {
    window.history.back();
}
