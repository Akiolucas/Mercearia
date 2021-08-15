$(document).ready(function() {
    $('#listar-produtos').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        },
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "http://localhost/mercearia/produtos/listar",
            "dataSrc":""
        },
        "columns":[
            {"data": "id"},
            {"data": "nome"},
            {"data": "preço"},
            {"data": "fornecedor"},
            {"data": "código"},
            {"data": "kilograma"},
            {"data": "dt_registro"}

        ]
    });
});