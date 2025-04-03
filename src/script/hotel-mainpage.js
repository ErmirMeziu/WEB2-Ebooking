//filter-hotels
class PriceFilter {
    constructor(submitSelector, lowestSelector, highestSelector, boxSelector) {
        this.submitButton = document.querySelector(submitSelector);
        this.lowestInput = document.querySelector(lowestSelector);
        this.highestInput = document.querySelector(highestSelector);
        this.hotels = document.querySelectorAll(boxSelector);
        this.init();
    }

    init() {
        if (this.submitButton && this.lowestInput && this.highestInput) {
            this.submitButton.addEventListener('click', () => this.filterHotels());
        } else {
            console.error("One or more elements not found in the DOM.");
        }   
    }

    filterHotels() {
        const lowest = parseFloat(this.lowestInput.value);
        const highest = parseFloat(this.highestInput.value);
        let MAX_VALUE = 1000;

        if (isNaN(lowest) || isNaN(highest) || (lowest > highest) || (lowest < 0)) {
            alert("Please enter valid numbers for the price range.");
            return;
        }

        if(highest > MAX_VALUE){
            alert("Max Value is " + MAX_VALUE.toString() + "!");
            return;
        }

        this.hotels.forEach(hotel => {
            const currentPriceElement = hotel.querySelector('.current-price');
            if (currentPriceElement) {
                const price = parseFloat(currentPriceElement.textContent.replace('$', '').trim());
                hotel.style.display = (price >= lowest && price <= highest) ? 'block' : 'none';
            }
        });
    }
}

// Usage
new PriceFilter('.submit', '.lowest', '.highest', '.box');


document.addEventListener("DOMContentLoaded", function() {
    // Funksion ndihmes per me ba update stylin e butonave
    function updateButtonStyles(activeButtonId) {
        //Reseton stylin per krejt butonat
        document.querySelectorAll(".page-btn").forEach(function(button) {
            button.style.backgroundColor = "white";
            button.style.color = "black";
        });
        
        // Vendos nje style te caktuar per butonin aktiv
        let activeButton = document.getElementById(activeButtonId);
        if (activeButton) {
            activeButton.style.backgroundColor = "rgb(205,44,34)";
            activeButton.style.color = "white";
        }
    }
    
    
      document.getElementById("page1-btn").addEventListener("click", function() {
        // Fsheh faqet e tjera
        document.querySelectorAll(".hotel-page").forEach(function(page) {
            page.style.display = "none";
        });
        // Shfaq faqen e pare
        document.querySelector(".page1").style.display = "block";
        updateButtonStyles("page1-btn");
        //Scroll ne fillim te faqes
        window.scrollTo(0, 0);
    });
    
    document.getElementById("page2-btn").addEventListener("click", function() {
        // Fsheh faqet e tjera
        document.querySelectorAll(".hotel-page").forEach(function(page) {
            page.style.display = "none";
        });
        // Shfaq faqen e dyte
        document.querySelector(".page2").style.display = "block";
        updateButtonStyles("page2-btn");
        window.scrollTo(0, 0);
    });

    document.getElementById("page3-btn").addEventListener("click", function() {
        // Fsheh faqet e tjera
        document.querySelectorAll(".hotel-page").forEach(function(page) {
            page.style.display = "none";
        });
        // Shfaq faqen e dyte
        document.querySelector(".page3").style.display = "block";
        updateButtonStyles("page3-btn");
        window.scrollTo(0, 0);
    });
});

