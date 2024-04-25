const ajax = new XMLHttpRequest();

function sendData(event, formId, url) {
    event.preventDefault();
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    ajax.onreadystatechange = function () {
        if (ajax.readyState === XMLHttpRequest.DONE) {
            if (ajax.status === 200) {
                if (url === "vendor.php") processText();
                if (url === "category.php") processJson();
                if (url === "price.php") processXML();
            } else {
                console.error("error: " + ajax.status);
            }
        }
    };

    ajax.open("POST", url, true);
    ajax.send(formData);
}

function processText() {
    document.getElementById("tableBody").innerHTML = ajax.response;
}

function processJson() {
    const data = JSON.parse(ajax.responseText);
    let trs = "";
    for (const item of data) {
        trs += `<tr><td>${item.name}</td>`;
        trs += `<td>${item.price}</td>`;
        trs += `<td>${item.quantity}</td>`;
        trs += `<td>${item.quality}</td>`;
        trs += `<td>${item.vendor}</td>`;
        trs += `<td>${item.category}</td></tr>`;
    }

    document.getElementById("tableBody").innerHTML = trs;
}

function processXML() {
    const xmlDoc = ajax.responseXML;

    const items = xmlDoc.getElementsByTagName("item");
    let trs = "";

    for (let i = 0; i < items.length; i++) {
        const item = items[i];
        const name = item.getElementsByTagName("name")[0].textContent;
        const price = item.getElementsByTagName("price")[0].textContent;
        const quantity = item.getElementsByTagName("quantity")[0].textContent;
        const quality = item.getElementsByTagName("quality")[0].textContent;
        const vendor = item.getElementsByTagName("vendor")[0].textContent;
        const category = item.getElementsByTagName("category")[0].textContent;

        const row = `
            <tr>
                <td>${name}</td>
                <td>${price}</td>
                <td>${quantity}</td>
                <td>${quality}</td>
                <td>${vendor}</td>
                <td>${category}</td>
            </tr>
        `;
        trs += row;
    }

    document.getElementById("tableBody").innerHTML = trs;
}
