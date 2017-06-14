<script>


    $(function() {
        // sub menus active?
        setTimeout(function () {
            $('.highlight').find('ul').show();
        }, 50);
    });


    function getCorrespondentes() {

        return 'ae';
    }

    function PrintElem(elem)
    {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + document.title  + '</h1>');
        mywindow.document.write( elem.html());
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }

    // Populate Statuses
    function populateStatusFields(data) {

        var statuses = JSON.parse(data);

        for( key in statuses ) {
            // Populate the field
            $('.' + key  + '-content').html(statuses[key].toFixed(0) + '%');
        }
    }

    //
    function getComarcas(uf, selected) {

        var where = '#comarcas-select';

        $(where).empty();

        // Get the info
        $.ajax({
            url: '{{ route('getComarcas') }}',
            type: "GET",
            data: {
                uf: uf
            }
        }).done(function(data) {

            // Create the first option
            $("<option value='0'>-- Please Select --</option>").appendTo( where );

            for ( key in data ) {

                // Create the options
                $("<option value='"+ data[key].id +"'>"+ data[key].comarca +"</option>", {value: data[key].id }).appendTo( where );
            }

            if (typeof (selected) != 'undefined')
                $(where).val( selected );

        }).complete(function(xhr, textStatus, data) {

            if (xhr.status == 422) {
                $('#error_msg').html( xhr.responseJSON.name);
                $('#error_panel').show();
                alert('Some error ocurred.');
            }

        });
    }
</script>