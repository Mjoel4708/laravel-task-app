<template>
    <div class="user-task">
        <div class="user-task-header">
            <h3>{{ task.title }}</h3>
            <p>{{ task.description }}</p>
        </div>
        <div class="user-task-body">
            <div class="user-task-remarks">
                <h4>Remarks</h4>
                <ul>
                    <li v-for="userTask in userTasks" :key="userTask.id">
                        <div class="user-task-card">
                            <p>{{ userTask.remark }}</p>
                            <p>{{ userTask.created_at }}</p>
                        </div>
                    </li>
                </ul>
                <form @submit.prevent="addRemark">
                    <label for="new-remark">Add Remark:</label>
                    <textarea id="new-remark" v-model="newRemark"></textarea>
                    <button type="submit">Add</button>
                </form>
            </div>
            <div class="user-task-status">
                <h4>Status</h4>
                <p>{{ status }}</p>
                <select v-model="newStatus" @change="updateStatus">
                    <option
                        v-for="option in statusOptions"
                        :value="option.id"
                        :key="option.id"
                    >
                        {{ option.name }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        task: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            userTasks: [],
            newRemark: "",
            statusOptions: [],
            newStatus: this.task.status_id,
            status: "",
        };
    },
    mounted() {
        this.getRemarks();
        this.getStatus();
    },
    methods: {
        getRemarks() {
            axios
                .get(`/tasks/${this.task.id}/remarks`)
                .then((response) => {
                    this.remarks = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addRemark() {
            axios
                .post(`/tasks/${this.task.id}/remarks`, {
                    remarks: this.newRemark,
                })
                .then((response) => {
                    this.remarks.push(response.data);
                    this.newRemark = "";
                })
                .catch((error) => {
                    console.log(error);
                });
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
                    console.log("finally");
                });

            console.log(request);
        },
        updateStatus() {
            let updateRequest = axios
                .put(
                    "api/user-tasks/v1",
                    {
                        status_id: this.newStatus,
                        task_id: this.task.id,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                )
                .then((response) => {
                    this.status = response.data.status.name;
                })
                .catch((error) => {
                    console.log(error);
                });

                
        },
    },
};
</script>
