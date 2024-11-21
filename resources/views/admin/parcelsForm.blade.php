<style>
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

    .active {
        color: orange;
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
</style>
<x-layout>

    <nav class="navbar mt-4 navbar-expand-lg bg-body-tertiary w-100">

        <nav aria-label="breadcrumb w-100">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route("parcels")}}"><i class="icon fa-solid fa-box"></i> Colis</a></li>
                <li class="breadcrumb-item active" aria-bs-current="page"><a href="">create</a></li>
            </ol>
        </nav>

    </nav>
    @if (session()->has('created'))
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
            toastr.success("parcel has been added successfully");
        </script>
    @endif
    <div class="card mt-2 mx-auto" style="width: 97%;">
        <div class="card-header p-3" style="background-color: orange;color:white;">
            <h3>
                Create new parcel
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('parcel.store') }}" method="POST" id="parcel-form">
                <!-- 2 column grid layout with text inputs for the first and last names -->
                @csrf
                <div class="row mb-4">

                    <div class="col">
                        <div class="form-outline">

                            <select name="magasin" id="magasin">
                                <option value="">Select</option>
                                @foreach ($mgs as $mg)
                                <option value="{{$mg->magasin}}">{{$mg->magasin}}</option>
                                    
                                @endforeach
                            </select>
                            <label class="form-label" for="form6Example2">Magasin</label>
                            <div id="magasin-error" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            
                <!-- Text input -->
                <div class="form-outline mb-4">
                    <input type="text" name="phone_number" id="phone" class="form-control" />
                    <label class="form-label" for="phone">Telephone</label>
                    <div id="phone-error" class="invalid-feedback"></div>
                </div>

                <!-- Text input -->
                <div class="form-outline mb-4">
                    <input type="text" name="Name" id="clientName" class="form-control" />
                    <label class="form-label" for="clientName">Destinataire</label>
                    <div id="clientName-error" class="invalid-feedback"></div>
                </div>
    <!-- Number input -->
    <div class="form-outline mb-4">
        <div class="row d-flex my-2 align-items-center justify-content-around">
            <div class="col-md-4 col-12 mb-2 mb-md-0">
                <div class="dropdown mb-2">
                    <button type="button" class="btn btn-light px-4 border">Delivering Company</button>
                    <div class="dropdown-content">
                        <div id="first" class=".checkbox-list checkbox-list2">
                            @foreach ($companies as $c)
                                <label>
                                    <div class="col-12">
                                        <input type="radio" name="cps"
                                            value="{{ $c->id }}">{{ $c->name }}
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
                    <button type="button" class="btn btn-light px-4 border">Destination</button>
                    <div style="width: 180px;" class="dropdown-content">
                        <div class=".checkbox-list checkbox-list1">
                            @foreach ($cities as $c)
                                <label>
                                    <div class="col-12">
                                        <input type="radio" name="city"
                                            value="{{$c->city }}">{{ $c->city }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Error message for city selection -->
            </div>
        </div>
    </div>
                <!-- Email input -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline mb-4">
                            <input type="number" name="price" id="price" class="form-control" />
                            <label class="form-label" for="price">Prix</label>
                            <div id="price-error" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <div class="dropdown mb-2">
                            <button type="button" class="btn btn-light px-4 border">Deliverymen</button>
                            <div class="dropdown-content">
                                <div id="first" class=".checkbox-list checkbox-list3">
                                    @foreach ($devs as $d)
                                        <label>
                                            <div class="col-12">
                                                <input type="radio" name="dev"
                                                    value="{{ $d->id }}">{{ $d->name }}
                                            </div>

                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Error message for company selection -->
                    </div>

                    <!-- <div class="col">
                        <div class="form-outline mb-4">
                            <input type="text" name="adress" id="adress" class="form-control"  />
                            <label class="form-label" for="adress">Adresse</label>
                            <div id="adress-error" class="invalid-feedback"></div>
                        </div>
        
                    </div> -->

                </div>



                {{-- <div class="">
                    <div class="form-outline mb-4">
                        <input type="checkbox" name="accessable" id="accessable" value="unaccessible" /> Interdit
                        d&apos;ouvrir le colis
                        <label for="price"></label>
                    </div>

                    <div class="form-outline mb-4">
                        <input type="checkbox" name="changeable" value="changeable" id="changeable" /> Colis a
                        remplacer
                    </div>
                </div> --}}

                <!-- Submit button -->
                <button type="submit" style="background-color: orange; cursor: pointer;color:white;"
                    class="btn btn-block mb-4">Add</button>
            </form>
        </div>
    </div>
</x-layout>
<script>
    $(document).ready(function() {

        $(".dropdown .btn").on("click", function(e) {
            $(this).next(".dropdown-content").toggleClass("show")
            console.log(this);
        });
       
        $('#parcel-form').submit(function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Clear any previous errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            let isValid = true;
            // Check if all  fields are filled

            if ($('#magasin').val() === '') {
                $('#magasin-error').text('Please enter a magasin.');
                isValid = false;
            }
            if ($('#phone').val() === '') {
                $('#phone').addClass('is-invalid');
                $('#phone-error').text('Please enter a phone number.');
                isValid = false;
            }
            if ($('#clientName').val() === '') {
                $('#clientName').addClass('is-invalid');
                $('#clientName-error').text('Please enter a destinataire name.');
                isValid = false;
            }
            if ($('#price').val() === '') {
                $('#price').addClass('is-invalid');
                $('#price-error').text('Please enter a price.');
                isValid = false;
            }

            let selectedCompany = $('input[name="cps"]:checked');
            console.log();
            
            if (!selectedCompany.val()) {
                isValid = false;
                $('.checkbox-list1').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one City.</div>'
                );
            }
            let selectedDeliveryman = $('input[name="dev"]:checked');
            if (!selectedDeliveryman.val()) {
                isValid = false;
                $('.checkbox-list3').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one Deliveryman.</div>'
                );
            }
            // Validate City Checkboxes (at least one city must be selected)
            let selectedCity = $('input[name="city"]:checked');
            if (!selectedCity.val()) {
                isValid = false;
                $('.checkbox-list2').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one company.</div>');
            }
            if (isValid) {
                // All fields are filled, submit the form
                $(this).unbind('submit').submit();
            }
        });
    });
</script>
