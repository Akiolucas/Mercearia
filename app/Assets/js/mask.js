let maskCnpj = $('#form-cnpj');
maskCnpj.mask('00.000.000/0000-00');

let maskPreco = $('#form-preco');
if(maskPreco.val() == "")
{
    maskPreco.val('0.10');
}
maskPreco.mask('000.000.000.000,00',{reverse:true});

let maskKilograma = $('#form-kilograma');
if(maskKilograma.val() == "")
{
    maskKilograma.val('0.001');
}
maskKilograma.mask('000.000.000.000,000',{reverse:true});