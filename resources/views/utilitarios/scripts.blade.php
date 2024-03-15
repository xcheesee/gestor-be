<script>
    var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

    $(document).ready(function(){
        $('.date').mask('00/00/0000');
        $('.time').mask('00:00:00');
        $('.date_time').mask('00/00/0000 00:00:00');
        $('.cep').mask('00000-000');
        $('.phone').mask(maskBehavior,options);
        $('.phone_with_ddd').mask('(00) 0000-0000');
        $('.phone_us').mask('(000) 000-0000');
        $('.rf').mask('000000-0');
        $('.dotacao').mask('00.00.00.000.0000.0.000.00000000.00.0');
        $('.processo_sei').mask('0000.0000/0000000-0');
        $('.contrato').mask('000/SSSS/0000');
        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('.money').mask('000.000.000.000.000,00', {reverse: true});

        //$('.mixed').mask('AAA 000-S0S'); //leia abaixo:
        /*O usuário poderá digitar uma sequência de três caracteres alpha números, seguido de espaço, seguido de três caracteres números,
        seguido de traço, seguido de um caractere do tipo string, seguido de um caractere do tipo inteiro e seguido de um caractere do tipo string.*/

        $('.jmulti').multiSelect({
            selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Clique na lista abaixo para selecionar, digite aqui para filtrar'>",
            selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Clique na lista abaixo para remover, digite aqui para filtrar'>",
            afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function(e){
            if (e.which === 40){
                that.$selectableUl.focus();
                return false;
            }
            });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function(e){
            if (e.which == 40){
                that.$selectionUl.focus();
                return false;
            }
            });
            },
            afterSelect: function(){
            this.qs1.cache();
            this.qs2.cache();
            },
            afterDeselect: function(){
            this.qs1.cache();
            this.qs2.cache();
            }
        });


        //habilita tooltips (bootstrap)
        $('[data-toggle="tooltip"]').tooltip();
    });

    var loadPreviewFoto = function(event) {
      var previewFoto = document.getElementById('previewFoto');
      previewFoto.src = URL.createObjectURL(event.target.files[0]);
      previewFoto.onload = function() {
        URL.revokeObjectURL(previewFoto.src) // free memory
      }
    };

    //$("select").bsMultiSelect();

    function formataDinheiro(data)
    {
        console.log(data);
        data = parseFloat(data);
        return data.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
    }
</script>
