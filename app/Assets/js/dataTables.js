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
            {"data": "preço",
            render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' )
            },
            {"data": "fornecedor"},
            {"data": "código"},
            {"data": "kilograma",
            render: $.fn.dataTable.render.number( '.', ',', 3, "",' Kg' )
            },
            {"data": "dt_registro",
                render:function (data,type, row)
                {
                    var horas = data.split(' ');
                    var date = horas[0].split('-');
                    return type === "display" || type === "filter" ?
                    date[2] + '/'+ date[1] + '/' + date[0] + ' ' + horas[1] : data;
                }
            }

        ]
    });
});