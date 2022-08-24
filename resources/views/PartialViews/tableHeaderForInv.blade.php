@php 
    $method = $crud->getActionMethod();
    if($method == 'edit')
        $invType = $data['invType'];
@endphp
<tr class="text-white" style="background-color: #192840">
    <th scope="col">S.N.</th>
    <th scope="col">Item Name <span class="text-danger">*</span></th>
    <th scope="col">Add Qty <span class="text-danger">*</span></th>
    <th scope="col">Free Qty </th>
    <th scope="col">Total Qty</th>
    @if($invType==='addRepeaterToStockEntry')
    <th scope="col">Expiry Date </th>
    @endif
    <th scope="col">Unit Cost</th>
    <th scope="col">Disc Mod</th>
    <th scope="col">Discount</th>
    @if($invType==='addRepeaterToStockEntry')
    <th scope="col">Tax/vat <span class="text-danger">*</span></th>
    <th scope="col">Unit Sale <span class="text-danger">*</span></th>
    @endif
    <th scope="col">Amount</th>
    <th scope="col" style="width: 6rem">Action</th>
</tr>
