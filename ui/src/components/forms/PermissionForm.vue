<template>
  <div class="w-1/3 bg-white rounded">
    <div class="flex justify-between items-center bg-green-600 p-4 rounded-t">
      <h3 class="text-white">{{ data.id ? 'Update Permission' : 'Create Permission' }}</h3>
      <button type="button" @click="$emit('close')"><i class="fas fa-times text-white hover:text-gray-200" title="Close"></i></button>
    </div>
    <form>
      <div class="flex flex-col space-y-4 p-8">
        <div class="flex flex-col">
          <label class="text-sm text-gray-600 font-bold uppercase">Name</label>
          <input type="text" v-model="data.name" class="px-2 py-1 rounded border">
          <div v-if="errors.hasOwnProperty('name')" class="text-sm text-red-600">{{ errors.name[0] }}</div>
        </div>

        <div v-if="saving" class="flex flex-col items-center space-y-4">
          <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-green-600"></div>
          <p class="text-gray-600 animate-pulse">Saving Permission Information</p>
        </div>
        <div v-else class="flex justify-end items-center space-x-4">
          <button type="button" @click="$emit('cancel')" class="w-40 bg-gray-200 hover:bg-gray-100 px-4 py-1 rounded">Cancel</button>
          <button type="button" @click="savePermission" class="w-40 text-white bg-green-600 hover:bg-green-500 px-4 py-1 rounded">Save</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
  export default {
    name: 'PermissionForm',
    props: {
      data: Object,
    },
    data() {
      return {
        errors: {},
        saving: false,
      }
    },
    methods: {
      savePermission() {
        this.saving = true;
        this.errors = {};

        if (this.data.id) {
          this.updatePermission();
        } else {
          this.createPermission();
        }
      },
      async createPermission() {
        await this.axios.post(`${import.meta.env.VITE_API_URL}/api/permissions`, this.data)
        .then(response => this.$emit('createdPermission', response.data))
        .catch(error => {
          const errors = error.response.data;

          if (typeof errors === 'object') {
            this.errors = errors;
          }
        });

        this.saving = false;
      },
      async updatePermission() {
        await this.axios.put(`${import.meta.env.VITE_API_URL}/api/permissions/${this.data.id}`, this.data)
        .then(response => this.$emit('updatedPermission', response.data))
        .catch(error => {
          const errors = error.response.data;

          if (typeof errors === 'object' && error.status === 400) {
            this.errors = errors;
          }
        });

        this.saving = false;
      },
    },
  }
</script>