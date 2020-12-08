<template>
  <div>
    <v-row>
    
      <v-col cols="12" sm="4"  md="6" class="c-form offset-sm-4  offset-md-3">
      <v-form ref="form" v-model="valid" lazy-validation class="bg-forms">
        <h1 class="titulo-form">Registro</h1>
        <v-text-field v-model="documento" :counter="15" :rules="documentoRules" label="Documento" required>
        </v-text-field>

        <v-text-field v-model="name" :counter="30" :rules="nameRules" label="Nombres" required></v-text-field>

        <v-text-field v-model="email" :rules="emailRules" label="Email" required></v-text-field>

        <v-text-field v-model="celular" :counter="15" :rules="celularRules" label="Celular" required></v-text-field>

        <v-checkbox v-model="checkbox" :rules="[v => !!v || 'Por favor seleccione para continuar']"
          label="¿Estás de acuerdo con la información?" required></v-checkbox>

        <v-btn :disabled="!valid" color="info" class="mr-2" @click="validate">
          Registrar
        </v-btn>

        <v-btn color="error" class="mr-4" @click="reset">
          Borrar formulario
        </v-btn>

      </v-form>
      </v-col>
      <v-col  class="col-3 hidden-md-dowm"></v-col>
    </v-row>
    <div v-if="advertencia">

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
        v => (v && v.length <= 15) || 'El documento debe tener menos de 15 caracteres',
      ],
      name: '',
      nameRules: [
        v => !!v || 'El nombre es requerido',
        v => (v && v.length <= 30) || 'Debe tener menos de 30 caracteres',
      ],
      celular: '',
      celularRules: [
        v => !!v || 'El número de celular es requerido',
        v => (v && v.length <= 15) || 'Por favor coloque su número de celular',
      ],
      email: '',
      emailRules: [
        v => !!v || 'El Email es requerido',
        v => /.+@.+\..+/.test(v) || 'El email debe ser válido',
      ],
      select: null,
      checkbox: false,
      advertencia: false,
      adv: true
    }),
    methods: {
      validate() {
        if (this.documento.length == 15 && this.name.length > 5 && this.celular.length == 15) {
          this.$refs.form.validate(),
            this.advertencia = true
        } else {
          this.adv = false,
            setTimeout(() => {
              this.adv = true,
                this.documento = '',
                this.name = '',
                this.celular = '',
                this.email = ''
            }, 3000);
        }

      },
      reset() {
        this.$refs.form.reset()
        this.advertencia = false
      },
    },
  }
</script>

<style>

</style>