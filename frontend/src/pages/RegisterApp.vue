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
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form method="post" class="row g-3 needs-validation" @submit.prevent="handleRegister"  enctype="multipart/form-data" novalidate>
          
                    <div class="col-12">
                      <label for="yourName" class="form-label">Fullname<span class="text-danger"> * </span></label>
                      <input type="text" placeholder="Fullname" name="fullname" class="form-control" :class="[errors.fullname ? 'is-invalid' : '']" id="fullname" v-model="register.fullname" required>
                      <div class="invalid-feedback"  v-if="errors.fullname">{{ errors.fullname[0] }}</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email<span class="text-danger"> * </span></label>
                      <input type="email" placeholder="Email" name="email" class="form-control" :class="[errors.email ? 'is-invalid' : '']" id="email" v-model="register.email" required>
                      <div class="invalid-feedback"  v-if="errors.email">{{ errors.email[0] }}</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password<span class="text-danger"> * </span></label>
                      <input type="password" placeholder="Password" name="password" class="form-control" :class="[errors.password ? 'is-invalid' : '']" id="yourPassword" v-model="register.password" required>
                      <div class="invalid-feedback"  v-if="errors.password">{{ errors.password[0] }}</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm password<span class="text-danger"> * </span></label>
                      <input type="password" placeholder="Confirm password" name="confirm_password" class="form-control" :class="[errors.confirm_password ? 'is-invalid' : '']" id="confirm_password" v-model="register.confirm_password" required>
                      <div class="invalid-feedback"  v-if="errors.confirm_password">{{ errors.confirm_password[0] }}</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <router-link to="/login">Log in</router-link></p>
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
    export default {
        name: 'RegisterApp',
        setup() {
            const toast = useToast();
            return { toast }
        },
        data(){
            return {
                register:reactive({
                    fullname:'',
                    email:'',
                    password:'',
                    confirm_password:'',
                }),
                errors:[]
            }
        },
        created(){

        },
        methods:{
            async handleRegister(){
                this.errors =[];
                await axios.post(api.register,this.register).then(response=>{
                    if(response.status == 200){
                        this.register.fullname = null
                        this.register.email = null
                        this.register.password = null
                        this.register.confirm_password = null
                        this.toast.success(response.data.message)
                        this.$router.push('/login')
                    }else{
                        this.toast.warning(response.data.message)
                    }
                }).catch(error=>{
                    console.log(error.response.data.errors)
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            }
        }
    }
</script>

<style>

</style>