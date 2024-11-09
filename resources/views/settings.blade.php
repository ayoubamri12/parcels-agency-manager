<style>
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
        padding: 10px 20px;
        font-size: 1em;
        border-radius: 25px;
        border: 2px solid #007bff;
        color: #007bff;
        background: #f0f8ff;
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
</style>

<x-layout>
    @if (session()->has('success'))
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
            toastr.success("operation has been finshed successfully");
        </script>
    @endif
    <div class="mt-5"
        style="background: white; border-radius: 10px; padding: 20px; width: 90%; margin: auto; height: fit-content;">
        <h1 class="mb-4 text-center" style="font-weight: bolder; color: orangered; padding-bottom: 5px;">
            <i class="icon ph-bold ph-gear"></i> Settings
        </h1>
        <div style="width: 90%; margin: auto; border-bottom: 2px solid gainsboro;"></div>

        <!-- Step 1: Select Deliveryman or Company -->
        <div class="my-4">
            <div class="selection-container">
                <h5 style="color: orange;" class="mb-3">Choose an Option</h5>
                <select id="entityType" class="custom-select form-control" onchange="showForm()">
                    <option selected disabled>-- Select --</option>
                    <option value="deliveryman">Deliveryman</option>
                    <option value="company">Company</option>
                    <option value="city">City</option>
                    <option value="magasin">Magasin</option>
                </select>
            </div>
        </div>

        <!-- Step 2: Form for Deliveryman or Company (Hidden initially) -->
        <div id="formContainer" class="form-container d-none p-4 border rounded"
            style="border: orange; box-shadow: 2px 2px 7px orange, -2px -2px 7px orange;">
            <!-- Deliveryman Form -->
            <form id="deliverymanForm" action="{{ route('settings.storeDeliveryman') }}" class="entity-form d-none"
                method="POST">
                @csrf
                <h3 class="mb-3" style="color: orangered">Add New Deliveryman</h3>
                <label class="form-label" style="color: orange">Deliveryman Name</label>
                <div class="row align-items-center justify-content-around">
                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                        <input type="text" name="name" placeholder="new deliverymen" class="form-control"
                            required>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <input type="text" name="password" placeholder="new password" class="form-control" required>
                    </div>
                    <div class="col-12 my-2">
                        <input type="number" name="comission" placeholder="comission" class="form-control" required>
                    </div>
                    <div class="col-md-2 col-12">
                        <button type="submit" class="btn" style="background: orange; color: #f0f8ff;">Add
                            Deliveryman</button>
                    </div>
                </div>
            </form>
            <form id="magasinForm" action="{{ route('settings.storeMagasin') }}" class="entity-form d-none"
                method="POST">
                @csrf
                <h3 class="mb-3" style="color: orangered">Add New Magasin</h3>
                <label class="form-label" style="color: orange">Magasin</label>
                <div class="row align-items-center">
                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                        <input type="text" name="magasin" placeholder="new magasin" class="form-control" required>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <Select name="company_id" class="form-control" required>
                            <option value="" disabled>Delivering Company</option>
                            @foreach ($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </Select>
                    </div>
                    <div class="col-md-2 col-12">
                        <button type="submit" class="btn" style="background: orange; color: #f0f8ff;">Add
                            Magasin</button>
                    </div>
                </div>
            </form>
            <form id="LocationForm" action="{{ route('settings.storeCity') }}" class="entity-form d-none"
                method="POST">
                @csrf
                <h3 class="mb-3" style="color: orangered">Add New Location</h3>
                <label class="form-label" style="color: orange">Location Name</label>
                <div class="row align-items-center">
                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                        <input type="text" name="location" placeholder="Location" class="form-control" required>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <select name="livreur" placeholder="livreur" class="form-control">
                            @foreach ($deliverymen as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12">
                        <button type="submit" class="btn" style="background: orange; color: #f0f8ff;">Add
                            Location</button>
                    </div>
                </div>
            </form>
            <!-- Company Form -->
            <form id="companyForm" action="{{ route('settings.storeCompany') }}" class="entity-form d-none"
                method="POST">
                @csrf
                <h3 class="mb-3" style="color: orangered">Add New Company</h3>
                <div class="row align-items-center">
                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                        <input type="text" name="name" placeholder="Company Name" class="form-control" required>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <input type="number" name="revenue" placeholder="Commission (%)" class="form-control"
                            min="0" max="100" required>
                    </div>
                    <div class="col-md-3 col-12">
                        <button type="submit" class="btn" style="background: orange; color: #f0f8ff;">Add
                            Company</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>

<!-- JavaScript for toggling forms and adding animation -->
<script>
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
