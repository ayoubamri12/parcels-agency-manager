<style>
    .cntr-select {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .selection-container {
        text-align: center;
        padding: 30px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        width: 80%;
    }

    /* Modern Dropdown Styles */
    .custom-select {
        width: 100%;
        padding: 10px 20px;
        font-size: 1em;
        border-radius: 25px;
        border: 2px solid #007bff;
        color: #007bff;
        background: #f0f8ff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-select:hover {
        background: #d1d1d1;
    }

    /* Animated File Upload Field */
    .file-upload {
        margin-top: 20px;
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .file-upload.activeFile {
        display: block;
        opacity: 1;
        animation: fadeIn 0.5s ease;
    }

    #validation {
        margin-top: 20px;
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    #validation.activebtn {
        display: block;
        opacity: 1;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .file-upload input[type="file"] {
        display: none;
    }

    .file-upload label {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1em;
        color: #ffffff;
        background-color: #28a745;
        border-radius: 25px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .file-upload label:hover {
        background-color: #218838;
    }

    .file-upload .file-info {
        margin-top: 10px;
        font-size: 0.9em;
        color: #555;
        font-style: italic;
    }
</style>
<x-layout>
    <div class="cntr-select">
        <div id="loaderHolder" style="display: none" class="loading">
            <p class="loader"></p>
        </div>
        <div class="selection-container">
            <h5 class="mb-3">Choose a Deliveryman</h5>
            <select id="deliverymanSelect" class="custom-select form-control">
                <option selected disabled>-- Select Deliveryman --</option>
                @foreach ($deliverymen as $deliveryman)
                    <option value="{{ $deliveryman->id }}">{{ $deliveryman->name }}</option>
                @endforeach
            </select>

            <div id="fileUpload" class="file-upload">
                <label for="fileInput"><i class="fas fa-file-upload"></i> Upload Excel File</label>
                <input type="file" id="fileInput" accept=".xlsx">
                <div class="file-info" id="fileInfo">No file chosen</div>
            </div>
            <div id="validation">
                <button class="btn form-control"
                    style="background: orange; border-radius: 5px; color: white; font-weight: bold; width: 25%;"
                    onclick="handleFile()">Validate</button>
            </div>
        </div>


        </script>
    </div>
</x-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
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
                    if (row[1] !== undefined) {
                        parcelDate = `${currentYear}-${String(row[1]).replace("/","-")}`
                        return {};
                    }
                    console.log(row[5]);
                    // console.log(row[14]);
                    const dlvCity = retrievedCities.map(e => {
                        let city = e.deliveries.find(e => e.id == document.getElementById(
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
                        if (!isNaN(Number(row[6])))
                            return company.magasin == "CATHEDIS"
                       return company.magasin == row[6]
                    }))
                    // console.log(filtredData);

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
</script>
