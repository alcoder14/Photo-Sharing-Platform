const search_input = document.querySelector("#search_input");
const users_container = document.querySelector(".users");

console.log("here")

const sendRequest = async (e) =>{
    let search_text = search_input.value;    

    if(search_text != "" && e.keyCode != 16){
        let response = await fetch("../Users/search-users.php", {
            method: "POST",
            body: new URLSearchParams("username=" + search_text)
        });

        let text = await response.text();
        console.log(text);
        users_container.innerHTML = text;
    }
}

search_input.addEventListener("keyup", sendRequest)

console.log(search_input.value)

if(search_input.value != ""){
    console.log("Here")
    sendRequest();
}

