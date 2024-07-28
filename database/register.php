<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
</head>

<body>
<div class="all">
        
<div class="side">
<?php include 'sidebar.php'; ?>
</div>
<div class="forms_all">
<div class="forms">
<h1>Member Registration</h1>
</div>
    <form action="register_process.php" method="post" enctype="multipart/form-data">
        <div class="forms">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="forms">
            <label for="dob">Date of Birth:</label>
            <input type="text" id="dob" name="dob" required>
        </div>
        <div class="forms">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
            <option value="" selected hidden>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="forms">
            <label for="natal_day">Natal Day:</label>
            <select id="natal_day" name="natal_day" required>
            <option value="" selected hidden>Select Natal Day</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
        </div>
        <div class="forms">
            <label for="telephone">Telephone:</label>
            <input type="text" id="telephone" name="telephone" required>
        </div>
   
        <div class="forms">
            <label for="nationality">Nationality:</label>
            <select id="nationality" name="nationality" required>
            <option value="" selected hidden>Select Nationality</option>
                <option value="Ghana">Ghana</option>
            </select>
        </div>
        <div class="forms">
            <label for="marital_status">Marital Status:</label>
            <select id="marital_status" name="marital_status" required>
            <option value="" selected hidden>Select Marital Status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Religious">Religious</option>
            </select>
        </div>
        <div class="forms">
            <label for="level_of_education">Level of Education:</label>
            <select id="level_of_education" name="level_of_education" required>
            <option value="" selected hidden>Select Level of Education</option>
                <option value="Primary">Primary</option>
                <option value="Junior High">Junior High</option>
                <option value="Senior High">Senior High</option>
                <option value="Tertiary">Tertiary</option>
            </select>
        </div>
        <div class="forms">
            <label for="profession">Profession:</label>
            <select id="profession" name="profession" required>
            <option value="" selected hidden>Select Profession</option>
                <option value="Worker">Worker</option>
                <option value="Student">Student</option>
            </select>
        </div>
        <div class="forms">
            <label for="confirmation">Confirmation:</label>
            <select id="confirmation" name="confirmation" required>
            <option value="" selected hidden>Select Confirmation</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="forms">
            <label for="baptized">Baptized:</label>
            <select id="baptized" name="baptized" required>
            <option value="" selected hidden>Select Baptized</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="forms">
            <label for="society">Society:</label>
           
            <select id="society" name="society[]" multiple required>
          
                <option value="Sacred Heart of Confraternity">Sacred Heart of Confraternity</option>
                <option value="Youth Choir">Youth Choir</option>
                <option value="Legion of Mary">Legion of Mary</option>
                <option value="Charismatic">Charismatic</option>
                <option value="St Theresa Society">St Theresa Society</option>
                <option value="COSRA">COSRA</option>
                <option value="Children of Mary">Children of Mary</option>
                <option value="Knight and Ladies of Marshall">Knight and Ladies of Marshall</option>
                <option value="Young Men's">Young Men's</option>
                <option value="Mary Mother of Mothers">Mary Mother of Mothers</option>
                <option value="Theresa Mma Kuo">Theresa Mma Kuo</option>
                <option value="Men's">Men's</option>
                <option value="Senior Choir">Senior Choir</option>
                <option value="Lay Reader's">Lay Reader's</option>
                <option value="Ushers">Ushers</option>
                <option value="St Anthony Guild">St Anthony Guild</option>
                <option value="Northern Union">Northern Union</option>
                <option value="CYO">CYO</option>
                <option value="St Theresa Guild">St Theresa Guild</option>
                <option value="KLBS">KLBS</option>
                <option value="Knight and Ladies of St John">Knight and Ladies of St John</option>
            </select>
        </div>
        <div class="forms">
            <label for="nlb_number">NLB Number:</label>
            <input type="text" id="nlb_number" name="nlb_number">
        </div>
        <div class="forms">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
        </div>
    
        <div class="forms">
            <button type="submit">Register</button>
        </div>
    </form>
</div>
</div>
       <!-- Include libraries -->
       <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // Initialize Flatpickr for date of birth
        flatpickr("#dob", {
            dateFormat: "Y-m-d",
        });

        // Function to fetch countries and populate the select element
        function populateCountries() {
            fetch('https://restcountries.com/v3.1/all')
                .then(response => response.json())
                .then(data => {
                    const nationalitySelect = document.getElementById('nationality');

                    // Remove Ghana if already exists to avoid duplication
                    const existingGhana = nationalitySelect.querySelector('option[value="Ghana"]');
                    if (existingGhana) {
                        nationalitySelect.removeChild(existingGhana);
                    }

                    // Append Ghana at the top
                    const ghanaOption = document.createElement('option');
                    ghanaOption.value = 'Ghana';
                    ghanaOption.textContent = 'Ghana';
                    nationalitySelect.appendChild(ghanaOption);

                    // Sort and append other countries
                    data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                    data.forEach(country => {
                        if (country.name.common !== 'Ghana') {
                            const option = document.createElement('option');
                            option.value = country.name.common;
                            option.textContent = country.name.common;
                            nationalitySelect.appendChild(option);
                        }
                    });

                    // Initialize Choices.js for the select element after adding options
                    new Choices(nationalitySelect, { searchEnabled: true, itemSelectText: '' });
                })
                .catch(error => console.error('Error fetching countries:', error));
        }

        // Call the function to populate countries
        populateCountries();

        // Initialize Choice.js for society
        new Choices('#society', {
            removeItemButton: true,
            delimiter: ',',
            editItems: true,
        });

        // Initialize Choice.js for natal day
        new Choices('#natal_day', {
            searchEnabled: false,
            itemSelectText: '',
        });

        new Choices('#marital_status', {
            searchEnabled: false,
            itemSelectText: '',
        });

        new Choices('#gender', {
            searchEnabled: false,
            itemSelectText: '',
        });
        new Choices('#level_of_education', {
            searchEnabled: false,
            itemSelectText: '',
        });
        
        new Choices('#profession', {
            searchEnabled: false,
            itemSelectText: '',
        });
        new Choices('#confirmation', {
            searchEnabled: false,
            itemSelectText: '',
        });
        new Choices('#baptized', {
            searchEnabled: false,
            itemSelectText: '',
        });
    </script>
</body>

</html>
