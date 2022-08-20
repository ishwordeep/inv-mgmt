<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-organization') }}'><i class='nav-icon la la-users'></i> Organization</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-compass"></i><span>Super Master</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-country') }}'><i class='nav-icon la la-file'></i> Countries</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-province') }}'><i class='nav-icon la la-file'></i> Provinces</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-district') }}'><i class='nav-icon la la-file'></i> Districts</a></li>
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-gender') }}'><i class='nav-icon la la-file'></i> Genders</a></li> --}}
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-sup-status') }}'><i class='nav-icon la la-file'></i> Status</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-discount-mode') }}'><i class='nav-icon la la-file'></i> Discount Modes</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-order-type') }}'><i class='nav-icon la la-file'></i> Purchase order types</a></li>
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-payment-mode') }}'><i class='nav-icon la la-file'></i> Payment Modes</a></li> --}}
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-compass"></i><span>Primary Master</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-unit') }}'><i class='nav-icon la la-file'></i> Units</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-category') }}'><i class='nav-icon la la-file'></i> Categories</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-subcategory') }}'><i class='nav-icon la la-file'></i> Subcategories</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-supplier') }}'><i class='nav-icon la la-file'></i> Suppliers</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-store') }}'><i class='nav-icon la la-file'></i> Stores</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-brand') }}'><i class='nav-icon la la-file'></i> Brands</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-item') }}'><i class='nav-icon la la-file'></i> Items</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-return-reason') }}'><i class='nav-icon la la-file'></i> Return Reasons</a></li>
    </ul>
</li>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-compass"></i><span>Sequences</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-invoice-sequence') }}'><i class='nav-icon la la-file'></i> Invoice Sequences</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-batch-no') }}'><i class='nav-icon la la-file'></i> Batch No</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-po-sequence') }}'><i class='nav-icon la la-file'></i> Po Sequences</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-purchase-return-sequence') }}'><i class='nav-icon la la-file'></i> PR Sequences</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-stock-adjustment-no') }}'><i class='nav-icon la la-file'></i> Stock Adjustment No</a></li>
    </ul>
</li>


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-compass"></i><span>Inventory Management</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-order') }}'><i class='nav-icon la la-file'></i> Purchase Orders</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('stock-entry') }}'><i class='nav-icon la la-file'></i> Stock Entries</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sale') }}'><i class='nav-icon la la-file'></i> Sales</a></li>
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-order-item') }}'><i class='nav-icon la la-file'></i> PO Items</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('stock-item') }}'><i class='nav-icon la la-file'></i> Stock Items</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sale-item') }}'><i class='nav-icon la la-file'></i> Sale items</a></li> --}}
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-user'></i> Users</a></li>
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('batch-detail') }}'><i class='nav-icon la la-file'></i> Batch details</a></li> --}}
<li class='nav-item'><a class='nav-link' href='{{ route('item-details') }}'><i class='nav-icon la la-list'></i> Item Details</a></li>
