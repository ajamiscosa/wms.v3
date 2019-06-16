@if(auth()->user())
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-light-danger">
        <!-- Brand Logo -->
        <a href="/" class="brand-link bg-danger">
            <img src="{{ asset('img/AdminLTELogo.png') }}"
                 alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">PMWMS</span>
        </a>
        <!-- Todo -->
        <!-- move nav-item ids to nav-link flat>
        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link flat user-panel mt-2 pb-3 pt-3 mb-2 pl-0 d-flex">
                            <div class="image">
                                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                            </div>
                            <p class="info">{{ auth()->user()->Person()->Name() }}</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item pt-0">
                                <a href="/account/view/{{ auth()->user()->Username }}" class="nav-link flat">
                                    <i class="fa fa-user-circle nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item pt-0">
                                <a href="/update-password" class="nav-link flat">
                                    <i class="fa fa-lock nav-icon"></i>
                                    <p>Update Password</p>
                                </a>
                            </li>
                            <li class="divider"><hr class="pb-0 mb-2 pt-0 mt-2"/></li>
                            <li class="nav-item pt-0 mt-0">
                                <a href="/logout" class="nav-link flat">
                                    <i class="fa fa-sign-out-alt nav-icon"></i>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">MAIN NAVIGATION</li>
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/" class="nav-link flat" id="dashboard">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    @if(auth()->user()->isAuthorized('Vendors','V'))
                        <li class="nav-item">
                            <a href="/vendor" class="nav-link flat" id="vendor">
                                <i class="nav-icon fa fa-users"></i>
                                <p>Vendor</p>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isAuthorized('Issuances','V') or auth()->user()->isAuthorized('PurchaseRequests','V'))
                        <li class="nav-item has-treeview" id="requisition">
                            <a class="nav-link flat" id="requisition-link">
                                <i class="nav-icon fa fa-download"></i>
                                <p>
                                    Requisition
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/rs" class="nav-link flat" id="rs" data-parent="#requisition">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>New Requisition</p>
                                    </a>
                                </li>
                                @if(auth()->user()->isAuthorized('PurchaseRequests','A'))
                                    <li class="nav-item">
                                        <a href="/special-request" class="nav-link flat" id="special-request" data-parent="#requisition">
                                            <i class="fa fa-angle-right nav-icon"></i>
                                            <p>One Time/Service Request</p>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->isAuthorized('Issuances','A'))
                                    <li class="nav-item nav-divider">
                                        <hr class="pt-0 pb-0 mt-0 mb-1"/>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/issuance-request" class="nav-link flat" id="issuance-request" data-parent="#requisition">
                                            <i class="fa fa-angle-right nav-icon"></i>
                                            <p>Issuance Request</p>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->isAuthorized('PurchaseRequests','A'))
                                    <li class="nav-item">
                                        <a href="/purchase-request" class="nav-link flat" id="purchase-request" data-parent="#requisition">
                                            <i class="fa fa-angle-right nav-icon"></i>
                                            <p>Purchase Request</p>
                                        </a>
                                    </li>
                                @endif
                                {{--@if(auth()->user()->isAuthorized('PurchaseRequests','A'))--}}
                                    {{--<li class="nav-item">--}}
                                        {{--<a href="/new-item-request" class="nav-link flat" id="new-item-request" data-parent="#requisition">--}}
                                            {{--<i class="fa fa-angle-right nav-icon"></i>--}}
                                            {{--<p>New Item</p>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--@endif--}}
                                {{--@if(auth()->user()->isAuthorized('PurchaseRequests','A'))--}}
                                    {{--<li class="nav-item">--}}
                                        {{--<a href="/capex-request" class="nav-link flat" id="single-purchase-request" data-parent="#requisition">--}}
                                            {{--<i class="fa fa-angle-right nav-icon"></i>--}}
                                            {{--<p>CAPEX</p>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--@endif--}}
                                {{-- @if(auth()->user()->isPPC())
                                <li class="nav-item nav-divider">
                                    <hr class="pt-0 pb-0 mt-0 mb-1"/>
                                </li>
                                <li class="nav-item">
                                    <a href="/restocking" class="nav-link flat" id="restocking" data-parent="#requisition">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>For Restocking</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/deferred" class="nav-link flat" id="deferred" data-parent="#requisition">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>For Restocking (Deferred)</p>
                                    </a>
                                </li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->isAuthorized('Products','V'))
                        <li class="nav-item has-treeview" id="inventory">
                            <a href="#" class="nav-link flat" id="inventory-link">
                                <i class="nav-icon fa fa-cubes"></i>
                                <p>
                                    Inventory
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/product" class="nav-link flat" id="product" data-parent="#inventory">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Products</p>
                                    </a>
                                </li>
                                <li class="nav-item nav-divider">
                                    <hr class="pt-0 pb-0 mt-0 mb-1"/>
                                </li>
                                <li class="nav-item">
                                    <a href="/stock-adjustment" class="nav-link flat" id="stock-adjustment" data-parent="#inventory">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Stock Adjustments</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/stock-transfer" class="nav-link flat" id="stock-transfer" data-parent="#inventory">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Stock Transfers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/issuance" class="nav-link flat" id="issuance" data-parent="#inventory">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Issuance</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->isAuthorized('PurchaseOrders','V'))
                        <li class="nav-item has-treeview" id="purchasing">
                            <a href="#" class="nav-link flat" id="purchasing-link">
                                <i class="nav-icon fa fa-credit-card"></i>
                                <p>
                                    Purchasing
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/for-quotation" class="nav-link flat" id="for-quotation" data-parent="#purchasing">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>For Quotation</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/pending-quote" class="nav-link flat" id="pending-quote" data-parent="#purchasing">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Quotation Approval</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/order-item" class="nav-link flat" id="order-item" data-parent="#purchasing">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Pending Order Items</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/purchase-order" class="nav-link flat" id="purchase-order" data-parent="#purchasing">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Purchase Orders</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/receive-order" class="nav-link flat" id="receive-order" data-parent="#purchasing">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Receiving</p>
                                    </a>
                                </li>
                                {{--<li class="nav-item">--}}
                                    {{--<a href="/purchase-return" class="nav-link flat" id="purchase-return" data-parent="#purchasing">--}}
                                        {{--<i class="fa fa-angle-right nav-icon"></i>--}}
                                        {{--<p>Purchase Returns</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="/purchase-invoice" class="nav-link flat" id="purchase-invoice" data-parent="#purchasing">--}}
                                        {{--<i class="fa fa-angle-right nav-icon"></i>--}}
                                        {{--<p>Bills</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="/supplier-payment" class="nav-link flat" id="supplier-payment" data-parent="#purchasing">--}}
                                        {{--<i class="fa fa-angle-right nav-icon"></i>--}}
                                        {{--<p>Payments</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->isAuthorized('Reports','V'))
                        <li class="nav-item has-treeview" id="reports">
                            <a href="#" class="nav-link flat" id="reports-link">
                                <i class="nav-icon fa fa-chart-bar"></i>
                                <p>
                                    Reports
                                    <i class="fa fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/reports/inventory-log" class="nav-link flat" id="inventory-log" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Inventory Logs</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/inventory-balance" class="nav-link flat" id="inventory-balance" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Inventory Balance</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/issuance-log" class="nav-link flat" id="issuance-log" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Issuance Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/receiving-log" class="nav-link flat" id="receiving-log" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Receiving Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/purchase-order-log" class="nav-link flat" id="purchase-order-log" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Purchase Orders Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/custom-po-list" class="nav-link flat" id="custom-po-list" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Custom PO List</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="/reports/consumption" class="nav-link flat" id="consumption" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Consumption Report</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="/reports/item-movement" class="nav-link flat" id="item-movement" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Item Movement Report</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="/reports/pr-status" class="nav-link flat" id="pr-status" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>PR Status Report</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="/reports/adjustments" class="nav-link flat" id="adjustments" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Stock Adjustments</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/recent-suppliers" class="nav-link flat" id="recent-suppliers" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Recent Vendors</p>
                                    </a>
                                </li>
                                </li>
                                <li class="nav-item">
                                    <a href="/reports/recent-items" class="nav-link flat" id="recent-items" data-parent="#reports">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Recently Added Items</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item has-treeview" id="settings">
                        <a href="#" class="nav-link flat" id="settings-link">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>
                                Settings
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->isAuthorized('Departments','V'))
                                <li class="nav-item">
                                    <a href="/department" class="nav-link flat" id="department" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Departments</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('Departments','V'))
                            <li class="nav-item">
                                <a href="/capex" class="nav-link flat" id="capex" data-parent="#settings">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>CAPEX</p>
                                </a>
                            </li>
                            @endif
                            @if(auth()->user()->isAuthorized('UserAccounts','V'))
                                <li class="nav-item">
                                    <a href="/account" class="nav-link flat" id="account" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>User Accounts</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('Roles','V'))
                                <li class="nav-item">
                                    <a href="/role" class="nav-link flat" id="role" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>User Roles</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('GeneralLedgers','V'))
                                <li class="nav-item">
                                    <a href="/gl" class="nav-link flat" id="gl" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>GL Accounts</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('UnitsOfMeasure','V'))
                                <li class="nav-item">
                                    <a href="/uom" class="nav-link flat" id="uom" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Units of Measure</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('Currencies','V'))
                                <li class="nav-item">
                                    <a href="/currency" class="nav-link flat" id="currency" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Currencies</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('ProductLines','V'))
                                <li class="nav-item">
                                    <a href="/product-line" class="nav-link flat" id="product-line" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Product Lines</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('Terms','V'))
                                <li class="nav-item">
                                    <a href="/term" class="nav-link flat" id="term" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Terms</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('ShipVia','V'))
                                <li class="nav-item">
                                    <a href="/ship-via" class="nav-link flat" id="ship-via" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Ship Via</p>
                                    </a>
                                </li>
                            @endif
                            {{--@if(auth()->user()->isAuthorized('ItemTypes','V'))--}}
                                {{--<li class="nav-item">--}}
                                    {{--<a href="/item-type" class="nav-link flat" id="item-type" data-parent="#settings">--}}
                                        {{--<i class="fa fa-angle-right nav-icon"></i>--}}
                                        {{--<p>Item Types</p>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--@endif--}}
                            @if(auth()->user()->isAuthorized('Locations','V'))
                                <li class="nav-item">
                                    <a href="/location" class="nav-link flat" id="location" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Warehouse Locations</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('Categories','V'))
                                <li class="nav-item">
                                    <a href="/category" class="nav-link flat" id="category" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Categories</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAuthorized('DataManagement','V'))
                                <li class="nav-item">
                                    <a href="/data-management" class="nav-link flat" id="data-management" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Backup and Restore</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdministrator())
                                <li class="nav-item">
                                    <a href="/batch-process" class="nav-link flat" id="batch-process" data-parent="#settings">
                                        <i class="fa fa-angle-right nav-icon"></i>
                                        <p>Batch Processes</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@else
    @php
        return redirect()->to('/login');
    @endphp
@endif