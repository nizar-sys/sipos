<script>
    async function payment(paymentCode, totaltax) {
        try {
            var modalPayment = $('#paymentModal')
            modalPayment.modal('show')
            modalPayment.find('#totalPayment').html(totaltax)
            modalPayment.find('#remainPayment').html(totaltax)
            modalPayment.find('#paymentCode').html(paymentCode)
            modalPayment.find('input[id="trx_code"]').val(paymentCode)

        } catch (error) {
            Snackbar.show({
                text: "Error " + error
            })
        }
    }

    async function bacaGambar(input) {
        try {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#buktiTfImg').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        } catch (error) {

            Snackbar.show({
                text: 'Error ' + error,
                duration: 4000,
            });
        }
    }

    $('input[name="bukti_tf"]').change(function() {
        bacaGambar(this);
    });
</script>