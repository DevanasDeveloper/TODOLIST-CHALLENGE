<template>
    <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <router-link to="/" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">TODOLIST</span>
                </router-link>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  <form method="post" class="row g-3 needs-validation" @submit.prevent="handleLogin"  enctype="multipart/form-data" novalidate>
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email<span class="text-danger"> * </span></label>
                      <input type="email" placeholder="Email" name="email" class="form-control" :class="[errors.email ? 'is-invalid' : '']" id="email" v-model="login.email" required>
                      <div class="invalid-feedback"  v-if="errors.email">{{ errors.email[0] }}</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password<span class="text-danger"> * </span></label>
                      <input type="password" placeholder="Password" name="password" class="form-control" :class="[errors.password ? 'is-invalid' : '']" id="password" v-model="login.password" required>
                      <div class="invalid-feedback"  v-if="errors.password">{{ errors.password[0] }}</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <router-link to="/register">Create an account</router-link></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
</template>

<script>
   import api from '../api/api.js'
    import axios from 'axios'
    import { reactive } from 'vue';
    import { useToast } from "vue-toastification";
    import { useStore } from 'vuex';
    export default {
        name: 'LoginApp',
        setup() {
            const store = useStore();
            const toast = useToast();
            return { toast,store }
        },
        data(){
            return {
                login:reactive({
                    email:'',
                    password:'',
                }),
                errors:[]
            }
        },
        created(){

        },
        methods:{
            async handleLogin(){
                this.errors =[];
                await axios.post(api.login,this.login).then(response=>{  
                    console.log(response)
                    if(response.status == 200){
                        this.login.email = null
                        this.login.password = null
                        localStorage.setItem('token',response.data.token)
                        this.store.state.isAuthenticated = true;
                        this.store.state.token = response.data.token;
                        this.toast.success(response.data.message)
                        this.$router.push('/')
                    }else{
                        this.toast.warning(response.data.message)
                    }
                }).catch(error=>{
                    console.log(error)
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            }
        },
        mounted(){

        }
    }
</script>

<style>

</style>