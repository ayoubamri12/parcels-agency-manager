<style>
    .holder {
        width: 98%;
        margin: 20px auto;
        font-family: Arial, sans-serif;
        height: fit-content;
    }

    .top-bar {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin-bottom: 20px;
        position: relative;
    }


    /* Main Content */
    .main-content {
        background-color: white;
        height: fit-content;
        border-bottom: 2px solid gainsboro;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #343a40;
    }

    /* Tabs */
    .tabs {
        display: flex;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .tab-btn {
        width: 200px;
        text-align: center;
        padding: 10px 0;
        font-size: 16px;
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        color: #6c757d;
        transition: color 0.3s, border-bottom 0.3s;
    }

    .dataTables_wrapper .dataTable tbody .dataTables_empty {
        width: 70%;
        margin: auto;
        text-align: center;
        color: #ff0000;
        /* Red text */
        font-weight: bold;
        padding: 15px;
        background-color: #f2f2f2;
        border-left: 4px solid #ff0000;
    }




    h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .filters {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .delete-btn {
        padding: 20px;
        display: none;
        background-color: #faf7f7;
        color: rgb(193, 192, 192);
        font-size: 22px;
        cursor: pointer;
        border-radius: 5px;
        border: 2px solid rgb(180, 179, 179);
    }

    /* Style for the main table */
    .main-datatable .dataTable th:first-child,.main-datatable .dataTable td:first-child{
        width: 10%!;

    }
    .main-datatable .dataTable thfirst-of-type,.main-datatable .dataTable td:first-of-type{
        text-align: center;
        border: 2px solid #ddd !important;
        text-justify: center;
        padding: 10px 0;

    }
    .main-datatable .dataTable th:not(:first-of-type),
    .main-datatable .dataTable td:not(:first-of-type) {
        border: 2px solid #ddd !important;
        /* Light gray border */
        /* Rounded corners */
        text-align: center;
        text-justify: center;
        font-weight: bold;
        /* White background */
        width: 25%;
        padding: 10px 0;
    }

    /* Pagination Buttons */
    /* .main-datatable .dataTable .paginate_button {
        background-color: white !important;
        border: 1px solid #ff8800 !important;
        border-radius: 5px !important;
        color: #ff8800 !important;
        padding: 5px 10px !important;
        margin: 2px !important;
        font-weight: bold !important;
        cursor: pointer !important;
    } */
    .main-datatable .dataTables_wrapper .dataTables_paginate {
        margin: 10px auto !important;
    }

    .main-datatable .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0 !important;
        border: 1px solid #f2f2f2 !important;
    }

    .main-datatable .dataTables_wrapper .dataTables_paginate .paginate_button.current {

        background-color: #ff8800 !important;
        color: white !important;
    }

    .main-datatable .dataTables_wrapper .dataTable tbody td.alignement {
        text-align: center !important;
    }

    /* .main-datatable .dataTable .paginate_button:hover {
        background-color: #ff8800 !important;
        color: white !important;
    } */

    /* Search Box */
    .main-datatable .dataTables_wrapper div.dataTables_filter {
        padding: 15px 10px !important;

    }

    .main-datatable .dataTables_wrapper div.dataTables_filter {
        width: 60% !important;
    }

    .main-datatable .dataTables_wrapper div.dataTables_filter input {
        border: 1px solid #ddd !important;
        padding: 5px 10px !important;
        width: 200px !important;
        font-size: 14px !important;
    }

    /* Table Header Styling */
    .main-datatable .dataTables_wrapper .dataTable thead th {
        background-color: #f2f2f2 !important;
        color: #333 !important;
        border-bottom: 2px solid #ddd !important;
        font-weight: bold !important;
        text-align: left !important;
        padding: 10px 15px !important;
    }

    .actions button {
        border: none;
        cursor: pointer;
        font-size: 18px;
    }

    .tab-btn:hover,
    .tab-btn.activebtn {
        color: orange;
        border-bottom: 2px solid orange;
    }

    /* Content Section */
    .content {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .content.show {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    span.rotate {
        animation: rt 0.9s infinite;
        color: orange;
    }

    @keyframes rt {
        from {
            transform: rotateX(0deg);
        }

        to {
            transform: rotateX(180deg);
        }
    }

    .selection-container {
        text-align: center;
        padding: 20px;
        width: 100%;
        max-width: 600px;
        margin: auto;
    }

    /* Modern Dropdown Styles */
    .custom-select {
        width: 100%;
        padding: 20px 20px;
        font-size: 1em;
        border-radius: 25px;
        border: 2px solid #007bff;
        color: orange;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-select:hover {
        background: #d1d1d1;
    }

    .fade-in-bounce {
        animation: fadeInBounce 0.6s ease-in-out;
    }

    @keyframes fadeInBounce {
        0% {
            opacity: 0;
            transform: scale(0.9);
        }

        60% {
            opacity: 1;
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .mt-5 {
            margin-top: 2rem !important;
        }

        .selection-container {
            padding: 15px;
        }

        .form-container {
            padding: 15px;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
        }
    }

    /* Style for the dropdown container */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Style for the dropdown content */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        width: 600px;
        height: 300px;
        overflow-y: scroll;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        padding: 12px 21px;
        z-index: 1;
    }

    /* Display dropdown content when active */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Checkbox list styling */
    .checkbox-list label {
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 5px;
    }

    @media (max-width: 768px) {
        .holder {
            width: 95%;
        }
    }
</style>
<x-layout>
    <div id="loaderHolder" style="display: none" class="loading">
        <p class="loader"></p>
    </div>
    <div class="holder">
        <div class="main-content">
            <h1>Settings <span class="rotate"><i class="icon ph-bold ph-gear"></i></span></h1>
            <div class="tabs">
                <a class="tab-btn activebtn" onclick="showContent('clients')">General Settings</a>
                <a class="tab-btn" onclick="showContent('products')">Locations</a>
            </div>
            <div class="content show" id="clients-content">
                @include('admin.settings')
            </div>
            <div class="content" id="products-content">
                @include('admin.locations')
            </div>
        </div>
    </div>
</x-layout>
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function showContent(type) {
        const allContents = document.querySelectorAll('.content');
        const allTabs = document.querySelectorAll('.tab-btn');

        // Hide all content sections
        allContents.forEach(content => content.classList.remove('show'));

        // Remove activebtn state from all tabs
        allTabs.forEach(tab => tab.classList.remove('activebtn'));

        // Show selected content
        const selectedContent = document.getElementById(`${type}-content`);
        selectedContent.classList.add('show');

        // Add activebtn state to the selected tab
        const selectedTab = document.querySelector(`.tab-btn[onclick="showContent('${type}')"]`);
        if (selectedTab) {
            selectedTab.classList.add('activebtn');
        }
    }
</script>
<!-- JavaScript for toggling forms and adding animation -->
<script>
    $(document).ready(function() {
        // Form submission event
        $('#deliverymanForm').on('submit', function(e) {
            // Prevent form submission for validation
            e.preventDefault();

            // Clear any previous error messages
            $('.error').remove();

            // Validation flags
            let isValid = true;

            // Validate Name (text field)
            let name = $('input[name="name"]').val();
            if (name.trim() === '') {
                isValid = false;
                $('input[name="name"]').after(
                    '<div class="error" style="color: red;">Name is required.</div>');
            }

            // Validate Password (text field)
            let password = $('input[name="password"]').val();
            if (password.trim() === '') {
                isValid = false;
                $('input[name="password"]').after(
                    '<div class="error" style="color: red;">Password is required.</div>');
            }

            // Validate Company Checkboxes (at least one company must be selected)
            let selectedCompanies = $('input[name="cps[]"]:checked').length;
            if (selectedCompanies === 0) {
                isValid = false;
                $('.checkbox-list').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one company.</div>'
                );
            }

            // Validate City Checkboxes (at least one city must be selected)
            let selectedCities = $('input[name="city[]"]:checked').length;
            if (selectedCities === 0) {
                isValid = false;
                $('.checkbox-list').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one city.</div>');
            }

            // If form is valid, submit the form
            if (isValid) {
                // Submit the form if everything is valid
                this.submit();
            }
        });
    });

    const checkboxes = document.querySelectorAll('#first input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('click', () => {
            if (checkbox.checked) {
                console.log($(checkbox).next("input[type=number]"));

                $(checkbox).parent("div").next("div").children("input[type=number]").removeAttr(
                    "disabled");
                return
            }
            $(checkbox).parent("div").next("div").children("input[type=number]").attr("disabled", true);

        });
    });

    function showForm() {
        const entityType = document.getElementById("entityType").value;
        const formContainer = document.getElementById("formContainer");
        const deliverymanForm = document.getElementById("deliverymanForm");
        const companyForm = document.getElementById("companyForm");
        const LocationForm = document.getElementById("LocationForm");
        const magasinForm = document.getElementById("magasinForm");

        // Hide both forms initially
        deliverymanForm.classList.add("d-none");
        companyForm.classList.add("d-none");
        LocationForm.classList.add("d-none");
        magasinForm.classList.add("d-none");

        // Show appropriate form based on selection
        if (entityType === "deliveryman") {
            deliverymanForm.classList.remove("d-none");
        } else if (entityType === "company") {
            companyForm.classList.remove("d-none");
        } else if (entityType === "magasin") {
            magasinForm.classList.remove("d-none");

        } else {
            LocationForm.classList.remove("d-none");

        }

        // Display the form container with animation
        if (entityType) {
            formContainer.classList.remove("d-none");
            formContainer.classList.add("fade-in-bounce");
        } else {
            formContainer.classList.add("d-none");
        }
    }
</script>
<script>
    var table = $('#table').DataTable({
        responsive: true,
        searching: true,
        "columnDefs": [
            { "orderable": false, "targets": 0 } ,// Disable sorting on the first column (index 0)
            { "orderable": false, "targets": 5 } ,// Disable sorting on the first column (index 0)
        ],
        ajax: {
            url: "/api/cities",
            type: "GET",
            dataSrc: "",
            beforeSend: function() {
                $('#loaderHolder').show();
            },
            complete: function() {
                $('#loaderHolder').hide();
            },
        },
       
        columns: [{
                data: null,
                render: (data) => `<input type="checkbox" value="${data.id}" class="row-checkbox">`
            },
            {
                data: 'id',
                className: "alignement"
            },
            {
                data: 'city'
            },
            {
                data: 'reg_local'
            },
            {
                data: "deliveryman_cities",
                render: (data, type, row) => {
                    return `${
                        row.deliveriyman_cities.length
                    }`

                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    let parcel = JSON.stringify(
                        row
                        ); // You might not need this line, unless you're doing something with the parcel data

                    return `
            <div class="btn-group">
                <div class="dropdown">
                    <button class="btn  action-btn" type="button" data-toggle="dropdown" id="dropdownMenuButton${row.id}">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                        <li><a class="dropdown-item action-btn" href="#" id='det${row.id}'><i class="fas fa-info-circle"></i> Details</a></li>
                        <li><a class="dropdown-item action-btn" href="#" id='status${row.id}'><i class="fas fa-edit"></i> Modify Status</a></li>
                        <li><a class="dropdown-item action-btn" href="#" id='state${row.id}'><i class="fas fa-edit"></i> Modify State</a></li>
                        <li><a class="dropdown-item action-btn" href="/parcels/delete/${row.id}"><i class="fas fa-trash-alt"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        `;
                }
            }
        ],
        paging: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, -1],
        pagingType: 'simple_numbers',
        initComplete: function() {
            $(".dataTables_filter input").addClass("form-control");
            this.api().columns().every(function () {
            var column = this;
            $('td', column.header()).each(function () {
                $(this).append('<span class="sort-icon"></span>');
            });
        });
        },
        drawCallback: function() {
            // Handle checkbox display
            $('.row-checkbox').on('change', function() {
                $('#delete-btn').toggle($('.row-checkbox:checked').length > 0);
            });
        },
    });

    // Select-all functionality
    $('#select-all').on('change', function() {
        $('.row-checkbox').prop('checked', this.checked);
        $('#delete-btn').toggle(this.checked);
    });
</script>
