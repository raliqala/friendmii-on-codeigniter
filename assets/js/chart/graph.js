$(document).ready(function(){
    var ctx = document.getElementById('myChart').getContext('2d');
    all_users = $('#all_users').val();
    online_users = $('#online_users').val();
    posts_today = $('#posts_today').val();
    deleted_accounts = $('#deleted_accounts').val();
    blocked_accounts = $('#blocked_accounts').val();
    last_seen_today = $('#last_seen_today').val();
    new_registrations = $('#new_registrations').val();
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['All Users', 'Online Users', 'Posts Today', 'Blocked Accounts', 'Deleted Accounts', 'Last Seen Today', 'New Registration'],
        datasets: [{
            label: all_users+' Users',
            data: [all_users, online_users, posts_today, blocked_accounts, deleted_accounts, last_seen_today, new_registrations],
            backgroundColor: [
                'rgba(65, 93, 89, 1)',
                'rgba(11, 229, 200, 1)',
                'rgba(88, 14, 80, 1)',
                'rgba(36, 34, 103, 1)',
                'rgba(103, 60, 34, 1)',
                'rgba(34, 103, 45, 1)',
                'rgba(103, 34, 34, 1)'
            ],
            borderColor: [
                'rgba(65, 93, 89, 1)',
                'rgba(0,255,0,1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(230, 10, 10, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
})