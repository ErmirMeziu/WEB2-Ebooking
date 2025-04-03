let next = document.querySelector('.next2')
let prev = document.querySelector('.prev2')

next.addEventListener('click', function () {
    let items = document.querySelectorAll('.item')
    document.querySelector('.slide20').appendChild(items[0])
})

prev.addEventListener('click', function () {
    let items = document.querySelectorAll('.item')
    document.querySelector('.slide20').prepend(items[items.length - 1])
})
function rezervo() {
    document.getElementById("modal").style.display = "block";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}

setTimeout(function () {
    document.getElementById("modal").style.display = "none";
});


function formatDate(date) {
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return date.toLocaleDateString('en-GB', options);
}


function updateDates() {
    const pickupInput = document.getElementById('pickup-input').value;
    const dropoffInput = document.getElementById('dropoff-input').value;

    if (pickupInput && dropoffInput) {
        const pickupDate = new Date(pickupInput);
        const dropoffDate = new Date(dropoffInput);

        if (dropoffDate < pickupDate) {
            alert("You selected the wrong date!");
            return;
        }

        const durationInMillis = dropoffDate - pickupDate;
        const durationInDays = Math.ceil(durationInMillis / (1000 * 60 * 60 * 24));

        document.getElementById('duration').textContent = `${durationInDays} Day(s)`;

        const dailyCost = parseFloat(document.getElementById("dailyCost").textContent);
        const totalCost = [durationInDays, dailyCost].reduce((acc, curr) => acc * curr);

        document.getElementById('total-cost').textContent = `${totalCost.toFixed(2)} €`;

        const formattedDates = [pickupDate, dropoffDate].map(date => formatDate(date));
        console.log(`Pickup Date: ${formattedDates[0]}, Dropoff Date: ${formattedDates[1]}`);
    }
}


document.getElementById('pickup-input').addEventListener('change', updateDates);
document.getElementById('dropoff-input').addEventListener('change', updateDates);

/*video-watch*/
document.addEventListener('DOMContentLoaded', () => {
    const watch = document.querySelector(".video-watch");
    const video = document.querySelector(".video");
    const overlay = document.querySelector(".video-overlay");
    const canvas = document.querySelector(".canva");


    watch.addEventListener('click', function () {
        video.classList.add("video-special");
        overlay.classList.add("video-special");
        canvas.classList.add("canvas-special");

    });

    canvas.addEventListener('click', function () {
        video.classList.remove("video-special");
        overlay.classList.remove("video-special");
        canvas.classList.remove("canvas-special");
    });
});

