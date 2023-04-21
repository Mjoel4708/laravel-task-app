<template>
    <div class="profile-page-container">
        <h1>Profile</h1>
        <div class="profile-info-container">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="email" disabled />
            <label for="name">Name:</label>
            <input type="text" id="name" v-model="name" />
            <label for="password">Password:</label>
            <input type="password" id="password" v-model="password" />
            <div class="button-container">
                <button @click="updateProfile">Update</button>
                <button @click="deleteProfile">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Profile",
    data() {
        return {
            email: "",
            name: "",
            password: "",
        };
    },
    created() {
        // Fetch the user's profile data from the backend
        this.fetchProfileData();
    },
    methods: {
        fetchProfileData() {
            // You can implement the logic to fetch the user's profile data from the backend here
            // Update the data properties (email, name, password) with the fetched data
            // Example:
            // axios.get('/api/profile')
            //   .then(response => {
            //     this.email = response.data.email;
            //     this.name = response.data.name;
            //     this.password = response.data.password;
            //   })
            //   .catch(error => {
            //     console.error(error);
            //   });
        },
        updateProfile() {
            // You can implement the logic to update the user's profile data in the backend here
            // Example:
            // axios.put('/api/profile', {
            //   email: this.email,
            //   name: this.name,
            //   password: this.password
            // })
            //   .then(response => {
            //     //console.log('Profile updated successfully');
            //   })
            //   .catch(error => {
            //     console.error(error);
            //   });
        },
        deleteProfile() {
            // You can implement the logic to delete the user's profile data in the backend here
            // Example:
            // axios.delete('/api/profile')
            //   .then(response => {
            //     //console.log('Profile deleted successfully');
            //   })
            //   .catch(error => {
            //     console.error(error);
            //   });
        },
    },
};
</script>

<style scoped>
.profile-page-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-info-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 300px;
    margin: 0 auto;
}

.button-container {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}
</style>
