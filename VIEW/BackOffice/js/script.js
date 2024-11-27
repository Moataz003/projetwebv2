// Traffic Chart (Bar)
const trafficCtx = document.getElementById('trafficChart').getContext('2d');
new Chart(trafficCtx, {
  type: 'bar',
  data: {
    labels: ['01', '02', '03', '04', '05', '06', '07'],
    datasets: [{
      label: 'Traffic',
      data: [500, 800, 750, 600, 950, 700, 850],
      backgroundColor: '#00bcd4',
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
    },
  }
});

// Order Time Chart (Pie)
const orderTimeCtx = document.getElementById('orderTimeChart').getContext('2d');
new Chart(orderTimeCtx, {
  type: 'pie',
  data: {
    labels: ['Afternoon', 'Evening', 'Morning'],
    datasets: [{
      data: [40, 32, 28],
      backgroundColor: ['#00bcd4', '#ff9800', '#8bc34a'],
    }]
  },
  options: {
    responsive: true,
  }
});

// Sales Over Time (Line Chart)
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
  type: 'line',
  data: {
    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    datasets: [{
      label: 'Sales ($)',
      data: [300, 450, 350, 500, 650, 700, 600],
      borderColor: '#ff9800',
      backgroundColor: 'rgba(255, 152, 0, 0.2)',
      fill: true,
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: true },
    },
  }
});

// Course Ratings Distribution (Doughnut Chart)
const ratingsCtx = document.getElementById('ratingsChart').getContext('2d');
new Chart(ratingsCtx, {
  type: 'doughnut',
  data: {
    labels: ['JavaScript', 'CSS', 'HTML', 'Python'],
    datasets: [{
      data: [25, 20, 30, 25],
      backgroundColor: ['#00bcd4', '#8bc34a', '#ff9800', '#673ab7'],
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: true },
    },
  }
});

// Category Performance (Radar Chart)
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
  type: 'radar',
  data: {
    labels: ['Web Development', 'Data Science', 'Mobile Apps', 'Game Development', 'AI'],
    datasets: [{
      label: 'Performance',
      data: [80, 90, 70, 60, 85],
      borderColor: '#673ab7',
      backgroundColor: 'rgba(103, 58, 183, 0.2)',
      fill: true,
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: true },
    },
    scales: {
      r: {
        angleLines: { display: false },
        suggestedMin: 50,
        suggestedMax: 100
      }
    }
  }
});
