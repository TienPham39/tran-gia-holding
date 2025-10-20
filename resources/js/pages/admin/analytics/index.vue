<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div
      v-for="(stat, index) in statsData"
      :key="index"
      class="stats bg-base-100 shadow"
    >
      <div class="stat">
        <div class="stat-title">{{ stat.title }}</div>
        <div class="stat-value">{{ stat.value }}</div>
        <div
          class="stat-desc"
          :class="{
            'text-green-500': isPositiveChange(stat.desc),
            'text-red-500': !isPositiveChange(stat.desc),
          }"
        >
          {{ stat.desc }}
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-base-100 p-6 rounded-xl shadow-md">
      <h2 class="text-lg font-semibold mb-4">Monthly Revenue</h2>
      <Line
        :data="revenueChartData"
        :options="lineChartOptions"
        class="max-h-[300px]"
        :key="lineChartKey"
      />
    </div>

    <div class="bg-base-100 p-6 rounded-xl shadow-md">
      <h2 class="text-lg font-semibold mb-4">Revenue Sources</h2>
      <Doughnut
        :data="doughnutChartData"
        :options="doughnutChartOptions"
        class="max-h-[300px]"
        :key="doughnutChartKey"
      />
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { Doughnut, Line } from "vue-chartjs";
import admin from "../../../layouts/admin.vue";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  ArcElement,
} from "chart.js";

defineOptions({
  layout: admin,
})

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
  ArcElement
);

const lineChartKey = ref(0);
const doughnutChartKey = ref(0);

const statsData = ref([
  { title: "Tổng Users", value: "100", desc: "⬈ 14% so với tháng trước" },
  { title: "Dự án", value: "10", desc: "⬈ 3 dự án mới" },
  { title: "Liên hệ", value: "300", desc: "⬈ 22% so với tháng trước" },
  { title: "Ứng viên", value: "45", desc: "⬊ 5% so với tháng trước" },
]);

const isPositiveChange = (desc) => {
  return desc.includes("⬈");
};

const revenueChartData = ref({
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
  datasets: [
    {
      label: "Revenue ($)",
      data: [12000, 1900, 3000, 5000, 20000, 3000],
      fill: false,
      borderColor: "#E82561",
      backgroundColor: "#E82561",
      tension: 0.4,
    },
  ],
});

const lineChartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  animations: {
    tension: {
      duration: 1000,
      easing: "linear",
      from: 1,
      to: 0,
      loop: false,
    },
  },
  plugins: {
    legend: {
      labels: {
        color: "#64748b",
      },
    },
  },
  scales: {
    x: {
      grid: {
        color: "rgba(0,0,0,0.1)",
      },
      ticks: {
        color: "#64748b",
      },
    },
    y: {
      grid: {
        color: "rgba(0,0,0,0.1)",
      },
      ticks: {
        color: "#64748b",
      },
    },
  },
});

const doughnutChartData = ref({
  labels: ["Products", "Services", "Subscription", "Consulting"],
  datasets: [
    {
      label: "Revenue ($)",
      data: [35, 25, 20, 20],
      backgroundColor: ["#4635B1", "#E82561", "#ECE852", "#FFA24C"],
      borderWidth: 0,
      hoverOffset: 10,
    },
  ],
});

const doughnutChartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  cutout: "70%",
  animations: {
    duration: 1000,
    easing: "linear",
    animateScale: true,
    animateRotate: true,
  },
  plugins: {
    legend: {
      position: "right",
      labels: {
        color: "#64748b",
        boxWidth: 1,
        padding: 16,
      },
    },
    tooltip: {
      callbacks: {
        label: function (context) {
          return `${context.label}: ${context.raw}%`;
        },
      },
    },
  },
});

onMounted(() => {
  lineChartKey.value++;
  doughnutChartKey.value++;
});
</script>
