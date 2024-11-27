<style>
    .holder {
        width: 98%;
        margin: 20px auto;
        height: fit-content;
    }

    .password-cell {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .password-input {
        flex: 1;
        margin-right: 5px;
    }

    .toggle-password.active {
        color: #007bff;
        /* Highlight color when active */
    }

    .edit-password:hover,
    .toggle-password:hover {
        color: #007bff;
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
    .main-datatable .dataTable th:first-child,
    .main-datatable .dataTable td:first-child {
        width: 10% !;

    }

    .main-datatable .dataTable th:first-of-type,
    .main-datatable .dataTable td:first-of-type {
        text-align: center;
        border: 2px solid #ddd !important;
        text-justify: center;
        padding: 10px 0;

    }

    .main-datatable .dataTable tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    .main-datatable .dataTable tr:nth-child(even) {
        background-color: whitesmoke;
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
    .main-datatable .dataTable thead th {
        background-color: white !important;

        color: #333 !important;
        border-bottom: 2px solid #ddd !important;
        font-weight: bold !important;
        text-align: left !important;
        padding: 20px 15px !important;
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

    @media (max-width: 800px) {
        .holder {
            width: 80%;
        }
    }
</style>
<x-layout>
    <div class="holder">
        <div id="loaderHolder" style="display: none" class="loading">
            <p class="loader"></p>
        </div>
        <div class="main-content">
            <h1>Settings <span class="rotate"><i class="icon ph-bold ph-gear"></i></span></h1>
            <div class="tabs">
                <a class="tab-btn activebtn" onclick="showContent('clients')">General Settings</a>
                <a class="tab-btn" onclick="showContent('products')">Locations</a>
                <a class="tab-btn" onclick="showContent('Deliverymen')">Deliverymen</a>
            </div>
            <div class="content show" id="clients-content">
                @include('admin.settings')
            </div>
            <div class="content" id="products-content">
                @include('admin.locations')
            </div>
            <div class="content" id="Deliverymen-content">
                @include('admin.Deliverymenlist')
            </div>
        </div>
    </div>
</x-layout>
<script>
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
<script src="{{asset('/assets/js/settings.js')}}"></script>
