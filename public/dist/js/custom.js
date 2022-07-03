


async function setValueForAttr(event, value){
    localUrl = 'http://127.0.0.1:8000/';

    let id = event.target.value;

    let attributeValues;

    let ValuesToHtml = ``;
    
    // get attribute values from the data base and put them inside the select
    await fetch(localUrl+ 'api/attrValue', {
        headers: {
            "Content-type": "application/json",
            Accept : 'application/json'
        },
        method : 'POST',
        body: id
    })
    .then((res) => {
        return res.json()
    }).then(res => {
        console.log(res)
        attributeValues = res
    })
    
    attributeValues.forEach(value => {
        ValuesToHtml += `<option value="${value.value}">${value.value}</option>`;
    })

    // set data to the dom
    document.querySelector('#'+value).innerHTML = ValuesToHtml
    
}

function createNewAttr({ attributes, id }){
    return  `
        <div class="row" id="attr${id}">
            <div class="col-4">
                <div class="form-group">
                    <label for="attrValue">ویژه گی</label>
                    <select name="attribute[${id}][name]" id="attribute${id}" data-value="attribute${id}" onchange="setValueForAttr(event, 'attrValue${id}')" class="form-control selectAttribute py-2" style="width: 100%;">
                        <option value="">انتخاب کنید</option>
                        ${
                            attributes.map((item) => {
                                return `<option value="${item.id}">${item.name}</option>`;
                            })
                        }
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label> مقدار ویژه گی</label>
                    <select name="attribute[${id}][value]" id="attrValue${id}" data-value="attribute${id}" class="form-control selectAttribute" style="width: 100%;text-align: right">
                    
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <div>
                        <label>اقدامات</label>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="removeAttr('attr${id}')">حذف ویژه گی</button>
                </div>
            </div>
        </div>
    `;
}

function newAttribute(attribute){

    let attributesDiv = $('#attributeDiv');

    let id = document.querySelector('#attributeDiv').children.length;

    attributesDiv.append(
        createNewAttr({
            attributes: attribute,
            id
        })
    );

    $('.selectAttribute').select2({ tags: true });    
    
}



function removeAttr(id){
    let attribute = document.querySelector('#'+id);
    attribute.remove();
}   