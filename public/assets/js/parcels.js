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
    startDate: moment('2024-12-01'),
    endDate: moment(),
    ranges: {

        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment()],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        'From 2022 to Now': [moment('2022-01-01'), moment()]
    },

}, cb);
cb(moment('2024-12-01'), moment());
var table = $('table#example').DataTable({
    responsive: true,
    searching: true,
    ajax: {
        url: "/api/parcels",
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
            d.delivery_date = $('#delivered-today-filter').is(':checked')
                ? $('#delivered-today-filter').val()
                : null;
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
    pageLength: 5,
    lengthMenu: [
        [5,10, 25, 50,],
        [5,10, 25, 50, 'All']
    ],
    pagingType: 'simple_numbers',


    columns: [{
        data: null,
        render: function (data, type, row) {
            return row.returned == 1 ? ` <i class="fas fa-undo text-danger"></i>` : `<input type="checkbox" value=${row.id} class="row-checkbox">`;
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
                                    ? `<p style="background-color: orange; color: black; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
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
            // console.log(parcel);


            return `
                     <div class="btn-group">
                        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" id="dropdownMenuButton${row.id}">
              <i class="fas fa-ellipsis-v"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
              <li><a class="dropdown-item" href="#" id='det${row.id}'><i class="fas fa-info-circle"></i> Details</a></li>
              <li><a class="dropdown-item" href="#"  id='status${row.id}'><i class="fas fa-edit"></i> Modify Status</a></li>
              <li><a class="dropdown-item" href="#"  id='state${row.id}'><i class="fas fa-edit"></i> Modify State</a></li>
              <li><a class="dropdown-item" href="/parcels/delete/${row.id}"><i class="fas fa-trash-alt"></i> Delete</a></li>
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


        // this.api().rows().every(function () {
        //     var row = $(this.node());
        //     var data = this.data();
        //     var qrious = new QRious({
        //         element: row.find('canvas.qr_code')[0],
        //         value: data.qr_code,
        //         size: 200,
        //         foreground: '#ffa500',
        //     });
        //     //   console.log(qrious);
        // });
        // $(".row-checkbox").on('change', function () {
        //     console.log($('#shipbtn'));
        //     if ($(".row-checkbox:checked").length > 0)
        //         $('#shipbtn').show()
        //     else
        //         $('#shipbtn').hide()

        // })

    },
    drawCallback: async function () {
        let delivredQ = 0, rev = 0, clearRev = 0, returned = 0, refused = 0;

        const retrievedCities = await fetch('/api/cities').then(e => e.json());
        const retrievedComps = await fetch('/api/companies_commissions').then(e => e.json());
        console.log(retrievedComps);

        this.api().rows({ search: 'applied' }).data().map(function (e, i) {
            if (e.returned == 1) {
                returned++
            }
            if (e.status == "Refusé" || e.status == "Annulé") {
                refused++
            }
            if (e.status == "Livré") {
                let city = retrievedCities.find(c => {
                    return c.city == e.city
                });
                // console.log(city.deliveriyman_cities);

                let deliveryCom = city.deliveriyman_cities.find(dc => {
                    return dc.company_id == e.company_id && dc.delivery_id == e.delivery_id;
                });
                // console.log(deliveryCom);

                let compCom = retrievedComps.find(c => {
                    return c.city_id == city.id && c.company_id == e.company_id
                });
                // console.log(compCom);

                delivredQ++
                rev += e.price
                // console.log(compCom.commission);
                //console.log(deliveryCom.commission);
                clearRev += (compCom.commission - deliveryCom.commission)
            }

        })
        let revLocal = 0, clearRevLocal = 0,totale=0;
      
    
         const localData = await fetch(`/api/parcelsLocal?created_at[]=${start}&created_at[]=${end}&magasin=${$('#magasin-filter').val()}&company_id=${$('#company-filter').val()}&delivery=${$('#delivery-filter').val()}&delivery_date=${$('#delivered-today-filter').is(':checked') ? $('#delivered-today-filter').val() : ""}`)
    .then(response => response.json());

        localData.map(function (e, i) {
              
                let city = retrievedCities.find(c => {
                    return c.city == e.city
                });
                let deliveryCom = city.deliveriyman_cities.find(dc => {
                    // console.log(e.company_name);
                    //  console.log(e.company_id);

                    return dc.company_id == e.company_id && dc.delivery_id == e.delivery_id
                });
                let compCom = retrievedComps.find(c => {
                    // console.log(c);
                    // console.log(city);
                    return c.city_id == city.id && c.company_id == e.company_id
                });
                totale+=e.totale_d;
                revLocal += e.price
                // console.log(compCom.commission);
                // console.log(deliveryCom.commission);
                clearRevLocal += (e.totale_d * (compCom.commission - deliveryCom.commission))
           


        })
        console.log(delivredQ+totale, rev+revLocal, clearRev+clearRevLocal);

        $("#deliveredQuantity").text((delivredQ+totale) + " Parcel")
        $("#totalRevenue").text((rev+revLocal) + " DH")
        $("#clearRevenue").text((clearRev+clearRevLocal) + " DH")
        $("#returned").text(returned + " Parcel")
        $("#refused").text(refused + " Parcel")

        $('.row-checkbox').on('click', function () {
            if ($(".row-checkbox:checked").length > 0) {
                $('#markAsReturned').show();
                $('#markAsReturned').addClass("return-button")
            }
            else {
                $('#markAsReturned').hide();
                $('#markAsReturned').removeClass("return-button");
            }


        });
        this.api().rows().data().each(function (e) {
            // console.log(e);

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

        });
    }

});


    // Initialize the second DataTable only after the first one is ready
 var table1 =   $('table#t2').DataTable({
      
    responsive: true,
    searching: true,
    ajax: {
        url: "/api/parcelsLocal",
        type: "GET",
        dataSrc: function (json) {
            return json;
        },
        data: function (d) {
            d.created_at = [start, end];
            d.magasin = $('#magasin-filter').val();
      d.company_id = $('#company-filter').val();
            d.delivery = $('#delivery-filter').val();
            d.delivery_date = $('#delivered-today-filter').is(':checked')
                ? $('#delivered-today-filter').val()
                : null;
        }
    },

    order: [
        [1, 'asc']
    ],
    "columnDefs": [

        { "orderable": false, "targets": 0 } // Disable sorting on the "Status" column
    ],
    paging: true,
    pageLength: 5,
    lengthMenu: [
        [5,10, 25, 50,],
        [5,10, 25, 50, 'All']
    ],
    pagingType: 'simple_numbers',


    columns: [
    {
        data: "id",
        render: function (data, type, row) {
            return `           
                                          
                                           <p class="badge badge-info"><i class="fa-solid fa-motorcycle"></i>
                                               ${row.delivery.name} </p>
                                   `


        }
    }, {
        data: "company_name",
        
        render: function (data, type, row) {
            return row.company_name
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
            return `<p style="background-color: #28a745; color: white; padding: 8px 12px; border-radius: 12px; font-size: 14px; font-weight: bold; display: inline-block; text-align: center; min-width: 100px;">
             ${row.status} 
            </p> 
            <br> 
             <span style="font-size: 12px; color: #343a40;">${new Date(row.delivery_date).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: '2-digit' })}</span>
            `
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
    }, {
        data: "totale_d"
    },
    {
        data: 'id',
        render: function (data, type, row) {
            let parcel = JSON.stringify(row);
            // console.log(parcel);


            return `
                               <div class="btn-group">
                                  <div class="dropdown">
                      <button class="btn btn-light" style='border-radius: 50px;' type="button" data-toggle="dropdown" id="dropdownMenuButton${row.id}">
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                     
                 <li><a class="dropdown-item" href="/parcels/delete_local/${row.id}"><i class="fas fa-trash-alt"></i> Delete</a></li>
                      </ul>
                    </div>
                               </div>
                               `;
        }
    }
    ],
       
    
    });

$('#filter-btn').on('click', function () {
    table.ajax.reload();
    table1.ajax.reload();
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
         table1.ajax.reload();
    } else {
        $('#delivered-today-filter').val("");

        // Reload the DataTable with the filter applied
        table.ajax.reload();
        table1.ajax.reload();
    }
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
    table1.ajax.reload();
});
// Select all functionality
$('#select-all').on('change', function () {
    $('.row-checkbox').prop('checked', this.checked);
    if ($(".row-checkbox:checked").length > 0) {
        $('#markAsReturned').show();
        $('#markAsReturned').addClass("return-button")
    }
    else {
        $('#markAsReturned').hide();
        $('#markAsReturned').removeClass("return-button");
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
$("button#markAsReturned").click(function () {
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
document.getElementById("downloadExcel").addEventListener("click", function () {
    // Define the headers for the Excel file
    const headers = [["Destinataire", "Telephone", "Ville", "Prix"]];

    // Create a worksheet with only the headers
    const worksheet = XLSX.utils.aoa_to_sheet(headers);
    const borderStyle = {
        top: { style: "thin", color: { rgb: "000000" } }, // Black border
        bottom: { style: "thin", color: { rgb: "000000" } },
        left: { style: "thin", color: { rgb: "000000" } },
        right: { style: "thin", color: { rgb: "000000" } },
    };
    // Apply styles to the headers (optional)
    const headerStyle = {
        font: { bold: true, color: { rgb: "000000" } }, // Black text
        alignment: { horizontal: "center", vertical: "center", wrapText: true }, // Centered with text wrapping
        fill: { fgColor: { rgb: "F28B82" } }, // Light red background
        border: borderStyle,
    };
    headers[0].forEach((_, colIndex) => {
        const cellAddress = XLSX.utils.encode_cell({ r: 0, c: colIndex }); // Get cell address
        worksheet[cellAddress].s = headerStyle; // Apply style
    });
    const cellStyle = {
        font: { italic: true, color: { rgb: "0000FF" } }, // Italic blue text
        alignment: { horizontal: "center", vertical: "center" },
        border: {
            top: { style: "bold", color: { rgb: "orange" } }, // Red border
            right: { style: "bold", color: { rgb: "orange" } }, // Red border
            bottom: { style: "bold", color: { rgb: "orange" } }, // Red border
            left: { style: "bold", color: { rgb: "orange" } },
        },
    };
    worksheet['A1'].s = {
        font: { bold: true, color: { rgb: 'FF0000' } }, // Red bold text
        fill: { fgColor: { rgb: 'FFFF00' } }, // Yellow background
    };
    for (let i = 1; i <= 50; i++) {
        const cellAddresses = [`A${i}`, `B${i}`, `C${i}`, `D${i}`];
        cellAddresses.forEach((address) => {
            if (!worksheet[address]) {
                worksheet[address] = { v: " " }; // Initialize the cell if it doesn't exist
            }
            worksheet[address].s = cellStyle; // Apply the style
        });
    }
    worksheet["!cols"] = [
        { width: 20 }, // Width for "Destinataire"
        { width: 15 }, // Width for "Telephone"
        { width: 12 }, // Width for "Ville"
        { width: 10 }, // Width for "Prix"
    ];

    worksheet["!rows"] = [
        { hpx: 30 }, // Width for "Destinataire"
    ];
    // Create a workbook and append the styled worksheet
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Headers Only");

    // Trigger download of the Excel file
    XLSX.writeFile(workbook, "HeadersOnly.xlsx");
});