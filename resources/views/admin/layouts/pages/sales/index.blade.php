<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restaurant POS - Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <style>
        :root {
            --primary-color: #3F54E7;
            --secondary-color: #6D35E7;
        }

        body {
            background-color: #f4f5f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2rem;
        }

        .category-wrapper {
            position: relative;
            margin: 0 auto;
            max-width: 100%;
            padding: 0 20px;
        }

        .category-row {
            display: flex;
            overflow-x: hidden;
            gap: 20px;
            scroll-behavior: smooth;
        }

        .category-card {
            flex: 0 0 calc((100% - 100px)/6);
            /* 6 cards large screens */
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            /* box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); */
            cursor: pointer;
            transition: transform 0.3s ease;
            min-width: 150px;
        }

        .category-card img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-bottom: 1px solid #e0e0e0;
        }

        .category-card .card-body {
            text-align: center;
            padding: 12px 8px;
        }

        .category-card .card-title {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1rem;
        }

        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .arrow-btn {
            position: absolute;
            top: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            transform: translateY(-50%);
            border: none;
            background-color: var(--primary-color);
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background 0.3s, transform 0.2s;
        }

        .arrow-btn:hover {
            background-color: var(--secondary-color);

        }

        .arrow-left {
            left: -10px;
        }

        .arrow-right {
            right: -10px;
        }

        /* ====== */
        #orderPanel {
            transition: all 0.3s ease;
        }

        .table th,
        .table td {
            padding: 8px !important;
            vertical-align: middle !important;
        }

        /* ====== */

        @media(max-width: 1200px) {
            .category-card {
                flex: 0 0 calc((100% - 60px)/4);
            }
        }

        @media(max-width: 768px) {
            .category-card {
                flex: 0 0 calc((100% - 30px)/2);
            }
        }

        @media(max-width: 576px) {
            .category-card {
                flex: 0 0 calc(100% - 20px);
            }
        }
    </style>
</head>

<body>

<div class="container my-5">
    <h2 class="section-title">Restaurant Menu</h2>

    <div class="category-wrapper">
        <button class="arrow-btn arrow-left" id="scrollLeft"><i class="fa-solid fa-angle-left"></i></button>
        <div class="category-row" id="categoryRow">
            @foreach($productCategories as $category)
                <div class="category-card" data-category-id="{{ $category->id }}">
                    <img src="{{ asset($category->image) }}" alt="{{ $category->category_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->category_name }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="arrow-btn arrow-right" id="scrollRight"><i class="fa-solid fa-angle-right"></i></button>
    </div>

    <div class="row my-5">
        <!-- Left side: Products -->
        <div class="col-md-8" id="productDisplay">
            <h4 class="mb-3 text-start fw-bold"
                style="color: #6D35E7; font-size: 15px; letter-spacing: 1px; margin:30px 0;">
                Click a Category to View Items
            </h4>

            <div class="row g-3" id="productRow"></div>
        </div>

        <!-- Right side: Order Details -->
        <div class="col-md-4 d-none" id="orderPanel">
            <div class="card shadow-sm border-0" style="border-radius:12px; overflow:hidden;">
                <div class="card-header text-white text-center fw-semibold"
                     style="background:#465DFF; font-size:16px; padding:12px;">
                    Order Details
                </div>
                <div class="card-body p-3" style="max-height:420px; overflow-y:auto;">
                    <table class="table table-bordered table-hover align-middle text-center mb-3" id="orderTable"
                           style="font-size:14px;">
                        <thead class="table-light">
                        <tr>
                            <th style="width:5%;">#</th>
                            <th style="width:45%;">Product</th>
                            <th style="width:20%;">Qty</th>
                            <th style="width:30%;">Rate</th>
                            <th style="width:30%;">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Items will be added dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white" style="padding:12px;">

                    <div class="d-flex justify-content-between fw-semibold mb-2" style="font-size:14px;">
                        <span>Total:</span>
                        <span id="billAmount">৳0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <label class="form-label mb-1">Paid</label>
                        <input type="text" class="form-control form-control-sm" id="paidAmount" placeholder="Received" value="" style="width: 150px; text-align: right">
                    </div>
                    <div class="d-flex justify-content-between fw-semibold mb-3" style="font-size:14px;">
                        <span>Return Amount:</span>
                        <span id="returnAmount">BDT. 0</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-1">Table</label>
                        <select class="form-select form-select-sm" id="tableSelect">
                            <option value=""> -- Select Table -- </option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->table_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-1">Waiter</label>
                        <select class="form-select form-select-sm" id="waiterSelect">
                            <option value=""> -- Select Waiter -- </option>
                            @foreach($waiters as $waiter)
                                <option value="{{ $waiter->id }}" data-table="{{ $waiter->res_table_id }}">
                                    {{ $waiter->waiter_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-1">Customer Phone Number</label>
                        <input type="text" class="form-control form-control-sm" id="customerPhone"
                               placeholder="Enter receiver name">
                    </div>
                    <button class="btn w-100 py-2" id="saveOrderBtn"
                            style="background:#465DFF; color:#fff; font-weight:600; border-radius:8px;">
                        Save Order
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Font awesome -->
<script src="{{ asset('backend') }}/assets/js/all.min.js"></script>

<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('tableSelect').addEventListener('change', function () {
        let selectedTableId = this.value;
        let waiterSelect = document.getElementById('waiterSelect');

        // Reset waiter selection
        waiterSelect.value = "";

        // Find waiter with matching table_id
        for (let option of waiterSelect.options) {
            if (option.dataset.table == selectedTableId) {
                waiterSelect.value = option.value; // auto select waiter
                break;
            }
        }
    });
</script>

<script>
    const allProducts = @json($productCategories->mapWithKeys(function($cat) {
        return [
            $cat->id => $cat->products->map(function($p) {
                return [
                    'name'  => $p->product_name,
                    'price' => $p->sales_price,
                    'img'   => $p->image ? asset($p->image) : 'https://via.placeholder.com/150'
                ];
            })
        ];
    }));
</script>

<script>
    const row = document.getElementById('categoryRow');
    const leftBtn = document.getElementById('scrollLeft');
    const rightBtn = document.getElementById('scrollRight');

    function scrollOneCard(direction) {
        const card = row.querySelector('.category-card');
        const gap = 20; // same as CSS gap
        const scrollAmount = card.offsetWidth + gap;

        if (direction === 'left') {
            row.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            row.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    leftBtn.addEventListener('click', () => scrollOneCard('left'));
    rightBtn.addEventListener('click', () => scrollOneCard('right'));
</script>

<script>
    const productRow = document.getElementById('productRow');

    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', () => {
            const categoryId = card.getAttribute('data-category-id');
            const items = allProducts[categoryId] || [];
            displayProducts(items);
        });
    });

    function displayProducts(items) {
        productRow.innerHTML = '';

        if (items.length === 0) {
            productRow.innerHTML = `<p class="text-danger text-center mt-3">No products available</p>`;
            return;
        }

        items.forEach(item => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 mb-4';
            col.innerHTML = `
            <div class="card product-card shadow-sm h-100 text-center"
                style="border-radius:14px; overflow:hidden; border: 1px solid #e6e6e6;">
                <img src="${item.img}" class="card-img-top" alt="${item.name}"
                     style="height:150px; object-fit:cover;">
                <div class="card-body p-3">
                    <h6 class="card-title mb-2" style="font-size:15px; font-weight:600; color:#333;">${item.name}</h6>
                    <p class="card-text text-success fw-bold mb-3" style="font-size:14px;">BDT. ${item.price}</p>
                    <button class="btn btn-add-to-cart w-100"
                        data-name="${item.name}"
                        data-price="${item.price}">Add</button>
                </div>
            </div>
        `;
            productRow.appendChild(col);
        });

        // re-apply add-to-cart button logic
        styleAddButtons();
        addCardHoverEffect();
        attachAddButtonEvents();
    }

    // ✅ Click Event for Category Titles
    document.querySelectorAll('.category-card .card-title').forEach(title => {
        title.addEventListener('click', () => {
            const category = title.innerText.trim();
            const items = menuData[category] || [];
            displayProducts(items, category);
        });
    });

    let orderItems = [];

    function styleAddButtons() {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.style.backgroundColor = '#465DFF';
            btn.style.color = '#fff';
            btn.style.border = 'none';
            btn.style.borderRadius = '8px';
            btn.style.fontSize = '14px';
            btn.style.padding = '8px';
            btn.style.transition = 'background 0.3s ease';
            btn.addEventListener('mouseenter', () => btn.style.backgroundColor = '#2d44d9');
            btn.addEventListener('mouseleave', () => btn.style.backgroundColor = '#465DFF');
        });
    }

    function addCardHoverEffect() {
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 8px 20px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 10px rgba(0,0,0,0.05)';
            });
        });
    }

    function attachAddButtonEvents() {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', () => {
                // ✅ Show the order panel if hidden
                const orderPanel = document.getElementById('orderPanel');
                if (orderPanel.classList.contains('d-none')) {
                    orderPanel.classList.remove('d-none');
                    orderPanel.style.opacity = 0;
                    setTimeout(() => {
                        orderPanel.style.transition = 'opacity 0.3s ease';
                        orderPanel.style.opacity = 1;
                    }, 50);
                }

                const name = btn.getAttribute('data-name');
                const price = parseFloat(btn.getAttribute('data-price'));

                const existing = orderItems.find(item => item.name === name);
                if (existing) {
                    existing.qty += 1;
                } else {
                    orderItems.push({ name, price, qty: 1 });
                }
                updateOrderTable();
            });
        });
    }

    function updateOrderTable() {
        const tbody = document.querySelector('#orderTable tbody');
        tbody.innerHTML = '';
        let total = 0;

        orderItems.forEach((item, index) => {
            total += item.price * item.qty;
            const row = `
            <tr>
                <td>${index + 1}</td>
                <td class="text-start">${item.name}</td>
                <td>${item.qty}</td>
                <td>৳ ${item.price}</td>
                <td>৳ ${item.price * item.qty}</td>
            </tr>
        `;
            tbody.innerHTML += row;
        });

        document.getElementById('billAmount').innerText = `BDT. ${total}.00`;
        const paid = parseFloat(document.getElementById('paidAmount').value) || 0;
        document.getElementById('returnAmount').innerText = `BDT. ${total - paid}.00`;
    }

    // ✅ Update Due when Paid changes
    document.getElementById('paidAmount').addEventListener('input', updateOrderTable);

    document.getElementById('saveOrderBtn').addEventListener('click', async () => {
        if (orderItems.length === 0) {
            Swal.fire('Error', 'No items in the order!', 'error');
            return;
        }

        const tableId = document.getElementById('tableSelect').value;
        const waiterId = document.getElementById('waiterSelect').value;
        const phone = document.getElementById('customerPhone').value.trim();
        const paid = parseFloat(document.getElementById('paidAmount').value) || 0;

        if (!tableId || !waiterId || !phone) {
            Swal.fire('Error', 'Please fill all required fields!', 'error');
            return;
        }

        const total = orderItems.reduce((sum, item) => sum + item.price * item.qty, 0);
        const due = total - paid;

        try {
            const res = await fetch("{{ route('admin.orders.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    res_table_id: tableId,
                    waiter_id: waiterId,
                    customer_phone: phone,
                    paid: paid,
                    total: total,
                    due: due,
                    items: orderItems
                })
            });

            if (!res.ok) {
                const text = await res.text();
                throw new Error('HTTP ' + res.status + ': ' + text);
            }

            const data = await res.json();

            if (data.success) {
                Swal.fire('Saved!', 'Order saved successfully!', 'success');

                const pdfBlob = b64toBlob(data.pdf, "application/pdf");
                const url = URL.createObjectURL(pdfBlob);
                window.open(url, "_blank");

                window.location.href = "{{ route('admin.sales.index') }}";
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', err.message, 'error');
        }
    });

    function b64toBlob(b64Data, contentType="application/pdf", sliceSize=512) {
        const byteCharacters = atob(b64Data);
        const byteArrays = [];
        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            byteArrays.push(new Uint8Array(byteNumbers));
        }
        return new Blob(byteArrays, { type: contentType });
    }

    function b64toBlob(b64Data, contentType="application/pdf", sliceSize=512) {
        const byteCharacters = atob(b64Data);
        const byteArrays = [];
        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            byteArrays.push(new Uint8Array(byteNumbers));
        }
        return new Blob(byteArrays, { type: contentType });
    }

</script>

<script>
    const productRow = document.getElementById('productRow');

    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', () => {
            const categoryId = card.getAttribute('data-category-id');
            const items = allProducts[categoryId] || [];
            displayProducts(items);
        });
    });

    function displayProducts(items) {
        productRow.innerHTML = '';

        if (items.length === 0) {
            productRow.innerHTML = `<p class="text-danger text-center mt-3">No products available</p>`;
            return;
        }

        items.forEach(item => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 mb-4';
            col.innerHTML = `
            <div class="card product-card shadow-sm h-100 text-center"
                style="border-radius:14px; overflow:hidden; border: 1px solid #e6e6e6;">
                <img src="${item.img}" class="card-img-top" alt="${item.name}"
                     style="height:150px; object-fit:cover;">
                <div class="card-body p-3">
                    <h6 class="card-title mb-2" style="font-size:15px; font-weight:600; color:#333;">${item.name}</h6>
                    <p class="card-text text-success fw-bold mb-3" style="font-size:14px;">BDT. ${item.price}</p>
                    <button class="btn btn-add-to-cart w-100"
                        data-name="${item.name}"
                        data-price="${item.price}">Add</button>
                </div>
            </div>
        `;
            productRow.appendChild(col);
        });

        // re-apply add-to-cart button logic
        styleAddButtons();
        addCardHoverEffect();
        attachAddButtonEvents();
    }

    // ✅ Click Event for Category Titles
    document.querySelectorAll('.category-card .card-title').forEach(title => {
        title.addEventListener('click', () => {
            const category = title.innerText.trim();
            const items = menuData[category] || [];
            displayProducts(items, category);
        });
    });

    let orderItems = [];

    function styleAddButtons() {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.style.backgroundColor = '#465DFF';
            btn.style.color = '#fff';
            btn.style.border = 'none';
            btn.style.borderRadius = '8px';
            btn.style.fontSize = '14px';
            btn.style.padding = '8px';
            btn.style.transition = 'background 0.3s ease';
            btn.addEventListener('mouseenter', () => btn.style.backgroundColor = '#2d44d9');
            btn.addEventListener('mouseleave', () => btn.style.backgroundColor = '#465DFF');
        });
    }

    function addCardHoverEffect() {
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 8px 20px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 10px rgba(0,0,0,0.05)';
            });
        });
    }

    function attachAddButtonEvents() {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', () => {
                // ✅ Show the order panel if hidden
                const orderPanel = document.getElementById('orderPanel');
                if (orderPanel.classList.contains('d-none')) {
                    orderPanel.classList.remove('d-none');
                    orderPanel.style.opacity = 0;
                    setTimeout(() => {
                        orderPanel.style.transition = 'opacity 0.3s ease';
                        orderPanel.style.opacity = 1;
                    }, 50);
                }

                const name = btn.getAttribute('data-name');
                const price = parseFloat(btn.getAttribute('data-price'));

                const existing = orderItems.find(item => item.name === name);
                if (existing) {
                    existing.qty += 1;
                } else {
                    orderItems.push({ name, price, qty: 1 });
                }
                updateOrderTable();
            });
        });
    }

    function updateOrderTable() {
        const tbody = document.querySelector('#orderTable tbody');
        tbody.innerHTML = '';
        let total = 0;

        orderItems.forEach((item, index) => {
            total += item.price * item.qty;
            const row = `
            <tr>
                <td>${index + 1}</td>
                <td class="text-start">${item.name}</td>
                <td>${item.qty}</td>
                <td>৳ ${item.price}</td>
                <td>৳ ${item.price * item.qty}</td>
            </tr>
        `;
            tbody.innerHTML += row;
        });

        document.getElementById('billAmount').innerText = `BDT. ${total}.00`;
        const paid = parseFloat(document.getElementById('paidAmount').value) || 0;
        document.getElementById('returnAmount').innerText = `BDT. ${total - paid}.00`;
    }

    // ✅ Update Due when Paid changes
    document.getElementById('paidAmount').addEventListener('input', updateOrderTable);

    document.getElementById('saveOrderBtn').addEventListener('click', async () => {
        if (orderItems.length === 0) {
            Swal.fire('Error', 'No items in the order!', 'error');
            return;
        }

        const tableId = document.getElementById('tableSelect').value;
        const waiterId = document.getElementById('waiterSelect').value;
        const phone = document.getElementById('customerPhone').value.trim();
        const paid = parseFloat(document.getElementById('paidAmount').value) || 0;

        if (!tableId || !waiterId || !phone) {
            Swal.fire('Error', 'Please fill all required fields!', 'error');
            return;
        }

        const total = orderItems.reduce((sum, item) => sum + item.price * item.qty, 0);
        const due = total - paid;

        try {
            const res = await fetch("{{ route('admin.orders.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    res_table_id: tableId,
                    waiter_id: waiterId,
                    customer_phone: phone,
                    paid: paid,
                    total: total,
                    due: due,
                    items: orderItems
                })
            });

            if (!res.ok) {
                const text = await res.text();
                throw new Error('HTTP ' + res.status + ': ' + text);
            }

            const data = await res.json();

            if (data.success) {
                Swal.fire('Saved!', 'Order saved successfully!', 'success');

                const pdfBlob = b64toBlob(data.pdf, "application/pdf");
                const url = URL.createObjectURL(pdfBlob);
                window.open(url, "_blank");
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', err.message, 'error');
        }
    });

    function b64toBlob(b64Data, contentType="application/pdf", sliceSize=512) {
        const byteCharacters = atob(b64Data);
        const byteArrays = [];
        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            byteArrays.push(new Uint8Array(byteNumbers));
        }
        return new Blob(byteArrays, { type: contentType });
    }

    function b64toBlob(b64Data, contentType="application/pdf", sliceSize=512) {
        const byteCharacters = atob(b64Data);
        const byteArrays = [];
        for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            const slice = byteCharacters.slice(offset, offset + sliceSize);
            const byteNumbers = new Array(slice.length);
            for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }
            byteArrays.push(new Uint8Array(byteNumbers));
        }
        return new Blob(byteArrays, { type: contentType });
    }

</script>

</body>

</html>
