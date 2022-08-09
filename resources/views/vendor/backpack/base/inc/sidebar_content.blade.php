<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-organization') }}'><i class='nav-icon la la-question'></i> Organizations</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-question"></i><span>Super Master</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-country') }}'><i class='nav-icon la la-question'></i> Countries</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-province') }}'><i class='nav-icon la la-question'></i> Provinces</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-district') }}'><i class='nav-icon la la-question'></i> Districts</a></li>
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-gender') }}'><i class='nav-icon la la-question'></i> Genders</a></li> --}}
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-sup-status') }}'><i class='nav-icon la la-question'></i> Status</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-discount-mode') }}'><i class='nav-icon la la-question'></i> Discount Modes</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-order-type') }}'><i class='nav-icon la la-question'></i> Purchase order types</a></li>
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-payment-mode') }}'><i class='nav-icon la la-question'></i> Payment Modes</a></li> --}}
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-question"></i><span>Primary Master</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-unit') }}'><i class='nav-icon la la-question'></i> Units</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-category') }}'><i class='nav-icon la la-question'></i> Categories</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-subcategory') }}'><i class='nav-icon la la-question'></i> Subcategories</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-supplier') }}'><i class='nav-icon la la-question'></i> Suppliers</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-store') }}'><i class='nav-icon la la-question'></i> Stores</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-brand') }}'><i class='nav-icon la la-question'></i> Brands</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-item') }}'><i class='nav-icon la la-question'></i> Items</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-return-reason') }}'><i class='nav-icon la la-question'></i> Return Reasons</a></li>
    </ul>
</li>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-question"></i><span>Sequences</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-invoice-sequence') }}'><i class='nav-icon la la-question'></i> Invoice Sequences</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-batch-no') }}'><i class='nav-icon la la-question'></i> Batch No</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-po-sequence') }}'><i class='nav-icon la la-question'></i> Po Sequences</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-purchase-return-sequence') }}'><i class='nav-icon la la-question'></i> PR Sequences</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('mst-stock-adjustment-no') }}'><i class='nav-icon la la-question'></i> Stock Adjustment No</a></li>
    </ul>
</li>


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-question"></i><span>Inventory Management</span></span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-order') }}'><i class='nav-icon la la-question'></i> Purchase Orders</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('stock-entry') }}'><i class='nav-icon la la-question'></i> Stock Entries</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sale') }}'><i class='nav-icon la la-question'></i> Sales</a></li>
        {{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('purchase-order-item') }}'><i class='nav-icon la la-question'></i> PO Items</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('stock-item') }}'><i class='nav-icon la la-question'></i> Stock Items</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('sale-item') }}'><i class='nav-icon la la-question'></i> Sale items</a></li> --}}
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-question'></i> Users</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('batch-detail') }}'><i class='nav-icon la la-question'></i> Batch details</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('item-detail') }}'><i class='nav-icon la la-question'></i> Item details</a></li>
