@extends(backpack_view('blank'))

{{-- @section('header')
    @include('customViews.partialViews.header_content');
@endsection --}}

@section('content')
    <form id="stockEntryForm" action="{{ url($crud->route) }}" method="POST">
        @csrf
        <div class="card main-container ">
            <div class="row m-3">

                <div class=" col-sm-4">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        <select class="form-select"  id="inputGroupSelect01">
                          <option selected>Choose...</option>
                          <option value="1">one</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                </div>

                <div class=" col-sm-4 ">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Entry Date</span>
                        <input type="date" id="stockDateAD" name='entry_date' value="" class="form-control"
                            placeholder="Entry Date">
                    </div>
                </div>
               

                <div class=" col-sm-4 ">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Item Wise Discount</span>

                        <input type="checkbox" checked="true" name="" id="" class="">
                    </div>
                </div>
            </div>            
        </div>

        {{-- End of upper form filter design? --}}
        <div class="table-responsive">

        </div>


    </form>
@endsection
