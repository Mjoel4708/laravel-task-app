<template>
    <div class="task">
        
        
        <div class="user-task-body">
            <div class="user-task-remarks">
                <h4>Remarks</h4>
                <ul>
            
                    <li
                        v-if="userTasks.length > 0"
                        v-for="userTask in userTasks"
                        :key="userTask.id"
                    >
                        <div class="user-task-card">
                            <span class="user-id">User ID: {{ userTask.user_id }}</span>
                            <p>{{ userTask.remarks }} </p>
                            <span class="status">
                                <p>Status: {{ 
                                    
                                    statusOptions.find(
                                        (status) => status.id === userTask.status_id
                                    ).name
                                }}</p> </span>
                            <p>
                                Created at:
                                {{
                                    Date(userTask.created_at)
                                        .toString()
                                        .slice(0, 15)
                                }}
                            </p>
                        </div>
                    </li>
                    <li v-else>No remarks found</li>
                </ul>
                <div class="error-message" v-if="error">
                    <p>{{ error }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            userTasks: [],
            newRemark: "",
            statusOptions: [],
            newStatus: "",
            status: "",
            start_date: "",
            showModal: false,
        };
    },
    mounted() {
        this.showUserTaskByTaskId();
        //this.setTask();
        this.getStatus();
    },
    methods: {
        showUserTaskByTaskId() {
            let token = localStorage.getItem("token");
            axios
                .get(`/api/user-tasks/v1/task/${this.id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    if(typeof response.data.data !== "array") {
                        this.userTasks = response.data.data;
                    } else if(typeof response.data.data === "object") {
                        for (let key in response.data.data) {
                            this.userTasks.push(response.data.data[key]);
                        }
                    } else {
                        this.userTasks = [];
                    }
                    console.log(this.userTasks);

                })
                .catch((error) => {
                    console.log(error);
                });
        },
        setTask() {
            this.task.id = this.id;
            this.task.title = this.title;
        },
        addRemark() {
            axios
                .post(`/tasks/${this.task}/remarks`, {
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
                        this.statusOptions.push(statusObj[key]);
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
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        //turn object task [object object] to object
        taskToArray() {
            let taskObj = this.task;
            for (let key in taskObj) {
                this.userTasks.push(taskObj[key]);
                console.log(taskObj[key]);
            }
        },
    },
};
</script>

<style scoped>
.task {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fff;
    padding: 1rem;
    padding-top: 0.4rem;
    max-width: 800px;
    width: 100%;
    height: 120vh;
    overflow-y: auto;
    margin: 1rem auto;
  }
.user-task-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 1rem;
}
.user-task-header h2 {
    margin: 0;
    margin-bottom: 0.5rem;
}
.user-task-remarks{
    padding: 1rem;
    
}
.user-task-remarks li{
    margin-bottom: 1rem;
    margin: 1.5rem;
    border: 1px solid #ddd;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.user-task-remarks h4 {
    margin: 0;
    margin-bottom: 0.5rem;
    
}
.user-task-card {
    display: flex;
    flex-direction: column;
    align-items: left;
    margin-bottom: 1rem;
}
.user-task-card p {
    margin: 0;
    margin-bottom: 0.5rem;
    color: #000;
    text-align: left;
}
.user-task-card span {
    /* position it on the right */
    margin-left: auto;
    color: #000;
    text-align: right;
}
ul {
    list-style: none;
    padding: 1rem;
    margin: 0.5rem;
}
li {
    border-bottom: 1px solid #ddd;
    padding: 0.5rem;
    background-color: #f5f5f5;
    border-radius: 4px;

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
textarea {
    resize: none;
}
button {
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    background-color: #000;
    color: #fff;
    cursor: pointer;
}

</style>
