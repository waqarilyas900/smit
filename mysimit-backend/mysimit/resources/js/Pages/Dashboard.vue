<template>
	<app-layout title="Dashboard">
		<div class="">
			<!-- <div class="mx-auto px-4">
				<h1 class="font-bold text-2xl">Dashboard</h1>
			</div> -->
			<div class="mx-auto px-4">
				<!-- Replace with your content -->
				<div class="">
					<div class="" >
						<div class="flex flex-row w-full mb-5">
							<div class="w-4/12 pr-4">
								<select class="px-4 border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-full shadow-sm w-full" v-model="selectedCustomer" @change="fetchChartData">
									<option value="">All Customers</option>
									<option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.firstName }}</option>
								</select>
							</div>
							<div class="w-4/12 pr-4">
								<select class="px-4 border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-full shadow-sm w-full" v-model="selectedDateRange" @change="fetchChartData">
									<option value="">All Time</option>
                  <option value="weekly">Last Week</option>
									<option value="monthly">Last Month</option>
									<option value="yearly">Current Year</option>
								</select>
							</div>
							<div class="w-4/12" v-if="chartData">
								<select class="px-4 border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-full shadow-sm w-full" v-model="selectedOrderStatus" @change="fetchChartData">
									<option value="">All Order Statuses</option>
									<option v-for="status in chartData.statusOptions" :value="status.value">{{ status.name }}</option>
								</select>
							</div>
						</div>
            <div v-if="chartData" class="flex flex-row w-full mb-2 justify-center text-center">
              
							<div class="w-4/12 pr-4" v-if="chartData.chartData.datasets[0].data.reduce((partialSum, a) => partialSum + a, 0) > 0">
								<div class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg">
                  <div>
                    <h2 class="text-gray-800 text-3xl font-semibold">{{ chartData.chartData.datasets[0].data.reduce((partialSum, a) => partialSum + a, 0) }}</h2>
                    <p class="mt-2 text-gray-600">Pending Orders</p>
                  </div>
                </div>
							</div>
							<div class="w-4/12 pr-4" v-if="chartData.chartData.datasets[2].data.reduce((partialSum, a) => partialSum + a, 0) > 0">
								<div class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg" v-if="chartData.chartData.datasets[2].data.reduce((partialSum, a) => partialSum + a, 0) > 0">
                  <div>
                    <h2 class="text-gray-800 text-3xl font-semibold">{{ chartData.chartData.datasets[2].data.reduce((partialSum, a) => partialSum + a, 0) }}</h2>
                    <p class="mt-2 text-gray-600">Delivered Orders</p>
                  </div>
                </div>
							</div>
							<div class="w-4/12 pr-4" v-if="chartData.chartData.datasets[3].data.reduce((partialSum, a) => partialSum + a, 0) > 0">
								<div class="max-w-md py-4 px-8 bg-white shadow-lg rounded-lg" v-if="chartData.chartData.datasets[3].data.reduce((partialSum, a) => partialSum + a, 0) > 0">
                  <div>
                    <h2 class="text-gray-800 text-3xl font-semibold">{{ chartData.chartData.datasets[3].data.reduce((partialSum, a) => partialSum + a, 0) }}</h2>
                    <p class="mt-2 text-gray-600">Canceled Orders</p>
                  </div>
                </div>
							</div>
						</div>
						<div class="mx-auto" style="width: 80%;">
							<canvas ref="chartCanvas"></canvas>
						</div>
					</div>
				</div>
				<!-- /End replace -->
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Chart, CategoryScale, LinearScale, BarElement, BarController, Title } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

export default {
	components: {
		AppLayout,
		Chart,
	},
	data() {
		return {
  		selectedCustomer: '',
  		selectedDateRange: '',
  		selectedOrderStatus: '',
  		customers: [], // Populate this with the customer data
  		chartData: null,
  		chartInstance: null,
		};
  },
	mounted() {
		this.fetchChartData();
    this.getCustomers();
	},
  methods: {
	fetchChartData() {
      const url = `/mysimit/api/dashboard/chart-data?customer=${this.selectedCustomer}&dateRange=${this.selectedDateRange}&orderStatus=${this.selectedOrderStatus}`;
      axios.get(url)
        .then(response => {
          this.chartData = response.data;
          this.renderChart();
        })
        .catch(error => {
          console.error('Failed to fetch chart data:', error);
        });
    	},

      getCustomers(){
        const url = `/mysimit/api/users/`;
        axios.get(url)
          .then(response => {
            this.customers = response.data.data;
          })
          .catch(error => {
            console.error('Failed to fetch chart data:', error);
          });
      },
    // renderChart() {
		
	// 	Chart.register(CategoryScale, LinearScale, BarElement, BarController, Title);
	// 	const canvas = this.$refs.chartCanvas;
	// 	const ctx = canvas.getContext('2d');

    //   new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //       labels: ['January', 'February', 'March', 'April', 'May', 'June'],
    //       datasets: [
    //         {
    //           label: 'Order Status 1',
    //           data: [10, 20, 15, 30, 25, 40],
    //           backgroundColor: 'rgba(255, 99, 132, 0.5)',
    //         },
    //         {
    //           label: 'Order Status 2',
    //           data: [5, 15, 25, 10, 20, 30],
    //           backgroundColor: 'rgba(54, 162, 235, 0.5)',
    //         },
    //       ],
    //     },
    //     options: {
    //       responsive: true,
    //       maintainAspectRatio: false,
    //       scales: {
    //         y: {
    //           beginAtZero: true,
    //         },
    //       },
    //     },
    //   });
    // },
	renderChart() {
    Chart.register(ChartDataLabels);
      if (this.chartInstance) {
        this.chartInstance.destroy();
      }
      
	  Chart.register(CategoryScale, LinearScale, BarElement, BarController, Title);
      const ctx = this.$refs.chartCanvas.getContext('2d');
      console.log(this.chartData)

      this.chartInstance = new Chart(ctx, {
        type: 'bar',
        data: this.chartData.chartData,
        // data: {
        //   labels: this.chartData.chartData.labels,

        //   datasets: [
        //     {
        //       label: 'Total Orders',
        //       data: this.chartData.totalOrders,
        //       backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //       borderColor: 'rgba(75, 192, 192, 1)',
        //       borderWidth: 1,
        //     },
        //     {
        //       label: 'Total Customers',
        //       data: this.chartData.totalCustomers,
        //       backgroundColor: 'rgba(255, 99, 132, 0.2)',
        //       borderColor: 'rgba(255, 99, 132, 1)',
        //       borderWidth: 1,
        //     },
        //   ],
        // },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0,
              },
            },
          },
          plugins: {
            //maintainAspectRatio: false,
            datalabels: {
              color: 'black',
              offset: 5,
              anchor: 'end',
              align: 'end',
              padding:{
                top: 40,
                bottom: 10
              },
              font: {
                weight: 'bold'
              },
              formatter: function (value, context) {
                if (value > 0) {
                  return value.toString(); // Customize the formatting as needed
                } else {
                  return ''; // Empty string if the value is not greater than 0
                }
              },
              offset: -25, // Adjust this value to set the vertical offset
            },
          },
        },

      });
    },
  },
};
</script>
<style>
canvas {
  width: 100%;
  height: 100%;
}
</style>