<template>
    <div>
        <v-footer color="" padless class="footer" style="bottom:0;">
    <v-row justify="center" no-gutters>
    
      <v-col class="secondary lighten-2 py-4 text-center white--text" cols="12">
        {{ new Date().getFullYear() }} — <strong>Vue - Vuetify</strong>
      </v-col>
    </v-row>
  </v-footer>
    </div>
</template>
<script>
export default {
    data: () => ({
      links: [
        'About Us',
        'Team',
        'Services',
        'Blog',
        'Contact Us',
      ],
    }),
}
</script>

<style>
.footer{
  position: fixed !important;
  width: 100%;
  z-index: 10000;
  left: 0;

}
</style>