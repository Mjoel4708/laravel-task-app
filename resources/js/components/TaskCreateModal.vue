<template>
    <div class="task-create-modal" v-show="showModal">
        <div v-if="isLoading" class="modal-content">...Loading</div>
        <div v-if="!isLoading" class="modal-content">
            <h2>{{ pageName }}</h2>
            <p v-if="taskSelect">Task ID: {{ taskSelect.id }}</p>
            <form @submit.prevent="createTask">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" v-model="task.title" required />
                </div>

                <div class="form-group">
                    <label for="dueDate">Due Date:</label>
                    <input
                        type="datetime-local"
                        v-model="task.due_date"
                        required
                    />
                </div>

                <div class="row form-group"></div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea
                        type="text"
                        rows="4"
                        id="description"
                        v-model="task.description"
                        required
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" v-model="task.status_id" required>
                        <option v-for="status in statuses" :value="status.id">
                            {{ status.name }}
                        </option>
                    </select>
                </div>
                <div class="error-message" v-if="error || errors">
                    <p>{{ error }}</p>
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                <div class="modal-buttons">
                    <button class="cancel-button" @click="cancelCreate">
                        Cancel
                    </button>
                    <button class="submit-button" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: {
        showModal: {
            type: Boolean,
            required: true,
        },

        taskSelect: {
            type: Object,
            required: false,
            id: {
                type: Number,
                required: false,
            },
            title: {
                type: String,
                required: false,
            },
            description: {
                type: String,
                required: false,
            },
            due_date: {
                type: String,
                required: false,
            },
            status_id: {
                type: Number,
                required: false,
            },
        },
        pageName: {
            type: String,
            required: false,
        },
    },
    data() {
        return {
            task: {
                id: "",
                title: "",
                due_date: "",
                description: "",
                status_id: "",
            },
            statuses: [],
            error: null,
            errors: [],
        };
    },
    mounted() {
        this.getStatus();
        //console.log(this.title);
        if (this.taskSelect) {
            this.isLoading = true;
            setTimeout(() => {
                this.task = this.taskSelect;
                this.isLoading = false;
            }, 1000);
        }
    },
    methods: {
        createTask(event) {
            if (this.taskSelect) {
                return this.updateTask(event);
            }
            event.preventDefault();
            let token = localStorage.getItem("token");
            let createTaskData = {
                title: this.task.title,
                due_date: this.task.due_date,
                description: this.task.description,
                status_id: this.task.status_id,
            };
            let createTaskRequest = axios
                .post("/api/tasks/v1", createTaskData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    this.$emit("closeModal");
                })
                .catch((error) => {
                    //console.log("Error 1", error);
                    if (error.response.status === 401) {
                        this.error = "You are not authorized to create a task";
                        return;
                    }
                    if (error.response.status === 422) {
                        let errorsObj = error.response.data.errors;
                        for (let key in errorsObj) {
                            if (errorsObj.hasOwnProperty(key)) {
                                this.errors = this.errors.concat(
                                    errorsObj[key]
                                );
                            }
                        }

                        return;
                    } else {
                        this.error = "Something went wrong";
                    }
                });
            //console.log(createTaskRequest);
        },
        updateTask(event) {
            event.preventDefault();
            let token = localStorage.getItem("token");
            let updateTaskData = {
                title: this.task.title,
                due_date: this.task.due_date,
                description: this.task.description,
                status_id: this.task.status_id,
            };
            let updateTaskRequest = axios
                .put(`/api/tasks/v1/${this.task.id}`, updateTaskData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    this.$emit("closeModal");
                    //go to the task page
                    this.$router.push("/tasks");
                    //reload the page
                    this.$router.go();
                })
                .catch((error) => {
                    //console.log("Error 1", error);
                    if (error.response.status === 401) {
                        this.error = "You are not authorized to create a task";
                        return;
                    }
                    if (error.response.status === 422) {
                        let errorsObj = error.response.data.errors;
                        for (let key in errorsObj) {
                            if (errorsObj.hasOwnProperty(key)) {
                                this.errors = this.errors.concat(
                                    errorsObj[key]
                                );
                            }
                        }

                        return;
                    } else {
                        this.error = "Something went wrong";
                    }
                });
            //console.log(updateTaskRequest);
        },
        getStatus() {
            //use axios to fetch the tasks from the API and update the tasks array
            let token = localStorage.getItem("token");
            let request = axios
                .get("/api/status/v1", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    let statusObj = response.data.data;
                    for (let key in statusObj) {
                        this.statuses.push(statusObj[key]);
                    }
                    //console.log(typeof this.statuses);
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

            //console.log(request);
        },
        cancelCreate() {
            // Emit an event to close the modal without creating a new task
            this.$emit("closeModal");
        },
    },
};
</script>

<style scoped>
.task-create-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    border-radius: 8px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    padding: 1rem;
    padding-top: 0.4rem;
    max-width: 500px;
    width: 100%;
    height: 90vh;
    overflow-y: auto;
}

h2 {
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
    font-family: "Roboto", sans-serif;
}

form {
    display: grid;
    gap: 0.4rem;
}

label {
    display: block;
}
input,
textarea,
select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.error-message {
    color: #e71d36;
    font-size: 0.8rem;
    margin-top: 0.2rem;
}
.error-message::before {
    content: "⚠ ";
}

.modal-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
}
.form-group {
    margin-bottom: 1rem;
}

button {
    cursor: pointer;
}
.submit-button {
    color: #fff;
    padding: 0.3rem 1rem;
    background-color: #2ec4b6;
    border: 1px solid #2ec4b6;
    border-radius: 6px;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
}
.cancel-button {
    color: #fff;
    padding: 0.5rem 1rem;
    background-color: #e71d36;
    border: 1px solid #e71d36;
    border-radius: 6px;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
}
</style>
