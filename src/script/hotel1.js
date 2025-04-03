try {
    const toggleButton = document.getElementById('toggle-btn');
    const extraText = document.getElementById('extra-text');


    if (!toggleButton || !extraText) {
        throw new Error("Toggle button or extra text element not found in the DOM");
    }


    toggleButton.addEventListener('click', () => {
        if (extraText.classList.contains('hidden')) {
            extraText.classList.remove('hidden');
            toggleButton.textContent = 'Show Less';
        } else {
            extraText.classList.add('hidden');
            toggleButton.textContent = 'Show More';
        }
    });
} catch (error) {
    console.error("Error in toggle button functionality:", error.message);
}


//photo part
document.querySelectorAll('.photo, .bottom-pht').forEach(photo => {
    photo.addEventListener('click', () => {
        const lightbox = document.createElement('div');
        lightbox.id = 'lightbox';
        document.body.appendChild(lightbox);

        const img = document.createElement('img');
        img.src = photo.src;
        lightbox.appendChild(img);
        lightbox.addEventListener('click', () => {
            lightbox.remove();
        });
    });
})

//answer part
document.querySelectorAll('.arrow').forEach(arrow => {
    arrow.addEventListener('click', function () {
        const answer = this.nextElementSibling;
        if (answer.style.display === 'block') {
            answer.style.display = 'none';
            this.innerHTML = '&#x25BC;'; // Down arrow
        } else {
            answer.style.display = 'block';
            this.innerHTML = '&#x25B2;'; // Up arrow
        }
    });
});

/*save the property*/
const button = document.querySelector(".bottom-btn1");
const favorit = document.querySelector(".favorit");
button.addEventListener('click', function () {
    button.classList.toggle('bottom-btn-special');
})

//Slider
const recommendations = document.querySelector('.recommendations');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

const cardWidth = 320; // Width i nje karte duke perfshir dhe hapsiren
const visibleCards = Math.floor(window.innerWidth / cardWidth); // Numri i kartave te dukshme
const maxScroll = recommendations.scrollWidth - cardWidth * visibleCards;

let scrollAmount = 0;

// Levizja majtas
prevButton.addEventListener('click', () => {
    scrollAmount -= cardWidth;

    // Parandalimi per mos me leviz pertej kartes se pare
    if (scrollAmount < 0) {
        scrollAmount = 0;
    }

    recommendations.style.transform = `translateX(-${scrollAmount}px)`;
});

// Levizja djathtas
nextButton.addEventListener('click', () => {
    scrollAmount += cardWidth;

    // Parandalimi per mos me leviz pertej kartes se fundit
    if (scrollAmount > maxScroll) {
        scrollAmount = maxScroll;
    }

    recommendations.style.transform = `translateX(-${scrollAmount}px)`;
});


document.addEventListener('DOMContentLoaded', function () {
    //Selekton krejt rreshtat e tabeles
    const rows = document.querySelectorAll('.room-table tbody tr');
    // Shtojm event listeners per cdo rresht
    rows.forEach(function (row, index) {
        // Lejon qe cdo rresht me kan draggable
        row.setAttribute('draggable', 'true'); // Mundet edhe pa qet rresht se e kem specifiku ne html dokument


        row.addEventListener('dragstart', function () {
            row.classList.add('dragging');  // Shtojm nje klas per rreshtin qe po bahet dragg me mujt me stilizu
        });
        //Krijojm klase te re kur bojm drag me u dallu rreshti qe po bahet drag -> ne style e kem klasen qe po e krijojm(.dragging)

        //Kur rreshti te behet drop, sigurohemi qe bahet drop ne vendin qe duam
        row.addEventListener('dragover', function (event) {
            event.preventDefault(); // E nevojshme me funksionu drag
        });
        //preventDeafault metod e gatshme qe na siguron qe rreshti bahet drop.

        row.addEventListener('drop', function () {
            // Move the dragged row to its new position
            const draggedRow = document.querySelector('.dragging');
            if (draggedRow !== row) { // kushti siguron që ne të mos përpiqemi ta zhvendosim rreshtin në të njëjtin pozicion nga ku është tërhequr
                const rowsContainer = row.parentNode; //Variabla prind ruan elementin prind (<tbody>)
                rowsContainer.insertBefore(draggedRow, row); // Reorder rows
                updateRowNumbers();  // Bene update numrat pasi rreshtat jan ba drop.
            }
            row.classList.remove('dragging');  //  pra largon efektin qe e kemi caktu ne style
        });

        // Kur perfundon drag largon efektet qe kemi caktu ne style
        row.addEventListener('dragend', function () {
            row.classList.remove('dragging');
        });
    });

    // Funksioni qe na mundeson me i ba update numrat ne rreshta
    function updateRowNumbers() {
        const rows = document.querySelectorAll('.room-table tbody tr');
        rows.forEach(function (row, index) {
            // Gjen hapsiren brenda rreshtit ku shfaqet numri
            const numberSpan = row.querySelector('.expand-icon');
            numberSpan.textContent = index + 1; // Perditeson numrin për të treguar pozicionin e ri të rreshtit
        });
    }
});

