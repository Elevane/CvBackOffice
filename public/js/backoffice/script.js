



var valeurDuRange = $('#valeurDuRange');
var range = $('#range');

$(document).on('input', '#range',  function(){
    valeurDuRange.html(($(this).val()));
    $('#skill_ratio').val($(this).val() * 5);
});

if($('#project_skills').val() != null){

    var skills = $('#project_skills').val().split(' ');
    if(skills && skills.length && skills[0] != ""){
        for(var i = 0; i < skills.length; i++){
            console.log(skills);
            if(i === 0){
                var hiddenSkill = $('#project_skills').val();
                $('#project_skills').val(  hiddenSkill + " ");
            }
            $('#skills_add option[value=' + skills[i] + ']').remove();
            $('#skills_buttons').append('<button type="button" id="'+skills[i]+'" class="buttons">'+ skills[i]+'</button>');
        }
    }


}

$('#skills_add').on('change', function (){

    if(this.value !== "choose"){
        var skill = $('#skills_add').val();
        $('#skills_buttons').append('<button type="button" id="'+skill+'" class="buttons">'+ skill+'</button>');
        $('#skills_add option:selected').hide();
        var hiddenSkill = $('#project_skills').val();
        $('#project_skills').val(  hiddenSkill += skill + " ");
    }

});

//quand on enleve un bouton de skills
$('#skills_buttons').on('click', function (e){
    if (!e.target) {
    } else {
        $('#' + e.target.id).remove();

    }
    $('#skills_add').append(new Option(e.target.id, e.target.id));
    var skills = $('#project_skills').val().split(' ');
    if(skills){
        var newVal = "";
        for(var i = 0; i < skills.length; i++){

            if(skills[i] !== e.target.id){
                newVal += skills[i] + " ";
            }


        }
        $('#project_skills').val(newVal);
    }
});