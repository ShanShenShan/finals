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


toggle.addEventListener('click', () => {
    sidebar.classList.toggle("appear");
});

//MODALS FUNCTION

// Select the CHECK OUT button by its ID
const checkOutButton = document.getElementById('checkOut');

// Select the first modal by its ID
const showModal = document.getElementById('ShowModal');

// Function to show the first modal
function showFirstModal() {
    showModal.style.display = 'block';
}

// Add a click event listener to the CHECK OUT button
checkOutButton.addEventListener('click', showFirstModal);

// Select the elements with the class of 'no' within the modal
const noButton = document.getElementById('no');

// Function to close the first modal
function closeFirstModal() {
    showModal.style.display = 'none';
}

// Add a click event listener to the 'No' button
noButton.addEventListener('click', closeFirstModal);

// Select the 'Yes' button by its ID within the first modal
const yesButton = document.getElementById('yes');

// Select the second modal by its ID
const showModal2 = document.getElementById('ShowModal2');

// Function to show the second modal
function showSecondModal() {
    showModal.style.display = 'none'; // Close the first modal
    showModal2.style.display = 'block'; // Show the second modal
}

// Add a click event listener to the 'Yes' button
yesButton.addEventListener('click', showSecondModal);

// Select the 'I understand' button by its ID within the second modal
const understandButton = document.getElementById('understand');

// Function to close the second modal
function closeSecondModal() {
    showModal2.style.display = 'none';
}

// Add a click event listener to the 'I understand' button
understandButton.addEventListener('click', closeSecondModal);