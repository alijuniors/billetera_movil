<template>
  <v-app >
    <Menu/>
    <router-view />
    <Footer/>
  </v-app>
</template>

<script>
import Menu from './components/Menu'
import Footer from './components/Footer'
export default {
  name: 'App',
  components: {
    Menu,
    Footer
  },
  data: () => ({
  }),
};
</script>

<style>

  .v-application{
    background-image: url("./assets/fondo.svg") !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
    background-size: cover !important;  
    background-attachment: fixed !important;
  }
  .v-application--wrap{
    justify-content: center;
  }

</style>