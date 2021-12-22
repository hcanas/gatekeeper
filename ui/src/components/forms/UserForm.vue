<template>
<div class="w-1/3 bg-white rounded">
  <div class="flex justify-between items-center bg-green-600 p-4 rounded-t">
    <h3 class="text-white">{{ user.id ? 'Update User' : 'Create User' }}</h3>
    <button type="button" @click="$emit('close')"><i class="fas fa-times text-white hover:text-gray-200" title="Close"></i></button>
  </div>
  <form>
    <div class="flex flex-col space-y-4 p-8">
      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Given Name</label>
        <input type="text" v-model="user.given_name" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('given_name')" class="text-sm text-red-600">{{ errors.given_name[0] }}</div>
      </div>

      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Middle Name</label>
        <input type="text" v-model="user.middle_name" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('middle_name')" class="text-sm text-red-600">{{ errors.middle_name[0] }}</div>
      </div>

      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Last Name</label>
        <input type="text" v-model="user.last_name" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('last_name')" class="text-sm text-red-600">{{ errors.last_name[0] }}</div>
      </div>

      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Name Suffix</label>
        <input type="text" v-model="user.name_suffix" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('name_suffix')" class="text-sm text-red-600">{{ errors.name_suffix[0] }}</div>
      </div>
 
      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Username</label>
        <input type="text" v-model="user.username" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('username')" class="text-sm text-red-600">{{ errors.username[0] }}</div>
      </div>

      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Password</label>
        <input type="password" v-model="user.password" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('password')" class="text-sm text-red-600">{{ errors.password[0] }}</div>
      </div>

      <div class="flex flex-col">
        <label class="text-sm text-gray-600 font-bold uppercase">Confirm Password</label>
        <input type="password" v-model="user.confirm_password" class="px-2 py-1 rounded border">
        <div v-if="errors.hasOwnProperty('confirm_password')" class="text-sm text-red-600">{{ errors.confirm_password[0] }}</div>
      </div>

      <div v-if="saving" class="flex flex-col items-center space-y-4">
        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-green-600"></div>
        <p class="text-gray-600 animate-pulse">Saving User Information</p>
      </div>
      <div v-else class="flex justify-end items-center space-x-4">
        <button type="button" @click="$emit('cancel')" class="w-40 bg-gray-200 hover:bg-gray-100 px-4 py-1 rounded">Cancel</button>
        <button type="button" @click="saveUser" class="w-40 text-white bg-green-600 hover:bg-green-500 px-4 py-1 rounded">Save</button>
      </div>
    </div>
  </form>
</div>
  
</template>
<script>
  export default {
    name: 'UserForm',
    props: {
      user: Object,
    },
    data() {
      return {
        errors: {},
        saving: false,
      }
    },
    methods: {
      saveUser() {
        this.saving = true;
        this.errors = {};

        if (this.user.id) {
          this.updateUser();
        } else {
          this.createUser();
        }
      },
      async createUser() {
        await this.axios.post(`${import.meta.env.VITE_API_URL}/api/users`, this.user)
        .then(response => this.$emit('createdUser', response.data))
        .catch(error => {
          const errors = error.response.data;

          if (typeof errors === 'object') {
            this.errors = errors;
          }
        });

        this.saving = false;
      },
      async updateUser() {
        await this.axios.put(`${import.meta.env.VITE_API_URL}/api/users/${this.user.id}`, this.user)
        .then(response => this.$emit('updatedUser', response.data))
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