// register modal component
Vue.component('modal-modificar', {
  template: '#modal-template'
});

Vue.component('viajes-modificar', {
    data : function() {
        return {
            'viajes_netos' : [],
            'cargando' : false,
            'guardando' : false,
            'form' : {
                'data' : {
                    'CubicacionCamion' : '',
                    'IdOrigen' : '',
                    'IdTiro' : '',
                    'IdMaterial' : '',
                    'IdSindicato' : '',
                    'IdEmpresa' : '',
                },
                'errors' : []
            },
        }
    },
    
    directives: { 
        datepicker: {
            inserted: function(el) {
                $(el).datepicker({
                    format: 'yyyy-mm-dd',
                    language: 'es',
                    autoclose: true,
                    clearBtn: true,
                    todayHighlight: true,
                    endDate: '0d'
                });
                $(el).val(App.timeStamp(1));
            }
        },
        
        tablefilter: {
            inserted: function(el) {
                var val_config = {
                    auto_filter: true,
                    watermark: [
                        '#',
                        'Fecha Llegada',
                        'Hora Llegada',
                        'Sindicato',
                        'Empresa',
                        'Origen',
                        'Tiro',
                        'Camion', 
                        'Cubic.',
                        'Material',
                        'Código',
                        'Modificar'
                    ],
                    col_0: 'none',
                    col_1: 'input',
                    col_2: 'input',
                    col_3: 'select',
                    col_4: 'select',
                    col_5: 'select',
                    col_6: 'select',
                    col_7: 'select',
                    col_8: 'input',
                    col_9: 'select',
                    col_10: 'input',
                    col_11: 'none',

                    base_path: App.tablefilterBasePath,
                    paging: false,
                    rows_counter: false,
                    rows_counter_text: 'Viajes: ',
                    btn_reset: true,
                    btn_reset_text: 'Limpiar',
                    clear_filter_text: 'Limpiar',
                    loader: true,
                    help_instructions: false,
                    extensions: [{ name: 'sort' }]       
                };
                var tf = new TableFilter('viajes_netos_modificar', val_config);
                tf.init();
            }         
        }        
    },
    
    methods: {

        buscar: function(e) {

            e.preventDefault();

            var _this = this;

            this.cargando = true;
            this.form.errors = [];

            var data = $('.form_buscar').serialize();
            var url = App.host + '/viajes_netos?action=modificar&' + data;

            this.$http.get(url).then((response) => {
                _this.cargando = false;
            if(! response.body.viajes_netos.length) {
                swal('¡Sin Resultados!', 'Ningún viaje coincide con los datos de consulta', 'warning');
            } else {
                _this.viajes_netos = response.body.viajes_netos;
            }
        }, (error) => {
                _this.cargando = false;
                swal('¡Error!', App.errorsToString(error.body), 'error');
            });
        },

        modificar: function(viaje) {

            var _this = this;

            swal({
                title: "¿Desea continuar con la modificación?",
                text: "¿Esta seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si",
                cancelButtonText: "No",
                confirmButtonColor: "#ec6c62"
            },
            function () {
                _this.guardando = true;
                _this.form.errors = [];
                var data = _this.form.data;

                _this.$http.post(App.host + '/viajes_netos', {'type' : 'modificar', '_method' : 'PATCH', 'IdViajeNeto' : viaje.IdViajeNeto,  data}).then((response) => {
                    swal({
                        type: response.body.tipo,
                        title : '',
                        text: response.body.message,
                        showConfirmButton: true,
                        html:true
                    });

                    viaje.CubicacionCamion = response.body.viaje.CubicacionCamion;
                    viaje.Tiro = response.body.viaje.Tiro;
                    viaje.IdTiro = response.body.viaje.IdTiro;
                    viaje.Origen = response.body.viaje.Origen;
                    viaje.IdOrigen = response.body.viaje.IdOrigen;
                    viaje.Material = response.body.viaje.Material;
                    viaje.IdMaterial = response.body.viaje.IdMaterial;
                    viaje.IdSindicato = response.body.viaje.IdSindicato;
                    viaje.Sindicato = response.body.viaje.Sindicato;
                    viaje.IdEmpresa = response.body.viaje.IdEmpresa;
                    viaje.Empresa = response.body.viaje.Empresa;

                    viaje.ShowModal = false;
                    _this.guardando = false;
                }, (error) => {
                    _this.guardando = false;
                    viaje.ShowModal = false;
                    swal({
                        type: 'error',
                        title: '¡Error!',
                        text: App.errorsToString(error.body),
                        html: true
                    });
                });
            });
        },

        showModal: function(viaje) {
            viaje.ShowModal = true;
            this.initializeData(viaje);
        },

        initializeData: function(viaje) {
            this.form.data.CubicacionCamion = viaje.CubicacionCamion;
            this.form.data.IdOrigen = viaje.IdOrigen;
            this.form.data.IdTiro = viaje.IdTiro;
            this.form.data.IdMaterial = viaje.IdMaterial;
            this.form.data.IdSindicato = viaje.IdSindicato;
            this.form.data.IdEmpresa = viaje.IdEmpresa;
        }
    }
});