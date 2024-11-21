 // JavaScript to handle dropdown selection and file upload appearance

 document.getElementById('deliverymanSelect').onchange = function() {
    const fileUpload = document.getElementById('fileUpload');
    fileUpload.classList.add('activeFile');
}

// Display selected file name
document.getElementById('fileInput').addEventListener('change', function() {
    const fileInfo = document.getElementById('fileInfo');
    fileInfo.textContent = event.target.files[0] ? document.getElementById('validation').classList.add(
        'activebtn') : 'No file chosen';
});
let retrievedComapnies = [];
fetch('/api/companies').then(res => res.json()).then(res => {
    res.map(e => retrievedComapnies.push(e))
})

let retrievedCities = [];
fetch('/api/cities').then(res => res.json()).then(res => {
    res.map(e => retrievedCities.push(e))
})
const handleFile = () => {
    const file = document.getElementById('fileInput').files[0];
    if (!file) return;
    $('#loaderHolder').show();

    const reader = new FileReader();
    reader.onload = (e) => {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, {
            type: 'array'
        });
        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];

        // Convert sheet to JSON format
        const rows = XLSX.utils.sheet_to_json(worksheet, {
            header: 1
        });
        const currentYear = new Date().getFullYear();
        // Filter rows based on conditions
        let parcelDate;
        let id_camp;
        const filtredComp = rows.filter((row, index) => {
                const check = row[1] ? true : !row[7] ? false : true;
                
                return index !== 8 && check; // Skip header row and empty rows
            })
            .map(row => {
                // Format date by concatenating with current year  
                // console.log(row[2]);

                if (row[1] !== undefined) {
                    parcelDate = `${currentYear}-${String(row[1]).replace("/","-")}`
                    return {};
                }
                // console.log(row[5]);
                // console.log(row[14]);
                // console.log(retrievedCities[0].deliveriyman_cities);
                // console.log(parcelDate);
                
                const dlvCity = retrievedCities.map(e => {
                    let city = e.deliveriyman_cities.find(e => e.delivery_id == document.getElementById(
                        'deliverymanSelect').value) || {};
                    if (Object.keys(city).length)
                        return e;
                });
                const filtredData = retrievedComapnies.find((company => {

                   /* if (!isNaN(Number(row[6])))
                        return company.name == "CATHEDIS"
                    else if (String(row[6]).toUpperCase() != "D PRO" && String(row[6])
                        .toUpperCase() != 'TAWSSIL' && String(row[6]).toUpperCase() !=
                        'SPEEDEX' && String(row[6]).toUpperCase() !=
                        'FREECOMA' && String(row[6]).toUpperCase() !=
                        'ANAVA' && String(row[6]).toUpperCase() !=
                        'ATLAS' && String(row[6]).toUpperCase() !=
                        'MIMOUN')
                        return company.name == "CHARK"
                    else
                        return company.name == row[6].toUpperCase();*/
                    if(! row[6])
                     return company
                    if (!isNaN(Number(row[6])))
                        return company.magasin == "CATHEDIS"
                    // console.log(company.magasin == row[6]);
                    
                   return company.magasin == row[6]
                }))
                //   console.log(filtredData.magasin);
                //   console.log(retrievedComapnies);

                return {
                    parcel_date: parcelDate || new Date(),
                    phone: row[4] != undefined ? row[4] : "067515",
                    price: row[7],
                    status: row[11] || "encours de livraison",
                    state: row[15] || "encours de livraison",
                    comment:row[12],
                    company_id: filtredData.company_id,
                    delivery_id: document.getElementById('deliverymanSelect').value,
                    city: row[3] || dlvCity[0].city,
                    marked_as_retourn: row[16],
                    company_name: row[6] || "cmp",
                };

            });
        // Display filtered data
        // console.log('Filtered Data:', filtredComp);
        sendToBackend(filtredComp);
        // Send the filtered data to the backend
    };
    reader.readAsArrayBuffer(file);
}

function sendToBackend(filteredData) {
    // Use fetch API to send data to the Laravel backend
    const data = filteredData.filter(e => Object.keys(e).length > 0)
    console.log(data);
    $.ajax({
        url: '/api/parcels/store',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            data: data
        },
        success: function(response) {
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
        },
        error: function(xhr, status, error) {
            $('#loaderHolder').hide();
        }
    });

}