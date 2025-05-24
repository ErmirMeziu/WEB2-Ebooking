

document.getElementById('toggle-review-form').addEventListener('click', function () {
    document.getElementById('review-modal').classList.remove('hidden');
});

document.getElementById('close-modal').addEventListener('click', function () {
    document.getElementById('review-modal').classList.add('hidden');
});

const form = document.getElementById('site-review-form');
const message = document.getElementById('review-message');
const modal = document.getElementById('review-modal');

const stars = document.querySelectorAll('.star-rating .star');
const ratingInput = document.getElementById('rating');

stars.forEach((star, index) => {
    star.addEventListener('mouseover', () => {
        highlightStars(index);
    });
    star.addEventListener('mouseout', () => {
        resetStars();
    });
    star.addEventListener('click', () => {
        ratingInput.value = index + 1;
        setSelectedStars(index);
    });
});

function highlightStars(index) {
    stars.forEach((star, i) => {
        star.classList.toggle('hovered', i <= index);
    });
}

function resetStars() {
    stars.forEach((star) => {
        star.classList.remove('hovered');
    });
}

function setSelectedStars(index) {
    stars.forEach((star, i) => {
        star.classList.toggle('selected', i <= index);
    });
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    const response = await fetch("/WEB2-Ebooking/src/user/submit_site_review.php", {
        method: "POST",
        body: formData
    });

    const result = await response.json();

    if (result.success) {
        alert("Review submitted")

        modal.classList.add("hidden");
    } else {
        message.textContent = result.message || "Failed to submit review.";
        message.style.color = "red";
    }
});
