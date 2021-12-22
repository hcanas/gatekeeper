<template>
  <div class="w-96 flex flex-col space-y-4 bg-white rounded p-4 relative">
    <button type="button" @click="$emit('close')" class="text-gray-400 hover:text-gray-600 absolute top-4 right-4" title="Close">
      <i class="fas fa-times"></i>
    </button>
    <div class="flex justify-center items-center space-x-4">
      <i class="fas fa-check-circle text-2xl text-green-600"></i>
      <span class="text-xl text-green-600">Success!</span>
    </div>
    <div class="text-gray-500 text-center">
      {{ data.message }}
    </div>
  </div>
</template>
<script>
  export default {
    name: 'SuccessMessage',
    props: {
      data: Object,
    },
  }
</script>