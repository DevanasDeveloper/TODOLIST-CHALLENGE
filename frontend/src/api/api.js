let url = "http://localhost:8000/api";
const api = {
    register : url+"/auth/register",
    profile : url+"/profile",
    login : url+"/auth/login",
    logout : url+"/auth/logout",
    statisticTodos : url+"/todos/statistic",
    todos : url+"/todos",
    storeTodo: url+"/todo/store",
    updateTodo: url+"/todo/value/update",
    completedTodo: url+"/todo/value/completed",
    deleteTodo: url+"/todo/value/delete"
}

export default api;