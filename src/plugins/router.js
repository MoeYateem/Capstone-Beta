import { createRouter, createWebHistory } from "vue-router";
import login from "../components/login.vue";
import signup from "../components/signup.vue";
import productPage from "../components/productPage.vue";
import singleProduct from "../components/singleProduct.vue";
import Home from "../components/home.vue";
import account from "../components/account.vue"


const routes = [
  { path: "/account", name: "account", component: account },
  { path: "/", name: "home", component: Home },
  { path: "/login", name: "login", component: login },
  { path: "/signup", name: "signup", component: signup },
  { path: "/productPage", name: "productPage", component: productPage },
  { path: "/singleProduct", name: "singleProduct", component: singleProduct },
];

const router = createRouter({
  routes,
  history: createWebHistory(),
});

export default router;

