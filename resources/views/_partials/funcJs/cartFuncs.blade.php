<script>
    function CartComp(carts) {

        $('#load-total-cart').html('')

        var total = 0
        var carts = carts
        carts.map(cart => {
            var numb = cart.subtotal;
            total += cart.subtotal
            $('#load-cart').append(`<div class="row mb-4">
                                    <div class="col-md-5 col-lg-3 col-xl-3">
                                        <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                                            <a href="#!">
                                                <div class="mask waves-effect waves-light">
                                                    <img class="avatar"
                                                        src="{{ asset('/storage/productimgs/${cart.product.gambar_produk}') }}">
                                                    <div class="mask rgba-black-slight waves-effect waves-light"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-lg-9 col-xl-9">
                                        <div>
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <div class="def-number-input number-input safari_only mb-0 w-100">
                                                        <button
                                                            onclick="this.parentNode.querySelector('input[id=inputQty]').stepDown(); updateQty($(this).parent().find('input[id=inputQty]').val(), ${cart.id})"
                                                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-minus"></i></button>
                                                        <input class="quantity" min="0" name="quantity" value="${cart.qty}"
                                                            type="number" onchange="updateQty(this.value, ${cart.id})" id="inputQty">
                                                        <button
                                                            onclick="this.parentNode.querySelector('input[id=inputQty]').stepUp(); updateQty($(this).parent().find('input[id=inputQty]').val(), ${cart.id})"
                                                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <a onclick="deleteCart(${cart.id})" href="#!" type="button"
                                                        class="card-link-secondary small text-uppercase mr-3"><i
                                                            class="fas fa-trash-alt mr-1"></i> Remove item </a>
                                                </div>
                                                <p class="mb-0"><span><strong>Rp.${convertRp(numb)}</strong></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4">`)
        });

        $('#load-total-cart').html(`
                    <h5 class="mb-3">The total amount of</h5>

                    <ul class="list-group list-group-flush">
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                            <div>
                                <strong>The total amount of</strong>
                            </div>
                            <span><strong>Rp.${convertRp(total)}</strong></span>
                        </li>
                    </ul>
                        <input type="hidden" multiple id="cartsIdField" value="${getCartsId(carts)}">
                        <input type="hidden" id="totalTax" value="${convertRp(total)}">
                        <button onclick="checkout()" type="button"
                            class="btn btn-primary btn-block waves-effect waves-light">Checkout</button>
                        `)
    }

    function getCartsId(carts) {
        var cartsId = [];

        carts.map((cart) => {
            cartsId.push(cart.id)
        })
        return cartsId;
    }

    async function getCart() {
        try {
            var url = '/:role/my-cart/:user_id';
            url = url.replace(':role', "{{ Auth::user()->role == '1' ? 'admin' : 'user' }}")
            url = url.replace(':user_id', "{{ Auth::user()->id }}");
            const response = await HitData(url, null, 'GET');
            var carts = response.data.carts

            $('#count-cart').html(carts.length)
            $('#load-cart').html('')
            CartComp(carts)


        } catch (error) {
            Snackbar.show({
                text: 'Error ' + error
            })
        }
    }

    async function addToCart(codeProd, hargaProd) {
        try {
            var url = '/add-to-cart/:kodeProd'
            url = url.replace(':kodeProd', codeProd)
            var data = {
                _token: "{{ csrf_token() }}",
                id_produk: codeProd,
                harga: hargaProd
            };

            const response = await HitData(url, data, 'POST')

            Snackbar.show({
                text: response.message
            })

            getCart();
        } catch (error) {
            Snackbar.show({
                text: 'Error ' + error
            })
        }
    }

    async function updateQty(qty, cartId) {
        try {
            var url = '/update-qty/:cartId'
            url = url.replace(':cartId', cartId)
            var data = {
                _token: '{{ csrf_token() }}',
                newQty: qty,
                id: cartId
            }

            const response = await HitData(url, data, 'PUT')
            Snackbar.show({
                text: response.message
            })

            getCart()
        } catch (error) {
            Snackbar.show({
                text: 'Error ' + error
            })
        }
    }

    async function deleteCart(cartId) {
        try {
            var url = '/delete-cart/:cartId'
            url = url.replace(':cartId', cartId)
            var data = {
                _token: '{{ csrf_token() }}',
                id: cartId
            }
            await Swal.fire({
                title: 'Anda yakin?',
                text: "Hapus barang di keranjang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const response = HitData(url, data, 'DELETE')
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    )
                }
            })

            getCart()
        } catch (error) {
            Snackbar.show({
                text: 'Error ' + error
            })
        }
    }

    async function checkout() {
        try {
            var cartsId = $('input[id="cartsIdField"]')
            var totaltax = $('input[id="totalTax"]')

            var url = '/checkout-cart';
            var data = {
                _token: "{{ csrf_token() }}",
                cartsId: cartsId.val(),
                total_transaksi: totaltax.val().split('.').join(''),
            }

            toastr.info('Loading ...')

            const response = await HitData(url, data, 'POST');
            Snackbar.show({
                text: response.message
            })
            getCart()
        } catch (error) {
            Snackbar.show({
                text: 'Error ' + error
            })
        }
    }
    getCart();
</script>
