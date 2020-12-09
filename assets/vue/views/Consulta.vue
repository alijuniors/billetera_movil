<template>
  <div>
    <v-row>
      <v-col cols="12" sm="4" class="c-form offset-sm-4">
        <v-form ref="form" v-model="valid" lazy-validation class="bg-forms">
          <h1 class="titulo-form">Consulta</h1>
          <v-text-field v-model="documento" :counter="20" :rules="documentoRules" label="Documento" required>
          </v-text-field>

          <v-text-field v-model="celular" :counter="25" :rules="celularRules" label="Celular" required></v-text-field>

          <template>
            <v-row justify="center">
              <v-dialog v-model="dialog" persistent max-width="290">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn v-bind="attrs" v-on="on" :disabled="!valid" color="info" class="mr-3 float-left" @click="consulta()">
                    consultar
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline">
                   Consulta <span class="ml-auto" @click="dialog=false" style="cursor: pointer;">X</span>
                  </v-card-title>

                  <div>
                    <div v-if="advertencia">
                      <div class="col-12 text-center">
                        <v-card :loading="loading" class="mx-auto my-auto pa-5" max-width="374">
                          <template slot="progress">
                            <v-progress-linear color="deep-purple" height="10" indeterminate></v-progress-linear>
                          </template>

                          <v-card-title>{{datos.nombre}}</v-card-title>


                          <v-divider class="mx-4"></v-divider>

                          <v-card-title>Su saldo es: {{datos.monto}}</v-card-title>
                          <v-chip active-class="deep-purple accent-4 white--text" column>530 Bs</v-chip>


                        </v-card>
                      </div>

                    </div>
                    <div class="fixed" v-else>
                      <div v-if="adv">
                      </div>
                      <div v-else>
                        <v-alert type="error">Hubo es un error en su consulta</v-alert>
                      </div>
                    </div>
                  </div>
                </v-card>
              </v-dialog>
            </v-row>
          </template>
        </v-form>
      </v-col>
    </v-row>








  </div>
</template>

<script>
  export default {
    name: 'Consulta',
    data: () => ({
      datos:[],
      dialog: false,
      valid: true,
      documento: '',
      documentoRules: [
        v => !!v || 'El documento es requerido',
        v => (v && v.length >= 7 && v.length <= 20) || 'El documento debe tener entre 7 a 20 caracteres',
      ],
      celular: '',
      celularRules: [
        v => !!v || 'El número de celular es requerido',
        v => (v && v.length >= 7 && v.length <= 25) || 'Por favor coloque su número de celular',
      ],
      select: null,
      advertencia: false,
      adv: true
    }),
    methods: {
      validate() {
        if (this.documento.length == 15 && this.celular.length == 15) {
          this.$refs.form.validate(),
            this.advertencia = true
        } else {
          this.adv = false,
            setTimeout(() => {
              this.adv = true,
                this.documento = '',
                this.celular = ''
            }, 3000);
        }

      },
      reset() {
        this.$refs.form.reset()
        this.advertencia = false
      },
      consulta(){
        let documento = this.documento;
        let celular = this.celular;
        const obj = {
          'tipo': 'consultar',
          'documento': documento,
          'celular': celular
        };
        this.$http.post("http://localhost/billetera_movil/public/index.php/soapclient", obj)
        .then(respuesta => {
          console.log(respuesta),
          console.log(respuesta.data), 
          this.advertencia = true
          setTimeout(() => {
              this.advertencia = false,
                this.documento = '',
                this.celular = ''
            }, 3000);
          this.datos = respuesta.data
        })
        .catch(error => { 
          console.log('error')
          setTimeout(() => {
              this.adv = true,
                this.documento = '',
                this.celular = ''
            }, 3000);
          })
      }
    }
  }
</script>

<style>
  body {
    box-sizing: border-box !important;
  }

  .v-application .error--text {
    color: white !important;
    caret-color: steelblue !important;
  }

  .bg-forms {
    background: rgb(255, 255, 255, .7) !important;
    padding: 2.5rem !important;
    box-shadow: 3px 5px 5px 3px rgba(0, 0, 0, 0.801);
  }

  @media (max-width: 600px) {
    .bg-forms {
      padding: 15px !important;
    }
  }

  .row {
    margin-right: 0 !important;
    margin-left: 0 !important;
  }

  .col,
  .col-1,
  .col-2,
  .col-3,
  .col-4,
  .col-5,
  .col-6,
  .col-7,
  .col-8,
  .col-9,
  .col-10,
  .col-11,
  .col-12,
  .col-auto,
  .col-lg,
  .col-lg-1,
  .col-lg-2,
  .col-lg-3,
  .col-lg-4,
  .col-lg-5,
  .col-lg-6,
  .col-lg-7,
  .col-lg-8,
  .col-lg-9,
  .col-lg-10,
  .col-lg-11,
  .col-lg-12,
  .col-lg-auto,
  .col-md,
  .col-md-1,
  .col-md-2,
  .col-md-3,
  .col-md-4,
  .col-md-5,
  .col-md-6,
  .col-md-7,
  .col-md-8,
  .col-md-9,
  .col-md-10,
  .col-md-11,
  .col-md-12,
  .col-md-auto,
  .col-sm,
  .col-sm-1,
  .col-sm-2,
  .col-sm-3,
  .col-sm-4,
  .col-sm-5,
  .col-sm-6,
  .col-sm-7,
  .col-sm-8,
  .col-sm-9,
  .col-sm-10,
  .col-sm-11,
  .col-sm-12,
  .col-sm-auto,
  .col-xl,
  .col-xl-1,
  .col-xl-2,
  .col-xl-3,
  .col-xl-4,
  .col-xl-5,
  .col-xl-6,
  .col-xl-7,
  .col-xl-8,
  .col-xl-9,
  .col-xl-10,
  .col-xl-11,
  .col-xl-12,
  .col-xl-auto {
    width: 100%;
    padding: 0 !important;
  }
  .fixed{
  position: fixed;
  z-index: 9000;
  top: 40px;
  right: 5px;
}
.titulo-form{
  padding-bottom: 1.1rem;
  color: rgb(59, 59, 59);
}
</style>