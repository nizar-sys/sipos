<script>
    function getCheckedCheckboxesFor(checkboxName) {

        var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'),
            values = [];
        Array.prototype.forEach.call(checkboxes, function(el) {
            values.push(el.value);
        });

        if (values.length > 0) {
            $('#delete-data-selected').removeAttr('disabled');
        } else {
            $('#delete-data-selected').attr('disabled', 'disabled');
        }

        $('input[id="selectedData"]').val(values)
        return values;
    }

    function selectAllData(checkboxes) {
        $(`input[name="${checkboxes}"]`).prop('checked', 'checked');

        getCheckedCheckboxesFor(checkboxes)
    }

    $('#delete-data-selected').click(function() {
        Swal.fire({
            title: 'Hapus Data Terpilih',
            text: "Anda akan menghapus beberapa data yang dipilih",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formdelete-select-data').submit()
            }
        })
    })

    function getFileData(input) {
        var file = input.files[0];
        var filename = file.name;
        $('#filename-upload').html(filename)
    }

    function detailImage(tagImg) {
        try {
            $("#modalDetailImage").modal('show')
            $('#modalDetailImage #modalLabelImage').html(tagImg.alt)
            $('#modalDetailImage #imageDetail').attr('src', tagImg.src)
            $('input[id="kodeProduk"]').val(tagImg.id)
            $('input[id="oldImgProd"]').val(tagImg.src)
            
        } catch (error) {
            Snackbar.show({
                text: 'Detail image has error ' + error
            })
        }
    }
</script>
