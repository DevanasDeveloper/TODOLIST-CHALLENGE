<template>
    <HeaderApp :isLoggedIn="isAuthenticated"></HeaderApp>
    <SideBarApp :isLoggedIn="isAuthenticated"></SideBarApp>
    <router-view>
      
    </router-view>
    <FooterApp :isLoggedIn="isAuthenticated"></FooterApp>
</template>

<script>
import HeaderApp from './layout/HeaderApp.vue';
import SideBarApp from './layout/SideBarApp.vue';
import FooterApp from './layout/FooterApp.vue';
import { computed } from 'vue';
import { useStore } from 'vuex';
export default {
  setup() {
    const store = useStore();
    const isAuthenticated = computed(() => store.state.isAuthenticated);

    return {
      isAuthenticated
    };
  },
  name: 'App',
  components:{
    HeaderApp,
    SideBarApp,
    FooterApp
  }
}
</script>

<style>

</style>
