const $ = window.jQuery;

class MediaUploader {
  constructor() {
    this.uploader = null;
    this.handleUploaderOpen = this.handleUploaderOpen.bind(this);
    this.handleClearButton = this.handleClearButton.bind(this);

    $('.caritas-app-media-input [data-action="upload"]').click(
      this.handleUploaderOpen
    );
    $('.caritas-app-media-input [data-action="clear"]').click(
      this.handleClearButton
    );
  }

  handleUploaderOpen(e) {
    e.preventDefault();
    const $inputContainer = $(e.target).closest(".caritas-app-media-input");

    // if (this.uploader) {
    //   this.uploader.open();
    //   return;
    // }

    this.uploader = wp.media.frames.file_frame = wp.media({
      title: "Wybierz obraz",
      button: {
        text: "Zatwierdź",
      },
      multiple: false,
    });

    this.uploader.on("select", () => {
      const attachment = this.uploader
        .state()
        .get("selection")
        .first()
        .toJSON();
      $inputContainer.find("input").val(attachment.url);
      $inputContainer.find("img").attr("src", attachment.url);

      this.uploader.off("select");
    });
    this.uploader.open();
  }

  handleClearButton(e) {
    e.preventDefault();
    const $inputContainer = $(e.target).closest(".caritas-app-media-input");
    $inputContainer.find("input").val("");

    const defaultUrl = $inputContainer
      .find("[data-default-src]")
      .attr("data-default-src");
    if (defaultUrl) {
      $inputContainer.find("img").attr("src", defaultUrl);
    } else {
      $inputContainer.find("img").attr("src", "");
    }

    $inputContainer.find('button[data-action="upload"]').text("Wybierz obraz");
  }
}

export default MediaUploader;
