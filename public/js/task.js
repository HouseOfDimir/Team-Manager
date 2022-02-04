$(function(){
    $('.collapser').atomCollapse();
    $('.color').attr('readonly', false)
    $('.color').siblings('label').css('opacity', 0.7)
    $('.color').css('cursor', 'pointer')
})
