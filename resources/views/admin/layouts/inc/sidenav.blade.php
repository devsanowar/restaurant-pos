<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="index.html" class="logo">
        <span class="logo-light">
            <span class="logo-lg" style="color:#fff; font-size: 18px;">Restaurant POS</span>
            <span class="logo-sm">Restaurant POS</span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg" style="color:#fff; font-size: 18px;">Restaurant POS</span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-circle align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title">Dash</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                    <span class="menu-text"> Dashboard </span>
                    <span class="badge bg-success rounded-pill">5</span>
                </a>
            </li>

            <!-- Category -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#posCategory" aria-expanded="false" aria-controls="posCategory"
                    class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-medical-cross"></i></span>
                    <span class="menu-text"> Category</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="posCategory">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="apps-category-all-category.html" class="side-nav-link">
                                <span class="menu-text">All Category </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-category-add-new.html" class="side-nav-link">
                                <span class="menu-text">Add New Category</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Product -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#posProduct" aria-expanded="false" aria-controls="posProduct"
                    class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-medical-cross"></i></span>
                    <span class="menu-text"> Product</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="posProduct">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="apps-product-all-products.html" class="side-nav-link">
                                <span class="menu-text">All Product</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-prodcut-add-new.html" class="side-nav-link">
                                <span class="menu-text">Add New Product</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Supplier -->
            <li class="side-nav-item">
                <a href="{{ route('admin.supplier.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Supplier </span>
                </a>
            </li>
            <!-- Stock -->
            {{-- <li class="side-nav-item">
                <a href="apps-stock.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Stock </span>
                </a>
            </li> --}}

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarInvoice" aria-expanded="false"
                    aria-controls="sidebarInvoice" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                    <span class="menu-text"> Stock</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarInvoice">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.stock.item.index') }}" class="side-nav-link">
                                <span class="menu-text">Stock items</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.stock.index') }}" class="side-nav-link">
                                <span class="menu-text">Stock</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <!-- Stock Out-->
            <li class="side-nav-item">
                <a href="apps-stock-out.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Stock Out </span>
                </a>
            </li>


            <!-- Sales-->
            <li class="side-nav-item">
                <a href="apps-sales.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Sales </span>
                </a>
            </li>
            <!-- Table-->
            <li class="side-nav-item">
                <a href="{{ route('admin.res-table.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Table </span>
                </a>
            </li>
            <!-- Waiter-->
            <li class="side-nav-item">
                <a href="{{ route('admin.waiter.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Waiter </span>
                </a>
            </li>
            <!-- Costs -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarInvoice" aria-expanded="false"
                    aria-controls="sidebarInvoice" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                    <span class="menu-text"> Costs</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarInvoice">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.cost-category.index') }}" class="side-nav-link">
                                <span class="menu-text">Cost Category</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.field-of-cost.index') }}" class="side-nav-link">
                                <span class="menu-text">Field Of Cost</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.cost.index') }}" class="side-nav-link">
                                <span class="menu-text">All Cost</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Income-->

             <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarIncomeCategory" aria-expanded="false"
                    aria-controls="sidebarIncomeCategory" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                    <span class="menu-text"> Incomes</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarIncomeCategory">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.income.category.index') }}" class="side-nav-link">
                                <span class="menu-text">Income Category</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.income.index') }}" class="side-nav-link">
                                <span class="menu-text">All Income</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <!-- Payroll-->
            <li class="side-nav-item">
                <a href="apps-payroll.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Payroll </span>
                </a>
            </li>
            <!-- Reports-->
            <li class="side-nav-item">
                <a href="apps-reports.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Reports </span>
                </a>
            </li>
            <!-- Settings-->
            <li class="side-nav-item">
                <a href="apps-settings.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Settings </span>
                </a>
            </li>
            <!-- SMS-->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#smsApiSetting" aria-expanded="false" aria-controls="smsApiSetting"
                    class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> SMS</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="smsApiSetting">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.sms.index') }}" class="side-nav-link">
                                <span class="menu-text">Send SMS</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.custom.sms') }}" class="side-nav-link">
                                <span class="menu-text">Send Custom SMS</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.sms-report.index') }}" class="side-nav-link">
                                <span class="menu-text">SMS Report</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.sms-settings.edit') }}" class="side-nav-link">
                                <span class="menu-text">SMS Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- User Management-->
            <li class="side-nav-item">
                <a href="apps-user-management.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> User Management </span>
                </a>
            </li>
            <!-- User Management-->
            <li class="side-nav-item">

                <form method="POST" action="{{ route('logout') }}" style="padding:10px 15px">
                    @csrf

                    <button type="submit" class="dropdown-item active fw-semibold text-danger">
                        <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                        <span class="align-middle">Sign Out</span>
                    </button>
                </form>
            </li>

            <div class="clearfix"></div>
    </div>
</div>
