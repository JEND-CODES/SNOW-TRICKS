new Vue({
    el: '#appJEND',
    //Changement des délimiteurs pour l'interpolation des variables (cause conflits avec TWIG)
    delimiters: ['[+[', ']+]'],
    vuetify: new Vuetify(),

    data() {

        return {

            page: 1,

            // Button Navbar PopUp Login Logout
            dialog: false,

            // Button Navbar PopUp Search Bar
            dialog2: false,

            // Modals on posts medias Flex Grid items
            modal_screen_1: false,
            modal_screen_2: false,
            modal_screen_3: false,
            modal_screen_4: false,
            modal_screen_5: false,
            modal_screen_6: false,
            modal_screen_7: false,
            modal_screen_8: false,
            modal_screen_9: false,
            modal_screen_10: false,
            modal_screen_11: false,
            modal_screen_12: false,
            modal_screen_13: false,
            modal_screen_14: false,
            modal_screen_15: false,
            modal_screen_16: false,
            modal_screen_17: false,
            modal_screen_18: false,
            modal_screen_19: false,
            modal_screen_20: false,

            // Modals on posts medias Flex Grid items
            modal_update_1: false,
            modal_update_2: false,
            modal_update_3: false,
            modal_update_4: false,
            modal_update_5: false,
            modal_update_6: false,
            modal_update_7: false,
            modal_update_8: false,
            modal_update_9: false,
            modal_update_10: false,
            modal_update_11: false,
            modal_update_12: false,
            modal_update_13: false,
            modal_update_14: false,
            modal_update_15: false,
            modal_update_16: false,
            modal_update_17: false,
            modal_update_18: false,
            modal_update_19: false,
            modal_update_20: false,

            modal_1: false,
            modal_2: false,
            modal_3: false,
            modal_4: false,
            modal_5: false,
            modal_6: false,
            modal_7: false,

            // Button scroll to top
            fab: false,

            // Dropdown Nav Links
            navlinks: [{
                    title: 'Login'
                },
                {
                    title: 'Back Office'
                },
                {
                    title: 'Click Me 3'
                },
                {
                    title: 'Click Me 4'
                },
            ],

            colors: [
                'indigo lighten-3',
                'indigo lighten-2',
                'indigo lighten-1',
                'deep-purple lighten-3',
                'deep-purple lighten-2',
            ],
            // Slideshow titles test
            slides: [
                '1er',
                '2ème',
                '3ème',
                '4ème',
                '5ème',
            ],
            // Messages d'alertes
            info: 'INFO1',
            info2: 'INFO2',
            info3: 'INFO3',
            info4: 'INFO4',
            link: 'http://planetcode.fr',

            // Navigation drawer component :
            drawer: null,

            // Utiliser le v-if pour afficher un bloc, false-> ne s'affiche pas, true-> s'affiche :
            successful: true,
            // Placement d'un v-else qui s'affiche ou se masque en fonction de la valeur true/false de "successful

            // Utilisation d'un v-for pour afficher la liste d'un array qui crée autant de <li> qu'il y a de noms dans l'array :
            persons: [
                'Marie',
                'Marion',
                'Michel',
                'Olivier',
                'Jean',
            ]
        }
    },

    // Tests de methods :
    methods: {
        // Voir placement de @click="close" qui équivaut à v-on:click
        close: function() {
            this.successful = false
        },
        // Voir placement de @click="open"
        open: function() {
            this.successful = true
        },

        // Scroll on top function :
        onScroll(e) {
            if (typeof window === 'undefined') return
            const top = window.pageYOffset || e.target.scrollTop || 0
            this.fab = top > 20
        },
        toTop() {
            this.$vuetify.goTo(0)
        },

        // V-bind exemple https://codepen.io/minamo173/pen/aEdYpp?editors=1010 : Il suffit ensuite d'ajouter par exemple :v-bind:style="setColor('orange')" à un component...
        setColor(color) {
            let style
            switch (color) {
                case 'red':
                    style = {
                        "background-color": "#f44336"
                    }
                    break
                case 'blue':
                    style = {
                        "background-color": "#3f51b5"
                    }
                    break
                case 'orange':
                    style = {
                        "background-color": "#ff9800"
                    }
                    break
            }
            return style
        },

    }
});