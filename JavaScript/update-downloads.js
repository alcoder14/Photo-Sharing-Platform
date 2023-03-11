const download_image_btn = document.querySelector(".download-image");
const image_id = document.querySelector("#image_id").innerHTML;
const downloads_number = document.querySelector(".downloads_number")

const updateDownloadsCount = async () =>{
    let req = await fetch("../PhotoView/updateDownloads.php", {
        method: "POST",
        body: new URLSearchParams("number=" + image_id)
    })

    let res = await req.text();
    downloads_number.innerHTML = res;
}

download_image_btn.addEventListener("click", updateDownloadsCount)
