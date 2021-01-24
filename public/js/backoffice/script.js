



var valeurDuRange = $('#valeurDuRange');
var range = $('#range');

$(document).on('input', '#range',  function(){
    valeurDuRange.html(($(this).val()));
    $('#skill_ratio').val($(this).val() * 5);
});
