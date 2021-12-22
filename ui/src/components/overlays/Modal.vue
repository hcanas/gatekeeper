<template>
  <div :class="{ '-translate-y-full': !show }" class="w-full h-full flex justify-center items-center absolute top-0 left-0 transition transform duration-100">
    <div class="absolute inset-0 bg-gray-700 opacity-60"></div>
    <div class="w-full h-5/6 absolute flex justify-center items-center p-4">
      <slot></slot>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'Modal',
    props: {
      show: Boolean,
      title: String,
    },
  }
</script>