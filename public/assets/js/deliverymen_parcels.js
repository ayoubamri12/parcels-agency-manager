/*  // Make rows draggable
    $(".draggable").draggable({
        helper: "clone",
        start: function(event, ui) {
            $(this).addClass("dragging");
        },
        stop: function(event, ui) {
            $(this).removeClass("dragging");
        }
    });

    // Make table sortable
    $('#example tbody').sortable({
        items: '.draggable',
        cursor: 'move',
        opacity: 0.6,
        update: function(event, ui) {
            var order = $(this).sortable('toArray', { attribute: 'data-id' });
            // Here, you can handle the new order
            console.log(order);
        }
    }).disableSelection();*/
// Get the table element
/* const $table = $('.table');

 $table.on('click', 'td', handleRowFocus);

 function handleRowFocus(event) {
     $(event.currentTarget).toggleClass('focus');
 }*/
let start, end;
function cb(st, ed) {
    $('#reportrange span').html(st.format('MMMM D, YYYY') + ' - ' + ed.format('MMMM D, YYYY'));
    start = st.format('YYYY-MM-DD')
    end = ed.format('YYYY-MM-DD')
}

$('#reportrange').daterangepicker({
    startDate: window.Laravel.userType ? moment() : moment().subtract(3, 'days'),
    endDate: moment(),
    ranges: {

        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 3 Days': [moment().subtract(3, 'days'), moment()],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'),  moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment()],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        'From 2024 to Now': [moment('2024-12-01'), moment()]
    },

}, cb);
let [st, endDate] = window.Laravel.userType ? [moment(), moment()] : [moment().subtract(3, 'days'), moment()]
cb(st, endDate);
var table1 = $('table#modalTable').DataTable({
    responsive: true,
    searching: true,
    ajax: {
        url: "/api/neededParcels_per_deliverymen/" + window.Laravel.userId,
        type: "GET",
        dataSrc: function (json) {
            return json;
        },
        beforeSend: function () {
            $('#loaderHolder').show();
        },
        complete: function () {
            $('#loaderHolder').hide();
        }
    },

    order: [
        [1, 'asc']
    ],

    paging: true,
    pageLength: 10,
    lengthMenu: [
        [10, 25, 50,],
        [10, 25, 50, 'All']
    ],
    pagingType: 'simple_numbers',
   
    columns: [
        {
            data: "code",
            render: function (data, type, row) {
                return `           
                                      ${row.code}
                                      <p class="badge badge-info"><i class="fa-solid fa-motorcycle"></i>
                                          ${row.delivery.name} </p>
                              `


            }
        }, {
            data: "company_name"
        },
        {
            data: 'client_name',
            render: function (data, type, row) {
                return `${row.client_name}`
            }
        },
        {
            data: 'created_at',
            render: function (data, type, row) {
                var createdAt = new Date(data);
                return createdAt.toLocaleDateString();
            }
        },
        {
            data: "phone",
            render: function (data, type, row) {
                return `                        
                                      <p>${row.phone}</p>
                              `
            }
        },

        {
            data: 'state'
            ,
            render: function (data, type, row) {
                return `            
                                      ${row.state == 'Payé' ? `<p class="badge badge-success p-1">${row.state}</p>` : ` <p class="badge badge-primary">${row.state}</p>`}       
                              `
            }
        },
        {
            data: 'status'
            ,
            render: function (data, type, row) {
                return `${row.status === 'Livré'
                    ? `<p style="background-color: #28a745; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p> 
       <br> 
        <span style="font-size: 12px; color: #343a40;">${new Date(row.delivery_date).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: '2-digit' })}</span>
       `
                    : row.status === 'Reporté'
                        ? `<p style="background-color: #ffc107; color: #343a40; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p> 
       <br> 
        <span style="font-size: 12px; color: #343a40;">Comment: ${row.comment}</span>
       `
                        : row.status === 'Refusé'
                            ? `<p style="background-color: #dc3545; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p>
       <br> 
        <span style="font-size: 12px; color: #343a40;">Comment: ${row.comment}</span>
       `
                            : row.status === 'Annulé'
                                ? `<p style="background-color: red; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p>
       <br> 
        <span style="font-size: 12px; color: #343a40;">Comment: ${row.comment}</span>
       `
                                : row.status === 'En voyage'
                                    ? `<p style="background-color: #17a2b8; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                    : row.status === 'Pas de reponse'
                                        ? `<p style="background-color: pink; color: black; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                        : row.status === 'Injoignable'
                                            ? `<p style="background-color: #6f42c1; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                            : row.status === 'Numéro Incorrect'
                                                ? `<p style="background-color: #d63384; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                                : row.status === 'Hors Zone'
                                                    ? `<p style="background-color: #fd7e14; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                                    : `<p style="background-color: orange; color: black; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
       ${row.status}
       </p>`
                    }`

            }
        },
        {
            data: "city"
        },
        {
            data: "price",
            render: (data, type, row) => {
                return `
                              <p>${row.price} DH </p>
                          `
            }
        },

    ],initComplete:function(){
       const data = this.api().rows().data()
      $("#modalbtn").text($("#modalbtn").text()+"("+data.length+")")
    }, drawCallback: function (s, j) {
       const data = this.api().rows().data();
     // $("#modalbtn").text($("#modalbtn").text() + "(" + data.length + ")")
        $("#reshipp").on('click', function () {
            $('#loaderHolder').show();

            data.map(e => {
                $.ajax({
                    url: '/Parcels/update/' + e.id,
                    type: 'put',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        data: {
                            status: "en cours de livraison"
                        },
                    },
                    success: function (response) {
                        $('#loaderHolder').hide();
                        
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
                        toastr.success("parcel has been shipped successfully");
                        table1.ajax.reload();

                    },
                    error: function (xhr, status, error) {
                        $('#loaderHolder').hide();
                    }
                });
            })
        })
    },


});
var table = $('table#example').DataTable({
    responsive: true,
    searching: true,
    ajax: {
        url: "/api/parcels_per_deliverymen/" + window.Laravel.userId,
        type: "GET",
        dataSrc: function (json) {
            return json;
        },
        data: function (d) {
            d.code = $('#code-filter').val();
            d.created_at = $('#delDate-filter').val() ? null : [start, end];
            d.magasin = $('#magasin-filter').val();
            d.state = $('#state-filter').val();
            d.status = $('#status-filter').val();
            d.company_id = $('#company-filter').val();
            d.delivery = $('#delivery-filter').val();
            d.delivery_date = $('#delivered-today-filter').is(':checked')
                ? $('#delivered-today-filter').val()
                : null || $('#delDate-filter').val();

        }, beforeSend: function () {
            $('#loaderHolder').show();
        },
        complete: function () {
            $('#loaderHolder').hide();
        }
    },

    order: [
        [1, 'asc']
    ],
    "columnDefs": [
        { "orderable": false, "targets": 0 } // Disable sorting on the "Status" column
    ],
    paging: true,
    pageLength: 10,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All']
    ],
    pagingType: 'simple_numbers',

    columns: [{
        data: null,
        render: function (data, type, row) {
            return `  <input type="checkbox" value=${row.id} class="row-checkbox">`;
        }
    },
    {
        data: "code",
        render: function (data, type, row) {
            return `           
                                      ${row.code}
                                      <p class="badge badge-info"><i class="fa-solid fa-motorcycle"></i>
                                          ${row.delivery.name} </p>
                              `


        }
    }, {
        data: "company_name"
    },
    {
        data: 'client_name',
        render: function (data, type, row) {
            return `${row.client_name}`
        }
    },
    {
        data: 'created_at',
        render: function (data, type, row) {
            var createdAt = new Date(data);
            return createdAt.toLocaleDateString();
        }
    },
    {
        data: "phone",
        render: function (data, type, row) {
            return `           
                               
                                      <p>${row.phone}</p>
                              `


        }
    },

    {
        data: 'state'
        ,
        render: function (data, type, row) {
            return `            
                                      ${row.state == 'Payé' ? `<p class="badge badge-success p-1">${row.state}</p>` : ` <p class="badge badge-primary">${row.state}</p>`}       
                              `
        }
    },
    {
        data: 'status'
        ,
        render: function (data, type, row) {
            return `${row.status === 'Livré'
                ? `<p style="background-color: #28a745; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p> 
       <br> 
        <span style="font-size: 12px; color: #343a40;">${new Date(row.delivery_date).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: '2-digit' })}</span>
       `
                : row.status === 'Reporté'
                    ? `<p style="background-color: #ffc107; color: #343a40; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p> 
       <br> 
        <span style="font-size: 12px; color: #343a40;">Comment: ${row.comment}</span>
       `
                    : row.status === 'Refusé'
                        ? `<p style="background-color: #dc3545; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p>
       <br> 
        <span style="font-size: 12px; color: #343a40;">Comment: ${row.comment}</span>
       `
                        : row.status === 'Annulé'
                            ? `<p style="background-color: red; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status} 
       </p>
       <br> 
        <span style="font-size: 12px; color: #343a40;">Comment: ${row.comment}</span>
       `
                            : row.status === 'En voyage'
                                ? `<p style="background-color: #17a2b8; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                : row.status === 'Pas de reponse'
                                    ? `<p style="background-color: pink; color: black; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                    : row.status === 'Injoignable'
                                        ? `<p style="background-color: #6f42c1; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                        : row.status === 'Numéro Incorrect'
                                            ? `<p style="background-color: #d63384; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                            : row.status === 'Hors Zone'
                                                ? `<p style="background-color: #fd7e14; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
        ${row.status}
       </p>`
                                                : `<p style="background-color: orange; color: black; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
       ${row.status}
       </p>`
                }`

        }
    },
    {
        data: "city"
    },
    {
        data: "price",
        render: (data, type, row) => {
            return `
                              <p>${row.price} DH </p>
                          `
        }
    },
    {
        data: 'id',
        render: function (data, type, row) {
            let parcel = JSON.stringify(row);
            console.log(parcel);


            return `
                          <div class="btn-group">
                             <div class="dropdown">
                 <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" id="dropdownMenuButton${row.id}">
                   <i class="fas fa-ellipsis-v"></i>
                 </button>
                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                 <li><a class="dropdown-item" href="#"  id='status${row.id}'><i class="fas fa-edit"></i> Modify Status</a></li>
                 <li><a class="dropdown-item" href="#" id='det${row.id}'><i class="fas fa-info-circle"></i> Details</a></li>
                 ${window.Laravel.userType ? ` 
            <li><a class="dropdown-item" href="/parcels/delete/${row.id}"><i class="fas fa-trash-alt"></i> Delete</a></li>` : ''
                }
                 </ul>
               </div>
                          </div>
                          `;
        }
    }
    ],
    initComplete: function (s, j) {
        this.api().columns().every(function () {
            var column = this;
            $('td', column.header()).each(function () {
                $(this).append('<span class="sort-icon"></span>');
            });
        });

        //  $(".row-checkbox").on('change', function () {
        //      console.log($('#shipbtn'));
        //      if ($(".row-checkbox:checked").length > 0)
        //          $('#shipbtn').show()
        //      else
        //          $('#shipbtn').hide()

        //  })

    },
    drawCallback: async function () {
        $('.row-checkbox').on('click', function () {
            if ($(".row-checkbox:checked").length > 0) {
                $('#return').show();
                $('#return').addClass("return-button")
            }
            else {
                $('#return').hide();
                $('#return').removeClass("return-button");
            }


        });
        let delivredQ = 0, rev = 0, clearRev = 0, clearRevenueDelivery = 0, returned = 0, refused = 0;

        const retrievedCities = await fetch('/api/cities').then(e => e.json());
        const retrievedComps = await fetch('/api/companies_commissions').then(e => e.json());
        //  console.log(retrievedComps);

        this.api().rows({ search: 'applied' }).data().map(function (e, i) {
            if (e.status == "Refusé" || e.status == "Annulé"){
                refused++
                 console.log(refused)
            }
            if (e.status == "Livré") {
                let city = retrievedCities.find(c => {
                    return c.city == e.city
                });
                let deliveryCom = city.deliveriyman_cities.find(dc => {
                   // console.log(e.company_name);
                    //  console.log(e.company_id);
                      
                    return dc.company_id == e.company_id && dc.delivery_id ==e.delivery_id
                });
                let compCom = retrievedComps.find(c => {
                    // console.log(c);

                    return c.city_id == city.id && c.company_id == e.company_id
                });
                delivredQ++
                rev += e.price
                // console.log(compCom.commission);
                // console.log(deliveryCom.commission);
                clearRev += (compCom.commission - deliveryCom.commission)
                clearRevenueDelivery += deliveryCom.commission
            }
            if (e.returned == 1) {
                returned++
            }

        })
        console.log(delivredQ, rev, clearRev,refused);

        $("#deliveredQuantity").text(delivredQ + " Parcel")
        $("#totalRevenue").text(rev + " DH")
        $("#clearRevenueDelivery").text(clearRevenueDelivery + " DH")
        $("#clearRevenue").text(clearRev + " DH")
        $("#refused").text(refused + " Parcel")
        $("#returned").text(returned + " Parcel")

        this.api().rows().data().each(function (e) {
            console.log(e);

            $(`#det${e.id}`).on("click", function () {
                showModal("details", e)
                console.log("det");

            })
            $(`#status${e.id}`).on("click", function () {
                if (!window.Laravel.userType && e.status === 'Livré') {
                    showModal("statusUnabling", e)
                    console.log(window.Laravel.userType);
                    return
                }
                showModal("modifyStatus", e)
            });
            
            $(`#del${e.id}`).on("click", function () {
                showModal("delete", e)
            })

        })
    }

});
$('#filter-btn').on('click', function () {
    table.ajax.reload();
});
$('#delivered-today-filter').on('click', function () {
    if ($('#delivered-today-filter').is(':checked')) {
        // Get today's date in "YYYY-MM-DD" format
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];

        // Set the value of the checkbox to today's date
        $('#delivered-today-filter').val(formattedDate);

        // Reload the DataTable with the filter applied
        table.ajax.reload();
    } else {
        $('#delivered-today-filter').val("");

        // Reload the DataTable with the filter applied
        table.ajax.reload();
    }
});
$('#delDate-filter').on('change', function () {
     table.ajax.reload();
    
});
$('#refresh-btn').on('click', function () {
    $('#code-filter').val('');
    $('#magasin-filter').val("");
    $('#state-filter').val("");
    $('#status-filter').val("");
    $('company-filter').val("");
    $('#delivery-filter').val("");
    cb(moment(), moment())
    $('#magasin-filter').val('');
    $('#delDate-filter').val('');
    table.ajax.reload();
});
// Select all functionality
$('#select-all').on('change', function () {
    $('.row-checkbox').prop('checked', this.checked);
    if ($(".row-checkbox:checked").length > 0) {
        $('#return').show();
        $('#return').addClass("return-button")
    }
    else {
        $('#return').hide();
        $('#return').removeClass("return-button");
    }

});
$("button#return").click(function () {
    let ids = [];
    $(".row-checkbox:checked").each(function () { ids.push(parseInt(this.value)) });
    console.log(ids);
    $.ajax({
        url: '/api/parcels/markAsReturned',
        type: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}',
            ids: ids
        },
        success: function (response) {
            table.ajax.reload();
$('#return').hide();
 $('#return').removeClass("return-button")
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


})
const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Sales',
            data: [30, 50, 40, 60, 70],
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const lineCtx = document.getElementById('lineChart').getContext('2d');
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Revenue',
            data: [10, 20, 15, 25, 30],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        tension: 0.4,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
const pieCtx = document.getElementById('pieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
            label: 'Colors',
            data: [12, 19, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
new Chart(doughnutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Product A', 'Product B', 'Product C'],
        datasets: [{
            label: 'Products',
            data: [50, 30, 20],
            backgroundColor: [
                'rgba(153, 102, 255, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: [
                'rgba(153, 102, 255, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
