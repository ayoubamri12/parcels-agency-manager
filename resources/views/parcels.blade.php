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


    @media (max-width: 650px) {
        .text-info {
            font-size: 13px;
        }

        .subject h3 {
            font-size: 15px;

        }
    }

    @media (max-width: 390px) {
        .text-info {
            font-size: 10px;
        }

        .subject h3 {
            font-size: 12px;

        }
    }
</style>
<x-layout>
    <div class="container-fluid mt-3 pb-3">
        <div>
            @if (session()->has('approving'))
                @if (session('approving') === 'approved')
                    <script>
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
                        toastr.info("the parcel is delayed now !!");
                    </script>
                @else
                    <script>
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
                        toastr.warning("the request has been rejected !!");
                    </script>
                @endif
            @endif
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
                        <option value="Facturé">Facturé</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="status-filter">
                        <option value="">Statut</option>
                        <option value="en cours">En cours</option>
                        <option value="livré">Livré</option>
                        <option value="Raporté">Raporté</option>
                        <option value="Annulé">Annulé</option>
                        <option value="Refusé">Refusé</option>
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
                <div class="col-md-3 mt-1">
                    <select class="form-control" id="delivery-filter">
                        <option value="">Livreur</option>
                        @foreach ($delmens as $delmen)
                            <option value="{{ $delmen->id }}">
                                {{ $delmen->name }}</option>
                        @endforeach
                    </select>
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
                                    <h5>Delivered Quantity</h5>
                                    <p id="deliveredQuantity">0</p>
                                </div>
                                <div class="stat-item">
                                    <h5>Total Revenue</h5>
                                    <p id="totalRevenue">$0.00</p>
                                </div>
                                <div class="stat-item">
                                    <h5>Clear Revenue</h5>
                                    <p id="clearRevenue">$0.00</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="main-datatable"
                style="border-top:4px solid orange ;border-radius: 2px ; box-shadow: 0px 3px 3px rgb(175, 175, 175) ; background-color: white; padding: 55px;overflow-x: scroll;">

                <div class="table-responsive">
                    <table id="example" class="table table-bordered cust-datatable dataTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>code d&apos;envoi</th>
                                <th>Date d&apos;expedition</th>
                                <th>Telephone</th>
                                <th>Nom du magasin</th>
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
        </div>
        <div class="row mt-4 mx-auto"
        style="border-top:4px solid orange ;border-bottom:4px solid #333232 ;border-radius: 2px ; width:95%; margin:auto;">
        <div class="card w-100">
            <div id="statistics" class="card-body">
              <div class="row justify-content-around">
                <div class="col-5">
                    <canvas id="barChart" width="400" height="400"></canvas>
                   </div>
                   <div class="col-5">
                    <canvas id="lineChart" width="400" height="400"></canvas>
    
                   </div>
              </div>
               <div class="row justify-content-around">
                <div class="col-4">
                    <canvas id="pieChart" width="400" height="400"></canvas>
                </div>
                <div class="col-7">
                    <canvas id="doughnutChart" width="400" height="400"></canvas>

                </div>
               </div>
            </div>
        </div>
    </div>
</x-layout>
<script src="{{ asset('assets/js/parcels.js') }}"></script>

<script></script>
