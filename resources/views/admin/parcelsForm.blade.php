<style>
    .form-control.is-invalid,
    .popup-input.is-invalid {
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
        z-index: 1000000;
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

    <nav class="navbar mt-4 navbar-expand-lg bg-body-tertiary w-100">

        <nav aria-label="breadcrumb w-100">
            <ol class="breadcrumb">
                @if (request()->id)
                    <li class="breadcrumb-item"><a href="{{ route('deliverymen.parcels', request()->id) }}"><i
                                class="icon fa-solid fa-box"></i>
                            Parcels</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('parcels') }}"><i class="icon fa-solid fa-box"></i>
                            Parcels</a></li>
                @endif
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
    <div id="loaderHolder" style="display: none" class="loading">
        <p class="loader"></p>
    </div>
    <div class="card mt-2 mx-auto" style="width: 97%;">
        <div class="card-header p-3" style="background-color: orange;color:white;">
            <h3>
                Create new parcel
            </h3>
        </div>
        <div class="card-body">
            @if (request()->id)
                <form action="{{ route('parcel.store', request()->id) }}" method="POST" class="parcel-form">
                @else
                    <form action="{{ route('parcel.store') }}" method="POST" class="parcel-form">
            @endif
            <!-- 2 column grid layout with text inputs for the first and last names -->
            @csrf
            {{-- <div class="row mb-4">

                <div class="col">
                    <div class="form-outline">

                        <select name="magasin" id="magasin" class="form-control">
                            <option value="">Select</option>
                            @foreach ($mgs as $mg)
                                <option value="{{ $mg->magasin }}">{{ $mg->magasin }}</option>
                            @endforeach
                        </select>
                        <label class="form-label" for="magasin">Magasin</label>
                        <div id="magasin-error" class="invalid-feedback"></div>
                    </div>
                </div>
            </div> --}}

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
                                                    <input type="radio" name="cps" class="open"
                                                        value="{{ $o->id }}">{{ $o->name }}
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
                    </div>
                    @if (!request()->id)
                        <!-- Covered Locations Dropdown with Checkboxes -->
                        <div class="col-md-4 col-12 mb-2 mb-md-0">
                            <div class="dropdown">
                                <button type="button" class="btn btn-light px-4 border">Destination</button>
                                <div style="width: 180px;" class="dropdown-content">
                                    <div class=".checkbox-list checkbox-list2">
                                        @foreach ($cities as $c)
                                            <label>
                                                <div class="col-12">
                                                    <input type="radio" name="city"
                                                        value="{{ $c->city }}">{{ $c->city }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Error message for city selection -->
                        </div>
                    @endif

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
                @if (!request()->id)
                    <div class="col-md-4 col-12 mb-2 mb-md-0">
                        <div class="dropdown mb-2">
                            <button type="button" class="btn btn-light px-4 border">Deliverymen</button>
                            <div class="dropdown-content">
                                <div id="first" class="checkbox-list3">
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
                @endif

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

        $('.parcel-form').submit(function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Clear any previous errors
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $('.error').remove(); // Clear dynamically added error messages
            let isValid = true;

            // Check if all fields are filled
            // if ($('#magasin').val() === '') {
            //     $('#magasin').addClass('is-invalid');

            //     $('#magasin-error').text('Please enter a magasin.');
            //     isValid = false;
            // }
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
            if (!selectedCompany.val()) {
                isValid = false;
                $('.checkbox-list1').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one Company.</div>'
                );
            }

            if (!@json(request()->id)) {
                let selectedDeliveryman = $('input[name="dev"]:checked');
                if (!selectedDeliveryman.val()) {
                    isValid = false;
                    $('.checkbox-list3').parents(".dropdown").after(
                        '<div class="error" style="color: red;">Please select at least one Deliveryman.</div>'
                    );
                }
            }
            if (!@json(request()->id)) {
                // Validate City Checkboxes (at least one city must be selected)
                let selectedCity = $('input[name="city"]:checked');
                if (!selectedCity.val()) {
                    isValid = false;
                    $('.checkbox-list2').parents(".dropdown").after(
                        '<div class="error" style="color: red;">Please select at least one City.</div>'
                    );
                }
            }
            console.log(isValid);

            if (isValid) {
                // Submit the form programmatically
                this.submit();
            }
        });

        const $popup = $('#popup');
        const $openPopupBtn = $('#openPopupBtn');
        const $closePopupBtn = $('#closePopupBtn');
        const $saveBtn = $('#commission');
        $(".open").on("click", function(e) {
            if (this.checked) {
                $('#name').val(this.value).hide();
                $("#commissionV").val(" ").hide()
                $popup.addClass('active');
            }
        });
        // Open popup
        $openPopupBtn.on('click', function() {
            if (this.checked) {
                $('#name').val('').hide();
                $popup.addClass('active');
            }
        });
        $saveBtn.on('click', function() {
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
                    $('#loaderHolder').hide();
                    $(".dropdown-content").toggleClass("show");
                    let company = response;
                    console.log(company);

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
            $popup.removeClass('active');
        });

        // Close popup when clicking outside of it
        $popup.on('click', function(e) {
            if ($(e.target).is($popup)) {
                $popup.removeClass('active');
            }
        });
    });
</script>
