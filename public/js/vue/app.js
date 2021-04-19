new Vue({
    el: "#appJEND",
    
    delimiters: ["[+[", "]+]"],
    
    vuetify: new Vuetify(),

    data() {

        return {

            dialog: false,

            searching: false,

            profile: false,

            modalScreen1: false,
            modalScreen2: false,
            modalScreen3: false,
            modalScreen4: false,
            modalScreen5: false,
            modalScreen6: false,
            modalScreen7: false,
            modalScreen8: false,
            modalScreen9: false,
            modalScreen10: false,
            modalScreen11: false,
            modalScreen12: false,
            modalScreen13: false,
            modalScreen14: false,
            modalScreen15: false,
            modalScreen16: false,
            modalScreen17: false,
            modalScreen18: false,
            modalScreen19: false,
            modalScreen20: false,
            modalScreen21: false,
            modalScreen22: false,
            modalScreen23: false,
            modalScreen24: false,

            fab: false,

            drawer: null,

            successful: true,
    
        }
    },

    methods: {
        close: function() {
            this.successful = false
        },
        open: function() {
            this.successful = true
        },

        onScroll(e) {
            if (typeof window === "undefined") return
            const top = window.pageYOffset || e.target.scrollTop || 0
            this.fab = top > 20
        },
        toTop() {
            this.$vuetify.goTo(0)
        },

    }

});
