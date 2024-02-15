<template>
    <div class="modal fade" :id="'div-new-todo-'+showTodo.id" tabindex="-1">
        <form method="post" class="row g-3 needs-validation" @submit.prevent="handleUpdateTodo"  enctype="multipart/form-data" novalidate>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Todo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Title<span class="text-danger"> * </span></label>
                                    <input type="title" placeholder="Title" name="title" class="form-control" :class="[errors.title ? 'is-invalid' : '']" id="title" v-model="todo.title" required>
                                    <div class="invalid-feedback"  v-if="errors.title">{{ errors.title[0] }}</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="description" rows="4" placeholder="Description" name="description" class="form-control" :class="[errors.description ? 'is-invalid' : '']" id="description" v-model="todo.description"></textarea>
                                    <div class="invalid-feedback"  v-if="errors.description">{{ errors.description[0] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" >Modify</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import api from '../../api/api.js'
    import axios from 'axios'
    import { reactive } from 'vue';
    import { useToast } from "vue-toastification";
    import { useStore } from 'vuex';
    export default {
        name: 'NewTodo',
        props:{
            showTodo: {}
        },
        setup() {
            const store = useStore();
            const toast = useToast();
            return { store,toast }
        },
        data(){
            return {
                todo:reactive({
                    id: this.showTodo.id,
                    title: this.showTodo.title,
                    description: this.showTodo.description
                }),
                isVisible:false,
                errors:[]
            }
        },
        created(){

        },
        methods:{
            async handleUpdateTodo(){
                this.errors =[];
                await axios.put(api.updateTodo.replace('value',this.todo.id),this.todo,{
                    headers:{
                        Authorization : 'Bearer '+ this.store.state.token
                    }
                }).then(response=>{
                    if(response.status == 200){
                        const itemIndex = this.store.state.todos.findIndex(item => item.id === this.todo.id)
                        this.store.state.todos[itemIndex] = response.data.todo;
                        this.toast.success(response.data.message)
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
        },
        mounted(){

        }
    }
</script>

<style>

</style>