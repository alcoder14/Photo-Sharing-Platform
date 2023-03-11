// Toggle Modal Window

console.log("Hello")

const add_photo_btn = document.querySelector("#add-photo");
const add_photo_btn_mobile = document.querySelector(".mobile-icon");

console.log(add_photo_btn);
console.log(add_photo_btn_mobile)

const container = document.querySelector(".upload-modal-container");
const close_btn = document.querySelector("#close");

add_photo_btn.addEventListener("click", ()=>{
    container.style.display = "flex";
})
add_photo_btn_mobile.addEventListener("click", ()=>{
    container.style.display = "flex";
})

// Add EventListener to add-btn on mobile header
window.addEventListener("resize", ()=>{
    if(window.innerWidth <= 800){
        const add_photo_mobile_btn = document.querySelector(".mobile-add")
        add_photo_mobile_btn.addEventListener("click", ()=>{
            container.style.display = "flex";
        })
    }
})

const closeModal = () =>{
    container.style.display = "none";
}

// Manage Selected File

const upload_section = document.querySelector(".upload-section");
const file_input = document.querySelector(".file-input");

upload_section.addEventListener("dblclick", ()=>{
    file_input.click();
})

let image_code
file_input.addEventListener("change", (e)=>{
    console.log("Hello")
    let file = e.target.files[0];

    let reader = new FileReader();
    reader.onload = () =>{
        image_code = reader.result;
        display_photo_form(image_code)
    }
    reader.readAsDataURL(file);
})

const form_section = document.querySelector(".form-section")
const selected_image = document.querySelector(".selected-image")
const input_form_parent = document.querySelector(".input-parent")
const location_input = document.querySelector("#location-input")

const display_photo_form = (image) => {
    upload_section.style.display = "none";
    
    selected_image.addEventListener("load", ()=>{
        let image_width = selected_image.width
        let image_height =  selected_image.height

        if(image_width > image_height){
            /*
            selected_image.style.width = "50%";
            selected_image.style.height = "auto";
            */
            selected_image.classList.add("bigger-by-width")
        } else {
            /*
            selected_image.style.width = "auto";
            selected_image.style.height = "250px";
            */
            selected_image.classList.add("bigger-by-height")
        }

        file_input.classList.remove("file-input")
        file_input.classList.add("input");

        input_form_parent.insertBefore(file_input, location_input)
        form_section.style.display = "flex"; 
    })

    selected_image.src = image

}

const discard_btn = document.querySelector(".discard-btn");
console.log(discard_btn);

const deleteForm = () =>{
    console.log("Hello")
    file_input.classList.remove("input");
    file_input.classList.add("file-input");

    form_section.style.display = "none";
    upload_section.style.display = "flex"

    file = undefined
    image_code = undefined

    closeModal()
}

discard_btn.addEventListener("click", deleteForm)
close_btn.addEventListener("click", deleteForm)
