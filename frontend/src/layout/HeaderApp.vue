<template>
   <!-- ======= Header ======= -->
  <header v-if="isLoggedIn" id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    <router-link to="/" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">TODOLIST</span>
    </router-link>
    <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

        

        <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ profile.fullname }}</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
                <a class="dropdown-item d-flex align-items-center" @click="handleLogout" href="javascript:void(0)">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Log Out</span>
                </a>
            </li>

        </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

    </ul>
    </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
</template>

<script>
    import api from '../api/api.js'
    import axios from 'axios'
    import { useToast } from "vue-toastification";
    import { useStore } from 'vuex';
    export default {
        name: 'HeaderApp',
        setup() {
            const store = useStore();
            const toast = useToast();
            return { store,toast }
        },
        data(){
            return{
                profile:{}
            }
        },
        created(){
            this.handleProfile()
        },
        props:{
            isLoggedIn:Boolean
        },
        methods:{
            async handleLogout(){
                await axios.get(api.logout,{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{  
                    console.log(response)
                    if(response.status == 200){
                        localStorage.removeItem('token')
                        this.store.state.isAuthenticated = false
                        this.store.state.token = null
                        this.toast.success(response.data.message)
                        this.$router.push('/login')
                    }
                }).catch(error=>{
                    console.log(error)
                })
            },
            async handleProfile(){
                await axios.get(api.profile,{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{
                    if(response.status == 200){
                        this.profile = response.data.profile
                        console.log(this.profile.fullname)
                    }
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
</script>

<style>

</style>