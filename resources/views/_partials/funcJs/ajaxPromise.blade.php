<script>
    function HitData(urlPost, dataPost, typePost) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: urlPost,
                data: dataPost,
                type: typePost,
                success: (response) => {
                    resolve(response)
                },
                error: (error) => {
                    reject(error)
                }
            })
        })
    }
</script>
