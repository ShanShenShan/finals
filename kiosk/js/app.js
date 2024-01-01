let iconCart = document.querySelector('.icon-cart');
let closeCart = document.querySelector('.close');
let body = document.querySelector('body');
let addToCart = document.querySelector('.addCart');

const body2 = document.querySelector("body");
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

// Select the "Add To Cart" button
addToCart.addEventListener('click', () => {
    // Check if the cart is not currently visible
    if (!body.classList.contains('showCart')) {
        // If not visible, add the 'showCart' class to make it visible
        body.classList.add('showCart');
    }
    // If the cart is already visible, do nothing (you can optionally handle other logic here)
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

//Third Modal

// Select all product images within the listProduct
const productImages = document.querySelectorAll('.listProduct .item img');

// Add a click event listener to each product image
productImages.forEach((image) => {
    image.addEventListener('click', showThirdModal);
});

document.addEventListener('DOMContentLoaded', () => {
    const productImages = document.querySelectorAll('.listProduct .item img');

    productImages.forEach((image) => {
        image.addEventListener('click', () => {
            const productName = image.dataset.productname;
            const category = image.dataset.category;
            const price = image.dataset.price;
            const description = image.dataset.description;
            const imageSrc = image.dataset.image;
            const productId = image.dataset.id; // Get product ID

            showThirdModal(productName, category, price, description, imageSrc, productId);
        });
    });
});

function showThirdModal(productName, category, price, description, imageSrc, productId) {
    const showModal3 = document.getElementById('ShowModal3');
    showModal3.style.display = 'block';

    const modalContent = showModal3.querySelector('.item');
    const pictureElement = modalContent.querySelector('picture');

    const imageElement = pictureElement.querySelector('img');
    imageElement.srcset = `${imageSrc}, ${imageSrc.replace('.jpg', '.webp')}`;
    imageElement.src = imageSrc;
    imageElement.alt = productName;

    modalContent.querySelector('h4').innerText = productName;
    modalContent.querySelector('h5').innerText = category;
    modalContent.querySelector('.price').innerText = `₱${price}`;
    modalContent.querySelector('.description').innerText = description;

    // Set product ID in the hidden input
    const productIdInput = modalContent.querySelector('.product-id');
    productIdInput.setAttribute('value', productId);
}








// Select the 'Close' button within the third modal
const closeModal3Button = document.querySelector('#ShowModal3 button');

// Add a click event listener to close the third modal when the 'Close' button is clicked
closeModal3Button.addEventListener('click', closeThirdModal);

// Function to close the third modal
function closeThirdModal() {
    // Select the third modal by its ID
    const showModal3 = document.getElementById('ShowModal3');

    // Hide the third modal
    showModal3.style.display = 'none';
}