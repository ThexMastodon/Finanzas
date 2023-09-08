import { createApp } from 'vue';
import HelloWorld from "./components/HelloWorld.vue";
import ModalComponent from "./components/ModalComponent.vue";
import DataTable from "./components/DataTable.vue";
//import GenericPDF from './components/GenericPDF.vue';

const app = createApp({});

app.component('hello-world', HelloWorld);
app.component('modal-component', ModalComponent);
app.component('generic-data-table', DataTable);


export default app;
