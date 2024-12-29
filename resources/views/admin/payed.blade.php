<link rel="stylesheet" href="{{ asset('assets/css/parcels.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<style>
    .dt-buttons .buttons-excel {
        background-color: rgb(0, 124, 128) !important;
        /* Blue for Excel */
        border-radius: 50px !important;
        color: #fff !important;
    }

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





    .table-responsive {
        overflow-x: visible;
    }

    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 10000;

    }

    /* Toast Styling */
    .toast {
        display: flex;
        align-items: center;
        background: rgba(242, 220, 76, 0.9);
        /* Foggy Color */
        color: #fff;
        padding: 15px 20px;
        border-radius: 8px;
        width: 350px;
        box-shadow: 0 4px 15px rgba(209, 160, 62, 0.8);
        opacity: 0;
        transform: translateX(100%);
        animation: slideIn 0.5s forwards, fadeOut 0.5s 3.5s forwards;
        position: relative;

    }

    /* Slide In and Fade Out Animations */
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    /* Timer Bar */
    .toast::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: green;
        /* Yellow color for timer */
        animation: timer 3.5s linear forwards;
    }

    @keyframes timer {
        from {
            width: 100%;
        }

        to {
            width: 0;
        }
    }

    /* Icon Styling */
    .toast .icon {
        font-size: 1.5rem;
        margin-right: 15px;
    }

    /* Close Button Styling */
    .toast .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
    }

    /* Message Styling */
    .toast .message {
        flex: 1;
        font-size: 1rem;
        line-height: 1.4;
    }

    @media (max-width: 768px) {

        .table-responsive {
            overflow-x: scroll;
        }

        /* Increase canvas size for charts */
        /* Allows height to adjust naturally */


        #table-cntr {
            width: 100vw !important;
        }



        table {
            width: 150%;
            /* Adjust width as needed to show half */
        }
    }
</style>
<x-layout>
    <div id="cntr" class="mx-auto mt-5 pb-3" style="width: 100%;">

        <div class="toast-container" id="toastContainer"></div>
        @if (session('updated'))
            <script>
                // Function to Show Toast Notification

                const toastContainer = document.getElementById('toastContainer');
                const toast = document.createElement('div');
                toast.classList.add('toast');

                toast.innerHTML = `
                <span class="icon" style='color:green;'><i class="fas fa-exclamation-circle"></i></span>
                <div class="message">
                    <strong style='color:green;'>Updated !</strong><br>
                    the updating operation completed successfuly
                </div>
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>
            `;

                // Append Toast to Container
                toastContainer.appendChild(toast);

                // Remove Toast After 3.5 Seconds
                setTimeout(() => {
                    toast.remove();
                }, 5500);
            </script>
        @endif

        <div id="loaderHolder" style="display: none" class="loading">
            <p class="loader"></p>
        </div>


        <div class="row mb-4 p-3"
            style="border-top:4px solid greenyellow ;border-bottom:4px solid purple ;border-radius: 2px ; width:95%; margin:auto; background-color: #fff;">
            <div class="col-md-3">
                <input type="text" class="form-control" id="code-filter" placeholder="Region">
            </div>


            {{-- <div class="col-md-3">
                <select class="form-control" id="status-filter">
                    <option value="">Statut</option>
                    <option value="en cours de livraison">En cours</option>
                    <option value="livré">Livré</option>
                    <option value="Raporté">Raporté</option>
                    <option value="Annulé">Annulé</option>
                    <option value="Refusé">Refusé</option>
                    <option value="En voyage">En voyage</option>
                    <option value="Pas de reponse">Pas de reponse</option>
                </select>
            </div> --}}
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



        <div id="table-cntr"
            style="border-top:4px solid orange ;border-radius: 2px ; box-shadow: 0px 3px 3px rgb(175, 175, 175) ; background-color: white; padding: 5px; width: 95%; margin: auto;">
            <div class="main-datatable table-responsive p-4">

                <div class="btn-group my-1 mx-auto">
                    <button class="mx-3 btn btn-info" id="markAsPayed" style="display: none;">
                        <i class="fas fa-hand-holding-usd"></i> Payed
                    </button>

                </div>
                <table id="example" class="table table-bordered table-hover cust-datatable dataTable dsiplay">
                    <thead>
                        <tr>
                            <th id="checks"><input type="checkbox" id="select-all"></th>
                            <th>code d&apos;envoi</th>
                            <th>Destinataire</th>
                            <th>Date d&apos;expedition</th>
                            <th>Telephone</th>
                            <th>Nom du magasin</th>
                            <th>Etat</th>
                            <th>Status</th>
                            <th>Ville</th>
                            <th>Prix</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layout>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/svg2pdf.js/1.4.1/svg2pdf.min.js"></script>

<script>
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
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                'month')],
            'This Year': [moment().startOf('year'), moment()],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf(
                'year')],
            'From 2022 to Now': [moment('2022-01-01'), moment()]
        },

    }, cb);
    cb(moment('2024-11-01'), moment());
    var table = $('table#example').DataTable({
        responsive: true,
        searching: true,
        ajax: {
            url: "/api/payed_parcels",
            type: "GET",
            dataSrc: function(json) {
                return json;
            },
            data: function(d) {
                d.code = $('#code-filter').val();
                d.created_at = [start, end];
                d.magasin = $('#magasin-filter').val();
                d.company_id = $('#company-filter').val();
                d.delivery = $('#delivery-filter').val();
            },
            beforeSend: function() {
                $('#loaderHolder').show();
            },
            complete: function() {
                $('#loaderHolder').hide();
            }
        },

        order: [
            [1, 'asc']
        ],
        "columnDefs": [

            {
                "orderable": false,
                "targets": 0
            } // Disable sorting on the "Status" column
        ],
        dom: 'Bfrtip', // Enable buttons
        buttons: [{
            text: 'Download Invoice',
            className: 'buttons-excel',
            action: function() {
                generatePDF(table.rows({
                    search: 'applied'
                }).data().toArray());
            }
        }],
        paging: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All']
        ],
        pagingType: 'simple_numbers',

        columns: [{
                data: null,
                render: function(data, type, row) {
                    return `<input type="checkbox" value=${row.id} class="row-checkbox">`;
                }
            },
            {
                data: "code",
                render: function(data, type, row) {
                    return `           
                                 ${row.code}
                                
                         `


                }
            },
            {
                data: 'client_name',
                render: function(data, type, row) {
                    return `${row.client_name}`
                }
            },
            {
                data: 'created_at',
                render: function(data, type, row) {
                    var createdAt = new Date(data);
                    return createdAt.toLocaleDateString();
                }
            },
            {
                data: "phone",
                render: function(data, type, row) {
                    return `           
                          
                                 <p>${row.phone}</p>
                         `


                }
            },
            {
                data: "company_name"
            },
            {
                data: 'state',
                render: function(data, type, row) {
                    return `            
                                 ${row.state == 'Payé' ? `<p class="badge badge-success p-1">${row.state}</p>` : ` <p class="badge badge-primary">${row.state}</p>`}       
                         `
                }
            },
            {
                data: 'status',
                render: function(data, type, row) {
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

        ],
        initComplete: function(s, j) {
            this.api().columns().every(function() {
                var column = this;
                $('td', column.header()).each(function() {
                    $(this).append('<span class="sort-icon"></span>');
                });
            });
        },
    });
    $('#refresh-btn').on('click', function() {
        $('#code-filter').val('');
        $('#magasin-filter').val("");

        $('company-filter').val("");
        $('#delivery-filter').val("");
        cb(moment('2024-08-01'), moment())
        $('#magasin-filter').val('');
        table.ajax.reload();
    });

    $('#filter-btn').on('click', function() {
        table.ajax.reload();
    });

    function  generatePDF(data) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
   
        // Add Logo
     
        const logoUrl = `https://salhiderlivery.com/assets/images/aloo-salhi-logo-new.png`; // Replace with your logo URL
        doc.addImage(logoUrl, 'PNG', 10, 5, 30, 30);

        // Add Title
        doc.setFontSize(18);
        doc.text('Aloo Salhi', 40, 20);
        doc.setFontSize(12);
         //const today = new Date();
        const formattedDate =start==end ?start:start+"=>"+end //|| today.toISOString().split('T')[0];
        doc.text(formattedDate, 40, 30);
        doc.setFontSize(8);
        // Add Icon
        

        // Add Table
        const headers = [
            [ 'Destinataire', 'Téléphone', 'Nom du magasin', 'État', 'Status', 'Ville', 'Prix']
        ];

        const rows = data.map(parcel => [
           
            parcel.client_name,
            parcel.phone,
            parcel.company_name,
            parcel.state,
            parcel.status,
            parcel.city,
            `${parcel.price.toFixed(2)} DH`
        ]);

        doc.autoTable({
            startY: 40,
            head: headers,
            body: rows,
            styles: {
                fontSize: 10
            },
            headStyles: {
                fillColor: [41, 128, 185]
            },
            bodyStyles: {
                textColor: 50
            }
        });

        // Calculate Total Price
        const totalPrice = data.reduce((sum, parcel) => sum + parseFloat(parcel.price), 0);

        // Add Footer Row
        const finalY = doc.lastAutoTable.finalY;
        doc.setTextColor(0, 0, 0); // Black text
        doc.setFontSize(12);
        doc.text(`Total: ${totalPrice.toFixed(2)} DH`, 105, doc.lastAutoTable.finalY + 10, null, null, 'center');

        // Save the PDF
        doc.save('Invoice.pdf');
    }
</script>
