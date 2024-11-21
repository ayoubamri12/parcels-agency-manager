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
    startDate: moment('2024-08-01'),
    endDate: moment(),
    ranges: {

        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), , moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment()],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        'From 2022 to Now': [moment('2022-01-01'), moment()]
    },

}, cb);
cb(moment(), moment());

var table = $('table#example').DataTable({
    responsive: true,
    searching: true,
    ajax: {
        url: "/api/parcels_per_deliverymen/"+window.Laravel.userId,
        type: "GET",
        dataSrc: function (json) {
            return json;
        },
        data: function (d) {
            d.code = $('#code-filter').val();
            d.created_at = [start, end];
            d.magasin = $('#magasin-filter').val();
            d.state = $('#state-filter').val();
            d.status = $('#status-filter').val();
            d.company_id = $('#company-filter').val();
            d.delivery = $('#delivery-filter').val();
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
    searching: false,
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
        data: "company_name"
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
                    ? `<p style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
        ${row.status} 
       </p> 
       <br> 
        <span style="font-size: 12px; color: black;">${row.delivery_date}</span>
       `
                    : row.status === 'Reporté'
                        ? `<p style="background-color: #ffc107; color: black; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
        ${row.status} 
       </p> 
       <br> 
        <span style="font-size: 12px; color: black;">Comment: ${row.comment}</span>
       `
                        : row.status === 'Refusé'
                            ? `<p style="background-color: #dc3545; color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
        ${row.status} 
       </p>
       <br> 
        <span style="font-size: 12px; color: black;">Comment: ${row.comment}</span>
       `
                            : row.status === 'Annulé'
                                ? `<p style="background-color: #6c757d; color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
        ${row.status} 
       </p>
       <br> 
        <span style="font-size: 12px; color:black;">Comment: ${row.comment}</span>
       `
                                : row.status === 'En voyage'
                                    ? `<p style="background-color: #17a2b8; color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
        ${row.status}
       </p>`
                                    : row.status === 'Pas de reponse'
                                        ? `<p style="background-color: #ff6347; color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
        ${row.status}
       </p>`
                                        : `<p style="background-color: #6c757d; color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: inline-block;">
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
                   <li><a class="dropdown-item" href="#" id='det${row.id}'><i class="fas fa-info-circle"></i> Details</a></li>
                   <li><a class="dropdown-item" href="#"  id='status${row.id}'><i class="fas fa-edit"></i> Modify Status</a></li>
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
        let delivredQ = 0, rev = 0, clearRev = 0, clearRevenueDelivery = 0,returned=0,refused=0;

        const retrievedCities = await fetch('/api/cities').then(e => e.json());
        const retrievedComps = await fetch('/api/companies_commissions').then(e => e.json());
        //  console.log(retrievedComps);

        this.api().rows({ search: 'applied' }).data().map(function (e, i) {
            if (e.status == "Refusé" || e.status == "Annulé"){
                refused++
            }
            if (e.status == "Livré") {
                let city = retrievedCities.find(c => {
                    return c => c.city == e.city
                });
                let deliveryCom = city.deliveriyman_cities.find(dc => {
                    return dc => dc.company_id == e.company_id
                });
                let compCom = retrievedComps.find(c => {
                    // console.log(c);

                    return c.city_id == city.id && c.company_id == e.company_id
                });
                delivredQ++
                rev += e.price
                console.log(compCom.commission);
                console.log(deliveryCom.commission);
                clearRev += (compCom.commission - deliveryCom.commission)
                clearRevenueDelivery += deliveryCom.commission
            }
            if (e.returned == 1){
                returned++
            }

        })
        console.log(delivredQ, rev, clearRev);

        $("#deliveredQuantity").text(delivredQ + " Parcel")
        $("#totalRevenue").text(rev + " DH")
        $("#clearRevenue").text(clearRev + " DH")
        $("#clearRevenueDelivery").text(clearRevenueDelivery + " DH")
        $("#returned").text(returned+ " Parcel")
        $("#refused").text(refused+ " Parcel")

        this.api().rows().data().each(function (e) {
            console.log(e);

            $(`#det${e.id}`).on("click", function () {
                showModal("details", e)
                console.log("det");

            })
            $(`#status${e.id}`).on("click", function () {
                showModal("modifyStatus", e)
            })
            $(`#state${e.id}`).on("click", function () {
                showModal("modifyState", e)
            })
            $(`#del${e.id}`).on("click", function () {
                showModal("delete", e)
            })

        })
    }

});
$('#filter-btn').on('click', function () {
    table.ajax.reload();
});

$('#refresh-btn').on('click', function () {
    $('#code-filter').val('');
    $('#magasin-filter').val("");
    $('#state-filter').val("");
    $('#status-filter').val("");
    $('company-filter').val("");
    $('#delivery-filter').val("");
    cb(moment('2024-08-01'), moment())
    $('#magasin-filter').val('');
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
