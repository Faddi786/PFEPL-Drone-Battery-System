<?php
session_start();
if (!isset($_SESSION['role'])!=0) {
  header('Location: login.html');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS
    <link rel="stylesheet" href="style.css"> -->


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
  <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <title>Flight Management</title>

  <style>
    
	.fa,
	.far,
	.fas {
		font-family: "Font Awesome 5 Free" !important;
	}

    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    html,
    body {
      display: grid;
      height: 100%;
      width: 100%;
      place-items: center;
      /*background-color: #8EC5FC;*/
      background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    }

    ::selection {
      background: #1a75ff;
      color: #fff;
    }

    .wrapper {
      overflow: hidden;
      max-width: 390px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
    }

    .wrapper .title-text {
      display: flex;
      width: 200%;
    }

    .wrapper .title {
      width: 50%;
      font-size: 29px;
      font-weight: 600;
      text-align: center;
      transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .wrapper .slide-controls {
      position: relative;
      display: flex;
      height: 50px;
      width: 100%;
      overflow: hidden;
      margin: 30px 0 10px 0;
      justify-content: space-between;
      border: 1px solid lightgrey;
      border-radius: 15px;
    }

    .slide-controls .slide {
      height: 100%;
      width: 100%;
      color: #fff;
      font-size: 18px;
      font-weight: 500;
      text-align: center;
      line-height: 48px;
      cursor: pointer;
      z-index: 1;
      transition: all 0.6s ease;
    }

    .slide-controls label.signup {
      color: #000;
    }

    .slide-controls .slider-tab {
      position: absolute;
      height: 100%;
      width: 50%;
      left: 0;
      z-index: 0;
      border-radius: 15px;
      background: -webkit-linear-gradient(left, #003366, #004080, #0059b3, #0073e6);
      transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    input[type="radio"] {
      display: none;
    }

    #signup:checked~.slider-tab {
      left: 50%;
    }

    #signup:checked~label.signup {
      color: #fff;
      cursor: default;
      user-select: none;
    }

    #signup:checked~label.login {
      color: #000;
    }

    #login:checked~label.signup {
      color: #000;
    }

    #login:checked~label.login {
      cursor: default;
      user-select: none;
    }

    .wrapper .form-container {
      width: 100%;
      overflow: hidden;
    }

    .form-container .form-inner {
      display: flex;
      width: 200%;
    }

    .form-container .form-inner form {
      width: 50%;
      transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .form-inner form .field {
      height: 50px;
      width: 100%;
      margin-top: 20px;
    }

    .form-inner form .field input {
      height: 100%;
      width: 100%;
      outline: none;
      padding-left: 15px;
      border-radius: 15px;
      border: 1px solid lightgrey;
      border-bottom-width: 2px;
      font-size: 17px;
      transition: all 0.3s ease;
    }

    .form-inner form .field input:focus {
      border-color: #1a75ff;
      /* box-shadow: inset 0 0 3px #fb6aae; */
    }

    .form-inner form .field input::placeholder {
      color: #999;
      transition: all 0.3s ease;
    }

    form .field input:focus::placeholder {
      color: #1a75ff;
    }

    .form-inner form .pass-link {
      margin-top: 5px;
    }

    .form-inner form .signup-link {
      text-align: center;
      margin-top: 30px;
    }

    .form-inner form .pass-link a,
    .form-inner form .signup-link a {
      color: #1a75ff;
      text-decoration: none;
    }

    .form-inner form .pass-link a:hover,
    .form-inner form .signup-link a:hover {
      text-decoration: underline;
    }

    form .btn {
      height: 50px;
      width: 100%;
      border-radius: 15px;
      position: relative;
      overflow: hidden;
    }

    form .btn .btn-layer {
      height: 100%;
      width: 300%;
      position: absolute;
      left: -100%;
      background: -webkit-linear-gradient(right, #003366, #004080, #0059b3, #0073e6);
      border-radius: 15px;
      transition: all 0.4s ease;
      ;
    }

    form .btn:hover .btn-layer {
      left: 0;
    }

    form .btn input[type="submit"] {
      height: 100%;
      width: 100%;
      z-index: 1;
      position: relative;
      background: none;
      border: none;
      color: #fff;
      padding-left: 0;
      border-radius: 15px;
      font-size: 20px;
      font-weight: 500;
      cursor: pointer;
    }

    .button-15 {
      background-image: linear-gradient(#42A1EC, #0070C9);
      border: 1px solid #0077CC;
      border-radius: 4px;
      box-sizing: border-box;
      color: #FFFFFF;
      cursor: pointer;
      direction: ltr;
      display: block;
      font-family: "SF Pro Text", "SF Pro Icons", "AOS Icons", "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 17px;
      font-weight: 400;
      letter-spacing: -.022em;
      line-height: 1.47059;
      min-width: 30px;
      overflow: visible;
      padding: 4px 15px;
      text-align: center;
      vertical-align: baseline;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      white-space: nowrap;
    }

    .button-15:disabled {
      cursor: default;
      opacity: .3;
    }

    .button-15:hover {
      background-image: linear-gradient(#51A9EE, #147BCD);
      border-color: #1482D0;
      text-decoration: none;
    }

    .button-15:active {
      background-image: linear-gradient(#3D94D9, #0067B9);
      border-color: #006DBC;
      outline: none;
    }

    .button-15:focus {
      box-shadow: rgba(131, 192, 253, 0.5) 0 0 0 3px;
      outline: none;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #E3F2FD;
    }

    .select-menu {
      width: 380px;
      margin: 140px auto;
    }

    .select-menu .select-btn {
      display: flex;
      height: 55px;
      background: #fff;
      padding: 20px;
      font-size: 18px;
      font-weight: 400;
      border-radius: 8px;
      align-items: center;
      cursor: pointer;
      justify-content: space-between;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .select-btn i {
      font-size: 25px;
      transition: 0.3s;
    }

    .select-menu.active .select-btn i {
      transform: rotate(-180deg);
    }

    .select-menu .options {
      position: relative;
      padding: 20px;
      margin-top: 10px;
      border-radius: 8px;
      background: #fff;
      box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
      display: none;
    }

    .select-menu.active .options {
      display: block;
    }

    .options .option {
      display: flex;
      height: 55px;
      cursor: pointer;
      padding: 0 16px;
      border-radius: 8px;
      align-items: center;
      background: #fff;
    }

    .options .option:hover {
      background: #F2F2F2;
    }

    .option i {
      font-size: 25px;
      margin-right: 12px;
    }

    .option .option-text {
      font-size: 18px;
      color: #333;
    }
  </style>

  <style>
    .field {
      margin-bottom: 10px;
    }

    .btn-layer {
      background-color: #5cb85c;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <a href="auth.php?action=logout" class="button-15" style="text-decoration:none; width:fit-content;">↩️Logout</a>
    <br>
    <div class="title-text">
      <div class="title login">Start Journey</div>
      <div class="title signup">End Journey</div>
    </div>

    <div class="form-container">
      <div class="slide-controls">
        <input type="radio" name="slide" id="login" checked>
        <input type="radio" name="slide" id="signup">
        <label for="login" class="slide login">Start</label>
        <label for="signup" class="slide signup">End</label>
        <div class="slider-tab"></div>
      </div>

      <div class="form-inner">

        <!-- start form  -->
        <form id="startJourneyForm" method="POST" action="saveStartJourney.php" class="login">
          <div class="field">
            <input placeholder="Your EmpID" type="text" id="emp_id_start" name="emp_id_start" required
              oninput="fetchEmployeeName(this.value, 'start')" value="<?php echo $_SESSION['emp_id']?>">
          </div>
          <div class="field">
            <input placeholder="Your name" type="text" id="emp_name_start" name="emp_name_start" required readonly value="<?php echo $_SESSION['emp_name']?>">
          </div>
          <div>
            <select class="field"
              style="display: flex; height: 49px; cursor: pointer; padding: 0 16px; border-radius: 15px; align-items: center; background: #fff;"
              id="project" name="project" required>
              <option value="">Select Project</option>
            </select>
          </div>
          <div class="field">
            <input type="text" id="start_location" name="start_location" readonly required>
          </div>
          <div class="field">
            <input placeholder="start_voltage" type="text" id="start_voltage" name="start_voltage" required>
          </div>
          <!-- <div class="field">
            <input hidden placeholder="start_time" type="text" id="start_time" name="start_time">
          </div> -->
          <div class="col-md-6" style="display:contents;">
            <video id="preview" width="100%"></video>
          </div>
          <br>
          <!-- <div class="container">
            <div class="row">
              <div class="col-md-6">
                <label>SCAN QR CODE for Drone ID</label>
                <input type="text" name="drone_id" id="drone_id"  placeholder="scan qrcode"
                  class="form-control">
                <button type="button" onclick="startScan('drone_id')">Scan Drone QR</button>
              </div>
            </div>
          </div> -->
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <label>SCAN QR CODE for Drone ID</label>
                <br>
                <input type="text" name="drone_id" id="drone_id"  placeholder="scan qrcode">
                <button type="button" onclick="startScan('drone_id')">Scan Drone QR</button>
              </div>
            </div>
          </div>
          <br>
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <label>SCAN QR CODE for Battery ID</label>
                <br>
                <input type="text" name="battery_id" id="battery_id" placeholder="scan qrcode">
                <button type="button" onclick="startScan('battery_id')">Scan Battery QR</button>
              </div>
            </div>
          </div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Submit">
          </div>
        </form>
        <!-- start form end -->

        <form id="endJourneyForm" method="POST" action="saveEndJourney.php" class="signup">
          <div class="field">
            <input placeholder="Your EmpID" type="text" id="emp_id_end" name="emp_id_end" required
              oninput="fetchEmployeeName(this.value, 'end')">
          </div>
          <div class="field">
            <input placeholder="Your name" type="text" id="emp_name_end" name="emp_name_end" required><br><br>
          </div>
          <!-- <div class="field">
            <input placeholder="Your location" type="text" id="end_location" name="end_location" readonly><br><br>
          </div> -->
          <div class="field">
            <input placeholder="End Voltage" type="text" id="end_voltage" name="end_voltage"><br><br>
          </div>
          <div class="field">
            <input placeholder="Flight Time" type="text" id="flight_time" name="flight_time"><br><br>
          </div>
          <div class="field">
            <input placeholder="Flight Area" type="text" id="flight_area" name="flight_area"><br><br>
          </div>
          <div class="field">
            <input type="text" placeholder="This is remark" id="remark" name="remark">
          </div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Submit">
          </div>

        </form>

      </div>
    </div>
  </div>


  <script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    let currentInputId = '';

    function startScan(inputId) {
      currentInputId = inputId;
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          alert('No cameras found');
        }
      }).catch(function (e) {
        console.error(e);
      });
    }

    scanner.addListener('scan', function (content) {
      document.getElementById(currentInputId).value = content;
      scanner.stop();
    });
  </script>

  <script>
    //switching tabs
    const loginText = document.querySelector(".title-text .login");
    const loginForm = document.querySelector("form.login");
    const loginBtn = document.querySelector("label.login");
    const signupBtn = document.querySelector("label.signup");
    const signupLink = document.querySelector("form .signup-link a");
    signupBtn.onclick = (() => {
      loginForm.style.marginLeft = "-50%";
      loginText.style.marginLeft = "-50%";
    });
    loginBtn.onclick = (() => {
      loginForm.style.marginLeft = "0%";
      loginText.style.marginLeft = "0%";
    });
    signupLink.onclick = (() => {
      signupBtn.click();
      return false;
    });
  </script>
  <script>
    function getLocation(callback) {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(callback, showError);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("User denied the request for Geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }

    function fetchEmployeeDetails(empName) {
      if (empName.length == 0) {
        document.getElementById("emp_id").innerHTML = "<option value=''>Select Employee ID</option>";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var empIDs = JSON.parse(this.responseText);
          var empIDDropdown = document.getElementById("emp_id");
          empIDDropdown.innerHTML = "<option  value=''>Select Employee ID</option>";
          for (var i = 0; i < empIDs.length; i++) {
            var option = document.createElement("option");
            option.value = empIDs[i];
            option.text = empIDs[i];
            empIDDropdown.add(option);
          }
        }
      };
      xmlhttp.open("GET", "getEmployeeDetails.php?emp_name=" + empName, true);
      xmlhttp.send();
    }


    function fetchVehicleDetails(vehicleNumber) {
      if (vehicleNumber.length == 0) {
        document.getElementById("v_name").value = "";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("v_name").value = this.responseText;
        }
      };
      xmlhttp.open("GET", "getVehicleDetails.php?v_id=" + vehicleNumber, true);
      xmlhttp.send();
    }

    function fetchEmployeeName(empId, formType) {
      if (empId.length == 0) {
        document.getElementById(formType === 'start' ? "emp_name_start" : "emp_name_end").value = "";
        return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById(formType === 'start' ? "emp_name_start" : "emp_name_end").value = this.responseText;
        }
      };
      xmlhttp.open("GET", "getEmployeeDetails.php?emp_id=" + empId, true);
      xmlhttp.send();
    }

    function fetchProjectDetails() {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          try {
            var projects = JSON.parse(this.responseText);
            var projectDropdown = document.getElementById("project");

            projectDropdown.innerHTML = "<option value=''>Select Project</option>";
            projects.forEach(function (project) {
              var option = document.createElement("option");
              option.value = project.project_id; // Assuming your project_id is named project_id
              option.text = project.project_name;
              projectDropdown.add(option);
            });
          } catch (e) {
            console.error("Error parsing JSON: ", e);
            console.log("Response Text: ", this.responseText);
          }
        }
      };
      xmlhttp.open("GET", "getProjectDetails.php", true);
      xmlhttp.send();
    }


    // Event listener for project dropdown change
    document.getElementById("project").addEventListener("change", function () {
      var projectId = this.value; // Get the selected project ID
      console.log("Selected Project ID:", projectId);
      fetchSiteDetails(projectId); // Pass the project ID to fetch site details
    });

    // Call fetchProjectDetails when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', fetchProjectDetails);

    function capturePhoto(formType) {
      // Trigger the hidden file input element to open camera
      document.getElementById('photo_input').click();

      // Listen for changes in the input
      document.getElementById('photo_input').addEventListener('change', function () {
        const file = this.files[0]; // Get the selected file

        if (file) {
          // Create FormData and append the selected file
          const formData = new FormData();
          formData.append('photo', file, 'photo.jpg'); // Assume saving as JPG

          // Perform the upload via fetch
          fetch('upload_photo.php', {
            method: 'POST',
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              console.log('Server response:', data);
              if (data.success) {
                // Assuming ${formType}_photo is the ID of your input field for storing the image path
                document.getElementById(`${formType}_photo`).value = data.imagePath;
                alert('Photo captured and uploaded successfully!');

                // Display the image in the form
                const img = document.createElement('img');
                img.src = data.imagePath;
                img.style.width = '100px';
                img.style.height = 'auto';
                // Assuming ${formType}PhotoContainer is the ID of the container where you want to display the image
                const container = document.getElementById(`${formType}PhotoContainer`);
                container.innerHTML = ''; // Clear existing content
                container.appendChild(img);
              } else {
                console.error('Upload failed:', data.error);
                alert('Failed to upload photo. Error: ' + data.error);
              }
            })
            .catch(error => {
              console.error('Error uploading photo:', error);
              alert('Error uploading photo. Please try again.');
            });
        }
      });
    }


    function setStartLocation() {
      getLocation(function (position) {
        document.getElementById('start_location').value = position.coords.latitude + ", " + position.coords.longitude;
        document.getElementById('start_latitude').value = position.coords.latitude;
        document.getElementById('start_longitude').value = position.coords.longitude;
      });
    }

    function setEndLocation() {
      getLocation(function (position) {
        document.getElementById('end_location').value = position.coords.latitude + ", " + position.coords.longitude;
        document.getElementById('end_latitude').value = position.coords.latitude;
        document.getElementById('end_longitude').value = position.coords.longitude;
      });
    }

    function validatePhoto(formType) {
      const photoField = document.getElementById(`${formType}_photo`).value;
      if (!photoField) {
        alert("Uploading the image is compulsory.");
        return false;
      }
      return true;
    }



    document.addEventListener('DOMContentLoaded', function () {
      setStartLocation();
      setEndLocation();
    });
  </script>
</body>

</html>