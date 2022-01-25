
function hideAll()
{
    var blocks=document.getElementsByClassName('serviceblock');
    document.getElementById('toDataDirectionsBtn').hidden = true;

    for (let item of blocks)
    {
        item.hidden=true
    }
}

function removeActiveClass()
{
    var nav_links = document.getElementsByClassName("nav-link");
    for (let item of nav_links)
    {
        item.classList.remove("active")
    }
}

function getSelectionRange()
{
    node1 = document.getSelection().anchorNode.parentNode.offsetParent
    node2 = document.getSelection().focusNode.parentNode.offsetParent
    array = node1.parentElement.getElementsByTagName("div")
    let startSelection = 0, endSelection = 0;
    for (i=0; i<array.length; i++)
    {
        if (array[i] == node1)
            startSelection = i+1;
        if (array[i] == node2)
            endSelection = i+1;
    }

    return {"start": startSelection, "end": endSelection};
}

function showMessage(message)
{
    element = document.getElementById("current_message");
    element.innerText = message;
    element.hidden = false;
    setTimeout(()=>{element.hidden = true;}, 2500);

}

function lockSelect(intaractionBlockID, selectIndex)
{
    element = document.getElementById(intaractionBlockID).getElementsByTagName("select")[selectIndex].disabled=true;
}