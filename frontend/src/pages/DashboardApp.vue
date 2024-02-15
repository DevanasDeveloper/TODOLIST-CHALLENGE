<template>
   <main id="main" class="main">

    <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
        <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                <h5 class="card-title">Todos <span>| Total</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-menu-button-wide"></i>
                    </div>
                    <div class="ps-3">
                    <h6>{{ statistic.count_todos}}</h6>

                    </div>
                </div>
                </div>

            </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                <h5 class="card-title">Todos <span>| Completed</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-menu-button-wide"></i>
                    </div>
                    <div class="ps-3">
                    <h6>{{ statistic.count_todos_completed }}</h6>
                    </div>
                </div>
                </div>

            </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">

                <div class="card-body">
                <h5 class="card-title">Todos <span>| No completed</span></h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-menu-button-wide"></i>
                    </div>
                    <div class="ps-3">
                    <h6>{{ statistic.count_todos_no_completed }}</h6>
                    </div>
                </div>

                </div>
            </div>

            </div><!-- End Customers Card -->

        </div>
        </div><!-- End Left side columns -->

  </div>
</section>

</main><!-- End #main -->
</template>

<script>
    import api from '../api/api.js'
    import axios from 'axios'
    import { reactive } from 'vue';
    import { useToast } from "vue-toastification";
    import { useStore } from 'vuex';
    export default {
        name: 'DashboardApp',
        data(){
            return {
                statistic:reactive({
                    count_todos:0,
                    count_todos_completed:0,
                    count_todos_no_completed:0
                })
            }
        },
        setup() {
            const store = useStore();
            const toast = useToast();
            return { store,toast }
        },
        created(){
            this.getStatisticTodos()
        },
        methods:{
            async getStatisticTodos(){
                await axios.get(api.statisticTodos,{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{
                    if(response.status == 200){
                        this.statistic.count_todos = response.data.count_todos
                        this.statistic.count_todos_completed = response.data.count_todos_completed
                        this.statistic.count_todos_no_completed = response.data.count_todos_no_completed
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