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

