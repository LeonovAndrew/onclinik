let preloader = function(parentSelector) {
    this.parentBlock = $(parentSelector);
    this.preloaderLayout = $('<div class="preloader-wrap"><span class="preloader"></span></div>');
    this.preloaderBlock = null;
}

preloader.prototype.init = function() {
    this.preloaderBlock = this.preloaderLayout.prependTo(this.parentBlock);
    this.preloaderBlock.width(this.parentBlock.width());
    this.preloaderBlock.height(this.parentBlock.height());
}

preloader.prototype.remove = function() {
    this.preloaderBlock.remove();
}