$(function(){
    $('.a-input-file').atomFileInput()

    $('.verifyDate').datepicker({
        format: 'dd/mm/yyyy',
        language: 'fr-FR,',
        autoclose: true,
        setDate: new Date()
    })
})
