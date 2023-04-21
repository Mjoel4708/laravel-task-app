<template>
    <div class="task-create-modal" v-show="showModal">
        <div class="modal-content">
            <h2>{{ pageName }}</h2>
            <form @submit.prevent="createUserTask">
                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea
                        type="text"
                        rows="4"
                        id="remarks"
                        v-model="task.remarks"
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="dueDate">Due Date:</label>
                    <input
                        type="datetime-local"
                        v-model="task.due_date"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="startDate">Start Date:</label>
                    <input
                        type="datetime-local"
                        v-model="task.start_date"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="endDate">End Date:</label>
                    <input
                        type="datetime-local"
                        v-model="task.end_date"
                        required
                    />
                </div>
                <div class="row form-group"></div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" v-model="task.status_id" required>
                        <option v-for="status in statuses" :value="status.id">
                            {{ status.name }}
                        </option>
                    </select>
                </div>
                <div class="error-message" v-if="error">
                    <p>{{ error }}</p>
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
        taskId: {
            type: String,
            required: true,
        },
        pageName: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            taskId: parseInt(this.taskId),
            task: {
                due_date: "",
                start_date: "",
                end_date: "",
                remarks: "",
                status_id: "",
            },
            statuses: [],
            error: "",
        };
    },
    mounted() {
        this.getStatus();
    },
    methods: {
        createUserTask() {
            let token = localStorage.getItem("token");
            let createUserTaskData = {
                task_id: this.taskId,
                remarks: this.task.remarks,
                due_date: this.task.due_date,
                start_date: this.task.start_date,
                end_date: this.task.end_date,
                status_id: this.task.status_id,
            };
            let createTaskRequest = axios
                .post("/api/user-tasks/v1", createUserTaskData, {
                    headers: {
                        Authorization: `Bearer  ${token}`,
                    },
                })
                .then((response) => {
                    this.$emit("close-modal");
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        let errorsObj = error.response.data.errors;
                        for (let key in errorsObj) {
                            if (errorsObj.hasOwnProperty(key)) {
                                this.errors = this.errors.concat(
                                    errorsObj[key]
                                );
                            }
                        }
                    } else {
                        this.errors = this.errors.concat(
                            error.response.data.error
                        );
                    }
                });
            return createTaskRequest;
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
                    } else {
                        this.error = "Something went wrong";
                    }
                })
                .finally(() => {
                    //console.log("finally");
                });
        },
        cancelCreate() {
            // Emit an event to close the modal without creating a new task
            this.$emit("closeModal");
            //console.log(this.showModal);
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
