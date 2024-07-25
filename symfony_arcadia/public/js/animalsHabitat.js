
function presentation(id, nbAnimal, idAnimal)
{
        let presentation = document.getElementsByClassName(`presentation_animaux`);
        presentation[(id)%nbAnimal].classList.remove("hidden");
        presentation[(id)%nbAnimal].classList.add('visible'); 
        window.location.href = `../click/${idAnimal}`;
        
}

function hiddenPresentation(id, nbAnimal)
{
        let presentation = document.getElementsByClassName("presentation_animaux");
        let detail = document.getElementById(`rapportVet[${id}]`);
        presentation[(id)%nbAnimal].classList.remove("visible");
        presentation[(id)%nbAnimal].classList.add("hidden");
        detail.classList.add("hidden")
}

function showDetail(id)
{
        let detail = document.getElementById(`rapportVet[${id}]`);
        detail.classList.remove("hidden");
}
