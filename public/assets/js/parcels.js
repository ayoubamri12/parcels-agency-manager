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
cb(moment('2024-11-01'), moment());
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
        { "orderable": false, "targets": 4 } // Disable sorting on the "Status" column
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
        data: "id",
        render: function (data, type, row) {
            return `           
                                 <p>${row.id}</p>
                                 <p class="badge badge-info"><i class="fa-solid fa-motorcycle"></i>
                                     ${row.delivery.name} </p>
                         `


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
            return `            
                        
                                 ${row.status == 'livré' ? `<p class="badge badge-success">${row.status} <br> ${row.delivery_date}</p>` : `<p class="badge badge-warning p-1">${row.status} <br/><br/>${row.status == "Reporté" && "comment : " + row.comment}</p>
                                     <small class="" style="color:gray;">
                                    `
                }
                                
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
    },
    {
        data: 'id',
        render: function (data, type, row) {
            return `
                     <div class="btn-group">
                         <!-- Action Dropdown Button -->
                         <button class="btn btn-sm dropdown-toggle"  data-bs-toggle="dropdown"  id="dropdownMenuButton${row.id}" type="button" style="background-color: #fe8a39; color: white;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="bx bx-dots-horizontal-rounded"></i>
                         </button>
             
                         <!-- Dropdown Menu for Actions -->
                         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${row.id}">
                             <!-- Details Action -->
                             <li>
                                 <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#detailsModal${row.id}">
                                     <i class="bx bx-info-circle mr-2"></i> Details
                                 </a>
                             </li>
             
                             <!-- Update State Action -->
                             <li>
                                 <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateStateModal${row.id}">
                                     <i class="bx bx-refresh mr-2"></i> Update State
                                 </a>
                             </li>
              <li>
                                 <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateStatusModal${row.id}">
                                     <i class="bx bx-refresh mr-2"></i> Update Status
                                 </a>
                             </li>
                             <!-- Remove Action -->
                             <li>
                                 <a class="dropdown-item text-danger" href="#">
                                     <i class="bx bxs-trash mr-2"></i> Remove
                                 </a>
                             </li>
                         </ul>
                     </div>
             
                     <!-- Details Modal -->
                     <div class="modal fade" id="detailsModal${row.id}" tabindex="-1" aria-labelledby="detailsModalLabel${row.id}" aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="detailsModalLabel${row.id}">Details for ${row.id}</h5>
                                     <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
                                 </div>
                                 <div class="modal-body">
                                     <!-- Details content here, customize as needed -->
                                     <p><strong>id:</strong> ${row.id}</p>
                                     <p><strong>Description:</strong> ${row.phone}</p>
                                     <!-- Add more details fields here -->
                                 </div>
                             </div>
                         </div>
                     </div>
             
                     <!-- Update State -->
                     <div class="modal fade" id="updateStateModal${row.id}" tabindex="-1" aria-labelledby="updateStateModalLabel${row.id}" aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="updateStateModalLabel${row.id}">Update State for ${row.id}</h5>
                                     <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
                                 </div>
                                 <div class="modal-body">
                                 <!-- Details content here, customize as needed -->
                                     <div class='border-bottom pb-3 my-3'>
                                     <p><strong>id:</strong> ${row.id}</p>
                                     <p><strong>Description:</strong> ${row.phone}</p>
                                     <p><strong>Current State:</strong> ${row.state}</p>
                                     <p><strong>Current Status:</strong> ${row.status}</p></div>
                                     <!-- Add more details fields here -->
                                     <!-- Update form for new state and comment -->
                                     <form id="updateForm${row.id}">
                                         <div class="mb-3">
                                             <label for="newState${row.id}" class="form-label">New State</label>
                                             <input type="text" class="form-control" id="newState${row.id}" placeholder="Enter new state">
                                         </div>
                                         <button type="submit" class="btn btn-primary">Update</button>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                      <div class="modal fade" id="updateStatusModal${row.id}" tabindex="-1" aria-labelledby="updateStatusModalLabel${row.id}" aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="updateStatusModalLabel${row.id}">Update State for ${row.id}</h5>
                                     <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close"> <i class="fas fa-times"></i></button>
                                 </div>
                                 <div class="modal-body">
                                  <div class='border-bottom pb-3 my-3'>
                                     <p><strong>id:</strong> ${row.id}</p>
                                     <p><strong>Description:</strong> ${row.phone}</p>
                                     <p><strong>Current State:</strong> ${row.state}</p>
                                     <p><strong>Current Status:</strong> ${row.status}</p></div>
                                     <!-- Update form for new state and comment -->
                                     <form id="updateForm${row.id}">
                                         <div class="mb-3">
                                             <label for="newStatus${row.id}" class="form-label">New State</label>
                                             <input type="text" class="form-control" id="newStatus${row.id}" placeholder="Enter new status">
                                         </div>
                                         <div class="mb-3">
                                             <label for="comment${row.id}" class="form-label">Comment</label>
                                             <textarea class="form-control" id="comment${row.id}" rows="3" placeholder="Enter comment"></textarea>
                                         </div>
                                         <button type="submit" class="btn btn-primary">Update</button>
                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                     `;
        }
    }
    ],
    initComplete: function () {
        this.api().columns().every(function () {
            var column = this;
            $('td', column.header()).each(function () {
                $(this).append('<span class="sort-icon"></span>');
            });
        });
        this.api().rows().every(function () {
            var row = $(this.node());
            var data = this.data();
            var qrious = new QRious({
                element: row.find('canvas.qr_code')[0],
                value: data.qr_code,
                size: 200,
                foreground: '#ffa500',
            });
            //   console.log(qrious);
        });
        $(".row-checkbox").on('change', function () {
            console.log($('#shipbtn'));
            if ($(".row-checkbox:checked").length > 0)
                $('#shipbtn').show()
            else
                $('#shipbtn').hide()

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
    if ($(".row-checkbox:checked").length > 0)
        $('#shipbtn').show()
    else
        $('#shipbtn').hide()

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
