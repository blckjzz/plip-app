<script>
    jQuery(document).ready(function ($) {
        $('.adotar').on('click', function (e) {
            if (!confirm('Você realmente deseja adotar esse PL?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
                    }

                });

                e.preventDefault();

                //
                // var petitionId = $("input[name=petitionid]").val();
                //
                // $.ajax({
                //
                //     type: 'POST',
                //
                //     url: '/voluntario/adotar',
                //
                //     data: {petitionId: petitionId},
                //
                //     success: function (data) {
                //
                //         alert(data.success);
                //
                //     }
                //
                // });
            }
        });
    });
</script>