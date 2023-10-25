require("./bootstrap");

// window.Vue = require('vue'); === import vue from 'vue'
import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);
// Inport Routes file
import { routes } from "./routes";
import User from "./Helpers/User";
window.User = User;
import Notification from "./Helpers/Notification";
window.Notification = Notification;

import Swal from "sweetalert2";
window.Swal = Swal;   
const router = new VueRouter({
    routes,
    mode: "history",
});

const app = new Vue({
    el: "#app",
    router,
});
