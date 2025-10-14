import "./bootstrap";
import "../css/app.css";
import { createApp } from "vue";
import router from "../js/router/index.js";
import { Icon } from "@iconify/vue";
import axios from "axios";
import App from "./App.vue";
window.axios = axios;

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
  Checkbox
} from "ant-design-vue";

import {
  EditOutlined,
  DeleteOutlined,
  PlusOutlined,
  UploadOutlined,
  UserOutlined,
  LoadingOutlined
} from "@ant-design/icons-vue";

const app = createApp(App);

app.component("Icon", Icon);
app.component("EditOutlined", EditOutlined);
app.component("DeleteOutlined", DeleteOutlined);
app.component("PlusOutlined", PlusOutlined);
app.component("UploadOutlined", UploadOutlined);
app.component("UserOutlined", UserOutlined);
app.component("LoadingOutlined", LoadingOutlined);

app.use(router);
app.use(Card);
app.use(Table);
app.use(Avatar);
app.use(Select);
app.use(Layout);
app.use(Button);
app.use(List);
app.use(Menu);
app.use(Drawer);
app.use(Input);
app.use(Tag);
app.use(Space);
app.use(Checkbox);

app.mount("#app");
