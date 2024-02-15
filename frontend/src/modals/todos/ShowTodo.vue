<template>
    <div class="modal fade" :id="'div-show-todo-'+showTodo.id" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Show Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Table with hoverable rows -->
                    <table class="table table-hover table-todo-detail mb-0">
                        <tbody>
                        <tr>
                            <th scope="row">Title</th>
                            <td><span class="text-secondary">{{ showTodo.title }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row">Description</th>
                            <td><span class="text-secondary">{{ showTodo.description }}</span></td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                <span v-if="showTodo.completed" class="badge bg-success">Completed</span>
                                <span v-else class="badge bg-danger">No completed</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Created at</th>
                            <td><span class="text-secondary">{{ formaDate(showTodo.created_at) }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <!-- End Table with hoverable rows -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        name: 'NewTodo',
        props:{
            showTodo: {}
        },
        methods:{
            formaDate(date){
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            }
        }
    }
</script>

<style>

</style>