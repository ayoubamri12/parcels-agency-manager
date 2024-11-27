
$(document).ready(function() {
    var table1 = $('#table').DataTable({
        responsive: true,
        searching: true,
        "columnDefs": [{
                "orderable": false,
                "targets": 0
            }, // Disable sorting on the first column (index 0)
            {
                "orderable": false,
                "targets": 5
            }, // Disable sorting on the first column (index 0)
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
                    <button class="btn  action-btn" style='border-radius:50%' type="button"  data-toggle="dropdown" id="dropdownMenuButton${row.id}">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                        <li><a class="dropdown-item action-btn"  id=${row.id} href="#"><i class="fas fa-user-plus"></i> Assign it </a></li>
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
            this.api().columns().every(function() {
                var column = this;
                $('td', column.header()).each(function() {
                    $(this).append('<span class="sort-icon"></span>');
                });
            });
        },
        drawCallback: function() {
            // Handle checkbox display
            this.api().rows().data().each(function(e) {
                console.log(e);

                $(`#${e.id}`).on("click", function() {
                    showModal(e)
                });
            });
            $('.row-checkbox').on('change', function() {
                $('#delete-btn').toggle($('.row-checkbox:checked').length > 0);
            });
        },
    });




    $("#delete-btn").on("click", function() {
        let ids = [];
        $(".row-checkbox:checked").each(function() {
            ids.push(parseInt(this.value))
        });
        console.log(ids);
        $.ajax({
            url: '/api/parcels/deleteCity',
            type: 'delete',
            data: {
                _token: '{{ csrf_token() }}',
                ids: ids
            },
            success: function(response) {
                table1.ajax.reload();
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
                toastr.success("done !!");
            },

        });



    });

    // Select-all functionality
    $('#select-all').on('change', function() {
        $('.row-checkbox').prop('checked', this.checked);
        $('#delete-btn').toggle(this.checked);
    });

    function showModal(city) {
        $('#actionModal').modal('show'); // Show the modal
        $("form#merge").attr("action", `/deliverymencity/merge/${city.id}`);
    }
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

// livreur js code :
var table2 = $('#tab').DataTable({
    responsive: true,
    searching: true,
    "columnDefs": [{
        "orderable": false,
        "targets": 0
    }],
    ajax: {
        url: "/api/Deliverymen",
        type: "GET",
        dataSrc: "",

    },

    columns: [ //{
        //         data: null,
        //         render: (data) => `<input type="checkbox" value="${data.id}" class="row-checkbox">`
        //     },
        {
            data: 'id'
        },
        {
            data: 'name'
        },
        {
            data: 'password',
            render: function(data, type, row) {
                return `${row.user.type}`
            }
        },
        {
            data: 'password',
            render: function(data, type, row) {
                return `
                    <span>******</span>
                     <p class="password-display" style='display:none'>${row.user.password}</p>
                    <span id='put' style='display:none'>
                        <input type="password" id='passw${row.id}' class="form-control password-input" style='border-radius:50px;' name="updatePassword" placeholder="Enter new password">
                        </span>
                    <button class="toggle-password btn btn-link" data-id="${row.id}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="edit-password btn btn-link" data-id="${row.id}">
                        <i class="fas fa-pen"></i>
                    </button>
                `;
            },
        },
        // ,{
        //     data: 'reg_local'
        // },
        // {
        //     data: "deliveryman_cities",
        //     render: (data, type, row) => {
        //         return `${
        //             row.deliveriyman_cities.length
        //         }`

        //     }
        // },
        //     {
        //         data: 'id',
        //         render: function(data, type, row) {

        //             return `
        //     <div class="btn-group">
        //         <div class="dropdown">
        //             <button class="btn  action-btn" type="button"  data-toggle="dropdown" id="dropdownMenuButton${row.id}">
        //                 <i class="fas fa-ellipsis-v"></i>
        //             </button>
        //             <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
        //                 <li><a class="dropdown-item action-btn"  id=${row.id} href="#"><i class="fas fa-user-plus"></i> Assign it </a></li>
        //             </ul>
        //         </div>
        //     </div>
        // `;
        //         }
        //     }
    ],
    paging: true,
    pageLength: 10,
    lengthMenu: [10, 25, 50, -1],
    pagingType: 'simple_numbers',
    // initComplete: function() {
    //     $(".dataTables_filter input").addClass("form-control");
    //     this.api().columns().every(function() {
    //         var column = this;
    //         $('td', column.header()).each(function() {
    //             $(this).append('<span class="sort-icon"></span>');
    //         });
    //     });
    // },
    drawCallback: function() {

        // // Handle checkbox display
        this.api().rows().data().each(function(e) {
            //     console.log(e);
            $(`#passw${e.id}`).on('keydown', function(event) {
                console.log(event.key);

                if (event.key === 'Enter') {
                    const $row = $(this).closest('tr');
                    const newPassword = $(event.target).val();

                    // Send new password to API
                    $.ajax({
                        url: `/api/users/${e.id}/password`,
                        type: 'patch',
                        data: {
                            password: newPassword
                        },
                        beforeSend: function() {
                            $('#loaderHolder').show();
                        },
                        complete: function() {
                            $('#loaderHolder').hide();
                            $row.find('span#put')
                                .toggle();
                                $row.find('span:first')
                                .toggle();
                        },
                        success: function() {
                            table2.ajax.reload();

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
                            toastr.success("password has renewed !!");
                        },
                        error: function() {
                            alert('Failed to update password');
                        },
                    });
                }
            });
            //     $(`#${e.id}`).on("click", function() {
            //         showModal(e)
            //     });
        });
        // $('.row-checkbox').on('change', function() {
        //     $('#delete-btn1').toggle($('.row-checkbox:checked').length > 0);
        // });
    },
});
// Toggle password visibility
$('#tab').on('click', '.toggle-password', function() {
    const rowId = $(this).data('id');
    const $row = $(this).closest('tr');
    $row.find('span:first').toggle();

    const $passwordDisplay = $row.find('.password-display').toggle();

});

// Enter edit mode
$('#tab').on('click', '.edit-password', function() {
    const rowId = $(this).data('id');
    const $row = $(this).closest('tr');

    const $passwordDisplay = $row.find('span#put').toggle();
    $row.find('span:first').toggle();

    // const $saveButton = $row.find('.save-password');
    // $saveButton.removeClass('d-none');
});
// $('#select-all').on('change', function() {
//     $('.row-checkbox').prop('checked', this.checked);
//     $('#delete-btn1').toggle(this.checked);
// });
// $("#delete-btn1").on("click", function() {
//     let ids = [];
//     $(".row-checkbox:checked").each(function() {
//         ids.push(parseInt(this.value))
//     });
//     console.log(ids);
//     $.ajax({
//         url: '/api/parcels/deleteDeliveryman',
//         type: 'delete',
//         data: {
//             _token: '{{ csrf_token() }}',
//             ids: ids
//         },
//         success: function(response) {
//             table.ajax.reload();

//             toastr.options = {
//                 "closeButton": true,
//                 "debug": false,
//                 "newestOnTop": true,
//                 "progressBar": true,
//                 "positionClass": "toast-top-right",
//                 "preventDuplicates": false,
//                 "onclick": null,
//                 "showDuration": "300",
//                 "hideDuration": "1000",
//                 "timeOut": "5000",
//                 "extendedTimeOut": "1000",
//                 "showEasing": "swing",
//                 "hideEasing": "linear",
//                 "showMethod": "fadeIn",
//                 "hideMethod": "fadeOut"
//             };
//             toastr.success("done !!");
//         },
//     });
// });
});