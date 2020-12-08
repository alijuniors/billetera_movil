<template>
  <div>
    <v-row class="contenedor-principal">

      <v-col cols="12" sm="4"  md="6" class="c-form offset-sm-4 offset-md-3">

        <v-form ref="form" v-model="valid" lazy-validation class="bg-forms">
          <h1 class="titulo-form">Recargar</h1>
          <v-text-field v-model="documento" :counter="20" :rules="documentoRules" label="Documento" required></v-text-field>
          <v-text-field v-model="celular" :counter="25" :rules="celularRules" label="Celular" required></v-text-field>
          <v-text-field v-model="monto" :rules="montoRules" label="Monto" required></v-text-field>
          <v-checkbox v-model="checkbox1" :rules="[v => !!v || 'Por favor seleccione para continuar']"
            label="¿Estás de acuerdo con la información?" required></v-checkbox>

            <v-btn :disabled="!valid1" color="info" class="mr-3" @click="validate1" v-bind="attrs" v-on="on">
              Recargar
            </v-btn>
          
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
      </div>
  </div>
</template>

<script>
  export default {
    name: 'Recarga',
    data: () => ({
      dialog: false,
      valid1: true,
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
      checkbox1: false,
      adv1: false,
      subAdv1: true,
      desabilitado: true,
      select: null,
      expresionRegular:'\/d+',
      monto: '',
      montoRules: [
        v => !!v || 'El monto es requerido',
        v => /^\d+$/.test(v) || 'Ingrese un monto correcto',
      ],
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
      recarga(){
        let documento = 0;
        // let celular = this.celular;
        // let monto = this.monto;
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
