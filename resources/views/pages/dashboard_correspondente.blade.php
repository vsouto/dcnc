@extends('layouts.app')

@section('content')

<!-- Main Container starts -->
<div class="main-container">

    <!-- Container fluid Starts -->
    <div class="container-fluid">

        <!-- Spacer starts -->
        <div class="spacer">

            <!-- Row Starts -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="blog blog-success no-margin">
                        <div class="blog-header">
                            <h5 class="blog-title">Suas Diligências</h5>
                        </div>
                        <div class="blog-body">
                            <div class="table-responsive">
                                <div id="dt_example" class="table-responsive example_alt_pagination clearfix">
                                    <div id="data-table_wrapper" class="dataTables_wrapper" role="grid">
                                        {!! $grid->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row Ends -->

            <br style="clear:both">


        </div>
        <!-- Spacer ends -->

    </div>
    <!-- Container fluid ends -->
</div>
<!-- Main Container ends -->

@endsection

@section('footer')

    <!-- JVector Map -->
    <script src="{{ asset('js/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('js/jvectormap/jquery-jvectormap-usa.js') }}"></script>

    <script src="{{ asset('js/jvectormap/maps/brazil.js') }}"></script>

    <!-- chart -->
    <script src="{{ asset('js/flot/custom/stacked-dashboard.js') }}"></script>

    <script src="{{ asset('js/custom-index.js') }}"></script>

    <script>
        $('.view-diligencia').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });
    </script>
@endsection