import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";

// Fonts: Manrope & Inter
import "@fontsource/manrope";
import "@fontsource/inter";
import "@fontsource/inter/400.css";
import "@fontsource/manrope/400.css";
import "@fontsource/inter/500.css";
import "@fontsource/manrope/500.css";
import "@fontsource/inter/600.css";
import "@fontsource/manrope/600.css";
import "@fontsource/inter/700.css";
import "@fontsource/manrope/700.css";


import "./assets/scss/app.scss";
import 'element-plus/es/components/message/style/css'; // Fix: ElementPlusResolver ElMessage CSS import issue. 

const pinia = createPinia();
const app = createApp(App);
app.use(pinia);
app.use(router);
app.mount("#addonify-wishlist-app");