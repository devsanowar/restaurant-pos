@extends('admin.layouts.app')
@section('title', 'All Customer')

@push('styles')

    <style>
        .dt-buttons {
            margin-top: 0 !important;
        }
    </style>

    <!-- JSZip for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- pdfmake for PDF export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/bootstrap-select/css/bootstrap-select.css" />

@endpush

@php
    use Carbon\Carbon;

    function banglaDate($date) {
        $english = ['0','1','2','3','4','5','6','7','8','9','January','February','March','April','May','June','July','August','September','October','November','December'];
        $bangla  = ['০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'];
        return str_replace($english, $bangla, Carbon::parse($date)->format('d F, Y'));
    }
@endphp


@section('admin_content')



    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-4">

                <div class="card">
                    <div class="card-header">
                        <h4> All Customer </h4>
                    </div>
                    <div class="body">

                        <p class="text-center text-success"><b>{!! session('message') !!}</b></p>

                        <form method="POST" action="{{ route('send.message') }}">
                            @csrf

                            <table id="customerTable" class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <label>
                                            <input type="checkbox" id="selectAll">
                                            <b style="padding-left: 10px">Select All</b>
                                        </label>
                                    </th>

                                    <th>SL</th>
                                    <th>Customer Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td><input type="checkbox" class="row-checkbox" name="selected[]" value="{{ $customer->id }}" data-phone="{{ $customer->phone }}"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: left">{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td style="text-align: left">{{ $customer->address }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="row mb-3 py-5">

                                <div class="col-md-12">

                                    <div>
                                        <label for="mobile-box"><b>Mobile Number</b></label>
                                        <textarea name="mobile_numbers" id="mobile-box" class="form-control" rows="3" placeholder="Select or Write your mobile number..." required>{{ old('mobile_numbers') }}</textarea>
                                    </div>

                                    <div class="pt-3">
                                        <label for="message"><b>Message</b></label>
                                        <textarea name="message" id="message-box" class="form-control" rows="10" placeholder="Write your message..." required>{{ $sms_setting->default_message ?? '' }}</textarea>

                                        <div class="d-flex justify-content-between">
                                            <div class="text-end mt-1">
                                                <small><span id="char-count">0</span> Character</small>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success btn-block mt-md-4">Send Message</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="{{ asset('backend/assets/plugins/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            $('.js-basic-example').DataTable({
                dom:
                    "<'row d-flex align-items-center mb-2'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                stateSave: true,
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.getElementById('message-box');
            const counter = document.getElementById('char-count');

            const updateCount = () => {
                counter.textContent = textarea.value.length;
            };

            textarea.addEventListener('input', updateCount);
            updateCount(); // initial
        });
    </script>


    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('backend') }}/assets/bundles/datatablescripts.bundle.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>


    <!-- Custom Js -->
    <script src="{{ asset('backend') }}/assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="{{ asset('backend') }}/assets/js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function () {
            window.customerTable = $('#customerTable').DataTable();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileBox = document.getElementById('mobile-box');
            const selectAll = document.getElementById('selectAll');

            $('#customerTable').on('change', '.row-checkbox', function () {
                const phone = this.dataset.phone.trim();
                let numbers = mobileBox.value.split(',').map(num => num.trim()).filter(num => num);

                if (this.checked) {
                    if (!numbers.includes(phone)) {
                        numbers.push(phone);
                    }
                } else {
                    numbers = numbers.filter(num => num !== phone);
                }

                const uniqueNumbers = Array.from(new Set(numbers));
                mobileBox.value = uniqueNumbers.join(', ');
            });

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    const allRows = window.customerTable.rows({ search: 'applied' }).nodes();
                    const checkboxes = $('input.row-checkbox', allRows);
                    let numbers = mobileBox.value.split(',').map(num => num.trim()).filter(num => num);

                    checkboxes.each(function () {
                        const phone = this.dataset.phone.trim();
                        this.checked = selectAll.checked;

                        if (selectAll.checked) {
                            if (!numbers.includes(phone)) {
                                numbers.push(phone);
                            }
                        } else {
                            numbers = numbers.filter(num => num !== phone);
                        }
                    });

                    const uniqueNumbers = Array.from(new Set(numbers));
                    mobileBox.value = uniqueNumbers.join(', ');
                });
            }
        });
    </script>


    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.checked = checked;
            });
        });
    </script>

    <script src="{{ asset('backend') }}/assets/plugins/ckeditor/ckeditor.js"></script> <!-- Ckeditor -->
    <script src="{{ asset('backend') }}/assets/js/pages/forms/editors.js"></script>


    <script>
        $('.show_confirm').click(function (event) {
            event.preventDefault();
            const id = $(this).data('id');
            const form = document.getElementById(`delete-form-${id}`);

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });


    </script>

@endpush
