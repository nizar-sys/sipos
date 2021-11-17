<script>
    function convertRp(numb) {
        var format = numb.toString().split('').reverse().join('');
        var convert = format.match(/\d{1,3}/g);
        var rupiah = convert.join('.').split('').reverse().join('')

        return rupiah
    }
</script>
