<template>
  <v-app >
    <Menu/>
    <router-view />
    <Footer/>
  </v-app>
</template>
<script>
import Menu from './components/Menu.vue'
import Footer from './components/Footer.vue'
export default {
  name: 'App',
  components: {
    Menu,
    Footer
  },
  data: () => ({
  }),
  mounted() {

    let el = document.querySelector("div[data-words]");
    let mywords = el.dataset.words.split(",");

    this.words.push.apply(this.words, mywords);
  }
};
</script>

<style>

  .v-application{
    background-image: url("./images/fondo.svg") !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
    background-size: cover !important;  
    background-attachment: fixed !important;
  }
  .v-application--wrap{
    justify-content: center;
  }

</style>