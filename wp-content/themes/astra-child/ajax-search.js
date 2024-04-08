// const stars = document.querySelectorAll('.star');
// console.log(stars);
// stars.forEach(star => {
//     star.addEventListener('mouseover', function() {
//         highlightStars(this.dataset.value);
//     });

//     star.addEventListener('mouseout', function() {
//         resetStars();
//     });

//     star.addEventListener('click', function() {
//         const rating = this.dataset.value;
//         document.getElementById('rating').value = rating;
//     });
// });

// function highlightStars(value) {
//     stars.forEach(star => {
//         if (star.dataset.value <= value) {
//             star.innerHTML = '&#9733;'; // Full star
//         } else {
//             star.innerHTML = '&#9734;'; // Empty star
//         }
//     });
// }

// function resetStars() {
//     const ratingInput = document.getElementById('rating');
//     const currentValue = ratingInput.value;
//     if (currentValue === '0') {
//         stars.forEach(star => {
//             star.innerHTML = '&#9734;'; // Empty star
//         });
//     } else {
//         highlightStars(currentValue);
//     }
// }

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('search-input');
    var titles = document.querySelectorAll('.project-card__title');
    var timer; // Timer variable

    searchInput.addEventListener('input', function() {
        clearTimeout(timer); // Clear previous timer
        timer = setTimeout(filterGames, 300); // Set a new timer
    });

    function filterGames() {
        var searchTerm = searchInput.value.toLowerCase();

        titles.forEach(function(title) {
            var titleText = title.textContent.toLowerCase();
            var isVisible = titleText.includes(searchTerm);
            title.closest('.project-card').style.display = isVisible ? 'block' : 'none';
        });
    }
});

// console.log("salut");
// alert("salut");