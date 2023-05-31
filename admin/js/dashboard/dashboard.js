const ctx = document.getElementById("myChart");

var doughnutData = [10, 4, 5, 8];

var doughnutColors = ["#F9B17A", "#676F9D", "#161e31", "#006400"];

var doughnutChart = new Chart(ctx, {
  type: "doughnut",
  data: {
    datasets: [
      {
        data: doughnutData,
        backgroundColor: doughnutColors,
      },
    ],
  },
  options: {
    //ma...
    responsive: false,
    cutout: 30,
    animation: {
      animateRotate: true,
    },
  },
});

const ctx2 = document.getElementById("myChart2");

const labels = ["프론트엔드", "백엔드", "UI/UX", "일반 디자인"];
const data = {
  labels: labels,
  datasets: [
    {
      data: [80, 59, 65, 40],
      backgroundColor: ["#F9B17A", "#676F9D", "#161e31", "#006400"],
    },
  ],
};

const config = {
  type: "bar",
  data: data,
  options: {
    responsive: false,
    indexAxis: "x",
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
      },
    },
  },
};
const stackedBar = new Chart(ctx2, config);

document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
  });
  calendar.render();
});
