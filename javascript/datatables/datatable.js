$(document).ready( function () {
       
    $('#dtUsers').DataTable({
        "pagingType": "simple_numbers",
        "order": [[ 0, "asc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [3,4,5,6]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    });
    
    $('#dtPlantDash').DataTable({
        "pagingType": "full_numbers",
        "order": [[ 0, "asc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3,4]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('#dtCustomers').DataTable({
        "pagingType": "simple_numbers",
        "order": [[ 0, "asc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    }),

    $('#dtPlants').DataTable({
        "pagingType": "simple_numbers",
        "order": [[ 0, "asc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,4,5]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    }),

    $('#dtListPlants').DataTable({
        "pagingType": "simple_numbers",
        "order": [[ 0, "asc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3,4]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    }),

    $('#dtComputer').DataTable({
        "pagingType": "simple_numbers",
        "order": [[ 0, "asc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [2,4,5,6]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    }),

    $('#dtRequests').DataTable({
        "pagingType": "simple_numbers",
        "order": [[ 0, "desc" ]],
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3,4,5]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    }),

    $('#dtDataDispenser').DataTable({
        "pagingType": "simple_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti"
            }
        }
    }),

    $('#dtLogInsert').DataTable({
        "pagingType": "full_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('#dtLogDelete').DataTable({
        "pagingType": "full_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('#dtLogUpdate').DataTable({
        "pagingType": "full_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('#dtLogMigration').DataTable({
        "pagingType": "full_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('#dtLogRequest').DataTable({
        "pagingType": "full_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('#dtBug').DataTable({
        "pagingType": "full_numbers",
        "aaSorting": [],
            columnDefs: [{
            orderable: false,
            targets: [4,5,6,7,8]
        }],
        "language": {
            "paginate": {
                "previous": "Indietro",
                "next": "Avanti",
                "first": "Primo",
                "last": "Ultimo"
            }
        }
    }),

    $('.dataTables_length').addClass('bs-select');
});