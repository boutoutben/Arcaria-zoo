
function presentation(id)
{
        let presentation = document.getElementsByClassName("presentation_animaux");
        presentation[(id-1)%6].classList.remove("hidden")
        presentation[(id-1)%6].classList.add('visible'); 
}

function hiddenPresentation(id)
{
        let presentation = document.getElementsByClassName("presentation_animaux");
        presentation[(id-1)%6].classList.remove("visible");
        presentation[(id-1)%6].classList.add("hidden");
}

