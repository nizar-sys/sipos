<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-dark" role="alert">
                    Transaction ID : <span id="paymentCode"></span>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" id="form-pay-trx" action="/pay-transaction"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="bukti_tf" id="bukti_tf" class="d-none">
                                <input type="hidden" name="trx_code" id="trx_code">
                                <input type="hidden" name="remain_pay" id="remain_pay">
                                <input type="hidden" name="change_pay" id="change_pay">
                                <input type="hidden" name="total_pay" id="total_pay">
                            </form>
                            <img src="" onclick="$('#bukti_tf').click()" class="img-fluid mx-auto d-block"
                                alt="Bukti Pembayaran" id="buktiTfImg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h3>Remaining : Rp.<span id="remainPayment"></span></h3>
                        </div>
                        <div class="col-6">
                            <h3>Change : Rp.<span id="changePayment"></span></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h4>Total Due : Rp.<span id="totalPayment"></span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="number" id="yourPayment" onkeyup="$('#remainPayment').html($('#totalPayment').text()-this.value < 0 ? 0 : convertRp($('#totalPayment').text()-this.value)); $('#changePayment').html($('#remainPayment').text() == 0 ? convertRp(this.value-$('#totalPayment').text()) : 0)
                                
                                $('#remain_pay').val($('#totalPayment').text()-this.value < 0 ? 0 : $('#totalPayment').text()-this.value); $('#change_pay').val($('#remain_pay').val() == 0 ? this.value-$('#totalPayment').text() : 0)
                                $('#total_pay').val(this.value)
                                " class="form-control" placeholder="Your Payment" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="$('#form-pay-trx').submit()" class="btn btn-success">Pay!</button>
            </div>
        </div>
    </div>
</div>
