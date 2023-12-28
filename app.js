let iconCart = document.querySelector('.icon-cart');
let closeCart = document.querySelector('.close');
let body = document.querySelector('body');

const body2 = document.querySelector("body");
      sidebar = body.querySelector(".sidebar");
      toggle = body.querySelector(".toggle");
      modeSwitch = body.querySelector(".toggle-switch");
      modeText = body.querySelector(".mode-text");

//if the user click the icon and the body will have class .showCart the cartTab will appear
iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart')
});

closeCart.addEventListener('click', () => {
    body.classList.toggle('showCart')
});

//Dark and Light Mode
modeSwitch.addEventListener('click', () => {
    body.classList.toggle("dark");

    if(body.classList.contains("dark")){
        modeText.innerText = "Light Mode"
    }else{
        modeText.innerText = "Dark Mode"
    }
    
});

toggle.addEventListener('click', () => {
    sidebar.classList.toggle("appear");
});

//MODAL

var modal = document.getElementById('ShowModal');
var checkOut = document.getElementById('checkOut');
var yesButton = document.getElementById("yes");
var noButton = document.getElementById("no");

checkOut.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior
    modal.style.display = 'block'; // Show the modal when Register is clicked
});
// Hide the modal when clicking outside of it or when clicking the 'X' button
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// Close the modal when "I understand" button is clicked
noButton.addEventListener('click', function() {
    modal.style.display = 'none';
});

// Second Modal
let modal2 = document.getElementById('ShowModal2');
let understandButton = document.getElementById("btn");

// Function to show the second modal
function showProcessingModal() {
    // Hide the first modal
    modal.style.display = 'none';

    // Show the second modal
    modal2.style.display = 'block';

    // Add event listener for the "I understand" button in the second modal
    understandButton.addEventListener('click', function() {
        // Remove the second modal
        modal2.style.display = 'none';
    });
}

// Update the event listener for the "Yes" button in the first modal
yesButton.addEventListener('click', function() {
    // Call the function to show the second modal
    showProcessingModal();
});

var understandBut = document.getElementById("understand");

// Close the modal when "I understand" button is clicked
understandBut.addEventListener('click', function() {
    modal2.style.display = 'none';
});

