function toggleDetails(index) {
    var details = document.getElementById('details-' + index);
    var button = document.querySelector('.view-more-btn[data-index="' + index + '"]'); // Asigură-te că fiecare buton are un atribut data-index
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        details.classList.add('visible');
        button.textContent = 'Vezi mai puțin'; // Schimbă textul în Vezi mai puțin
    } else {
        details.classList.add('hidden');
        details.classList.remove('visible');
        button.textContent = 'Vezi mai mult'; // Schimbă textul înapoi în Vezi mai mult
    }
}


document.addEventListener('DOMContentLoaded', function() {
    var dropBtn = document.querySelector('.dropbtn');
    var dropContent = document.querySelector('.profile-dropdown-content');

    dropBtn.onclick = function(event) {
        event.stopPropagation();
        dropContent.style.display = dropContent.style.display === 'block' ? 'none' : 'block';
    };

    // Ascunde dropdown-ul când se face clic în altă parte
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("profile-dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    };
});





function confirmDeletion() {
    if (confirm("Ești sigur că vrei să îți ștergi contul?")) {
        window.location.href = 'delete_account.php'; // Pagina PHP care va șterge contul
    }
}
