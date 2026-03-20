export const UIService = {
    loader: null,

    init() {
        this.loader = document.getElementById('global-loader');
    },

    show() {
        if (this.loader) {
            this.loader.classList.remove('hidden');
            this.loader.classList.add('flex');
        }
    },

    hide() {
        if (this.loader) {
            this.loader.classList.add('hidden');
            this.loader.classList.remove('flex');
        }
    }
};