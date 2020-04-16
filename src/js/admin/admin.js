import MediaUploader from "./MediaUploader";

class CaritasWpAdminPanel {
  constructor() {
    new MediaUploader();
  }
}

jQuery(document).ready(() => {
  new CaritasWpAdminPanel();
});
