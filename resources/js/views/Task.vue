<template>
    <div class="task-parent-container">
        <h1>Tasks Page</h1>
        <button @click="showCreateTaskModal">Create New Task</button>
        <TaskList />
        <TaskCreateModal 
            :showModal="showModal"  
            @closeModal="closeModal" 
        />
    </div>
</template>

<script>
import TaskList from "../components/TaskList.vue";
import TaskCreateModal from "../components/TaskCreateModal.vue";

export default {
    components: {
        TaskList,
        TaskCreateModal,
    },
    data() {
        return {
            showModal: false,
        };
    },
    mounted() {
        if (
            typeof localStorage.getItem("token") !== "undefined" &&
            localStorage.getItem("token") !== null
        ) {
            //this.isAuthenticated = true;
        } else {
            this.$router.push(`/login`);
        }
    },
    methods: {
        showCreateTaskModal() {
            // Set showModal to true to show the create task modal
            this.showModal = true;
        },
        closeModal() {
            // Set showModal to false to close the create task modal
            this.showModal = false;
        },
    },
};
</script>

<style scoped>
.task-parent-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

h1 {
    margin-bottom: 1rem;
    text-align: center;
    font: 2rem "Roboto", sans-serif;
    text-transform: uppercase;
    color: #2ec4b6;
}

button {
    margin-bottom: 1rem;
    padding: 0.5rem 1rem;
    float: right;
    cursor: pointer;
    color: #fff;
    background-color: #2ec4b6;
    border: 1px solid #2ec4b6;
    border-radius: 6px;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
}
</style>
