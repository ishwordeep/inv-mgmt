

@extends(backpack_view('blank'))

@section('content')

<div class="container">
    <div class="row">
        <div class="card w-100 p-2">
            <h3 class="text-center">
                {{$data['title']}}
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="card w-100 p-2">
            <table class="table table-bordered ">
                <thead class="{{ isset($data['specifiedColor'])? $data['specifiedColor'] : ''}}" style="font-weight: bold;">
                    <tr>
                        <th scope="col">S.N.</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Available Qty</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Tomato</td>
                        <td>Vegetable</td>
                        <td>123</td>
                        <td>
                            <i class="fa-solid fa-eye px-2"></i>
                            @if(isset($data['po']))
                            <a href="{{backpack_url('purchase-order/create')}}"><span class="badge badge-primary">PO</span></a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
