// Profile Progress Chart
const ctx1 = document.getElementById('profileProgressChart').getContext('2d');
const profileProgressChart = new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: ['Completed', 'In Progress', 'Remaining'],
        datasets: [{
            label: 'Profile Progress',
            data: [50, 20, 30], // Sample data - modify this as per actual progress data
            backgroundColor: ['#0cc0df', '#a8e0f0', '#eeeeee'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        }
    }
});

// Recent Achievements Chart
const ctx2 = document.getElementById('recentAchievementsChart').getContext('2d');
const recentAchievementsChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['HTML', 'CSS', 'JavaScript', 'SQL', 'Python'], // Achievement categories
        datasets: [{
            label: 'Recent Achievements',
            data: [5, 3, 4, 2, 1], // Sample data - modify this as per recent achievements
            backgroundColor: '#0cc0df'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Milestones Chart
const ctx3 = document.getElementById('milestonesChart').getContext('2d');
const milestonesChart = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'], // Time-based milestone tracking
        datasets: [{
            label: 'Milestone Progress',
            data: [1, 2, 3, 4, 5], // Sample data - adjust as per actual milestone progression
            borderColor: '#0cc0df',
            backgroundColor: '#a8e0f0',
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
