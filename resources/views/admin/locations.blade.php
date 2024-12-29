
<div style="background-color: white; padding: 10px; width: 100%;">
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">Parcel Action</h5>
                    <button type="button" class="btn-close btn btn-info" style="width: 10%;" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" id="modalContent">
                    <form id="merge" action='' method='post'>
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                          <label for="status" class="form-label">Status</label>
                          <select id="status" name="dlvm" class="form-control my-2" required >
                           <option value="">Select Deliveryman</option>
                            @foreach ($deliverymen as $d)
                           <option value="{{$d->id}}">{{$d->name}}</option>
                                
                            @endforeach
                          </select>
                          <div class="dropdown-assign mb-2">
                            <button type="button" class="btn btn-light px-4 border">Delivering Company</button>
                            <div class="dropdown-content">
                                <div id="first" class="checkbox-list1">
                                    @foreach ($companies as $c)
                                        <label class="row">
                                            <div class="col-3">
                                                <input type="checkbox"  name="cps[]"
                                                    value="{{ $c->id }}">{{ $c->name }}
                                            </div>
                                            <div class="col-7">
                                                <input type="number" required disabled name="commission[]"
                                                    placeholder="commission (%)" class="form-control">
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        </div>
                        
                                        <button type="submit" class="btn btn-primary">Save</button>
                
                      </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <h1>Locations</h1>
    {{-- <div class="filters">

        <button id="delete-btn"  class="delete-btn">
            <i class="fas fa-trash"></i>
        </button>

    </div> --}}
    <div class="main-datatable table-responsive" style="width: 100%; height: fit-content;">
        <table class="table table-hover cust-datatable dataTable " id="table" style="width: 100%">
            <thead>
                <tr>
                    <th><input id="select-all" type="checkbox" /></th>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Deliverymen Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
     $(".dropdown-assign .btn").on("click", function(e) {
            $(this).next(".dropdown-assign .dropdown-content").toggleClass("show")
            console.log( $(this).next(".dropdown-assign .dropdown-content"));
        });
   
</script>

