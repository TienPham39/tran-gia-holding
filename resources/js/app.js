import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Icon } from "@iconify/vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import {
  Card,
  Table,
  Avatar,
  Select,
  Layout,
  Button,
  List,
  Menu,
  Drawer,
  Input,
  Tag,
  Space,
  Checkbox,
  Modal,
  message,
} from "ant-design-vue";

import {
  KeyOutlined,
  SafetyOutlined,
  LoadingOutlined,
} from "@ant-design/icons-vue";

import ButtonEffect from "./components/client/ButtonEffect.vue";

import { ArrowRight, ChevronsRight } from "lucide-vue-next";

createInertiaApp({
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob("./pages/**/*.vue")
    ),
  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) });

    vueApp.use(plugin);

    // Đăng ký các component / plugin bạn đang dùng
    vueApp.component("Icon", Icon);
    vueApp.use(ZiggyVue);
    vueApp.use(Card);
    vueApp.use(Table);
    vueApp.use(Avatar);
    vueApp.use(Select);
    vueApp.use(Layout);
    vueApp.use(Button);
    vueApp.use(List);
    vueApp.use(Menu);
    vueApp.use(Drawer);
    vueApp.use(Input);
    vueApp.use(Tag);
    vueApp.use(Space);
    vueApp.use(Checkbox);
    vueApp.use(Modal);

    vueApp.component("KeyOutlined", KeyOutlined);
    vueApp.component("SafetyOutlined", SafetyOutlined);
    vueApp.component("LoadingOutlined", LoadingOutlined);
    vueApp.component("ButtonEffect", ButtonEffect);

    // Lucide icons
    vueApp.component("ArrowRight", ArrowRight);
    vueApp.component("ChevronsRight", ChevronsRight);

    vueApp.config.globalProperties.$message = message;

    vueApp.mount(el);
  },
});
