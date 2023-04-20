<template>
    <div class="login-container">
        <div class="login-card">
            <h2>Login:</h2>
            <form @submit.prevent="login">
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
                <div class="error-message" v-if="errors.length > 0">
                    <p>There were some errors with your submission:</p>
                    <ul>
                        <li v-for="error in errors" :key="error">
                            {{ error }}
                        </li>
                    </ul>
                </div>
                <div class="register-link">
                    <p>
                        <router-link to="/register">Don't have an account? Register</router-link>
                    </p>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            email: "",
            password: "",
            errors: [],
        };
    },
    mounted() {
        if(typeof localStorage.getItem('token') == 'string'){
            this.$router.push("/");
        }     
    },
    methods: {
        login() {
            // prevent the form from submitting
            event.preventDefault();
            // form validation logic here
            if (!this.email) {
                this.errorMessage = "Email is required";
                return;
            } else if (!this.password) {
                this.errorMessage = "Password is required";
                return;
            }
            // You can use API calls or any other logic to login the user
            axios
                .post("/api/auth/v1/login", {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    // Login successful
                    console.log(response);
                    // Store the token in localStorage
                    localStorage.setItem("token", response.data.access_token);
                    if(typeof localStorage.getItem('token')){
                        this.isAuthenticated = true;
                        //reload the page
                        this.$router.go();
                        this.$router.push("/");
                    } 
                    
  
                })
                .catch((error) => {
                  console.log(error);
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
                        return;
                    }
                }). finally(() => {
                    this.email = "";
                    this.password = "";
                });
        },
    },
};
</script>

<style scoped>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
}

.login-card {
    max-width: 500px;
    min-width: 300px;
    padding: 2rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.login-card h2 {
    margin-top: 0;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}
p {
    margin: 0;
}
p:hover {
    color: #007bff;
}
label {
    display: block;
    margin-bottom: 0.25rem;
}

input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    display: block;
    width: 100%;
    padding: 0.75rem;
    margin-top: 1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.error-message {
    margin-top: 1rem;
    padding: 0.75rem;
    color: #721c24;
    font-size: 0.9rem;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    border-radius: 4px;
}
.error-message ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.error-message li {
    margin-bottom: 0.25rem;
    color: #721c24;
}

button:hover {
    background-color: #0056b3;
}
</style>
