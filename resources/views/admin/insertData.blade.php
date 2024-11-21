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
<script src="{{asset("assets/js/excelExporting.js")}}">
   
</script>
