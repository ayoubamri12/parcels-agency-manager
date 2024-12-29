<link rel="stylesheet" href="{{ asset('assets/css/parcels.css') }}">
<style>
     .dt-buttons .buttons-excel {
        background-color: rgb(138, 239, 50) !important;
        /* Blue for Excel */
        border-radius: 50px !important;
        color: #fff !important;
        padding:10px;
    }
    .wrapper-info .card {
        width: 100%;
        height: 90px;
        background-color: #fff;
        padding: 10px 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        border-left: 5px solid #3286e9;
        border-radius: 3px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .wrapper-info .card .subject p {
        color: #909092;
    }

    .wrapper-info .card .icon {
        font-size: 25px;
        color: #3286e9;
    }

    .wrapper-info .card .icon-times {
        font-size: 28px;
        color: #c3c2c7;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .smScreen {
            display: none;
        }

        p#listbtn {
            display: block;
            border-radius: 50%;
        }

        .text-info {
            font-size: 15px;

        }
    }

    /* Input Styling */
    .form-control.rounded-input {
        border-radius: 50px;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        width: 100%;
        background-color: white;
        border: 1px solid white;
        border-radius: 14px;
        padding: 4px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 15px 0 rgba(0, 0, 0, 0.1);
        place-items: center;
    }


    .button {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.09), 0 6px 15px 0 rgba(0, 0, 0, 0.09);
        padding: 10px 17px 10px 17px;
        font: 15px Ubuntu;
        color: white;
        border-radius: 7px;
    }

    .button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .button span:after {
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    .button:hover span {
        padding-right: 25px;
    }

    .button:hover span:after {
        opacity: 1;
        right: 0;
    }



    .table-responsive {
        overflow-x: visible;
    }

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 10000;

    }

    /* Toast Styling */
    .toast {
        display: flex;
        align-items: center;
        background: rgba(242, 220, 76, 0.9);
        /* Foggy Color */
        color: #fff;
        padding: 15px 20px;
        border-radius: 8px;
        width: 350px;
        box-shadow: 0 4px 15px rgba(209, 160, 62, 0.8);
        opacity: 0;
        transform: translateX(100%);
        animation: slideIn 0.5s forwards, fadeOut 0.5s 3.5s forwards;
        position: relative;
    }

    /* Slide In and Fade Out Animations */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    /* Timer Bar */
    .toast::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: green;
        /* Yellow color for timer */
        animation: timer 3.5s linear forwards;
    }

    @keyframes timer {
        from {
            width: 100%;
        }

        to {
            width: 0;
        }
    }

    /* Icon Styling */
    .toast .icon {
        font-size: 1.5rem;
        margin-right: 15px;
    }

    /* Close Button Styling */
    .toast .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
    }

    /* Message Styling */
    .toast .message {
        flex: 1;
        font-size: 1rem;
        line-height: 1.4;
    }

    @media (max-width: 768px) {

        .table-responsive {
            overflow-x: scroll;
        }

        /* Increase canvas size for charts */
        .chart-canvas {
            width: 100% !important;
            height: auto;
            /* Allows height to adjust naturally */
        }

        #table-cntr {
            width: 100vw !important;
        }

        .statistics-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-content: center;
        }

        .statistics-container .stat-item {
            width: 90%;
        }

        table {
            width: 150%;
            /* Adjust width as needed to show half */
        }
    }

    .form-control.is-invalid,.popup-input.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .wd {

        width: 90% !important;
    }
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Divider */
    .divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #ccc;
    }

    .divider span {
        margin: 0 10px;
        font-size: 1rem;
        color: #555;
        text-transform: uppercase;
        font-weight: 600;
    }

    /* Style for the dropdown content */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        width: 200px;
        height: 250px;
        overflow-y: scroll;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        padding: 12px 21px;
        z-index: 1;
    }

    /* Display dropdown content when active */
    .show {
        display: block;
    }

    /* Checkbox list styling */
    .checkbox-list label {
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 5px;
    }

    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 100000;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .popup-overlay.active {
        display: flex;
        opacity: 1;
    }

    /* Popup */
    .popup-box {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .popup-header {
        margin: 0;
        margin-bottom: 20px;
        font-size: 1.5rem;
        color: #333;
    }

    .popup-input {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 25px;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s ease;
    }

    .popup-input:focus {
        border-color: greenyellow;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .popup-btn {
        padding: 10px 20px;
        border: none;
        background-color: greenyellow;
        color: #fff;
        border-radius: 25px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .popup-btn:hover {
        background-color: rgb(134, 216, 11);
    }

    .popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
    }

    .popup-close:hover {
        color: greenyellow;
    }

    @media screen and (max-width: 800px) {
        .popup-box {
            width: 90%;
            /* Take up 90% of the screen */
            padding: 15px;
            /* Reduce padding for smaller screens */
        }

        .popup-header {
            font-size: 1.3rem;
            /* Slightly smaller font size */
            margin-bottom: 15px;
        }

        .popup-input {
            z-index:10000;
            padding: 8px 12px;
            /* Smaller input padding */
            font-size: 0.9rem;
        }

        .popup-btn {
            padding: 8px 15px;
            /* Smaller button padding */
            font-size: 0.9rem;
        }

        .popup-close {
            font-size: 1rem;
            /* Adjust close button size */
            top: 5px;
            right: 5px;
        }

        .divider span {
            font-size: 0.8rem;
        }
    }
</style>
<x-layout>
    <div id="cntr" class="mx-auto mt-5 pb-3" style="width: 100%;">
        <nav aria-label="breadcrumb w-100">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('deliverymen') }}"><i class="icon fa-solid fa-person"></i>
                        Deliverymen</a></li>
                <li class="breadcrumb-item active" aria-bs-current="page"><a href=""><i
                            class="icon fa-solid fa-box"></i> Parcels</a></li>
            </ol>
        </nav>

        <div class="toast-container" id="toastContainer"></div>
        @if (session('updated'))
            <script>
                // Function to Show Toast Notification

                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.classList.add('toast');

                toast.innerHTML = `
                <span class="icon" style='color:green;'><i class="fas fa-exclamation-circle"></i></span>
                <div class="message">
                    <strong style='color:green;'>Updated !</strong><br>
                    the updating operation completed successfuly
                </div>
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>
            `;

                // Append Toast to Container
                toastContainer.appendChild(toast);

                // Remove Toast After 3.5 Seconds
                setTimeout(() => {
                    toast.remove();
                }, 5500);
            </script>
        @endif


        <div id="loaderHolder" style="display: none" class="loading">
            <p class="loader"></p>
        </div>
         <div class="popup-overlay" id="popup">
                    <div class="popup-box">
                        <button class="popup-close" id="closePopupBtn">&times;</button>
                        <h2 class="popup-header">Commission</h2>
                        <input type="text" id="name" class="popup-input" placeholder="Put a name"
                            name='name' value="" />
                        <input type="hidden" id="city" name='city[]'
                            value="{{ $deliverymen->deliveriyman_cities[0]->city_id }}" />
                        <input type="text" id="commissionV" name='commission' class="popup-input"
                            placeholder="Commission %" />
                        <input type="text" id="commissionlv" name='commissionlv' class="popup-input"
                            placeholder="Commission livreur %" />
                        <button type="button" id="commission" class="popup-btn">SAVE</button>
                    </div>
                </div>
<!-- Modal -->
                    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="dataModalLabel">Add Data</h5>
                                    <button type="button" id='close' class="btn btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <form id="addDataForm">

                                            <div class="mb-2">
                                                <div class="dropdown mb-2">
                                                    <button type="button" class="btn btn-light px-4 border">Delivering Company</button>
                                                    <div class="dropdown-content">
                                                        <div id="first" class=".checkbox-list checkbox-list1">
                                                            @foreach ($companies as $c)
                                                                <label>
                        
                                                                    <div class="col-12">
                                                                        <input type="radio" name="cps"
                                                                            value="{{ $c->id }}">{{ $c->name }}
                                                                    </div>
                        
                        
                                                                </label>
                                                            @endforeach
                                                            <div class="divider">
                                                                <span>Other</span>
                                                            </div>
                                                            @foreach ($other as $o)
                                                                @php
                                                                    // Get an array of delivery IDs from the related deliveryman_cities
                                                                    $deliveryIds = $o->deliveriyman_cities->pluck('delivery_id')->toArray();
                                                                @endphp
                        
                                                                @if (!in_array(request()->id, $deliveryIds))
                                                                    <label>
                        
                                                                        <div class="col-12">
                                                                            <input type="radio" name="cps" id="{{ $o->id }}" class="open"
                                                                                value="">{{ $o->name }}
                                                                        </div>
                        
                        
                                                                    </label>
                                                                @endif
                                                            @endforeach
                                                            <label>
                                                                <div class="col-12">
                                                                    <input type="radio" id="openPopupBtn" name="cps" value=""> Other
                                                                </div>
                        
                                                            </label>
                        
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Error message for company selection -->
                                                
                                            </div>
                                            {{-- <label for="nomMagasin" class="form-label">Nom du magasin</label> --}}
                                            {{-- <select id="nomMagasin" class="form-control rounded-input" id="company-filter">
                                                <option value="">Magasin</option>
                                                @foreach ($companies as $c)
                                                    <option value="{{ $c->id }}">{{ $c->name }} </option>
                                                @endforeach
                                            </select> --}}
                                        <div class="mb-3">
                                            <label for="prix" class="form-label">Prix</label>
                                            <input type="number" class="form-control rounded-input" id="prix"
                                                name="prix" placeholder="Enter Prix">
                                        </div>
                                        <div class="mb-3">
                                            <label for="totaleLivre" class="form-label">Totale Livré</label>
                                            <input type="number" class="form-control rounded-input" id="totaleLivre"
                                                name="totaleLivre" placeholder="Enter Totale Livré">
                                        </div>
                                        <button type="button" class="btn btn-primary" id="saveDataBtn">Save</button>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
        <div class="row mb-4 p-3"
            style="border-top:4px solid greenyellow ;border-bottom:4px solid purple ;border-radius: 2px ; width:95%; margin:auto; background-color: #fff;">


            <div class="col-md-3">
                <select class="form-control" id="state-filter">
                    <option value="">Etat</option>
                    <option value="payé">Payé</option>
                    <option value="Non payé">Non payé</option>

                </select>
            </div>

            <div class="col-md-3">
                <select class="form-control" id="company-filter">
                    <option value="">Entreprise</option>
                    @foreach ($companies as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <div id="reportrange"
                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%"
                    class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>


            <div class="col-md-2 mt-1">
                <button class="btn me-1" style="background-color: orange;" id="filter-btn"><i
                        class="fa-solid fa-filter"></i>Filtrer</button>
                <button class="btn btn-success mt-1 p-2" id="refresh-btn"><i
                        class="fa-solid fa-arrows-rotate"></i></button>
            </div>
        </div>

        <div class="row mb-4 mx-auto"
            style="border-top:4px solid orange ;border-bottom:4px solid #333232 ;border-radius: 2px ; width:95%; margin:auto;">
            <div class="card w-100">
                <div id="statistics" class="card-body">
                    <div class="container-fluid mt-3">
                        <!-- Filters and Main Table as per your current code -->
                        <!-- Statistics Section -->
                        <div class="statistics-container">
                            <div class="stat-item">
                                <h5 style="color: rgb(135, 206, 29);"><i class="fas fa-shipping-fast"></i> Delivered
                                    Quantity</h5>
                                <p id="deliveredQuantity" style="color: red;font-weight: bold;">0</p>
                            </div>
                            <div class="stat-item">
                                <h5 style="color: green;"><i class="fas fa-dollar-sign"></i> Total Revenue</h5>
                                <p id="totalRevenue" style="color: red;font-weight: bold;">$0.00</p>
                            </div>
                            @if (auth()->user()->type == 'admin')
                                <div class="stat-item">
                                    <h5 style="color: purple;"><i class="fas fa-coins"></i> Commision</h5>
                                    <p id="clearRevenue" style="color: red;font-weight: bold;">$0.00</p>
                                </div>
                            @endif
                            <div class="stat-item">
                                <h5 style="color: rgb(241, 97, 241);"><i class="fas fa-coins"></i> Commision Livreur
                                </h5>
                                <p id="clearRevenueDelivery" style="color: red;font-weight: bold;">$0.00</p>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div id="table-cntr"
            style="border-top:4px solid orange ;border-radius: 2px ; box-shadow: 0px 3px 3px rgb(175, 175, 175) ; background-color: white; padding: 5px; width: 95%; margin: auto;">
            <div class="main-datatable table-responsive p-4">
                <div class="d-flex justify-content-between my-1 mx-auto">
                    @if (auth()->user()->type == 'admin')
                        <button class="btn btn-success" id="shippment"
                            style="display:flex;justify-content: space-around; align-items:center;">
                            <input type="checkbox" class="form-control p-2 w-25" id="delivered-today-filter"
                                value=""> Delivered today
                        </button>
                        <input type="date" class="form-control w-25" id="delDate-filter"
                            placeholder="Nom de Magasin" />


                        <button class="mx-3" id="return" style="display: none;">
                            <i class="fas fa-undo"></i>
                        </button>
                    @endif
                    <button type="button" class="btn" id="modalbtn"
                        style="color: white;background-color: rgb(255, 117, 37); cursor: pointer;"
                        data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add payment
                    </button>
                    <!-- Trigger Button -->


                    

                </div>
               
                <table id="example" class="table table-hover cust-datatable dataTable">
                    <thead>
                        <tr>
                            <th id="checks"><input type="checkbox" id="select-all"></th>
                            <th>Livreur</th>
                            <th>Nom du magasin</th>
                            <th>Date d&apos;expedition</th>
                            <th>Etat</th>
                            <th>Status</th>
                            <th>Ville</th>
                            <th>Prix</th>
                            <th>Totale Livré</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layout>
<script>
    window.Laravel = {
        userId: @json(request()->id),
        userType: @json(auth()->user()->type === 'admin')
    };
</script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svg2pdf.js/1.4.1/svg2pdf.min.js"></script>
<script src="{{ asset('assets/js/deliverymen_local_parcels.js') }}"></script>
<script>
      const $popup = $('#popup');
        const $openPopupBtn = $('#openPopupBtn');
        const $closePopupBtn = $('#closePopupBtn');
        const $saveBtn = $('#commission');
        $(".open").on("click", function(e) {
            $('#close').click();

            if (this.checked) {
                  console.log(this.id);
                $('#name').val(this.id).hide();
                $popup.addClass('active');
            }
        });
        // Open popup
        $openPopupBtn.on('click', function() {
            $("#name").val("").show()
            $('#close').click();
            if (this.checked) {
                $popup.addClass('active');
            }
        });
        $saveBtn.on('click', function() {
            console.log("hhhhh")
            let isValid = true;
          
            if ($("#name").val() === '') {
                $('#name').addClass('is-invalid');
                isValid = false;
            }
            if ($("#commissionV").val() === '') {
                $('#commissionV').addClass('is-invalid');

                isValid = false;
            }
            if ($("#commissionlv").val() === '') {
                $('#commissionlv').addClass('is-invalid');

                isValid = false;
            }
            if (!isValid) {
                // Submit the form programmatically
                return;
            }
            $.ajax({
                url: '{{ route('settings.storeCompany', ['other' => true]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: {
                        id: @json(request()->id),
                        name: $("#name").val(),
                        city: [$("#city").val()],
                        commission: $("#commissionV").val(),
                        commissionlv: $("#commissionlv").val(),
                    }
                },
                beforeSend: function() {
                    $('#loaderHolder').show();
                    $popup.removeClass('active');
                },
                complete: function() {
                    $('#loaderHolder').hide();
                },
                success: function(response) {
                       $('#modalbtn').click();
                    // $(`#${$("#name").val()}`).hide();
                    $(".dropdown-content").toggleClass("show");
                    let company = response;
                    console.log(company);
                    $(".open:checked").val(company.id)
                     console.log($(".open:checked").val());
                    $("#openPopupBtn").val(company.id)
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success("Done !");
                },
                error: function(xhr, status, error) {
                    $('#loaderHolder').hide();
                }
            });
        });
        // Close popup
        $closePopupBtn.on('click', function() {
            $("#modalbtn").click()
            // $("input[name=cps]").attr("checked",false)
            $popup.removeClass('active');
        });

        // Close popup when clicking outside of it
        $popup.on('click', function(e) {
                   $('#close').click();
            if ($(e.target).is($popup)) {
                $popup.removeClass('active');
            }
        });
    
</script>

