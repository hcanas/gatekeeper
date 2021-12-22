<template>
  <div class="w-full h-full flex items-stretch">
    <div class="flex-shrink-0 w-80 flex flex-col bg-gray-700 p-8">
      <div class="flex justify-center items-center mb-4">
        <span class="text-5xl text-gray-200 font-bold">P</span>
        <img src="/images/DOH-Logo.png" class="w-9">
        <span class="text-5xl text-gray-200 font-bold">RTAL</span>
      </div>

      <div class="flex flex-col mb-4 py-4">
        <p class="text-gray-200">Hello,</p>
        <p class="text-gray-200">{{ user.last_name + ', ' + user.given_name + ' ' + user.middle_name ?? '' + ' ' + user.name_suffix }}</p>
        <p class="flex flex-wrap">
          <span v-for="role in user.roles" :key="role.id" class="text-sm bg-gray-100 m-0.5 px-2 py-0.5 rounded-full">
            {{ role.name }}
          </span>
        </p>
      </div>

      <div class="flex flex-col space-y-4">
        <router-link to="/" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Dashboard</span>
            <i class="fas fa-tachometer-alt"></i>
          </div>
        </router-link>
        <router-link to="/users" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Users</span>
            <i class="fas fa-users"></i>
          </div>
        </router-link>
        <router-link to="/roles" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Roles</span>
            <i class="fas fa-user-tag"></i>
          </div>
        </router-link>
        <router-link to="/permissions" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Permissions</span>
            <i class="fas fa-user-lock"></i>
          </div>
        </router-link>
        <router-link to="/offices" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Offices</span>
            <i class="fas fa-building"></i>
          </div>
        </router-link>
        <router-link to="/items" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Items</span>
            <i class="fas fa-clipboard-list"></i>
          </div>
        </router-link>
        <router-link to="/item_categories" class="text-white hover:text-green-500">
          <div class="flex justify-between items-center">
            <span>Item Categories</span>
            <i class="fas fa-tag"></i>
          </div>
        </router-link>
      </div>
    </div>
    <div id="content" class="flex-grow max-h-full p-8 overflow-y-auto">
      <slot></slot>
    </div>
    <div class="flex-shrink-0 w-80 flex flex-col bg-gray-200 px-4 py-8">
      <div class="font-medium pb-1 mb-1 border-b border-gray-400">Announcements</div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'MainLayout',
    computed: {
      user() {
        return this.$store.getters['getUser'];
      },
    },
  }
</script>
<style scoped>
  a {
    @apply outline-none ring-0
  }

  a.router-link-active {
    @apply text-green-600
  }
</style>