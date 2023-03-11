const search_bar = document.querySelector("#search-bar");
const live_search_results = document.querySelector(".column")

let search_text;
search_bar.addEventListener("keyup", async (e)=>{
    search_text = search_bar.value;

    // Make Request
    if(search_bar.value != "" && e.keyCode != 16){
        let response = await fetch("search.php", {
            method: "POST",
            body: new URLSearchParams("text=" + search_text)
        });
        let text = await response.text();


        // Put results on screen
        live_search_results.innerHTML = text;
        // Make every result clickable
        let results_elements = document.querySelectorAll(".search-result");
        results_elements.forEach(elem => elem.addEventListener("click", submitForm));

    }

    // Delete Results from Screen
    if(search_bar.value == "" && live_search_results.hasChildNodes()){
        removeResults();
    }
})

const submitForm = (e) =>{
    search_bar.value = e.target.innerHTML
    
    // Remove results from screen
    removeResults();
}

const removeResults = () =>{
    live_search_results.innerHTML = "";
}