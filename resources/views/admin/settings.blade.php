
<div style="width: 100%;">
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
                <div class="row align-items-center justify-content-around">
                    <!-- Name Field -->
                    <div class="col-md-5 col-12 mb-2 mb-md-0">
                        <input type="text" name="name" placeholder="new deliveryman" class="form-control">
                        <!-- Error message for name -->
                        <div class="error" style="color: red;"></div>
                    </div>

                    <!-- Password Field -->
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <input type="text" name="password" placeholder="new password" class="form-control">
                        <!-- Error message for password -->
                        <div class="error" style="color: red;"></div>
                    </div>

                    <!-- Delivering Company Dropdown with Checkboxes -->
                    <div class="row d-flex my-2 align-items-center justify-content-around">
                        <div class="col-md-4 col-12 mb-2 mb-md-0">
                            <div class="dropdown mb-2">
                                <button class="btn btn-light px-4 border">Delivering Company</button>
                                <div class="dropdown-content">
                                    <div id="first" class="checkbox-list">
                                        @foreach ($companies as $c)
                                            <label>
                                                <div class="col-3">
                                                    <input type="checkbox" name="cps[]"
                                                        value="{{ $c->id }}">{{ $c->name }}
                                                </div>
                                                <div class="col-7">
                                                    <input type="number" disabled name="commission[]"
                                                        placeholder="commission (%)" class="form-control">
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Error message for company selection -->
                        </div>

                        <!-- Covered Locations Dropdown with Checkboxes -->
                        <div class="col-md-4 col-12 mb-2 mb-md-0">
                            <div class="dropdown">
                                <button class="btn btn-light px-4 border">Covered Location</button>
                                <div style="width: 180px;" class="dropdown-content">
                                    <div class="checkbox-list">
                                        @foreach ($cities as $c)
                                            <label>
                                                <div class="col-12">
                                                    <input type="checkbox" name="city[]"
                                                        value="{{ $c->id }}">{{ $c->city }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Error message for city selection -->
                        </div>
                    </div>

                    <!-- Submit Button -->
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
                    <div class="col-md-7 col-12 mb-2 mb-md-0">
                        <input type="text" name="location" placeholder="Location" class="form-control" required>
                    </div>

                    <div class="col-md-4 col-12 mb-2 mb-md-0  d-flex  align-items-center justify-content-around">
                        <div>
                            <input type="radio" id="local"
                                style="background-color: orange;color: orange; margin: 0;" name="local_reg"
                                value="local" /> Local
                        </div>
                        <div>
                            <input type="radio" id="reg"
                                style="background-color: orange;color: orange; margin: 0%" name="local_reg"
                                value="regional" /> Region
                        </div>
                    </div>
                    <div class="col-12 mt-2">
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
                        <input type="text" name="name" placeholder="Company Name" class="form-control"
                            required>
                    </div>
                    <div class="col-md-6 col-12 mb-2 mb-md-0">
                        <div class="dropdown" style="width:100%;">
                            <button class="btn btn-light px-4 border w-100">Covered Location</button>
                            <div style="width: 180px;" class="dropdown-content">
                                <div class="checkbox-list">
                                    @foreach ($cities as $c)
                                        <label>
                                            <div class="col-12">
                                                <input type="checkbox" name="city[]"
                                                    value="{{ $c->id }}">{{ $c->city }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Error message for city selection -->
                    </div>
                </div>
                <div class="row my-2 d-flex  align-items-center justify-content-around">
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <input type="number" name="local_commission" placeholder="local cities comission (%)"
                            class="form-control" required>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <input type="number" name="reg_commission" placeholder="comission for other regions (%)"
                            class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <button type="submit" class="btn" style="background: orange; color: #f0f8ff;">Add
                        Company</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>



