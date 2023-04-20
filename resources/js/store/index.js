import { reactive } from "vue";

const store = ({
    state: reactive({
        user:  localStorage.getItem('user') || null,
        token: localStorage.getItem('token') || null,
        loggedIn: localStorage.getItem('loggedIn') || false
    }),
    getters: {
        getUser(){
            return store.state.user;
        },
        getToken(){
            return store.state.token;
        },
        getLoggedIn(){
            return store.state.loggedIn;
        }

    },
    mutations: {
        setUser(user){
            store.state.user = user;
        },
        setToken(token){
            store.state.token = token;
        },
        setLoggedIn(loggedIn){
            store.state.loggedIn = loggedIn;
        }
    },
    actions: {
        init(){
            store.mutations.setUser(null);
            store.mutations.setToken(null);
            store.mutations.setLoggedIn(false);

        }
    }

});

export default store;
