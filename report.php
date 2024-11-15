<?php include ('./admin/includes-admin/connection.php'); ?>
<?php include ('includes/header.php'); ?>
<?php include ('./admin/includes-admin/navbar-admin.php'); ?>
<nav style="background:white; height:68px; ">
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>

    </label>
    <ul style="text-align: left;width: 100%;cursor:pointer;color:black; font-size:18px " id="menu">
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C; margin-left:40px">Battery Report</li>
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C;">Monthly Drone</li>
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C;">Yearly Drone</li>
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C;">Flight Count Drone</li>
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C;">Battery In Drone</li>
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C;">Project Specific</li>
        <li style="line-height: 40px; font-size:15px;padding:5px; border-radius: 10px 10px 0 0;background:#f0f0f0; border-top: 1px solid #356A5C; border-left: 1px solid #356A5C; border-right: 1px solid #356A5C;">Overall Drone</li>
    </ul>
</nav>
<style>
    body {
        /* display: flex; */
        /* #f0f0f0 */
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f0f0f0;
        margin: 0;
    }

    .chartImg {
        overflow: auto;
    }

    .container {
        display: flex;
        flex-direction: row;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        background-color: white;
        padding: 10px;
        background:#307a67d1;
    }


    .form-container {
        padding: 30px;
        background-color: #ffffff;
        width: 40%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-container h1 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .form-label {
        margin-bottom: 10px;
        color: #555;
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-primary_custom {
        background-color: #094938d1;
        border: none;
        padding: 10px;
        border-radius: 4px;
        width: 100%;
        color: white;
        cursor: pointer;
    }

    .chart-container {
        width: 60%;
        background-color: #f7f7f7;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    #chart-container img {
        max-width: 100%;
        height: auto;
    }
</style>
<div>
    <!-- Drone Report Form -->
    <div class="container DroneForm" style="display:none">
        <div class="form-container">
            <h1>Drone Report (Monthly)</h1>
            <form id="DroneForm">
                <input type="hidden" name="form_id" value="DroneForm">
                <label for="drone_id" class="form-label">Drone ID</label>
                <input type="text" class="form-control" id="drone_id" name="drone_id" required>
                <label for="month" class="form-label">For Month</label>
                <input type="month" class="form-control" id="month" name="month" required>
                <button type="submit" id="drone_submit" class="btn btn-primary_custom">Submit</button>
            </form>
        </div>
        <div class="chart-container" id="drone_chart_container">
            <!-- Chart will be displayed here -->
        </div>
    </div>

    <!-- Battery Report Form (hidden by default) -->
    <div class="container BatteryForm" style="display:none">
        <div class="form-container">
            <h1>Battery Report</h1>
            <form id="BatteryForm">
                <input type="hidden" name="form_id" value="BatteryForm">
                <label for="battery_id" class="form-label">Battery ID</label>
                <input type="text" class="form-control" id="battery_id" name="battery_id" required>
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
                <button type="submit" id="battery_submit" class="btn btn-primary_custom">Submit</button>
            </form>
        </div>
        <div class="chart-container" id="battery_chart_container">
            <!-- Chart will be displayed here -->
        </div>
    </div>

    <!-- Drone Report Form Yearly(hidden by default) -->
    <div class="container DroneYearlyForm" style="display:none">
        <div class="form-container">
            <h1>Drone Report (Yearly)</h1>
            <form id="DroneYearlyForm">
                <label for="drone_id_yearly" class="form-label">Drone ID</label>
                <input type="text" class="form-control" id="drone_id_yearly" name="drone_id_yearly" required>
                <label for="year" class="form-label">Enter Year</label> <br>
                <input type="number" id="year" name="year" required min="2000" max="2099" step="1"
                    style="width:100%; border: 1px solid #ccc; margin-bottom:10px">
                <button type="submit" id="drone_yearly_submit" class="btn btn-primary_custom">Submit</button>
            </form>
        </div>
        <div class="chart-container" id="drone_yearly_chart_container">
            <!-- Chart will be displayed here -->
        </div>
    </div>

    <!-- Flight count for drone -->
    <div class="container FlightCountForm" style="display:none">
        <div class="form-container">
            <h1>Flight Count</h1>
            <form id="FlightCountForm">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <button type="submit" class="btn btn-primary_custom">Submit</button>
            </form>
        </div>
        <div class="chart-container" id="flight_count_chart_container">
            <!-- chart -->
        </div>
    </div>
    <!-- Project area covered by drones-->
    <div class="container ProjectAreaForm" style="display:none">
        <div class="form-container">
            <h1>Project Area</h1>
            <form id="ProjectAreaForm">
                <label for="project_name" class="form-label">Project Name:</label>
                <input type="text" id="project_name" name="project_name" required>

                <label for="start_date_area" class="form-label">Start Date:</label>
                <input type="date" id="start_date_area" name="start_date" required>

                <label for="end_date_area" class="form-label">End Date:</label>
                <input type="date" id="end_date_area" name="end_date" required>

                <button type="submit" class="btn btn-primary_custom">Submit</button>
            </form>

        </div>

        <div class="chart-container" id="project_area_chart_container"></div>
        <!-- chart -->
    </div>

    <!-- Battery Usage Report Form (hidden by default) -->
    <div class="container BatteryUsageForm">
        <div class="form-container">
            <h1>Battery Usage Report</h1>
            <form id="BatteryUsageForm">
                <label for="drone_id_usage" class="form-label">Drone ID</label>
                <input type="text" class="form-control" id="drone_id_usage" name="drone_id_usage" required>

                <label for="start_date_usage" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date_usage" name="start_date_usage" required>

                <label for="end_date_usage" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date_usage" name="end_date_usage" required>

                <button type="submit" class="btn btn-primary_custom">Submit</button>
            </form>
        </div>
        <div class="chart-container" id="battery_usage_chart_container">
            <!-- Chart will be displayed here -->
        </div>
    </div>
    <!-- total area covered by drones-->
    <div class="container TotalAreaForm">
        <div class="form-container">
            <h1>Drone area coverage</h1>
            <form id="TotalAreaForm">
                <button type="submit" class="btn btn-primary_custom">Generate Total Area Graph</button>
            </form>
        </div>
        <div class="chart-container" id="total_area_chart_container"></div>
        <!-- chart -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Handle Drone Report Form submission
        $('#DroneForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'report_handler.php',
                type: 'POST',
                data: formData + '&form_id=DroneForm',
                dataType: 'json',
                success: function (data) {
                    console.log('Drone Report Response:', data);
                    var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                        type: 'line',
                        data: {
                            labels: data.dates,
                            datasets: [
                                {
                                    label: 'Total Area Covered (sq/km)',
                                    data: data.totalAreas,
                                    borderColor: 'blue',
                                    fill: false
                                }
                            ]
                        }
                    }))}`;
                    $('#drone_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Drone Report Chart">`);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                }
            });
        });

        // Handle Battery Report Form submission
        $('#BatteryForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'report_handler.php',
                type: 'POST',
                data: formData + '&form_id=BatteryForm',
                dataType: 'json',
                success: function (data) {
                    console.log('Battery Report Response:', data);
                    var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                        type: 'line',
                        data: {
                            labels: data.dates,
                            datasets: [
                                {
                                    label: 'Start Voltage',
                                    data: data.startVoltages,
                                    borderColor: 'blue',
                                    fill: false
                                },
                                {
                                    label: 'End Voltage',
                                    data: data.endVoltages,
                                    borderColor: 'green',
                                    fill: false
                                },
                                {
                                    label: 'Flight Time',
                                    data: data.flightTimes,
                                    borderColor: 'red',
                                    fill: false
                                }
                            ]
                        }
                    }))}`;
                    $('#battery_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Battery Report Chart">`);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                }
            });
        });
    });

    // Handle Drone Yearly Report Form submission
    $('#DroneYearlyForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        const monthsName = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $.ajax({
            url: 'report_handler.php',
            type: 'POST',
            data: formData + '&form_id=DroneYearlyForm',
            dataType: 'json',
            success: function (data) {
                console.log('Drone Yearly Report Response:', data);

                // Assuming data contains monthsArray and totalAreas
                var monthsArray = data.months[0]; // [1, 2, 3, ...] (month numbers from 1 to 12)
                var totalAreas = data.totalAreas; // Array of total areas

                var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                    type: 'bar',
                    data: {
                        labels: monthsArray.map(monthIndex => monthsName[monthIndex - 1]), // Convert month numbers to names
                        datasets: [
                            {
                                label: 'Total Area Covered (sq/km)',
                                data: totalAreas, // Data should match the length of monthsArray
                                backgroundColor: 'blue',
                                borderColor: 'blue',
                                borderWidth: 1
                            }
                        ]
                    }
                }))}`;

                $('#drone_yearly_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Drone Yearly Report Chart">`);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });

    //flight count for drone
    $('#FlightCountForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log('Form data:', formData);
        $.ajax({
            url: 'report_handler.php',
            type: 'POST',
            data: formData + '&form_id=FlightCountForm',
            dataType: 'json',
            success: function (data) {
                console.log('Flight Count Response:', data);
                var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                    type: 'bar',
                    data: {
                        labels: data.drones,
                        datasets: [
                            {
                                label: 'Number of Flights',
                                data: data.flightCounts,
                                backgroundColor: 'green',
                                borderColor: 'green',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }]
                        }
                    }
                }))}`;
                $('#flight_count_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Flight Count Chart">`);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });

    //project area covered by drone
    $('#ProjectAreaForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log('Form Data:', formData);

        $.ajax({
            url: 'report_handler.php',
            type: 'POST',
            data: formData + '&form_id=ProjectAreaForm',
            dataType: 'json',
            success: function (data) {
                console.log('Project Area Report Response:', data);
                var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                    type: 'bar',
                    data: {
                        labels: data.drones,
                        datasets: [
                            {
                                label: 'Total Area Covered (sq/km)',
                                data: data.totalAreas,
                                backgroundColor: 'green',
                                borderColor: 'green',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }]
                        }
                    }
                }))}`;
                $('#project_area_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Project Area Report Chart">`);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });
    // Handle Battery Usage Report Form submission
    $('#BatteryUsageForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'report_handler.php',
            type: 'POST',
            data: formData + '&form_id=BatteryUsageForm',
            dataType: 'json',
            success: function (data) {
                console.log('Battery Usage Report Response:', data);
                var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                    type: 'bar',
                    data: {
                        labels: data.batteryIds,
                        datasets: [
                            {
                                label: 'Battery Usage Count',
                                data: data.usageCounts,
                                backgroundColor: 'purple',
                                borderColor: 'purple',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1
                                }
                            }]
                        }
                    }
                }))}`;
                $('#battery_usage_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Battery Usage Report Chart">`);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });

    $('#TotalAreaForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'report_handler.php',
            type: 'POST',
            data: { form_id: 'TotalAreaForm' },
            dataType: 'json',
            success: function (data) {
                console.log('Total Area Report Response:', data);
                var chartUrl = `https://quickchart.io/chart?c=${encodeURIComponent(JSON.stringify({
                    type: 'bar',
                    data: {
                        labels: data.drones,
                        datasets: [
                            {
                                label: 'Total Area Covered (sq/km)',
                                data: data.totalAreas,
                                backgroundColor: 'purple',
                                borderColor: 'purple',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 10
                                }
                            }]
                        }
                    }
                }))}`;
                $('#total_area_chart_container').html(`<img class="chartImg" src="${chartUrl}" alt="Total Area Covered Chart">`);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });

    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Get all the <li> elements
    const menuItems = document.querySelectorAll('#menu li');

    // Store form elements in an object
    const forms = {
        'Battery Report': document.querySelector('.BatteryForm'),
        'Monthly Drone': document.querySelector('.DroneForm'),
        'Yearly Drone': document.querySelector('.DroneYearlyForm'),
        'Flight Count Drone': document.querySelector('.FlightCountForm'),
        'Battery In Drone': document.querySelector('.BatteryUsageForm'),
        'Project Specific': document.querySelector('.ProjectAreaForm'),
        'Overall Drone': document.querySelector('.TotalAreaForm')
    };

    // Function to display a form
    function displayForm(formKey) {
        // Hide all forms
        Object.values(forms).forEach(form => {
            if (form) form.style.display = 'none';
        });

        // Show the selected form
        const formToShow = forms[formKey];
        if (formToShow) {
            formToShow.style.display = 'flex';
        } else {
            console.warn('No form found for:', formKey);
        }
    }

    // Function to handle click on menu items
    function handleMenuItemClick(event) {
        // Remove the 'active' class from all menu items
        menuItems.forEach(item => {
            item.style.background = '#f0f0f0';
            item.style.color="black";
        });

        // Add the 'active' class to the clicked item
        event.currentTarget.style.background = '#307a67d1';
        event.currentTarget.style.color= 'white';

        // Display the corresponding form
        const text = event.currentTarget.textContent.trim(); // Trim any extra spaces
        displayForm(text);
    }

    // Set default form to display
    const defaultForm = 'Battery Report'; // Set the default form key
    displayForm(defaultForm);

    // Set the default menu item background to white
    menuItems.forEach(item => {
        if (item.textContent.trim() === defaultForm) {
            item.style.background = '#307a67d1';
            item.style.color="white";
        }
    });

    // Add click event listeners to each <li>
    menuItems.forEach(item => {
        item.addEventListener('click', handleMenuItemClick);
    });

</script>

</body>

</html>