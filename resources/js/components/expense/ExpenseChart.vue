<template>
  <canvas id="myChart"></canvas>
</template>

<script>
import Chart from 'chart.js/auto';
import {getRelativePosition} from 'chart.js/helpers';

export default {
  name: 'BarChart',

  data: () => ({
    bgColors: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(67, 20, 108, 0.2)'
    ],
    bColors: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)',
      'rgba(67, 20, 108, 1)'
    ],
    loaded: false,
    chartData: [],
    labels: []
  }),
  async mounted() {
    try {
      axios.get('/api/category/chartList').then(({data}) => {
        const resp = data.data
        resp.forEach((category) => {
          this.labels.push(category.name)
          this.chartData.push(category.total)
        })

        console.log(JSON.parse(JSON.stringify(this.chartData)))
        const ctx = 'myChart';
        const chart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: this.labels,
            datasets: [
              {
                label: [],
                data: this.chartData,
                backgroundColor: this.bgColors,
                borderColor: this.bColors
              }
            ]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            },
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Total Expenses per Category'
              }
            }
          }
        })

      });

    } catch (e) {
      console.error(e)
    }
  }
}
</script>