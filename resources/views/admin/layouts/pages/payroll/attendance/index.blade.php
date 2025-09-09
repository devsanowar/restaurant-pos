@extends('admin.layouts.app')
@section('title', 'All Attendance')
@section('admin_content')
     <div class="page-content">

            <!-- Start Content-->
            <div class="page-container">


                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold mb-0">Doctors</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Osen</a></li>

                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hospital</a></li>

                            <li class="breadcrumb-item active">Doctors</li>
                        </ol>
                    </div>
                </div>

                <!-- Body Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- Header -->
                            <div
                                class="card-header d-flex align-items-center justify-content-between border-bottom border-light">
                                <h4 class="header-title mb-0">All Attendance</h4>
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="ti ti-printer me-1"></i> Print
                                </a>
                            </div>

                            <!-- Filter Bar with Labels -->
                            <div class="card-body border-bottom py-2">
                                <form class="row g-2 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label small mb-1">Showroom</label>
                                        <select class="form-select form-select-sm">
                                            <option selected>Demo Electronics</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small mb-1">Employee</label>
                                        <select class="form-select form-select-sm">
                                            <option selected>Select Employee</option>
                                            <option>Ibrahim Khalil</option>
                                            <option>Shachsaw</option>
                                            <option>Ritu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small mb-1">Status</label>
                                        <select class="form-select form-select-sm">
                                            <option selected>Select Status</option>
                                            <option>Present</option>
                                            <option>Absent</option>
                                            <option>Late</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small mb-1">From Date</label>
                                        <input type="date" class="form-control form-control-sm" placeholder="From">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small mb-1">To Date</label>
                                        <input type="date" class="form-control form-control-sm" placeholder="To">
                                    </div>
                                    <div class="col-md-1 d-grid">
                                        <label class="form-label invisible">Search</label>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">Search</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th class="ps-3" style="width: 50px;"><input type="checkbox"
                                                    class="form-check-input"></th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Showroom</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Designation</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Attendance Row 1 -->
                                        <tr>
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td><img src="assets/images/employees/emp1.jpg" alt="Ibrahim Khalil"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>2025-08-30</td>
                                            <td>Demo Electronics</td>
                                            <td>Ibrahim Khalil</td>
                                            <td>01686311295</td>
                                            <td>Graphics Designer</td>
                                            <td>09:00</td>
                                            <td>18:00</td>
                                            <td><span class="badge bg-success">Present</span></td>
                                            <td class="text-center">
                                                <div class="hstack gap-1 justify-content-center">
                                                    <a href="#"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle"
                                                        title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>
                                                    <a href="#"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle"
                                                        title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Attendance Row 2 -->
                                        <tr>
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td><img src="assets/images/employees/emp2.jpg" alt="Shachsaw"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>2025-08-30</td>
                                            <td>Demo Electronics</td>
                                            <td>Shachsaw</td>
                                            <td>01234567891</td>
                                            <td>Salesperson</td>
                                            <td>09:30</td>
                                            <td>18:30</td>
                                            <td><span class="badge bg-danger">Absent</span></td>
                                            <td class="text-center">
                                                <div class="hstack gap-1 justify-content-center">
                                                    <a href="#"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle"
                                                        title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>
                                                    <a href="#"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle"
                                                        title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Attendance Row 3 -->
                                        <tr>
                                            <td class="ps-3"><input type="checkbox" class="form-check-input"></td>
                                            <td><img src="assets/images/employees/emp3.jpg" alt="Ritu"
                                                    class="img-thumbnail"
                                                    style="width: 50px; height: 50px; object-fit: cover;"></td>
                                            <td>2025-08-30</td>
                                            <td>Demo Electronics</td>
                                            <td>Ritu</td>
                                            <td>01010101010</td>
                                            <td>Salesperson</td>
                                            <td>10:00</td>
                                            <td>19:00</td>
                                            <td><span class="badge bg-warning">Late</span></td>
                                            <td class="text-center">
                                                <div class="hstack gap-1 justify-content-center">
                                                    <a href="#"
                                                        class="btn btn-soft-success btn-icon btn-sm rounded-circle"
                                                        title="Edit">
                                                        <i class="ti ti-edit fs-16"></i>
                                                    </a>
                                                    <a href="#"
                                                        class="btn btn-soft-danger btn-icon btn-sm rounded-circle"
                                                        title="Delete">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Footer / Pagination -->
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button class="btn btn-sm btn-outline-secondary">Copy</button>
                                        <button class="btn btn-sm btn-outline-success">Excel</button>
                                        <button class="btn btn-sm btn-outline-info">Column Visibility</button>
                                    </div>
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled">
                                            <a href="#" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="#" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



            </div>

            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <script>document.write(new Date().getFullYear())</script> © Restaurant POS - By <span
                                class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Freelance
                                IT</span>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
@endsection
