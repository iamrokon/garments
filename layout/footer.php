        <!-- Begin Page Vendor Js -->
        <script src="assets/vendors/js/nicescroll/nicescroll.min.js"></script>
        <script src="assets/vendors/js/chart/chart.min.js"></script>
        <script src="assets/vendors/js/progress/circle-progress.min.js"></script>
        <script src="assets/vendors/js/calendar/moment.min.js"></script>
        <script src="assets/vendors/js/calendar/fullcalendar.min.js"></script>
        <script src="assets/vendors/js/owl-carousel/owl.carousel.min.js"></script>
        <script src="assets/vendors/js/app/app.js"></script>
        <!-- End Page Vendor Js -->

        <script src="assets/vendors/js/base/jquery.min.js"></script>
        <script src="assets/vendors/js/base/core.min.js"></script>

        <!-- datatable link -->
        <script src="assets/vendors/js/datatables/datatables.min.js"></script>
        <script src="assets/vendors/js/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/vendors/js/datatables/jszip.min.js"></script>
        <script src="assets/vendors/js/datatables/buttons.html5.min.js"></script>
        <script src="assets/vendors/js/datatables/pdfmake.min.js"></script>
        <script src="assets/vendors/js/datatables/vfs_fonts.js"></script>
        <script src="assets/vendors/js/datatables/buttons.print.min.js"></script>
        <script src="assets/vendors/js/app/app.min.js"></script>
        <script src="assets/js/components/tables/tables.js"></script>

        <!-- End Vendor Js -->
        <!-- Begin Page Snippets -->
        <script src="assets/js/dashboard/dashboard.js"></script>
        <script src="assets/js/adminlte.min.js"></script>
        <script src="assets/js/demo.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/js/jquery.sparkline.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/jquery-jvectormap-world-mill-en.js"></script>
        <!-- End Page Snippets -->

        <script src="assets/vendors/js/base/bootstrap.min.js"></script>
        <script src="assets/select2/select2.min.js"></script>

        <script>

         $( document ).ready(function() {
               $.ajaxSetup ({
               cache: false
            });

            $('.select2').select2({
              theme: "classic"
            });
         });

         $(document).keypress(
          function(event){
          if (event.which == '13') {
            event.preventDefault();
           }
         });

       </script>
