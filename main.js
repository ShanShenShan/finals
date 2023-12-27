const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

//Calculate BMI
const calculateForm = document.getElementById("calculate-form");
      calculateCm = document.getElementById("calculate-cm");
      calculateKg = document.getElementById("calculate-kg");
      calculateMessage = document.getElementById("calculate-message");

const calculateBmi = (e) => {
    e.preventDefault()

    // Check if the field have a value
    if(calculateCm.value === '' || calculateKg.value ===''){
        // Add and remove color
        calculateMessage.classList.remove('color-green')
        calculateMessage.classList.add('color-red')

        //Show Message
        calculateMessage.textContent = 'Fill in the Heigt and Weight 🧑‍💻'

        //Remove the message in 3 sec
        setTimeout(() =>{
            // This message will be shown when it takes 3 sec 'blank'
            calculateMessage.textContent = ''
        }, 3000)
    } else{
        // BMI FORMULA
        // < 18.5 under, 18.5 - 24.9 healthy, 25- 29 over, 30-39.9 obese, 40+ extremely obese
        const cm = calculateCm.value / 100,
              kg = calculateKg.value,
              bmi = Math.round(kg / (cm * cm))
        
        // Health status
        if (bmi < 18.5){
            //Add color and display message
            calculateMessage.classList.add('color-green')
            calculateMessage.textContent = `Your BMI is ${bmi} and you are skinny 🥺`
        } else if(bmi < 25){
            calculateMessage.classList.add('color-green')
            calculateMessage.textContent = `Your BMI is ${bmi} and you are healthy 🥳`
        } else{
            calculateMessage.classList.add('color-green')
            calculateMessage.textContent = `Your BMI is ${bmi} and you are overweight 😭`
        }


        //Clearing input field
        calculateCm.value = ''
        calculateKg.value = ''
        //Remove message 4 seconds
        setTimeout(() => {
            calculateMessage.textContent =''
        }, 4000)
    
    }
}

calculateForm.addEventListener('submit', calculateBmi)




menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  distance: "50px",
  origin: "bottom",
  duration: 1000,
};

// header container
ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
});

ScrollReveal().reveal(
  ".header__content h4, .header__content .section__header",
  {
    ...scrollRevealOption,
    delay: 500,
  }
);

ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 1000,
});

ScrollReveal().reveal(".header__btn", {
  ...scrollRevealOption,
  delay: 1500,
});

// about container
ScrollReveal().reveal(".about__image img", {
  ...scrollRevealOption,
  origin: "left",
});

ScrollReveal().reveal(".about__content .section__header", {
  ...scrollRevealOption,
  delay: 500,
});

ScrollReveal().reveal(".about__content .section__description", {
  ...scrollRevealOption,
  delay: 1000,
});

ScrollReveal().reveal(".about__card", {
  ...scrollRevealOption,
  delay: 1500,
  interval: 500,
});

// price container
ScrollReveal().reveal(".price__card", {
  ...scrollRevealOption,
  interval: 500,
});

const swiper = new Swiper(".swiper", {
  loop: true,
  slidesPerView: "auto",
  spaceBetween: 20,
});
