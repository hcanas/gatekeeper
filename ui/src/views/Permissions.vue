<template>
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-gray-700 text-2xl font-bold">Permissions</h1>
    <div class="flex items-center space-x-4">
      <input type="text" v-model="filter_text" placeholder="Search keyword..." class="text-sm px-2 py-1 border rounded">
      <button type="button" @click="showModal('permission-form')" class="w-40 text-white bg-green-600 hover:bg-green-500 px-2 py-1 rounded">New Permission</button>
    </div>
  </div>
  <ag-grid-vue v-if="permissions.length > 0"
    @grid-ready="gridReady"
    @cell-clicked="cellClicked"
    :columnDefs="column_defs"
    :rowData="permissions"
    :rowSelection="'single'"
    :getRowNodeId="getRowNodeId"
    :pagination="true"
    :paginationPageSize="25"
    class="ag-theme-alpine w-full h-full"
  >
  </ag-grid-vue>

  <modal :show="modal.show" @close="closeModal">
    <component @created-permission="createdPermission" @updated-permission="updatedPermission" @close="closeModal" @cancel="closeModal" :data="modal.data" :is="modal.component"></component>
  </modal>
</template>
<script>
  import "ag-grid-community/dist/styles/ag-grid.css";
  import "ag-grid-community/dist/styles/ag-theme-alpine.css";
  import { AgGridVue } from "ag-grid-vue3";
  import Modal from "../components/overlays/Modal.vue";
  import PermissionForm from "../components/forms/PermissionForm.vue";
  import SuccessMessage from "../components/messages/SuccessMessage.vue";

  export default {
    name: 'Permissions',
    components: {
      AgGridVue,
      Modal,
      PermissionForm,
      SuccessMessage,
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
        permissions: [],
        column_defs: [
          {
            headerName: '',
            width: 70,
            lockPosition: true,
            cellRenderer: params => '<div class="flex items-center space-x-4">'
              + '<button type="button" class="text-gray-600 hover:text-green-600 outline-none ring-0" data-action="edit-permission"><i class="fas fa-edit" title="Edit Permission" data-action="edit-permission"></i></button>'
              + '<button type="button" class="text-gray-600 hover:text-red-600 outline-none ring-0" data-action="delete-permission"><i class="fas fa-trash" title="Delete Permission" data-action="delete-permission"></i></button>'
              + '</div>',
          },
          { 
            headerName: 'Name', 
            field: 'name',
            sortable: true,
            resizable: true, 
            flex: 1, 
          },
        ],
      }
    },
    created() {
      this.axios.get(`${import.meta.env.VITE_API_URL}/api/permissions`)
      .then(response => this.permissions = response.data)
      .catch(error => this.permissions = []);
    },
    methods: {
      gridReady(params) {
        this.grid_api = params.api;
      },
      cellClicked(params) {
        if (params.event.target.dataset.action) {
          switch (params.event.target.dataset.action) {
            case 'edit-permission':
              this.modal.show = true;
              this.modal.component = 'permission-form';
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
        this.modal.dadta = data ?? { name: '' };
      },
      closeModal() {
        this.modal.show = false;
        this.modal.component = '';
        this.modal.data = {};
      },
      createdPermission(permission) {
        this.grid_api.applyTransaction({
          add: [permission],
          addIndex: 0,
        });
        this.modal.component = 'success-message';
        this.modal.data = { message: `${permission.name} has been created.` };
      },
      updatedPermission(permission) {
        this.grid_api.applyTransaction({ update: [permission] });
        this.modal.component = 'success-message';
        this.modal.data = { message: `${permission.name} has been updated.` };
      },
    },
    watch: {
      filter_text(val) {
        this.grid_api.setQuickFilter(val);
      },
    },
  }
</script>