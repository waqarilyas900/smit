<template>
  <div v-if="showModal" class="zone-modal overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex" style="background: rgba(0,0,0,0.5)">
    <div class="relative w-full my-6 mx-3" :style="{maxWidth:  maxWidth +'px'}">
      <!--content-->
      <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full outline-none focus:outline-none popup-main">
        <div @click="toggleModal" class="text-gray-400 hover:text-primary-500 cursor-pointer pop-cross">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        <!--header-->
        <div class="popup-logo">
          <img src="/images/popup-logo.png" alt="">
        </div>
        <div class="flex items-center justify-between py-3 px-5 border-b border-solid border-blueGray-200 rounded-t">
          <h3 class="text-xl font-semibold text-white">Select Area</h3>

        </div>
        <!--body-->
        <div class="relative p-6 flex-auto zone-modal-datepicker">
          <multiselect class="mb-3 mt-1 border-gray-300"
            v-model="selectedZone"
            :custom-label="selectedLangLabel"
            placeholder="Select Area"
            label="Select Area"
            :show-labels="false"
            :searchable="false"
            :preselectFirst="false"
            :allowEmpty="false"
            :preserve-search="false"
            @input="getZones"
            :options="cities"
          >
            <template slot="option" slot-scope="props">
              <div class="option__desc"><span class="option__title">{{ props.option.city[$i18n.locale] }}</span></div>
            </template>
          </multiselect>

          <div class="flex" v-if="selectedZone">
            <input type="checkbox" id="deliver_asap" class="mr-2 accent-white" v-model="deliver_asap" :disabled="disableDeliverAsap">
            <label class="text-white" for="deliver_asap">Deliver Asap</label>
          </div>

          <div class="relative w-full mt-4 date-picker-model" v-if="selectedZone && !deliver_asap">
            <div class="absolute inset-y-0 left-0 pl-3 pointer-events-none datepicker-icon">
              <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <datepicker :value="date_today" v-model="area_date" placeholder="Select Date" :disabled-dates="disabledDates"></datepicker>
          </div>

          <div class="relative w-full mt-1 modal-timepicker" v-if="selectedZone && !deliver_asap">
            <multiselect class="mb-3 mt-1 border-gray-300"
              v-model="delivery_time"
              :custom-label="selectedHourLabel"
              placeholder="Select Time"
              label="Select Time"
              :show-labels="false"
              :searchable="false"
              :preselectFirst="true"
              :allowEmpty="false"
              :preserve-search="false"
              @input="getHoursOption"
              :options="hoursOption"
            >
              <template slot="option" slot-scope="props">
                <div class="option__desc">
                  <span class="option__title">{{ props.option }}</span>
                </div>
              </template>
            </multiselect>
          </div>

          <button-field :disabled="!selectedZone" class="mt-10 w-full" type="button" @click="save" label="Save"></button-field>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Datepicker from 'vuejs-datepicker';
import Multiselect from 'vue-multiselect'
import { startOfToday, isSameDay } from 'date-fns';

export default {
  name: "zone-modal",
  components: {
    Datepicker,
    Multiselect
  },
  props: {
    maxWidth: {
      type: Number,
      default: 500
    }
  },
  data() {
    return {
      selectedZone: null,
    deliver_asap: true,
    date_today: new Date(),
    area_date: new Date(),
    delivery_time: '', // Initialize delivery_time as an empty string
    hoursOption: [],
    zones: []
    };
  },
  computed: {
    ...mapGetters({
      cities: "config/getCities",
      showModal: "zone/showZoneModal",
      storeTime: 'config/getStoreTime'
    }),
    disabledDates() {
      const today = startOfToday();
      return {
        to: today,
      };
    },
  },
  methods: {
    getHoursOption(time)
    {
      this.delivery_time = time
    },
    formatTime(hours, minutes) {
      const formattedHours = String(hours).padStart(2, '0');
      const formattedMinutes = String(minutes).padStart(2, '0');
      return `${formattedHours}:${formattedMinutes}`;
    },
    toggleModal() {
      this.$store.dispatch("zone/toggleZoneModal");
      if (this.showModal) {
        document.body.classList.add("overflow-hidden");
      } else {
        document.body.classList.remove("overflow-hidden");
      }
    },
    selectedLangLabel(option) {
      return `${option.city[this.$i18n.locale]}`;
    },
    selectedHourLabel(option) {
      return `${option}`;
    },
    save() {
      let options = {
        deliver_asap: this.deliver_asap,
        delivery_date: this.date_today,
        delivery_time: this.delivery_time,
        zone: this.selectedZone,
      }
      this.$store.dispatch("zone/setSelectedZone", options);
      this.toggleModal();
    },
    async getZones() {
      try {
        const res = await this.$axios.$get(`/zones?city=${this.selectedZone}`);
        this.zones = res.data;
      } catch (error) {
        console.error(error);
      }
    },
    getCurrentTime() {
      const currentTime = new Date();
      const currentHour = currentTime.getHours();
      const currentMinute = currentTime.getMinutes();
      return this.parseTime(`${currentHour}:${currentMinute}`);
    },
    parseTime(time) {
      const [hour, minute] = time.split(":");
      return new Date().setHours(parseInt(hour), parseInt(minute), 0, 0);
    },
    compareTimes(time1, time2) {
      return time1 - time2;
    },
    generateHourOptions(newDate) {
      const storeTimeData = this.storeTime;
      if (storeTimeData && storeTimeData.hours) {
        const hours = Array.isArray(storeTimeData.hours) ? storeTimeData.hours : [];
        const currentTime = new Date();
        const selectedDate = newDate;
        const selectedDay = selectedDate.getDay();
        const options = [];
        for (const hourRange of hours) {
          if (typeof hourRange === "string") {
            const [start, end] = hourRange.split("-");
            const [startHour, startMinute, startAmPm] = start.split(/:|(?=[ap]m)/i);
            const [endHour, endMinute, endAmPm] = end.split(/:|(?=[ap]m)/i);
            let startHourInt = parseInt(startHour);
            let endHourInt = parseInt(endHour);
            if (startAmPm && startAmPm.toLowerCase() === 'pm' && startHourInt !== 12) {
              startHourInt += 12;
            }
            if (endAmPm && endAmPm.toLowerCase() === 'pm' && endHourInt !== 12) {
              endHourInt += 12;
            }
            const startTime = new Date(selectedDate);
            startTime.setHours(startHourInt);
            startTime.setMinutes(parseInt(startMinute));
            const endTime = new Date(selectedDate);
            endTime.setHours(endHourInt);
            endTime.setMinutes(parseInt(endMinute));
            if (startTime.getTime() > currentTime.getTime()) {
              const formattedStartTime = this.formatTime(
                startTime.getHours(),
                startTime.getMinutes()
              );
              const formattedEndTime = this.formatTime(
                endTime.getHours(),
                endTime.getMinutes()
              );
              options.push(`${formattedStartTime} - ${formattedEndTime}`);
            }
          }
        }
        this.hoursOption = options;
      }
    }
  },
  async mounted() {
  this.$store.dispatch("zone/setSelectedZone", this.$cookies.get("selected-zone"));

  if (!this.$cookies.get("selected-zone")) {
    this.toggleModal();
  }
},
watch: {
  area_date: {
    immediate: true,
    handler(newDate) {
      this.generateHourOptions(newDate);
    }
  }
},
};
</script>

<style>
.popup-main {
    padding: 18px 18px 42px 18px;
    background-color: #000000cf;
}
.popup-logo img {
    width: 65%;
    margin: 0 auto;
}
.popup-logo {
    margin-bottom: 40px;
}
.pop-cross {
    margin-bottom: 24px;
}
.zone-modal{
  z-index: 9999;
}
.accent{
  accent-color: black;
}
.accent-white{
  accent-color: white;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
