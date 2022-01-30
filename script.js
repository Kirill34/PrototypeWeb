
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

function addDataElementIntoTable(element_name, element_mission)
{
    let table = document.getElementsByTagName("table").item(0)
    let tbody = table.getElementsByTagName("tbody").item(0)
    let row = tbody.insertRow()
    row.setAttribute("dataelement", element_name)
    row.insertCell().innerText = element_mission

}

function addDataDirectionSelects()
{
    let table = document.getElementsByTagName("table").item(0)
    let tbody = table.getElementsByTagName("tbody").item(0)
    let rows = tbody.rows

    trs = tbody.getElementsByTagName("tr");
    let counter = 0
    for (let item of rows) {

        dataelement = trs.item(counter).getAttribute("dataelement")
        console.log(dataelement)

        let cell = item.insertCell();
        let select = document.createElement("select")
        select.setAttribute("dataelement", dataelement)

        let optionSelect = document.createElement("option")
        optionSelect.text = "..."
        optionSelect.disabled = true
        optionSelect.selected = true

        let optionInput = document.createElement("option")
        optionInput.text = "Входные данные"
        optionInput.value = "input"

        let optionOutput = document.createElement("option")
        optionOutput.text = "Выходные данные"
        optionOutput.value = "output"

        let optionUpdatable = document.createElement("option")
        optionUpdatable.text = "Обновляемые данные"
        optionUpdatable.value = "updatable"

        select.appendChild(optionSelect)
        select.appendChild(optionInput)
        select.appendChild(optionOutput)
        select.appendChild(optionUpdatable)

        select.style.margin = "20px"

        select.setAttribute("onchange",  "$.post('api.php',  'student=1&interaction=2&elementName="+this.dataelement+"&direction='+this.value,  function (data) {  obj = JSON.parse(data); let b = document.getElementById('"+this.dataelement+"-direction-alert'); b.innerText = obj.message; if (obj.correct=='false') { b.classList.remove('alert-success'); b.classList.add('alert-danger'); } else { b.classList.remove('alert-danger'); b.classList.add('alert-success');  }  } )")

        cell.appendChild(select)



        let message_block = document.createElement("div")
        message_block.classList.add("alert")
        message_block.id = dataelement+"-direction-alert"
        message_block.style.width = "320px"
        message_block.style.margin = "20px"



        message_block.setAttribute("role", "alert")
        message_block.innerText = "ОК"
        cell.appendChild(message_block)

            counter++
        //cell.innerText = "Входной/выходной/обновляемый"
    }



    let thead = table.getElementsByTagName("thead").item(0).getElementsByTagName("tr").item(0)
    thead.innerHTML += "<th scope='col'>Направления данных</th>"
}