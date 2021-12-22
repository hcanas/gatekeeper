<template>
  <div class="w-full h-full flex justify-center items-center bg-gray-100">
    <div class="w-96 flex flex-col space-y-12 p-8 bg-white shadow-lg rounded">
      <h1 class="flex justify-center items-center">
        <span class="text-5xl text-gray-600 font-bold">P</span>
        <img src="/images/DOH-Logo.png" class="w-9">
        <span class="text-5xl text-gray-600 font-bold">RTAL</span>
      </h1>

      <form>
        <div class="flex flex-col space-y-8">
          <div v-if="login_status === 'failed'" class="text-red-600 bg-red-50 p-4 rounded">Incorrect username or password.</div>

          <div class="flex flex-col">
            <label class="text-gray-600 text-sm uppercase font-bold">Username</label>
            <input type="text" v-model="credentials.username" class="px-2 py-1 border rounded">
          </div>

          <div class="flex flex-col">
            <label class="text-gray-600 text-sm uppercase font-bold">Password</label>
            <input type="password" v-model="credentials.password" class="px-2 py-1 border rounded">
          </div>

          <div class="flex flex-col">
            <div v-if="logging_in" class="flex flex-col items-center space-y-4">
              <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-green-600"></div>
              <p class="text-gray-600 animate-pulse">Signing In</p>
            </div>
            <button v-else type="button" @click="signIn" class="bg-green-600 hover:bg-green-500 text-white px-2 py-1 rounded">
              Sign in
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'Login',
    data() {
      return {
        credentials: {
          username: '',
          password: '',
        },
        logging_in: false,
        login_status: '',
      }
    },
    methods: {
      signIn() {
        this.logging_in = true;
        this.login_status = '';

        this.axios.get(`${import.meta.env.VITE_API_URL}/sanctum/csrf-cookie`)
        .then(response => {
          this.axios.post(`${import.meta.env.VITE_API_URL}/api/auth`, this.credentials)
          .then(response => {
            this.$store.dispatch('setUser', response.data);
            this.$router.push('/');
          })
          .catch(error => {
            this.logging_in = false;
            this.login_status = 'failed';
          });
        });
      },
    },
  }
</script>