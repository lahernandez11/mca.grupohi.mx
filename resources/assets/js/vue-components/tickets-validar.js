Vue.component('tickets-validar', {
    data:function() {
        return {
            code: '',
            items:{},
            click: false,
            error: ''
        }
    },
    created: function() {

    },

    methods: {
        escanear: function (e) {
            var self = this;
            if ((e.keyCode == 13)){
                self.click = true;
                self.error = '';
                self.items = {};
                self.decodificar(e);
            }
        },
        decodificar: function(e) {
            e.preventDefault();
            var self = this;
            var url = App.host + '/tickets/validar?data=' + self.code;

            $.ajax({
                type : 'get',
                url: url,
                beforeSend: function() {
                },
                success: function(response) {
                    self.items = response;
                    self.code = '';
                },
                error: function(error) {
                    self.error = error.responseJSON.error;
                    self.code =  '';
                }
            });
        },
        limpiar: function () {
            var self = this;
            self.code = '';
            self.error = '';
            self.items = {};
        }


    }

});