<template>
    <div class="task-list-container">
        <h2>Task List</h2>
        <ul v-if="tasks.length > 0">
            <li
                v-for="task in tasks"
                :key="task.id"
                @click="viewUserTask(task)"
            >
                <div class="task-card">
                    <p>Task title: {{ task.title }}</p>
                    <p>Description: {{ task.description }}</p>
                    <p>
                        Created at:
                        {{ Date(task.created_at).toString().slice(0, 15) }}
                    </p>
                    <div class="task-actions">
                        <button
                            class="action-btn update-btn"
                            @click="updateTask(task)"
                        >
                            Update
                        </button>
                        <button
                            class="action-btn delete-btn"
                            @click="deleteTask(task.id)"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </li>
        </ul>
        <li v-else>No tasks found</li>
        <li class="errors" v-if="error">{{ error }}</li>
    </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
    data() {
        return {
            tasks: [], // Update this with the actual list of tasks from the API
            error: null,
            id: "",
            showModal: false,
            task: "",
        };
    },
    mounted() {
        if (
            typeof localStorage.getItem("token") !== "undefined" &&
            localStorage.getItem("token") !== null
        ) {
            this.isAuthenticated = true;
            this.token = localStorage.getItem("token");
        }

        this.fetchTasks();
        //console.log(typeof this.tasks);
    },

    methods: {
        viewTaskDetail(taskId) {
            // Redirect to TaskDetail page with taskId as route parameter
            this.$router.push(`/task/${taskId}`);
        },
        viewUserTask(task) {
            //console.log(task);
            // Navigate to user-task page with the specified userTaskId as route param
            this.$router.push({
                name: "UserTasks",
                params: {
                    id: task.id,
                    title: task.title,
                    description: task.description,
                    created_at: task.created_at,
                },
            });
        },
        fetchTasks() {
            // use axios to fetch the tasks from the API and update the tasks array
            let token = localStorage.getItem("token");
            let fetchRequest = axios
                .get("/api/tasks/v1", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    let taskObject = response.data.data;
                    if (taskObject.length > 0) {
                        this.tasks = taskObject;
                    } else {
                        this.tasks = [];
                    }
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        this.error = "You are not authorized to view this page";
                        localStorage.removeItem("token");
                        this.isAuthenticated = false;
                        this.$router.push("/login");
                    } else {
                        this.error = "Something went wrong";
                    }
                })
                .finally(() => {
                    //console.log("finally");
                });

            //if response code is not 200 return error
            if (fetchRequest.status !== 200) {
                //console.log("error");
            }
        },

        deleteTask(taskId) {
            // Delete a task by taskId
            let token = localStorage.getItem("token");
            axios
                .delete(`/api/tasks/v1/${taskId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    this.fetchTasks();
                    //reload the page
                    this.$router.go();
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        this.error = "You are not authorized to view this page";
                        localStorage.removeItem("token");
                        this.isAuthenticated = false;
                        this.$router.push("/login");
                    } else {
                        this.error = "Something went wrong";
                    }
                })
                .finally(() => {
                    //console.log("finally");
                });
        },
    },
};
</script>

<style scoped>
.task-list-container {
    max-width: 800px;
    margin: 1rem auto;
    padding: 2rem;
}

h2 {
    margin-top: 0;
    text-align: start;
    font-size: 1.8rem;
}

ul {
    list-style-type: none;
    padding: 1rem;
}

li {
    cursor: pointer;
    padding: 0.5rem;
    border: 1px solid #ccc;
    margin-bottom: 1.5rem;
    color: #2ec4b6;
    border-radius: 6px;
    background-color: #f5f5f5;
}
li .task-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
}

li:hover {
    background-color: #2ec4b6;
    color: #fff;
}

li:last-child {
    margin-bottom: 0;
}

li:active {
    background-color: #2ec4b6;
    color: #fff;
}

li:focus {
    background-color: #2ec4b6;
    color: #fff;
}

li:visited {
    background-color: #2ec4b6;
    color: #fff;
}

li.errors {
    color: #e71d36;
    background-color: #fff;
    border: 1px solid #e71d36;
}
.task-actions {
    /* delete and update buttons */
    display: flex;
    margin-top: 1rem; /* space between buttons and task card */
    justify-content: space-between; /* space between buttons */
    width: 100%;
}
.action-btn {
    /* update button */
    background-color: #2ec4b6;
    color: #fff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease-in-out;
}
.delete-btn {
    /* delete button */
    background-color: #e71d36;
    color: #fff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    margin-right: 1rem;
    transition: all 0.3s ease-in-out;
}
.delete-btn:hover {
    background-color: #fff;
    color: #e71d36;
    border: 1px solid #e71d36;
}

@media (min-width: 768px) {
    .task-list-container {
        padding: 2rem 4rem;
    }
}

@media (min-width: 992px) {
    .task-list-container {
        padding: 2rem 6rem;
    }
}

@media (min-width: 1200px) {
    .task-list-container {
        padding: 2rem 8rem;
    }
}
</style>
