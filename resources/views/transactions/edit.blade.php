<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="mb-5">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Barang</label>
                <input type="text" id="search" placeholder="Masukkan kode atau nama barang"
                    class="input input-bordered w-full" oninput="searchProduct(this.value)">
            </div>

            <div id="search-results" class="mt-3"></div>

            <div class="mt-5">
                <h4 class="text-lg font-semibold">Keranjang</h4>
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <tr>
                            <td colspan="7" class="text-center text-gray-500">Keranjang kosong</td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-lg font-semibold">Total Bayar: <span id="total-bayar">Rp 0</span></span>
                </div>

                <div class="mt-6">
                    <h4 class="text-lg font-semibold">Form Pembayaran</h4>
                    <div class="form-control mb-4">
                        <label for="payment" class="label">
                            <span class="label-text">Jumlah Uang Pembeli</span>
                        </label>
                        <input type="text" id="payment" class="input input-bordered"
                            placeholder="Masukkan jumlah pembayaran" oninput="formatPaymentInput(this)">
                    </div>
                    <div class="form-control mb-4">
                        <label for="change" class="label">
                            <span class="label-text">Kembalian</span>
                        </label>
                        <input type="text" id="change" class="input input-bordered" readonly>
                        @error('products')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                        @error('total_price')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <form id="transaction-form" action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="products" id="products-input">
                        <input type="hidden" name="total_price" id="total-price-input">
                        <button type="button" id="pay-button" class="btn btn-primary" disabled onclick="processPayment()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let debounceTimer;
        const initialCart = @json($transactionDetails);

        cart = initialCart;

        document.addEventListener('DOMContentLoaded', renderCart);

        const formatRupiah = (value) => {
            if (!value) return '';
            value = value.toString().replace(/[^,\d]/g, '');
            const split = value.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] !== undefined ? 'Rp. ' + rupiah + ',' + split[1] : 'Rp. ' + rupiah;
        };

        const formatPaymentInput = (input) => {
            const rawValue = input.value.replace(/[^0-9]/g, '');
            input.value = formatRupiah(rawValue);
            calculateChange();
        };

        function calculateChange() {
            const totalBayar = cart.reduce((sum, item) => sum + item.total, 0);
            const paymentInput = document.getElementById('payment');
            const paymentValue = parseInt(paymentInput.value.replace(/[^0-9]/g, '') || 0, 10);
            const change = paymentValue - totalBayar;
            document.getElementById('change').value = change > 0 ? formatRupiah(change) : 'Rp. 0';
            document.getElementById('pay-button').disabled = paymentValue < totalBayar;
        }

        function processPayment() {
            document.getElementById('products-input').value = JSON.stringify(cart);
            const totalPrice = cart.reduce((sum, item) => sum + item.total, 0);
            document.getElementById('total-price-input').value = totalPrice;
            document.getElementById('transaction-form').submit();
        }

        function searchProduct(term) {
            clearTimeout(debounceTimer);
            const searchResultsElement = document.getElementById('search-results');

            if (!term.trim()) {
                searchResultsElement.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/transactions/search?term=${encodeURIComponent(term)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResultsElement.innerHTML = '<p class="text-gray-500">Barang tidak ditemukan</p>';
                            return;
                        }

                        const results = data.map(product => `
                            <div class="border p-3 rounded mb-3 flex justify-between items-center">
                                <div>
                                    <p><b>${product.name}</b> (${product.code.toUpperCase()})</p>
                                    <p>${formatRupiah(product.price)}</p>
                                    <p>Stock: ${product.stock}</p>
                                </div>
                                ${product.stock > 0
                                    ? `<button class="btn btn-sm btn-success" onclick="addToCart(${product.id}, '${product.code}', '${product.name}', ${product.price}, ${product.stock})">Tambah</button>`
                                    : `<button class="btn btn-sm btn-secondary" disabled>Stock Habis</button>`
                                }
                            </div>
                        `).join('');
                        searchResultsElement.innerHTML = results;
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        }

        function addToCart(id, code, name, price, stock) {
            const existing = cart.find(item => item.id === id);

            if (existing) {
                if (existing.qty < stock) {
                    existing.qty++;
                    existing.total += price;
                } else {
                    Swal.fire('Stok Tidak Cukup', 'Jumlah produk melebihi stok yang tersedia!', 'warning');
                    return;
                }
            } else {
                cart.push({ id, code, name, price, qty: 1, total: price, stock });
            }
            renderCart();
        }
        function renderCart() {
            const tbody = document.getElementById('cart-body');
            if (cart.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-gray-500">Keranjang kosong</td></tr>`;
                document.getElementById('total-bayar').textContent = 'Rp 0';
                return;
            }

            let totalBayar = 0;
            const rows = cart.map((item, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.code}</td>
                    <td>${item.name}</td>
                    <td>${formatRupiah(item.price)}</td>
                    <td>
                        <input type="number" value="${item.qty}" class="input input-bordered w-20" min="1"
                            onchange="updateQty(${item.id}, this.value)">
                    </td>
                    <td>${formatRupiah(item.total)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">Hapus</button>
                    </td>
                </tr>
            `).join('');
            tbody.innerHTML = rows;

            cart.forEach(item => totalBayar += item.total);
            document.getElementById('total-bayar').textContent = formatRupiah(totalBayar);
        }

        function updateQty(id, qty) {
            const product = cart.find(item => item.id === id);
            if (product) {
                if (qty < 1 || qty > product.stock) {
                    Swal.fire('Jumlah Tidak Valid', 'Jumlah tidak boleh melebihi stok atau kurang dari 1!', 'error');
                    return;
                }
                product.qty = parseInt(qty, 10);
                product.total = product.qty * product.price;
                renderCart();
            }
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }
    </script>
</x-app-layout>
