<link rel="stylesheet" href="{{ asset('assets/css/parcels.css') }}">
<style>
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

    #reject {
        background-color: rgb(241, 85, 85);
        border: 1px solid rgb(241, 85, 85);

    }

    #accept {
        background-color: rgb(39, 166, 75);
        border: 1px solid rgb(39, 166, 75);

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

    #reject span:after {
        font-family: FontAwesome;
        content: "\f05e";
    }

    #accept span:after {
        font-family: FontAwesome;
        content: "\f0c7";
    }

    #statics canvas {
        width: 90%;
        height: 90%;
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

    .form-control.is-invalid {
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
        <div class="modal fade" id="largeModal" tabindex="-1" aria-labelledby="largeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg wd">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="largeModalLabel">Details Table</h5>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-times"></i></button>

                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="height: 60vh; overflow-y: auto;">
                            <table class="table table-striped table-hover" id="modalTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Code d'envoi</th>
                                        <th>Nom du magasin</th>
                                        <th>Destinataire</th>
                                        <th>Date d'expédition</th>
                                        <th>Téléphone</th>
                                        <th>État</th>
                                        <th>Status</th>
                                        <th>Ville</th>
                                        <th>Prix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table rows will go here -->
                                </tbody>
                            </table>
                        </div>



                        </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="reshipp"
                            style="color: white;background-color:orange; cursor: pointer;"
                            class="btn btn-primary">Reset</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="loaderHolder" style="display: none" class="loading">
            <p class="loader"></p>
        </div>

        <div class="row mb-4 p-3"
            style="border-top:4px solid greenyellow ;border-bottom:4px solid purple ;border-radius: 2px ; width:95%; margin:auto; background-color: #fff;">
            <div class="col-md-3">
                <input type="text" class="form-control" id="code-filter" placeholder="Region">
            </div>

            <div class="col-md-3">
                <select class="form-control" id="state-filter">
                    <option value="">Etat</option>
                    <option value="payé">Payé</option>
                    <option value="Non payé">Non payé</option>

                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="status-filter">
                    <option value=''>STATUS</option>
                    <option {{ auth()->user()->type !== 'admin' ? 'selected' : '' }} value="en cours de livraison">En
                        cours</option>
                    <option value="Livré">Livré</option>
                    <option value="Reporté">Reporté</option>
                    <option value="Refusé">Refusé</option>
                    <option value="Annulé">Annulé</option>
                    <option value="En voyage">En voyage</option>
                    <option value="Pas de reponse">Pas de reponse</option>
                    <option value="Injoignable">Injoignable</option>
                    <option value="Numéro Incorrect">Numéro Incorrect</option>
                    <option value="Hors Zone">Hors Zone</option>
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
            <div class="col-md-3 mt-1">
                <input type="text" class="form-control" id="magasin-filter" placeholder="Nom de Magasin" />
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
                            <div class="stat-item">
                                <h5 style="color: rgb(9, 81, 75);"><i class="fas fa-box-open"></i> Returned Parcels
                                </h5>
                                <p id="returned" style="color: red;font-weight: bold;">0 Parcel</p>
                            </div>
                            <div class="stat-item">
                                <h5 style="color: rgb(245, 201, 80);"><i class="fas fa-ban"></i> Refused Parcels
                                </h5>
                                <p id="refused" style="color: red;font-weight: bold;">0 Parcel</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div id="table-cntr"
            style="border-top:4px solid orange ;border-radius: 2px ; box-shadow: 0px 3px 3px rgb(175, 175, 175) ; background-color: white; padding: 5px; width: 95%; margin: auto;">
            <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel"
                aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="actionModalLabel">Parcel Action</h5>
                            <button type="button" class="btn-close btn btn-info" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="modalContent">
                            <!-- Content injected here based on action type -->
                        </div>

                    </div>
                </div>
            </div>
            <div class="main-datatable table-responsive p-4">
                @if (auth()->user()->type == 'admin')
                    <div class="d-flex justify-content-between my-1 mx-auto">
                        <button class="btn btn-success" id="shippment"
                            style="display:flex;justify-content: space-around; align-items:center;">
                            <input type="checkbox" class="form-control p-2 w-25" id="delivered-today-filter"
                                value=""> Delivered today
                        </button>
                        <input type="date" class="form-control w-25" id="delDate-filter"
                            placeholder="Nom de Magasin" />
                        <button type="button" class="btn" id="modalbtn"
                            style="color: white;background-color: rgb(199, 158, 8); cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#largeModal">
                            Parcels needs attention
                        </button>
                        <a href="{{ route('admin.addParcel', request()->id) }}" class="btn"
                            style="color: white;background-color: orange; cursor: pointer;">Add Parcels</a>
                        <button class="mx-3" id="return" style="display: none;">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                @endif
                <table id="example" class="table table-bordered table-hover cust-datatable dataTable">
                    <thead>
                        <tr>
                            <th id="checks"><input type="checkbox" id="select-all"></th>
                            <th>code d&apos;envoi</th>
                            <th>Nom du magasin</th>
                            <th>Destinataire</th>
                            <th>Date d&apos;expedition</th>
                            <th>Telephone</th>
                            <th>Etat</th>
                            <th>Status</th>
                            <th>Ville</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 mx-auto"
            style="border-top:4px solid orange ;border-bottom:4px solid #333232 ;border-radius: 2px ; width:95%; margin:auto;">
            <div class="card w-100">
                <div id="statistics" class="card-body">
                    <div class="row justify-content-around">
                        <div class="col-md-5 col-12 mb-3 mb-md-0">
                            <canvas id="barChart"></canvas>
                        </div>
                        <div class="col-md-5 col-12 mb-3 mb-md-0">
                            <canvas id="lineChart"></canvas>

                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-md-4 col-12 mb-3 mb-md-0">
                            <canvas id="pieChart"></canvas>
                        </div>
                        <div class="col-md-7 col-12 mb-3 mb-md-0">
                            <canvas id="doughnutChart"></canvas>

                        </div>
                    </div>
                </div>
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
<script src="{{ asset('assets/js/deliverymen_parcels.js') }}"></script>

<script>
    function showModal(action, parcel) {
        $('#actionModal').modal('show'); // Show the modal
        let modalContent = '';
        console.log("ih");

        if (action === 'details') {
            modalContent = `<p>Details for Parcel ID: ${parcel.id}</p>
                            <p>Code: ${parcel.code}</p>
                            <p>Magasin: ${parcel.company_name}</p>
                            <p>Status: ${parcel.status}</p>
                            <p>Details Client: ${parcel.client_name}</p>
                           <p>Telephone : <a href="tel:${parcel.phone }">${parcel.phone }</a></p>
                        <p><i class="fab fa-whatsapp"></i> Whatsapp <a
    href="https://api.whatsapp.com/send?phone=212${parcel.phone.replace(/\D/g, '')}"
    target="_blank"
>
    ${parcel.phone}
</a>
</p>
                            <p>Details Status: ${parcel.status}</p>
            `;
        } else if (action === 'modifyStatus') {
            modalContent = `
            <p>Details for Parcel ID: ${parcel.id}</p>
                            <p>Details Client: ${parcel.client_name}</p>
                                                <p>Details Client Phone: ${parcel.phone}</p>        <p>Details Client Phone: ${parcel.phone}</p>
                            <p>Details Status: ${parcel.status}</p>
      <form id="statusForm" action='' method='post'>
        @csrf
        @method('put')
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select id="status" name="status" class="form-control" required onchange="handleStatusChange()">
          <option value="">Select Status</option>
          <option value="Livré">Livré</option>
            <option value="Reporté">Reporté</option>
            <option value="Refusé">Refusé</option>
            <option value="Annulé">Annulé</option>
            <option value="En voyage">En voyage</option>
            <option value="Pas de reponse">Pas de reponse</option>
            <option value="Injoignable">Injoignable</option>
    <option value="Numéro Incorrect">Numéro Incorrect</option>
    <option value="Hors Zone">Hors Zone</option>
          </select>
        </div>
        <div id="commentField" class="mb-3" style="display: none;">
          <label for="comment" class="form-label">Comment</label>
        <textarea type="text" value='' id="comment" name="comment" class="form-control" ></textarea>

        <div id="cmt-error" class="invalid-feedback"></div>

        </div>
        <div id="dateField" class="mb-3" style="display: none;">
          <label for="date" class="form-label">Date</label>
          <input type="date" id="date" name="date" class="form-control" >
        </div>
                                               <button type="button" onclick='save(${parcel.id})' class="btn btn-primary">Save</button>


      </form>
    `;

        } else {
            modalContent =
                `<p>Sorry you are unabled from making changes on: <strong style='color:red;'>${parcel.code}</strong></p>`;
        }

        $('#modalContent').html(modalContent);
    }

    function handleStatusChange() {
        const status = document.getElementById('status').value;
        const commentField = document.getElementById('commentField');
        const dateField = document.getElementById('dateField');

        // Show/hide comment and date fields based on selected status
        if (status === 'Reporté' || status === 'Annulé' || status === 'Refusé' || status === 'Hors zone') {
            commentField.style.display = 'block';
            commentField.querySelector('textarea').required = true;
        } else {
            commentField.style.display = 'none';
            commentField.querySelector('textarea').required = false;
        }

        if (status === 'Reporté') {
            dateField.style.display = 'block';
            dateField.querySelector('input').required = true;
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);

            // Format the date to YYYY-MM-DD
            const year = tomorrow.getFullYear();
            const month = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const day = String(tomorrow.getDate()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;
            dateField.querySelector('input').value = formattedDate;
        } else {
            dateField.style.display = 'none';
            dateField.querySelector('input').required = false;
        }
    }

    function save(e) {
        const status = document.getElementById('status').value;
        const commentField = document.getElementById('commentField').querySelector('textarea').value;
        const dateField = document.getElementById('dateField').querySelector('input').value;
        console.log("/Parcels/update/" + e);
        if (!status) {
            $('#status').addClass('is-invalid');
            return
        }
        if (status === 'Annulé' || status === 'Refusé' || status === 'Hors zone') {
            if ($("textarea#comment").val() == "") {
                $('textarea#comment').addClass('is-invalid');
                $('#cmt-error').text('Please enter comment.');
                return
            }
        }
        $.ajax({

            url: `/Parcels/update/${e}`, // Replace with your API endpoint
            method: 'put',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token for security
            },
            data: {
                status,
                comment: commentField || "",
                date: dateField || ""
            },
            beforeSend: function() {
                $('#loaderHolder').show(); // Show loader before the request
            },
            complete: function() {
                $('#loaderHolder').hide(); // Hide loader after the request
            },
            success: function(response) {
                // Reset form
                $("#statusForm")[0].reset();
                $('#actionModal').modal('hide')
                // Reload table data
                table.ajax.reload();
                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.classList.add('toast');

                toast.innerHTML = ` 
                <span class="icon" style='color:green;'><i class="fas fa-exclamation-circle"></i></span>
                <div class="message">
                    <strong style='color:green;'>Updated !</strong><br>
                    the updating operation completed successfuly
                </div>
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>`;

                // Append Toast to Container
                toastContainer.appendChild(toast);

                // Remove Toast After 3.5 Seconds
                setTimeout(() => {
                    toast.remove();
                }, 5500); // Automatically remove toast after 5.5 seconds

            },
            error: function(error) {
                console.error('Error updating data:', error);

                // Display error notification as a toast
                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.classList.add('toast');
                toast.style.cssText = `
            position: fixed; 
            top: 10px; 
            right: 10px; 
            background-color: #ffe0e0; 
            border-left: 5px solid red; 
            padding: 10px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif; 
            border-radius: 5px; 
            animation: fadeIn 0.5s, fadeOut 0.5s 5s forwards;
        `;

                toast.innerHTML = `
            <span style="font-size: 20px; color: red; margin-right: 10px;">
                <i class="fas fa-times-circle"></i>
            </span>
            <strong style="color: red;">Error!</strong>
            <br>
            Failed to update data. Please try again.
            <button class="close-btn" style="float: right; background: none; border: none; color: #000; font-size: 18px; cursor: pointer;" 
                onclick="this.parentElement.remove()">×</button>
        `;

                // Append toast to the container
                toastContainer.appendChild(toast);

                // Automatically remove toast after 5.5 seconds
                setTimeout(() => {
                    toast.remove();
                }, 5500);
            }
        });

        // $("#statusForm").submit()
    }
</script>
