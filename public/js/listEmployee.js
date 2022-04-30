$(function(){
    $('#a-input-shuffle').atomShuffleInstance();
    $('.verifyDate').datepicker({
        format: 'dd/mm/yyyy',
        language: 'fr-FR,',
        autoclose: true,
        setDate: new Date(),
        daysOfWeekDisabled:[0,6],
        daysOfWeekHighlighted:[1,5]
    });

    $('input[name="fkEmployee[]"]').prop('checked', true);
})
