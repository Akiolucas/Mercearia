$(document).ready(function() {
    $('#listar-produtos').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        },
        "order":[[7,'desc']]
    });
});
