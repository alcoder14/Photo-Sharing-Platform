<div class="upload-modal-container">
    <div class="window">
        <div class="discard-line">
            <i class="fa-sharp fa-solid fa-xmark" id="close"></i>
        </div>
        <div class="upload-section">
            <i class="fa-solid fa-upload"></i>
            <h3>Upload</h3>
            <input type="file" name="image" class="file-input" accept=".png, .jpg, .jpeg">
        </div>
        <form action="../Modals/UploadPhotoModal/upload-photo.php" method="post" enctype="multipart/form-data" class="form-section">
            <div class="input-parent">
                <div class="image-container">
                    <img class="selected-image">
                </div>
                <input type="text" name="location" placeholder="Location" class="input" id="location-input">
            </div>
                <select name="category" id="display-inline">
                    <option value="wildlife">Wildlife</option>
                    <option value="scientific">Scientific</option>
                    <option value="landscape">Landscape</option>
                    <option value="astro">Astro</option>
                    <option value="aerial">Aerial</option>
                    <option value="travel">Travel</option>
                    <option value="macro">Macro</option>
                    <option value="food">Food</option>
                    <option value="architecture">Architecture</option>
                    <option value="underwater">Underwater</option>
                </select>
                <select name="software">
                    <option value="Adobe Photoshop">Adobe Photoshop</option>
                    <option value="Adobe Lightroom">Adobe Lightroom</option>
                    <option value="Photopea">Photopea</option>
                    <option value="Darktable">Darktable</option>
                    <option value="RawTherapee">RawTherapee</option>
                    <option value="Luminar Neo">Luminar Neo</option>
                    <option value="Not specified">Other</option>
                </select>
                <!--
                <textarea name="caption" placeholder="Caption" rows="6"></textarea>
                -->
            <div class="bottom-side">
                <button type="submit" class="upload-submit">Submit</button>
                <button class="discard-btn" type="button">Discard</button>
            </div>

        </form>
    </div>
</div>