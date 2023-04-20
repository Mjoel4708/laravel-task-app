<template>
    <div class="task-list-container">
        <h2>Task List</h2>
        <ul>
            <li v-if="tasks.length === 0">No tasks found</li>
            <li
                v-for="task in tasks"
                :key="task.id"
                @click="viewTaskDetail(task.id)"
            >
                {{ task.name }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tasks: [], // Update this with the actual list of tasks from the API
        };
    },
    methods: {
        viewTaskDetail(taskId) {
            // Redirect to TaskDetail page with taskId as route parameter
            this.$router.push(`/task/${taskId}`);
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
