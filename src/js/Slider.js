import Swiper from "swiper";

class Slider {
  constructor() {
    this.slider = new Swiper(".swiper-container", {
      loop: true,
      autoplay: true,
      // Navigation arrows
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }
}

export default Slider;
