<template>
    <div class="user-task-container">
        <div v-if="task" class="user-task-header">
            <h3>{{ task.title }}</h3>
            <p>{{ task.description }}</p>
        </div>
        <div class="action-button">
            <button class="update-btn btn" @click="showUpdateTaskModal">
                Update Task
            </button>
            <button class="create-btn btn" @click="showCreateUserTaskModal">
                Create New Task
            </button>
        </div>

        <div v-if="isLoading" class="loading">
            <p>Loading...</p>
        </div>
        <div v-if="!isLoading && task" class="user-task">
            <UserTask :id="id" @status-change="changeStatus" />
            <CreateUserTaskModal
                :taskId="id"
                :showModal="showModal"
                :pageName="pageName"
                @closeModal="closeModal"
            />
            <TaskCreateModal
                :taskId="id"
                :showModal="showTaskModal"
                :taskSelect="task"
                :pageName="pageName"
                @closeModal="closeModal"
            />
        </div>
    </div>
</template>

<script>
import UserTask from "../components/UserTask.vue";
import CreateUserTaskModal from "../components/CreateUserTaskModal.vue";
import TaskCreateModal from "../components/TaskCreateModal.vue";
export default {
    name: "UserTasks",
    data() {
        return {
            task: {
                id: "",
                title: "",
                description: "",
                status_id: "",
                due_date: "",
            },
            showModal: false,
            showTaskModal: false,
            pageName: "",
        };
    },
    mounted() {
        this.getTask();
    },
    props: {
        id: {
            type: Number,
            required: true,
        },
    },
    methods: {
        showCreateUserTaskModal() {
            // Set showModal to true to show the create task modal
            this.pageName = "Create New User Task";
            this.showModal = true;
        },
        showUpdateTaskModal() {
            this.pageName = "Updating Task";
            this.showTaskModal = true;
        },
        closeModal() {
            // Set showModal to false to hide the create task modal
            this.showTaskModal = false;
        },
        closeTaskModal() {
            // Set showModal to false to hide the create task modal
            this.showTaskModal = false;
            this.getTask();
        },
        changeStatus(newStatusId) {
            // Emit event to parent component with new status ID
            this.$emit("status-change", this.task.id, newStatusId);
        },
        getTask() {
            this.isLoading = true;
            let token = localStorage.getItem("token");
            let fetchRequest = axios
                .get("/api/tasks/v1/" + this.id, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    let taskObject = response.data.data;
                    this.task = {
                        id: taskObject.id,
                        title: taskObject.title,
                        description: taskObject.description,
                        status_id: taskObject.status_id,
                        due_date: taskObject.due_date,
                    };
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
            this.isLoading = false;
        },
    },
    components: {
        UserTask,
        CreateUserTaskModal,
        TaskCreateModal,
    },
};
</script>

<style scoped>
.user-task-container {
    margin-top: 1rem;
    margin-bottom: 1rem;
    padding: 1rem;
    border: 1px solid #ddd;
}
.user-task-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    background-color: #2ec4b6;
    padding: 10px;
    border: 1px solid #2ec4b6;
    border-radius: 5px;
}

.task-id {
    color: #fff;
    font-size: 18px;
    margin-bottom: 5px;
}

.task-title {
    color: #f3f3f3;
    font-size: 14px;
}
.loading {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1rem;
    text-align: center;
    font-family: sans-serif;
}
.action-button {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem; /* space between buttons and task card */
    justify-content: space-between; /* space between buttons */
    margin: 1rem;
}
.create-btn {
    margin-left: auto;
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    background-color: #000;
    color: #fff;
    cursor: pointer;
}
.update-btn {
    /*green update button */
    background-color: #2fb95d;
    color: #fff;
    border-radius: 4px;
    border: none;
    padding: 0.5rem 1rem;
}
.update-btn:hover {
    /*green update button */
    background-color: #fff;
    color: #2fb95d;
    border: 1px solid #2fb95d;
}
</style>
