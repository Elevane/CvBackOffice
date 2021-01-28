const valeurDuRange = document.getElementById('valeurDuRange')
const range = document.getElementById('range')
let hiddenskills = document.getElementById('project_skills')
let select_skill = document.getElementById('skills_add')
const skills_button_list = document.getElementById("skills_buttons")


//la valeur des ratio est proportionné
document.addEventListener('input', range,  function(){
    valeurDuRange.innerHTML = this.value
    document.getElementById('skill_ratio').value = this.value * 5
});


// ajout des bouton des skills qui existent déja sur ce project
// suppresion des option du select qui ne peuvent être choisies car déja choisies.
if(hiddenskills != null){
    let skills = hiddenskills.value.split(' ');
    if(skills && skills.length && skills[0] !== ""){
        for(let i = 0; i < skills.length; i++){
            if(i === 0){
                hiddenskills.value += " "
            }
            document.querySelector(' #skills_add option[value="'+ skills[i]+'"]').remove();
            var button = document.createElement('button')
            button.type = "button"
            button.id = skills[i]
            button.classList.add("backoffice_edit_skills_buttons")
            button.innerHTML = skills[i]
            skills_button_list.appendChild(button)
        }
    }

//lors du clique sur un choix du select ajoute à l'input caché le skill
// concerné et ajoute un bouton dans la liste des skills de ce projet
}if(select_skill !== null){
    select_skill.addEventListener('change', function (){
        if(this.value !== "choose"){
            var skill = select_skill.value;
            var button = document.createElement('button')
            button.type = "button"
            button.id = skill
            button.classList.add("backoffice_edit_skills_buttons")
            button.innerHTML = skill
            skills_button_list.appendChild(button)
            const {selectedIndex} = select_skill;
            select_skill.remove(selectedIndex)
            hiddenskills.value += skill + " "
        }

    })
}

// suppresion des boutons de skills qu'on on clicke dessus
//supprime égelement les valeurs dans l'input caché
if(skills_button_list !== null){

    skills_button_list.addEventListener("click", function(e){
        if (!e.target) {

        } else {
            if (e.target.id !== "skills_buttons") {
               document.getElementById(e.target.id).remove();
                var option = document.createElement('option')
                option.value = e.target.id
                option.innerHTML = e.target.id
                select_skill.appendChild(option);
                let skills = hiddenskills.value.split(' ');
                if (skills) {
                    var new_value = "";
                    for (var i = 0; i < skills.length; i++) {
                        if (skills[i] !== e.target.id) {
                            new_value += skills[i] + " ";
                        }
                    }
                    hiddenskills.value = new_value;
                }
            }
        }
    })

}
