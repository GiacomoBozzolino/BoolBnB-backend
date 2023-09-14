import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

// RECUPERO I DELETE_BUTTON DI OGNI APPARTAMENTO
const apartmentDeleteButton = document.querySelectorAll('.apartment-delete-button');

// CICLO L'ARRAY CONTENENTE I DELETE_BUTTON
apartmentDeleteButton.forEach((button) => {

    // PER OGNI DELETE_BUTTON, AGGIUNGO UN EVENT_LISTENER "CLICK"
    button.addEventListener('click', (event) => {

        // QUANDO L'UTENTE CLICCA SUL DELETE_BUTTON, IL FORM NON VIENE AVVIATO GRAZIE A QUESTO COMANDO
        event.preventDefault();
        const apartmentTitle = button.getAttribute('data-apartment-title');

        const modalApartmentTitle = document.getElementById('modal-apartment-title');

        modalApartmentTitle.innerText = apartmentTitle;


        // RECUPERO L'HTML DELLA MODALE "MODAL_PROJECT_DELETE", DALLA VIEW ADMIN -> PARTIALS
        const modal = document.getElementById('apartmentConfirmDeleteModal');

        // CREO LA MODALE COME OGGETTO DI BOOTSTRAP, PARTENDO DALL'HTML DELLA MODALE RECUPERATA PRIMA
        const bootstrapModal = new bootstrap.Modal(modal);

        // QUANDO L'UTENTE CLICCA NEL DELETE_BUTTON, MOSTRO LA "BOOTSTRAP_MODAL"
        bootstrapModal.show();

        // RECUPERO IL PULSANTE DI "CONFERMA CANCELLAZIONE" PRESENTE NELLA MODALE
        const apartmentConfirmDeleteButton = document.getElementById('apartment-confirm-delete-button');

        // AL PULSANTE DI "CONFERMA CANCELLAZIONE", AGGIUNGO UN EVENT_LISTENER "CLICK"
        apartmentConfirmDeleteButton.addEventListener('click', () => {

            // RECUPERO IL "DELETE_BUTTON", ED ESEGUO LA FORM DI CANCELLAZIONE
            button.submit();
        })
    })
})