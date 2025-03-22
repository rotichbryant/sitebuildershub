import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

export default {
    install: (app: any) => {
        app.provide('$toast', toast);
        app.config.globalProperties.$toast = toast;
    }
}
