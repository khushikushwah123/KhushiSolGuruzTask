<script src="{{ asset('admin_assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/demo.js') }}"></script>
<script src="{{ asset('admin_assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/twitter-bootstrap.js') }}"></script>
<script src="{{ asset('admin_assets/js/js_dataTables.js') }}"></script>
<script src="{{ asset('admin_assets/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('admin_assets/js/moment.min.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    $(document).ready(function() {
        $('.nav-link').click(function() {
            $(this).parent().find('ul').toggle();
        })
    })
</script>
<!-- Datatable -->
<script>
    new DataTable('.table');
</script>

<!-- Active Links -->
<script>
    jQuery(function($) {
        var path = window.location.href;
        $('.nav-sidebar .nav-item .nav-link').each(function() {
            if (this.href === path) {
                $(this).addClass('active');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.navbar-nav').click(function() {
            $('.sidebar-mini').toggleClass('sidebar-collapse');
        });
    });
</script>
<script>
    $(document).ready(function() {
        setTimeout(() => {
            $('.alert').hide();
        }, 8000);
    });
</script>
