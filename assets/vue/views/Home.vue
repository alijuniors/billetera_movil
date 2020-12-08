<template>
  <div>
    <v-row >
      <v-col cols="12" lg="3" class="texto-hover" v-for="opcion of opciones" :key="opcion.id">
        <v-card class=" mx-auto v-card-w">
          <v-img class="v-card-img" :src="opcion.img">
            <v-card-title class="white--text mt-8 float-right" >
              <h1 class="mr-md-5 ">
                {{opcion.opcion}}
              </h1>
            </v-card-title>
          </v-img>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  export default {
    name: 'Home',
    components:{
    },
    data: () => ({
      a:'green',
      opciones:[
        {
          id:1,
          opcion:'Registro',
          subopcion:'Ultimos registros',
          url: '/registro',
          img: require('../images/fondoRegistro.svg'),
        },
        {
          id:2,
          opcion:'Recarga',
          subopcion:'Ultimas pagos',
          url: '/pagar',
          img: require('../images/fondoRecarga.svg')
        },
        {
          id:2,
          opcion:'Pagar',
          subopcion:'Ultimas pagos',
          url: '/pagar',
          img: require('../images/fondoRecarga.svg')
        },
        {
          id:3,
          opcion:'Consultar',
          subopcion:'Ultimos consultados',
          url: '/consulta',
          img: require('../images/fondoConsulta.svg')
        }
      ]
    }),

    methods: {
      ir(e){
        this.$router.push(e)
      }
    },
  }
</script>
<style scoped>
 .v-card-w{
   width: 450px !important;
 }
 .v-card-img{
   height: 180px !important;
   cursor: pointer;
   box-shadow: -5px 25px 25px 3px  rgba(0, 0, 0, 0.774);
   transition: width .5s ease-in !important;
 }
 .v-card-img:hover{
  box-shadow: 0px 5px 5px 3px  rgba(0, 0, 0, 0.712) !important;

 }

 h1{
   transition: all .4s ease;
 }
.texto-hover:hover h1{
   padding-right: 1.5rem;
 }
 @media (max-width:600px) {
   .v-card-x{
     width: 450px!important;
  }
  .v-card-img{
   height: 150px!important;
    box-shadow: 2px -7px 17px 6px rgba(0,0,0,0.75)!important;
   transition: width .5s ease-in !important;
 }
 }
</style>