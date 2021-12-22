<template>
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-gray-700 text-2xl font-bold">Users</h1>
    <div class="flex items-center space-x-4">
      <input type="text" v-model="filter_text" placeholder="Search keyword..." class="text-sm px-2 py-1 border rounded">
      <button type="button" @click="showModal('user-form')" class="w-40 text-white bg-green-600 hover:bg-green-500 px-2 py-1 rounded">New User</button>
    </div>
  </div>
  <ag-grid-vue v-if="users.length > 0"
    @grid-ready="gridReady"
    @cell-clicked="cellClicked"
    :columnDefs="column_defs"
    :rowData="users"
    :rowSelection="'single'"
    :getRowNodeId="getRowNodeId"
    :pagination="true"
    :paginationPageSize="25"
    class="ag-theme-alpine w-full h-full"
  >
  </ag-grid-vue>

  <modal :show="modal.show" @close="closeModal">
    <component @created-user="createdUser" @updated-user="updatedUser" @updated-roles="updatedRoles" @close="closeModal" @cancel="closeModal" :user="modal.data" :is="modal.component"></component>
  </modal>
</template>
<script>
  import "ag-grid-community/dist/styles/ag-grid.css";
  import "ag-grid-community/dist/styles/ag-theme-alpine.css";
  import { AgGridVue } from "ag-grid-vue3";
  import Modal from "../components/overlays/Modal.vue";
  import UserForm from "../components/forms/UserForm.vue";
  import UserCreated from "../components/messages/UserCreated.vue";
  import UserUpdated from "../components/messages/UserUpdated.vue";
  import UserRolesForm from "../components/forms/UserRolesForm.vue";
  import UserRolesUpdated from "../components/messages/UserRolesUpdated.vue";

  export default {
    name: 'Users',
    components: {
      AgGridVue,
      Modal,
      UserForm,
      UserCreated,
      UserUpdated,
      UserRolesForm,
      UserRolesUpdated,
    },
    data() {
      return {
        modal: {
          show: false,
          component: '',
          data: {},
        },
        grid_api: null,
        filter_text: '',
        users: [],
        column_defs: [
          {
            headerName: '',
            width: 70,
            lockPosition: true,
            cellRenderer: params => '<div class="flex items-center space-x-4">'
              + '<button type="button" class="text-gray-600 hover:text-green-600 outline-none ring-0" data-action="edit-user"><i class="fas fa-edit" title="Edit User" data-action="edit-user"></i></button>'
              + '<button type="button" class="text-gray-600 hover:text-green-600" data-action="manage-roles"><i class="fas fa-user-tag" title="Manage Roles" data-action="manage-roles"></i></button>'
              + '</div>',
          },
          { 
            headerName: 'Name', 
            field: 'name',
            sortable: true,
            resizable: true, 
            flex: 1, 
            valueGetter: params => !params.data
              ? ''
              : params.data.last_name + ', ' 
                + params.data.given_name + ' ' 
                + (params.data.middle_name ?? '') + ' ' 
                + (params.data.name_suffix ?? ''), 
          },
          { 
            headerName: 'Username', 
            field: 'username', 
            sortable: true,
            resizable: true, 
            flex: 1,
          },
          {
            headerName: 'Roles',
            field: 'roles',
            sortable: true,
            resizable: true,
            flex: 2,
            autoHeight: true,
            cellRenderer: params => {
              if (!params.data.roles) {
                return '';
              }
              
              let field = '<div class="flex flex-wrap">';

              Object.values(params.data.roles).forEach(role => {
                field += `<span class="text-white bg-gray-600 leading-relaxed m-1 px-4 py-1 rounded-full">${role.name}</span>`;
              })

              field += '</div>';

              return field.substring(0, field.length - 2);
            },
            getQuickFilterText: params => {
              if (!params.data.roles) {
                return '';
              }
              
              let field = '';

              Object.values(params.data.roles).forEach(role => {
                field += `${role.name}, `;
              })

              return field.substring(0, field.length - 2);
            },
          },
        ],
      }
    },
    created() {
      this.axios.get(`${import.meta.env.VITE_API_URL}/api/users`)
      .then(response => this.users = response.data)
      .catch(error => this.users = []);
    },
    methods: {
      gridReady(params) {
        this.grid_api = params.api;
      },
      cellClicked(params) {
        if (params.event.target.dataset.action) {
          switch (params.event.target.dataset.action) {
            case 'edit-user':
              this.modal.show = true;
              this.modal.component = 'user-form';
              this.modal.data = {
                ...params.data,
                password: null,
                confirm_password: null,
              };
              break;
            
            case 'manage-roles':
              this.modal.show = true;
              this.modal.component = 'user-roles-form';
              this.modal.data = params.data;
              break;
          }
        }
      },
      getRowNodeId(data) {
        return data.id;
      },
      showModal(component, data) {
        this.modal.show = true;
        this.modal.component = component;
        this.modal.data = data ?? {
          given_name: null,
          middle_name: null,
          last_name: null,
          name_suffix: null,
          username: null,
          password: null,
          confirm_password: null,
        };
      },
      closeModal() {
        this.modal.show = false;
        this.modal.component = '';
        this.modal.data = {};
      },
      createdUser(user) {
        this.grid_api.applyTransaction({
          add: [user],
          addIndex: 0,
        });

        this.modal.component = 'user-created';
      },
      updatedUser(user) {
        this.grid_api.applyTransaction({ update: [user] });
        this.modal.component = 'user-updated';
      },
      updatedRoles(roles) {
        this.modal.data.roles = roles;

        this.grid_api.applyTransaction({ update: [this.modal.data] });
        this.modal.component = 'user-roles-updated';
      },
    },
    watch: {
      filter_text(val) {
        this.grid_api.setQuickFilter(val);
      },
    },
  }
</script>