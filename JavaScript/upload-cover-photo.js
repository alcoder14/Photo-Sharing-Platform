const photo_preview = document.querySelector("#photo")
const input = document.querySelector(".cover-photo-input");
const form = document.querySelector(".settings-form")

input.addEventListener("change", (e)=>{
    if(e.target.files){
        const file = e.target.files[0];

        const reader = new FileReader();
        reader.onload = () =>{
            const image_url = reader.result;
            photo_preview.src = image_url;
        } 
        reader.readAsDataURL(file);
    }
})


