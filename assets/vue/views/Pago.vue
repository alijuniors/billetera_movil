<template>
  <div>
    <v-row class="contenedor-principal">

      <v-col cols="12" sm="4"  md="6" class="c-form offset-sm-4 offset-md-3">

        <v-form ref="form" v-model="valid" lazy-validation class="bg-forms">
          <h1 class="titulo-form">Pagar</h1>
          <v-text-field v-model="documento" :counter="20" :rules="documentoRules" label="Documento" required></v-text-field>
          <v-text-field v-model="monto" :rules="montoRules" label="Monto" required></v-text-field>
          <v-checkbox v-model="checkbox1" :rules="[v => !!v || 'Por favor seleccione para continuar']"
            label="¿Estás de acuerdo con la información?" required></v-checkbox>
          <template>

            <v-dialog v-model="dialog" persistent max-width="600px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn :disabled="!valid1" color="info" class="mr-3" @click="pago()" v-bind="attrs" v-on="on">
                  Pagar
                </v-btn>
                <v-btn color="success" class="mr-3 float-right"  v-bind="attrs" v-on="on">
                  Confirmar
                </v-btn>

              </template>
              <v-row justify="center">
                <v-card>
                  <v-card-title>
                    <span class="headline">Confirmacion</span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12">
                          <v-text-field v-model="id" :rules="idRules" label="Id de la Compra"
                            required></v-text-field>
                        </v-col>

                        <v-col cols="12">
                          <v-text-field v-model="token" :counter="6" :rules="tokenRules" label="Token" required>
                          </v-text-field>

                        </v-col>
                        <v-col cols="12">
                          <v-form ref="form" v-model="valid" lazy-validation>
                            <v-btn :disabled="!valid2" color="success" class="mr-4" @click="confirmacion">
                              Confirmar
                            </v-btn>
                            <v-btn color="error" class="mr-4" @click="reset2">
                              Borrar formulario
                            </v-btn>
                          </v-form>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">
                      Close
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-row>
            </v-dialog>

          </template>
        </v-form>

      </v-col>

    </v-row>

      <div class="fixed">  
        <div v-if="adv1">
          <v-alert type="info">Su recarga ha sido exitosa</v-alert>
        </div>
        <div v-else>
          <div v-if="subAdv1">
          </div>
          <div v-else>
            <v-alert type="error">Debe llenar correctamente el form</v-alert>
          </div>
        </div>
        <div v-if="adv2">
          <v-card class="mx-auto" max-width="344" outlined>
            <v-list-item three-line>
              <v-list-item-content>
                <div class="overline mb-4">
                  CONFIRMADO
                </div>
                <v-list-item-title class="headline mb-1">
                  Nombre
                </v-list-item-title>
                <v-list-item-subtitle>Pago de 500 bs</v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-avatar tile size="80" color="green"></v-list-item-avatar>
            </v-list-item>
          </v-card>
        </div>
        <div v-else>
          <div v-if="subAdv2">
          </div>
          <div v-else>
            <v-alert type="error">Los datos que introdujo son incorrectos, por favor intente de nuevo</v-alert>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
  export default {
    name: 'Pago',
    data: () => ({
      dialog: false,
      valid1: true,
      documento: '',
      documentoRules: [
        v => !!v || 'El documento es requerido',
        v => (v && v.length <= 20) || 'El documento debe tener maximo 20 caracteres',
      ],
      monto:'',
      montoRules: [
        v => !!v || 'El monto es requerido',
        v => /^\d+$/.test(v) || 'Ingrese un monto correcto',
      ],
      checkbox1: false,
      adv1: false,
      subAdv1: true,
      desabilitado: true,
      valid2: true,
      id: '',
      // idRules: [
      //   v => !!v || 'El id de la compra es requerido',
      //   v => (v && v.length <= 15) || 'El id debe tener menos de 15 caracteres',
      // ],
      token: '',
      tokenRules: [
        v => !!v || 'El token es requerido',
        v => (v && v.length == 6) || 'El token debe tener 6 caracteres',
      ],
      select: null,
      checkbox: false,
      adv2: false,
      subAdv2: true
    }),
    methods: {
      validate1() {
        if (this.documento.length == 15 && this.valor.length == 30 && this.celular.length == 15) {
          this.$refs.form.validate(),
            this.adv1 = true,
            this.desabilitado = false,
            setTimeout(() => {
              this.adv1 = false
            }, 6000)
        } else {
          this.subAdv1 = false,
            setTimeout(() => {
              this.subAdv1 = true,
                this.documento = '',
                this.valor = ''
              this.celular = ''
            }, 3000);
        }
      },
      reset1() {
        this.$refs.form.reset()
        this.adv1 = false
      },
      validate2() {
        if (this.idCompra.length == 15 && this.token.length == 30) {
          this.$refs.form.validate(),
            this.adv2 = true
        } else {
          this.subAdv2 = false,
            setTimeout(() => {
              this.subAdv2 = true,
                this.idCompra = '',
                this.token = ''
            }, 3000);
        }

      },
      reset2() {
        this.$refs.form.reset()
        this.adv2 = false
      },
      pago(){
        let documento = 0;
        // let monto = this.monto;
        const obj = {'test0': 'holaaaa'};
        this.$http.post("http://localhost/billetera_movil/public/index.php/soapclient", obj)
        .then(respuesta => {
          console.log(respuesta)
          console.log(respuesta.data) 
        })
        .catch(error => { console.log('error')})
      },
      confirmacion(){
        let id = this.id;
        // let token = this.token;
        const obj = {'test0': 'holaaaa'};
        this.$http.post("http://localhost/billetera_movil/public/index.php/soapclient", obj)
        .then(respuesta => {
          console.log(respuesta)
          console.log(respuesta.data) 
        })
        .catch(error => { console.log('error')})
      }
    },
  }
</script>

<style>
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