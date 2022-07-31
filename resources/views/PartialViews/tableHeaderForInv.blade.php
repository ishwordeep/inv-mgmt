
<tr class="text-white" style="background-color: #192840">
    <th scope="col">S.N.</th>
    <th scope="col">Item Name</th>
    <th scope="col">Add Qty</th>
    <th scope="col">Free Qty</th>
    <th scope="col">Total Qty</th>
    @if($invType==='addRepeaterToStockEntry')
    <th scope="col">Expiry Date </th>
    @endif
    <th scope="col">Unit Cost </th>
    <th scope="col">Disc Mode</th>
    <th scope="col">Discount</th>
    @if($invType==='addRepeaterToStockEntry')
    <th scope="col">Tax/vat</th>
    <th scope="col">Unit Sale</th>
    @endif
    <th scope="col">Amount</th>
    <th scope="col" style="width: 6rem">Action</th>
</tr>
