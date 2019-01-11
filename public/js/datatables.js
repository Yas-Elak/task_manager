$(document).ready(function () {
    /*I create a second header y cloning the first one, like that if i want I can put the name of the header on
     *the placeholder of the search bar. Now on each column I put a searchbar who works only on his own column
     *then i put a listener who will hide the value who are not corresponding with the input
     * */
    $('#table thead tr').clone(true).prop('id', 'column-title').appendTo('#table thead');
    $('#table thead tr:eq(0) th').each(function (i) {
        $(this).html('<input type="text" />');

        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    $("#column-search").hide();

    /*
   *Option for the datatables
    */
    $('#table').DataTable({
        scrollX: true,
        columnDefs: [{
            "targets": [],
            "visible": false,
        }],
        dom: 'Bfrtip',
        stateSave: true,
        buttons: [{
            extend: 'colvis',
            collectionLayout: 'fixed three-column'
        }, {
            text: 'Search by column',
            action: function () {
                $("#column-search").toggle();
            }
        }]
    });


    $(".delete-form").submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var element_id = $(this).attr("data-id");
        $("#deleted-element-id").text(element_id);
        $('#delete-modal').modal('show');
        $("#delete-confirmation").click(function () {
            $($form).unbind('submit').submit();
        });

    });

});
