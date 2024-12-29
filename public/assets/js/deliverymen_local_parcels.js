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
    startDate:  moment(),
    endDate: moment(),
    ranges: {

        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 3 Days': [moment().subtract(3, 'days'), moment()],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year': [moment().startOf('year'), moment()],
        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        'From 2024 to Now': [moment('2024-12-01'), moment()]
    },

}, cb);
let [st, endDate] = [moment(), moment()] 
cb(st, endDate);
var table = $('table#example').DataTable({
    responsive: true,
    searching: true,
    ajax: {
        url: "/api/parcels_per_deliverymen_local/" + window.Laravel.userId,
        type: "GET",
        dataSrc: function (json) {
            return json;
        },
        data: function (d) {
            d.created_at = $('#delDate-filter').val() ? null : [start, end];
            d.state = $('#state-filter').val();
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
    order: [
        [1, 'asc']
    ],
    "columnDefs": [
        { "orderable": false, "targets": 0 },
        { "orderable": false, "targets": 9 } // Disable sorting on the "Status" column
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
            console.log(parcel);


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
       
        let rev = 0, clearRev = 0, clearRevenueDelivery = 0,totale=0;

        const retrievedCities = await fetch('/api/cities').then(e => e.json());
        const retrievedComps = await fetch('/api/companies_commissions').then(e => e.json());
        //  console.log(retrievedComps);

        this.api().rows({ search: 'applied' }).data().map(function (e, i) {

            if (e.status == "Livré") {
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
                    console.log(city);
                    return c.city_id == city.id && c.company_id == e.company_id
                });
                totale += e.totale_d
                rev += e.price
                // console.log(compCom.commission);
                 console.log(deliveryCom.commission);
                clearRev += (e.totale_d * (compCom.commission - deliveryCom.commission))
                clearRevenueDelivery += (e.totale_d * deliveryCom.commission)
            }


        })

        $("#deliveredQuantity").text(totale + " Parcel")
        $("#totalRevenue").text(rev + " DH")
        $("#clearRevenueDelivery").text(clearRevenueDelivery + " DH")
        $("#clearRevenue").text(clearRev + " DH")


        // this.api().rows().data().each(function (e) {
        //     console.log(e);

        //     $(`#det${e.id}`).on("click", function () {
        //         showModal("details", e)
        //         console.log("det");

        //     })
        //     $(`#status${e.id}`).on("click", function () {
        //         if (!window.Laravel.userType && e.status === 'Livré') {
        //             showModal("statusUnabling", e)
        //             console.log(window.Laravel.userType);
        //             return
        //         }
        //         showModal("modifyStatus", e)
        //     });

        //     $(`#del${e.id}`).on("click", function () {
        //         showModal("delete", e)
        //     })

        // })
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
    $('company-filter').val("");
    $('#delivery-filter').val("");
    cb(moment(), moment())
    $('#delDate-filter').val('');
    table.ajax.reload();
});
// Select all functionality

$(".dropdown .btn").on("click", function(e) {
    $(this).next(".dropdown-content").toggleClass("show")
    console.log(this);
});

    // Save button click event
    $('#saveDataBtn').click(function () {
        let notValide = false;
        $('.form-control').removeClass('is-invalid');
        let selectedCompany = $('input[name="cps"]:checked');
            if (!selectedCompany.val()) {
                notValide = true;
                $('.checkbox-list1').parents(".dropdown").after(
                    '<div class="error" style="color: red;">Please select at least one Company.</div>'
                );
            }
        // if (!$('#nomMagasin').val()) {
        //     $('#nomMagasin').addClass('is-invalid');
        //     notValide = true;
        // }
        if (!$('#prix').val()) {
            $('#prix').addClass('is-invalid');
            notValide = true;
        }
        if (!$('#totaleLivre').val()) {
            $('#totaleLivre').addClass('is-invalid');
            notValide = true;
        }
        if (notValide) {
            return
        }
        // Gather form data
        const formData = {
            company_name: selectedCompany.val(),
            price: $('#prix').val(),
            totaleLivre: $('#totaleLivre').val(),
        };

        // Send data to API
        $.ajax({
            url: '/parcelsAdd/' + window.Laravel.userId, // Replace with your API endpoint
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            beforeSend: function () {
                $('#loaderHolder').show();
            },
            complete: function () {
                $('#loaderHolder').hide();
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
                // $('#dataModal').modal('hide');
                $('#addDataForm')[0].reset(); // Reset form
            },
            error: function (error) {
                console.error('Error saving data:', error);
                alert('Failed to save data. Please try again.');
            },
        });
    });

const dcom = async (data)=>{
    let  clearRevenueDelivery = 0,rev=0,clearRev=0;
    const retrievedCities = await fetch('/api/cities').then(e => e.json());
    const retrievedComps = await fetch('/api/companies_commissions').then(e => e.json());
    data.map(e=>{
        
    
        if (e.status == "Livré") {
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
                console.log(city);
                return c.city_id == city.id && c.company_id == e.company_id
            });
            rev += e.price
            // console.log(compCom.commission);
            // console.log(deliveryCom.commission);
            clearRev += (e.totale_d * (compCom.commission - deliveryCom.commission))
            clearRevenueDelivery += (e.totale_d * deliveryCom.commission)
        }
})
// let ct = data.find(e=>e.delivery_id==$('#delivery-filter').val())
// console.log(ct);


//  console.log(retrievedComps);
return [rev,clearRevenueDelivery,clearRev]

}
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
  const formattedDate =start==end ?start:start+"=>"+end 
 doc.text(formattedDate, 40, 30);
 doc.setFontSize(8);
  doc.text(`Livreur : ${data[0].delivery.name}`, 160, 25);
 doc.setFontSize(7);
// Add Icon


// Add Table
const headers = [
  [ 'Nom du magasin', 'État', 'Status',"Totale",'Ville', 'Prix']
];
let totD = 0;
const rows = data.map(parcel => {
     totD+=parcel.totale_d
   return [
 
  
  parcel.company_name,
  parcel.state,
  parcel.status,
   parcel.totale_d,
  parcel.city,
  `${parcel.price.toFixed(2)} DH`
 
]});

rows.push(["","","","","","Totale Livré :  "+totD+" Colis"])
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



dcom(data).then(com=>{
  // Calculate Total Price
const finalY = doc.lastAutoTable.finalY;
    const [rev,CrevL,CrevA]=com
doc.autoTable({
  startY:doc.lastAutoTable.finalY+15 ,
  startX:100,
  body:[ ["totale",rev+" DH"],
    ["to be paid",rev-CrevL+" DH"],
    [`Commission ${data[0].delivery.name}`,CrevL+" DH"], 
   window.Laravel.userType && ["Salhi Commission",CrevA+" DH"]
], 
  styles: {
      fontSize: 10
  },
 
  bodyStyles: {
      textColor: 50,
      
  },
 
});
 doc.save('Invoice.pdf');
      
})


// Add Footer Row
// const finalY = doc.lastAutoTable.finalY;
// doc.setTextColor(0, 0, 0); // Black text
// doc.setFontSize(12);
// doc.text(`Total: ${totalPrice.toFixed(2)} DH`, 105, doc.lastAutoTable.finalY + 10, null, null, 'center');

// Save the PDF

}