import {createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Home from "../views/Home.vue";
import Task from "../views/Task.vue";
import Profile from "../views/UserProfile.vue";
import UserTasks from "../views/UserTasks.vue";

const routes = [
    {
      path: "/",
      name: "Home",
      component: Home,
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
    },
    {
      path: "/register",
      name: "Register",
      component: Register,
    },
    {
      path: "/profile",
      name: "Profile",
      component: Profile,
    },
    {
      path: "/tasks",
      name: "Task",
      component: Task,
    },
    {
      path: "/user-tasks/:id",
      name: "UserTasks",
      component: UserTasks,
      props: true,
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;