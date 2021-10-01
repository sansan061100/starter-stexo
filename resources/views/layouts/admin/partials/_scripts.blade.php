<!-- jQuery  -->
<script src="{{ asset('') }}assets/js/jquery.min.js"></script>
<script src="{{ asset('') }}assets/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('') }}assets/js/jquery.slimscroll.js"></script>
<script src="{{ asset('') }}assets/js/waves.min.js"></script>

<!-- App js -->
<script src="{{ asset('') }}assets/js/app.js"></script>
<script src="{{ asset('') }}assets/js/crud.js/?v={{ time() }}"></script>
<!-- Required datatable js -->

<script src="{{ asset('') }}assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('') }}assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>


<script src="{{ asset('') }}assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="{{ asset('') }}assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!-- Alertify js -->
<script src="{{ asset('') }}assets/plugins/alertify/js/alertify.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script>
    $("form").on("submit", function(e) {
        $(this)
            .find('input.number')
            .each(function() {
                const nilai = $(this)
                    .val().replace(/\./g, '')
                $(this).val(nilai);
            });

        number();
    });
</script>
