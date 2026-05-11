let lastScrollY = window.scrollY;
const navbar = document.getElementById("navbar");
const mobileMenu = document.getElementById("mobile-menu");
const navList = document.getElementById("nav-list");
const categoriesButton = document.getElementById("categories-button");
const modal = document.getElementById("categories-modal");
const closeModal = document.querySelector(".close-modal");
const regionButton = document.getElementById("region-button");
const regionModal = document.getElementById("region-modal");
const closeRegionModal = document.querySelector(".close-region-modal");

// Disable scrolling when menu is open
function disableScroll() {
    document.body.classList.add("no-scroll");
}

// Enable scrolling when menu is closed
function enableScroll() {
    document.body.classList.remove("no-scroll");
}

// Handle Navbar Hide on Scroll Down & Show on Scroll Up
window.addEventListener("scroll", () => {
    if (window.scrollY > lastScrollY) {
        navbar.style.top = "-100%"; // Hide navbar when scrolling down
    } else {
        navbar.style.top = "0"; // Show navbar when scrolling up
    }
    navbar.classList.toggle("scrolled", window.scrollY > 50);
    lastScrollY = window.scrollY;
});

mobileMenu.addEventListener("click", () => {
    const isActive = navList.classList.toggle("active");
    if (isActive) {
        mobileMenu.innerHTML = "&times;"; // Show close icon
        mobileMenu.classList.add("close-icon"); // Add close-icon class to change style
        disableScroll(); // Prevent scrolling when menu is open
    } else {
        mobileMenu.innerHTML = "&#9776;"; // Show menu icon
        mobileMenu.classList.remove("close-icon"); // Remove close-icon class to revert style
        enableScroll(); // Enable scrolling when menu is closed
    }
    // Close modals if menu is toggled
    modal.style.display = "none";
    regionModal.style.display = "none";
});

document.addEventListener("DOMContentLoaded", function () {
    // Open Categories Modal
    categoriesButton.addEventListener("click", function (e) {
        e.preventDefault();
        modal.style.display = "block";
    });

    // Close Categories Modal
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Close Categories Modal on Outside Click
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Open Region Modal
    regionButton.addEventListener("click", function (e) {
        e.preventDefault();
        regionModal.style.display = "block";
    });

    // Close Region Modal
    closeRegionModal.addEventListener("click", function () {
        regionModal.style.display = "none";
    });

    // Close Region Modal on Outside Click
    window.addEventListener("click", function (e) {
        if (e.target === regionModal) {
            regionModal.style.display = "none";
        }
    });
});

//fore auto complte search //
$(document).ready(function() {
    $('#searchInput').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '{{ route("search") }}',
                dataType: 'json',
                data: {
                    query: request.term
                },
                success: function(data) {
                    response(data.stores); // Ensure `data.stores` is an array of strings or objects
                }
            });
        },
        minLength: 1 // Minimum characters to trigger autocomplete
    });
});
