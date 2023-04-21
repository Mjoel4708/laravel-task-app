<template>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h2>Register</h2>
            </div>

            <form @submit.prevent="register">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" v-model="name" required />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" v-model="email" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        v-model="password"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input
                        type="password"
                        id="confirm-password"
                        v-model="confirmPassword"
                        required
                    />
                </div>
                <div class="error-message" v-if="errors.length > 0">
                    <p>There were some errors with your submission:</p>
                    <ul>
                        <li v-for="error in errors" :key="error">
                            {{ error }}
                        </li>
                    </ul>
                </div>
                <button type="submit">Register</button>
            </form>
            <router-link to="/login" tag="p"
                >Already have an account? Login</router-link
            >
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirmPassword: "",
            errors: [],
        };
    },
    methods: {
        register() {
            // Perform registration logic here
            // You can use API calls or any other logic to register the user
            // Example:
            if (this.password === this.confirmPassword) {
                // Register the user with email and password
                const userData = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                };
                // Call an API to register the user with the userData object
                axios
                    .post("/api/auth/v1/register", userData)
                    .then((response) => {
                        // redirect to the login page
                        localStorage.setItem("token", response.data.token);
                        // After successful registration, you can navigate to the login page or perform other actions as needed
                        this.$router.push("/login");
                        return;
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
                        return;
                    });
            } else {
                // Show an error message or take appropriate action for password mismatch
                this.errors = this.errors.concat(
                    "Password and Confirm Password do not match"
                );
            }
        },
    },
};
</script>

<style scoped>
.register-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
}
.register-card {
    max-width: 500px;
    min-width: 300px;
    padding: 2rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
    justify-content: center;
    align-items: center;
    display: flex;
    flex-direction: column;
}
.register-card h2 {
    margin-top: 0;
    margin-bottom: 1rem;
    font-size: 1.5rem;
}
.register-card p {
    margin-top: 1rem;
    margin-bottom: 0;
    color: #007bff;
}
.form-group {
    margin-bottom: 1rem;
}
input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    margin: 10px;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
}

button:hover {
    background-color: #0069d9;
}

button:active {
    background-color: #0062cc;
}

@media (max-width: 768px) {
    .register-card {
        width: 100%;
        height: 100%;
    }
}
@media (max-width: 576px) {
    .register-card {
        width: 80%;
        height: 100%;
    }
}

.error-message {
    color: #dc3545;
    margin-bottom: 1rem;
}
</style>
