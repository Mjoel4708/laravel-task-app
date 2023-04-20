<template>
    <div class="task-create-modal" v-show="showModal">
        <div class="modal-content">
            <h2>Create New Task</h2>
            <form @submit.prevent="createTask">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="" type="text" v-model="task.name" required />
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <input
                        type="text-area"
                        v-model="task.description"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="dueDate">Due Date:</label>
                    <input
                        type="datetime-local"
                        v-model="task.dueDate"
                        required
                    />
                </div>
                <div class="modal-buttons">
                    <button class="submit-button" type="submit">Create</button>
                    <button class="cancel-button" @click="cancelCreate">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        showModal: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            task: {
                name: "",
                description: "",
                dueDate: "",
            },
        };
    },
    methods: {
        createTask() {
            // Validate the form data and create a new task
            if (this.task.name && this.task.description && this.task.dueDate) {
                // Call an API or dispatch an action to create a new task with the form data
                // Once the task is created successfully, emit an event to close the modal
                this.$emit("closeModal");
            }
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
}

.modal-content {
    background-color: #fff;
    padding: 2rem;
    max-width: 400px;
    width: 100%;
}

h2 {
    margin-bottom: 1rem;
}

form {
    display: grid;
    gap: 1rem;
}

label{
    display: block;
    
}
input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
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
    padding: 0.5rem 1rem;
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
