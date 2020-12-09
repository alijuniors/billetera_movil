<template>
  <div>
    <v-row>
    
      <v-col cols="12" sm="4"  md="6" class="c-form offset-sm-4  offset-md-3">

        <v-form ref="form" v-model="valid" lazy-validation class="bg-forms">
          <h1 class="titulo-form">Registro</h1>

          <v-text-field v-model="documento" :counter="20" :rules="documentoRules" label="Documento" required></v-text-field>
          <v-text-field v-model="name" :counter="30" :rules="nameRules" label="Nombres" required></v-text-field>
          <v-text-field v-model="email" :rules="emailRules" label="Email" required></v-text-field>
          <v-text-field v-model="celular" :counter="15" :rules="celularRules" label="Celular" required></v-text-field>

          <v-btn :disabled="!valid" color="info" class="mr-2" @click="registro()">
            Registrar
          </v-btn>

          <v-btn color="error" class="mr-4" @click="reset">
            Borrar formulario
          </v-btn>

        </v-form>

      </v-col>

      <v-col  class="col-3 hidden-md-dowm"></v-col>

    </v-row>

    <div class="fixed" v-if="advertencia">

      <v-alert type="info">Su registro ha sido exitoso</v-alert>

    </div>

    <div class="fixed" v-else>
      <div v-if="adv">
      </div>
      <div v-else>
        <v-alert type="error">Hubo es un error en su registro, por favor intente de nuevo</v-alert>
      </div>
    </div>


  </div>
</template>

<script>

  export default {
    name: 'Registro',
    data: () => ({
      valid: true,
      documento: '',
      documentoRules: [
        v => !!v || 'El documento es requerido',
        v => (v && v.length >= 7 && v.length <= 20) || 'El documento debe tener entre 7 a 20 caracteres',
      ],
      name: '',
      nameRules: [
        v => !!v || 'El nombre es requerido',
        v => (v && v.length >= 3 && v.length <= 25) || 'Debe tener entre 3 a 25 caracteres',
      ],
      celular: '',
      celularRules: [
        v => !!v || 'El número de celular es requerido',
        v => (v && v.length >= 7 && v.length <= 25) || 'Por favor coloque su número de celular',
        v => /^\d+$/.test(v) || 'Ingrese un número de celular correcto',

      ],
      email: '',
      emailRules: [
        v => !!v || 'El Email es requerido',
        v => /.+@.+\..+/.test(v) || 'El email debe ser válido',
      ],
      select: null,
      advertencia: false,
      adv: true
    }),
    methods: {
      reset() {
        this.$refs.form.reset()
        this.advertencia = false
      },
      registro(){
        let documento = this.documento;
        let nombre = this.name;
        let email = this.email;
        let celular = this.celular;
        const obj = {
          'tipo': 'registrar',
          'documento': documento,
          'nombre': nombre,
          'email': email,
          'celular': celular
        };
        this.$http.post("http://localhost/billetera_movil/public/index.php/soapclient", obj)
        .then(respuesta => {
          console.log(respuesta.data),
          setTimeout(() => {
              this.documento = '',
              this.name = '',
              this.celular = '',
              this.email = ''
              this.advertencia = true
            }, 3000);
          this.advertencia = true
        })
        .catch(error => { 
          console.log('Error Axios'),
          setTimeout(() => {
              this.adv = true,
                this.documento = '',
                this.name = '',
                this.celular = '',
                this.email = ''
            }, 3000);
          })
        
      },
    },
  }
</script>