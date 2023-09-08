<template>
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card">
        <div class="card-header">
          <h4>Usuarios</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <DataTable class="table table-striped table-bordered display">
              <thead>
              <tr>
                <th v-for="header in headers" :key="header">{{ header }}</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="row in data" :key="getRowKey(row)">
                <td v-for="value in row" :key="getColumnKey(row, value)">{{ value }}</td>
              </tr>
              </tbody>
            </DataTable>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DataTable from 'datatables.net-vue3';
import DataTableLib from 'datatables.net-bs5';

DataTable.use(DataTableLib);
export default {
  name: 'generic-data-table',
  components: {
    DataTable,
  },
  props: {
    data: {
      type: Array,
      required: true,
    },
    headers: {
      type: Array,
      required: true,
    },
  },
  methods: {
    getRowKey(row) {
      // Genera una clave única para cada fila
      return JSON.stringify(row);
    },
    getColumnKey(row, value) {
      // Genera una clave única para cada celda
      return `${this.getRowKey(row)}_${value}`;
    },
  },
  created() {
    console.log(this.data);
    console.log('-------------');
    console.log(this.headers);
  },
};
</script>

<style>
@import 'bootstrap';
@import 'datatables.net-bs5';
</style>
