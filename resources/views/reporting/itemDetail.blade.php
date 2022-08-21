
  @extends(backpack_view('blank'))
  @section('content')
  <div class="container-fluid">
    <h2 class="text-center">Item Overview </h2>
    <div class="row">
      <div class="col">
        <div class="card shadow-lg">
          <div class="card-header ">
            <div class="row justify-content-center">
              <div class="col-md-6 input-group ">
                <span class="scan-header mx-3 mt-2"> Select an item</span>
                <input type="text" class="form-control rounded-pill" id="item_name" placeholder="Enter item name Here.." size="10" required>
              </div>
            </div>
          </div>
          <div class="card-body" id="item-details-content">
           <p class="text-center">Please enter item name to fetch informations</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
  

@section('after_scripts')
  @include('invScripts.itemdetails')
@endsection
