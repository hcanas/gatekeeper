<template>
  <div class="w-2/3 h-full flex flex-col bg-white rounded">
    <div class="flex-shrink-0 flex justify-between items-center bg-green-600 p-4 rounded-t">
      <h3 class="text-white">Manage Roles - {{ user.username }}</h3>
      <button type="button" @click="$emit('close')"><i class="fas fa-times text-white hover:text-gray-200" title="Close"></i></button>
    </div>
    <div class="flex-grow flex flex-col space-y-4 p-8 overflow-y-auto">
      <div class="flex justify-between items-center">
        <div class="text-xs font-bold uppercase text-gray-600">{{ selected_row_count }} item(s) selected</div>
        <div class="flex items-center space-x-4">
          <input type="text" v-model="filter_text" placeholder="Search keyword..." class="text-sm px-2 py-1 border rounded">
          <button type="button" @click="save" class="w-40 text-white bg-green-600 hover:bg-green-500 px-2 py-1 rounded">Save</button>
        </div>
      </div>

      <ag-grid-vue
        @grid-ready="gridReady"
        @first-data-rendered="dataRendered"
        @selection-changed="selectionChanged"
        :columnDefs="column_defs"
        :rowData="roles"
        :rowSelection="'multiple'"
        :suppressRowClickSelection="true"
        :getRowNodeId="getRowNodeId"
        :pagination="true"
        :paginationPageSize="25"
        class="ag-theme-alpine w-full h-full"
      >
      </ag-grid-vue>
    </div>
  </div>
</template>
<script>
  import "ag-grid-community/dist/styles/ag-grid.css";
  import "ag-grid-community/dist/styles/ag-theme-alpine.css";
  import { AgGridVue } from "ag-grid-vue3";

  export default {
    name: 'UserRolesForm',
    props: {
      user: Object,
    },
    components: {
      AgGridVue,
    },
    data() {
      return {
        user_roles: [],
        roles: [],
        grid_api: null,
        filter_text: '',
        selected_row_count: 0,
        column_defs: [
          {
            headerName: '',
            checkboxSelection: true,
            width: 40,
            suppressSizeToFit: true,
          },
          {
            headerName: 'Name',
            field: 'name',
            resizable: true,
            flex: 1,
            cellRenderer: params => {
              return `<span class="w-full h-full items-center">${params.data.name}</span>`;
            },
          },
          {
            headerName: 'Permissions',
            flex: 2,
            autoHeight: true,
            cellRenderer: params => {
              let permissions = '<div class="w-full flex flex-wrap">';

              Object.values(params.data.role_permissions).forEach(role_permission => {
                permissions += '<span class="text-white bg-gray-600 leading-relaxed m-1 px-4 py-1 rounded-full">' + role_permission.permission.name;

                if (role_permission.offices.length > 0) {
                  let offices = ' (';

                  Object.values(role_permission.offices).forEach(office => {
                    offices += office.short_name + ', ';
                  });

                  permissions += offices.substring(0, offices.length - 2) + ')';
                }

                permissions += '</span>';
              });
              
              permissions += '</div>';

              return permissions;
            },
            getQuickFilterText: params => {
              let permissions = '';

              Object.values(params.data.role_permissions).forEach(role_permission => {
                permissions += role_permission.permission.name;

                if (role_permission.offices.length > 0) {
                  let offices = ' (';

                  Object.values(role_permission.offices).forEach(office => {
                    offices += office.short_name + ', ';
                  });

                  permissions += offices.substring(0, offices.length - 2) + ')';
                }
              });

              return permissions;
            },
          },
        ],
      }
    },
    created() {
      this.axios.get(`${import.meta.env.VITE_API_URL}/api/roles`)
      .then(response => this.roles = response.data);
    },
    methods: {
      gridReady(params) {
        this.grid_api = params.api;
      },
      dataRendered() {
        this.axios.get(`${import.meta.env.VITE_API_URL}/api/user_roles/${this.user.id}`)
        .then(response => {
          this.user_roles = response.data;
          this.selected_row_count = this.user_roles.length;

          Object.values(this.user_roles).forEach(user_role => this.grid_api.getRowNode(user_role.id).setSelected(true));
        });
      },
      getRowNodeId(data) {
        return data.id;
      },
      selectionChanged() {
        this.selected_row_count = this.grid_api.getSelectedRows().length;
      },
      save() {
        const role_ids = [];

        this.grid_api.getSelectedRows().forEach(row => {
          role_ids.push(row.id);
        });

        this.axios.put(`${import.meta.env.VITE_API_URL}/api/user_roles/${this.user.id}`, { role_ids })
        .then(response => this.$emit('updatedRoles', this.grid_api.getSelectedRows()))
        .catch(error => console.log(error.response.data));
      },
    },
    watch: {
      filter_text(val) {
        this.grid_api.setQuickFilter(val);
      },
    },
  }
</script>