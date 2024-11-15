<?php include ('./admin/includes-admin/connection.php'); ?>
<?php include ('includes/header.php'); ?>
<?php include ('./admin/includes-admin/navbar-admin.php'); ?>
<style>
    .container{
        background-color: white;
    border-radius: 20px;
    display: flex;
    align-items: center;
    flex-direction: column;
    margin-top: 5%;
    max-width: 550px;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

</style>
<div class="container">
    <h1 class="mt-5" style="margin-top: 2rem !important;">Battery Usage Report</h1>
    <form id="reportForm" action="generate_report.php" method="post" class="mt-3" style="margin-left: 10%;">
        <div class="mb-3" style="display : flex;">
            <label for="battery_id" class="form-label" style="margin-right: 6%;margin-top: 1%;">Battery ID</label>
            <input type="text" class="form-control" style="width : 55%;" id="battery_id" name="battery_id" required>
        </div>
        <div class="mb-3" style="display : flex;">
            <label for="start_date" class="form-label" style="margin-right: 5%;margin-top: 2%;">Start Date</label>
            <input type="date" class="form-control" style="width : 55%;" id="start_date" name="start_date" required>
        </div>
        <div class="mb-3" style="display : flex;">
            <label for="end_date" class="form-label" style="margin-right: 7.5%;margin-top: 2%;">End Date</label>
            <input type="date" class="form-control" style="width : 55%;" id="end_date" name="end_date" required>
        </div>
        <button type="submit" class="btn btn-primary"  style="background-color: #094938d1;;margin-bottom: 10%;width: 60%;margin-left: 13%;">Submit</button>
    </form>
</div>

<!-- <script>
document.getElementById('reportForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting

    var startDate = new Date(document.getElementById('start_date').value);
    var endDate = new Date(document.getElementById('end_date').value);

    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    var startDateFormatted = startDate.toLocaleDateString('en-US', options);
    var endDateFormatted = endDate.toLocaleDateString('en-US', options);


    // Now set the formatted dates to hidden inputs and submit the form
    var form = document.getElementById('reportForm');
    form.appendChild(createHiddenInput('start_date_formatted', formatDateForSQL(startDate)));
    form.appendChild(createHiddenInput('end_date_formatted', formatDateForSQL(endDate)));
    form.submit();
});

function createHiddenInput(name, value) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}

function formatDateForSQL(date) {
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    return year + '-' + month + '-' + day;
}
</script> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>