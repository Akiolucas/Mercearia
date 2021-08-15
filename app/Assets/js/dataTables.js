$(document).ready(function() {
    $('#listar-produtos').DataTable( {
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "http://localhost/mercearia/produtos/listar",
            "dataSrc":""
        },
        "columns":[
            {"data": "nome"},
            {"data": "preço"},
            {"data": "fornecedor"},
            {"data": "código"},
            {"data": "kilograma"},
            {"data": "dt_registro"}

        ]
    });
});