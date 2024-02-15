<template>
    <main id="main" class="main">

    <div class="pagetitle">
    <h1>Todos</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Dashboard</router-link></li>
        <li class="breadcrumb-item active">Todos</li>
        </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title">With Checkboxes and radios</h5>
                            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#div-new-todo"><i class="ri ri-add-circle-line"></i></button>
                            <NewTodo/>
                        </div>
                    

                    <!-- List group With Checkboxes and radios -->
                    <div class="div-todos-scroll">
                        <div class="div-todos">
                            <ul class="list-group">
                                <li v-for="todo in todos" :key="todo.id" class="list-group-item my-2 d-flex justify-content-between align-items-center">
                                    <div class="d-flex">
                                        <i @click="handleCompleted(todo)" class="bi check-icon " :class="todo.completed ? 'bi-check-circle-fill text-success' : 'bi-circle text-danger'"></i>
                                        <span class="span-todo-title">{{todo.title}}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="div-todo-status">
                                            <span v-if="todo.completed" class="badge bg-success">Completed</span>
                                            <span v-else class="badge bg-danger">No completed</span>
                                        </div>
                                        <div class="div-todo-date">
                                            <span class="text-secondary">{{ formatDate(todo.created_at) }}</span>
                                        </div>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" :data-bs-target="'#div-show-todo-'+ todo.id"><i class="ri-eye-line text-info m-2"></i></a>
                                        <ShowTodo :showTodo="todo"/>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" :data-bs-target="'#div-new-todo-'+ todo.id"><i class="ri-edit-2-line text-primary m-2"></i></a>
                                        <EditTodo :showTodo="todo"/>
                                        <a href="javascript:void(0)" @click="deleteTodo(todo)"><i class="ri-delete-bin-6-line text-danger m-2"></i></a>
                                    </div>
                                </li>
                                <li v-if="todos.length<=0" class="list-group-item my-3 text-center">
                                    There is no result
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    
                    <!-- End List Checkboxes and radios -->
                    </div>
                </div>

            </div>
        </div>
    </section>

    </main><!-- End #main -->
</template>

<script>
    import NewTodo from '../modals/todos/NewTodo.vue'
    import EditTodo from '../modals/todos/EditTodo.vue'
    import ShowTodo from '../modals/todos/ShowTodo.vue'
    import moment from 'moment';
    import api from '../api/api.js'
    import axios from 'axios'
    import { useToast } from "vue-toastification";
    import { useStore } from 'vuex';
    export default {
        name: 'TodoListApp',
        components :{
            NewTodo,
            EditTodo,
            ShowTodo
        },
        setup() {
            const store = useStore();
            const toast = useToast();
            return { store,toast }
        },
        computed :{
            todos() {
                return this.store.state.todos
            }
        },
        created(){
            this.getTodos()
        },
        methods:{
            async getTodos(){
                await axios.get(api.todos,{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{
                    if(response.status == 200){
                        this.store.state.todos = response.data.todos;
                    }
                }).catch(error=>{
                    console.log(error)
                })
            },
            async handleCompleted(todo){
                await axios.get(api.completedTodo.replace('value',todo.id),{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{
                    if(response.status == 200){
                        todo.completed = response.data.todo.completed
                        this.toast.success(response.data.message)
                    }else{
                        this.toast.warning(response.data.message)
                    }
                }).catch(error=>{
                    console.log(error)
                })
            },
            async deleteTodo(todo){
                await axios.delete(api.deleteTodo.replace('value',todo.id),{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{
                    if(response.status == 200){
                        this.store.state.todos = this.store.state.todos.filter(item=>item.id != todo.id)
                        this.toast.success(response.data.message)
                    }else{
                        this.toast.warning(response.data.message)
                    }
                }).catch(error=>{
                    console.log(error.response.data.errors)
                })
            },
            formatDate(date){
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            }
        }
    }
</script>

<style>

</style>