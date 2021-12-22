<template>
  <div class="flex flex-col">
    <h1 class="text-xl font-bold mb-4">Time Attendance</h1>

    <v-calendar
      @update:from-page="loadRecords"
      class="custom-calendar w-full"
      :masks="masks"
      :attributes="biometrics"
      trim-weeks
    >
      <template v-slot:day-content="{ day, attributes }">
        <div class="flex flex-col h-full z-10 overflow-hidden p-1">
          <span class="day-label text-sm text-gray-900">{{ day.day }}</span>
          <div class="flex-grow overflow-y-auto overflow-x-auto h-28">
            <p
              v-for="attr in attributes"
              :key="attr.key"
              class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"
              :class="attr.customData.class"
            >
              {{ attr.customData.title }}
            </p>
          </div>
        </div>
      </template>
    </v-calendar>
  </div>
</template>
<script>
  export default {
    name: 'Home',
    data() {
      return {
        masks: {
          weekdays: 'WWW',
        },
        biometrics: [],
      };
    },
    methods: {
      loadRecords(event) {
        this.axios.get(`${import.meta.env.VITE_API_URL}/api/biometrics?id=1486&month=${event.month}&year=${event.year}`)
        .then(response => {
          const data = response.data;
          this.biometrics = [];

          data.forEach(item => {
            const date = new Date(item.checktime);

            this.biometrics.push({
              customData: {
                title: date.toTimeString().substring(0, date.toTimeString().indexOf('G')),
                class: item.checktype === 'I' ? 'bg-green-600 text-white' : 'bg-red-600 text-white',
              },
              dates: date,
            });
          });
        })
        .catch(error => {

        });
      }
    },
  }
</script>