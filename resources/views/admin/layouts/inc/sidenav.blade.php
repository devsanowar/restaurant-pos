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
                            <a href="{{ route('admin.product-category.index') }}" class="side-nav-link">
                                <span class="menu-text">Product Category</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.product.index') }}" class="side-nav-link">
                                <span class="menu-text">All Product</span>
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
                <a data-bs-toggle="collapse" href="#sidebarInvoice" aria-expanded="false" aria-controls="sidebarInvoice"
                    class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-shopping-cart"></i></span>
                    <span class="menu-text"> Purchase</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarInvoice">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.stock.item.index') }}" class="side-nav-link">
                                <span class="menu-text">Add items</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.purchase.create') }}" class="side-nav-link">
                                <span class="menu-text">Add Purchase</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.purchase.index') }}" class="side-nav-link">
                                <span class="menu-text">All Purchase</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <!-- Stock -->
            <li class="side-nav-item">
                <a href="{{ route('admin.stock.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Stock </span>
                </a>
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
                <a href="{{ route('admin.sales.index') }}" class="side-nav-link" target="_blank">
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


            <!-- Payroll -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarHospital" aria-expanded="false"
                    aria-controls="sidebarHospital" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-medical-cross"></i></span>
                    <span class="menu-text"> Payroll</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarHospital">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.restaurant.branch.index') }}" class="side-nav-link">
                                <span class="menu-text">All Retaurant</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.payroll.create') }}" class="side-nav-link">
                                <span class="menu-text">Add Payroll</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.payroll.index') }}" class="side-nav-link">
                                <span class="menu-text">View All Payroll</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.attendance.create') }}" class="side-nav-link">
                                <span class="menu-text">Add Attendance</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.attendance.index') }}" class="side-nav-link">
                                <span class="menu-text">All Attendance</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.advance.payment.index') }}" class="side-nav-link">
                                <span class="menu-text">Advance Payment</span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ route('admin.salary.create') }}" class="side-nav-link">
                                <span class="menu-text">Add Salary</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.salary.index') }}" class="side-nav-link">
                                <span class="menu-text">All Salary </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="apps-payroll-add-paymenet.html" class="side-nav-link">
                                <span class="menu-text">Add Payment </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-payroll-all-paymenet.html" class="side-nav-link">
                                <span class="menu-text">All Payment</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-payroll-salary-report.html" class="side-nav-link">
                                <span class="menu-text">Salary Report</span>
                            </a>
                        </li>

                    </ul>
                </div>
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
                <a href="{{ route('admin.setting.index') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-message"></i></span>
                    <span class="menu-text"> Settings </span>
                </a>
            </li>
            <!-- SMS-->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#smsApiSetting" aria-expanded="false"
                    aria-controls="smsApiSetting" class="side-nav-link">
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
                <a href="{{ route('admin.user.management.index') }}" class="side-nav-link">
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
