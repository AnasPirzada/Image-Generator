@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Generate Post</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('store-post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Enter Post Title</label>
                                <input type="text" class="form-control" id="postTitle" name="postTitle"
                                    placeholder="Post Title">
                            </div>
                            <div class="mb-3">
                                <label for="postDescription" class="form-label">Enter Description</label>
                                <input type="text" class="form-control" id="postDescription" name="postDescription"
                                    placeholder="Description">
                            </div>
                            <div class="mb-3">
                                <label for="fileInput" class="form-label">Choose File</label>
                                <input type="file" class="form-control" id="fileInput" name="fileInput">
                            </div>
                            <div class="mb-3">
                                <label for="languageSelect" class="form-label">Select Language</label>
                                <select class="form-select" style="background-image:none !important;" id="languageSelect"
                                    name="language">
                                    <option value="ar">Arabic</option>
                                    <option value="hi">Hindi</option>
                                    <option value="ml">Malayalam</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#previewModal" id="previewButton">Preview Post</button>

                        </form>
                        <!-- Preview Modal -->
                        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="margin-top: 100px; width: 1050px;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="previewModalLabel">Image Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="height: 1000px;  position: relative;">
                                        <div id="photo"
                                            style="
                                            width: 1000px;
                                            height: 1000px;
                                            position: relative;
                                            ">
                                            <img src="{{ asset('Images/bg-dubai.png') }}" id="languageImage"
                                                style="
                                            
                                            width: 1000px;height: 1000px;position: absolute;left: 0;top: 0;
                                            z-index: 2;
                                            ">

                                            <div
                                                style="
                                            
                                            position: absolute;left: 0;top: 600px;width: 100%;text-align: center;
                                            padding: 0 50px;z-index: 3;
                                            ">
                                                <h5 id="imageTitle"
                                                    style="
                                                
                                                text-align: center;font-size: 30px;font-weight: bold;
                                                padding: 3px 20px;line-height: 77px;background: #f7e3d3;
                                                display: inline;
                                                ">
                                                    Image
                                                    Title</h5>
                                                <p id="imageDescription"
                                                    style="
                                                margin-top: 10px; text-align: center; font-size: 20px;display: block; color: #fff;
                                                ">
                                                    Image
                                                    Description</p>
                                            </div>
                                            <img id="previewImage" alt="Preview"
                                                style="
                                            width: 1000px;height: 1000px;position:absolute;left: 0;top: 0;z-index: 1;
                                            ">
                                        </div>

                                    </div>
                                    <div id="successMessage" style="text-align: center; display:none; margin-top: 25px;"
                                        class="alert alert-success "></div>
                                    <div class="modal-footer" style="margin-top: 30px";>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="saveImage">Save</button>
                                        <button type="button" class="btn btn-danger" id="download">Download</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var imageInput;

        // ----------- update preview ------------------------------
        function updatePreview() {
            var modalContent = document.getElementById("modalContent");
            var postTitle = document.getElementById("postTitle").value;
            var postDescription = document.getElementById("postDescription").value;
            imageInput = document.getElementById("fileInput");
            var imagePreview = document.getElementById("previewImage");
            var selectedLanguage = document.getElementById("languageSelect").value;

            translateText(postTitle, selectedLanguage, function(translatedTitle) {
                document.getElementById("imageTitle").innerHTML = translatedTitle;

                translateText(postDescription, selectedLanguage, function(translatedDescription) {
                    document.getElementById("imageDescription").innerHTML = translatedDescription;

                    if (imageInput.files && imageInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;

                            document.getElementById("saveImage").disabled = false;
                        };
                        reader.readAsDataURL(imageInput.files[0]);
                    }


                    document.getElementById("saveImage").addEventListener("click", function() {
                        html2canvas(document.getElementById("modalContent")).then(function(canvas) {
                            var screenshotImage = new Image();
                            screenshotImage.src = canvas.toDataURL("image/png");

                            var newCanvas = document.createElement("canvas");
                            var ctx = newCanvas.getContext("2d");
                            newCanvas.width = canvas.width;
                            newCanvas.height = canvas.height;
                            ctx.drawImage(screenshotImage, 0, 0);

                            var title = document.getElementById("imageTitle").textContent;
                            var description = document.getElementById("imageDescription")
                                .textContent;
                            ctx.font = "50px";
                            ctx.fillStyle = "#455772";
                            ctx.fillText(title, 20, canvas.height - 100);
                            ctx.font = "20px";
                            ctx.fillText(description, 40, canvas.height - 30);

                            var newImageDataURL = newCanvas.toDataURL("image/png");
                            downloadImage(newImageDataURL, title + ".png");
                        });
                    });
                });
            });
        }

        var photoDivIdd = null;
        // Function to capture and store the screenshot
        function captureAndStoreScreenshot() {
            return new Promise(function(resolve, reject) {
                html2canvas(document.getElementById("photo")).then(function(canvas) {
                    canvas.toBlob(function(blob) {
                        var reader = new FileReader();
                        reader.onloadend = function() {
                            var screenshotDataURL = reader.result;
                            console.log(
                                "Screenshot captured and stored in 'photoDivId' variable.");

                            var screenshotImage = new Image();
                            screenshotImage.src = screenshotDataURL;

                            resolve(
                                screenshotDataURL
                            );
                        };
                        reader.readAsDataURL(blob);
                    }, "image/png");
                });
            });
        }


        document.getElementById("previewButton").addEventListener("click", updatePreview);

        document.getElementById("fileInput").addEventListener("change", updatePreview);

        document.getElementById("saveImage").addEventListener("click", function() {
            var formData = new FormData();
            if (photoDivIdd == null) {
                captureAndStoreScreenshot()
                    .then(function(photoDivId) {
                        photoDivIdd = photoDivId;
                        var translatedTitle = document.getElementById("imageTitle").textContent;
                        var translatedDescription = document.getElementById("imageDescription").textContent;

                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                        formData.append('postTitle', translatedTitle);
                        formData.append('postDescription', translatedDescription);
                        formData.append('fileInput', imageInput.files[0]);

                        formData.append('photoDivId', photoDivIdd);
                        formData.append('language', document.getElementById("languageSelect").value);
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                        $.ajax({
                            url: "{{ route('store-post') }}",
                            method: 'POST',
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                console.log("Data saved successfully");
                                console.log(response);
                                // Alert Message for the save Data
                                var successMessage = document.getElementById("successMessage");
                                successMessage.textContent = "Data saved successfully";
                                successMessage.style.display = "block";
                            },
                            error: function(xhr, status, error) {
                                console.error("Failed to save data");
                                console.error(xhr
                                    .responseText);
                            },
                        });
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            } else {
                console.error("No screenshot to save.");
            }
        });


        //------------------ Google Translation Api ------------------------------------------------
        function translateText(text, targetLanguage, callback) {
            $.ajax({
                url: 'https://translation.googleapis.com/language/translate/v2',
                method: 'POST',
                dataType: 'json',
                data: {
                    q: text,
                    target: targetLanguage,
                    key: 'AIzaSyA0LWidzMAHY8H5djEbLlxjWLwO_8jcAak'
                },
                success: function(response) {
                    if (response && response.data && response.data.translations) {
                        callback(response.data.translations[0].translatedText);
                    } else {
                        console.error('Translation failed.');
                    }
                },
                error: function() {
                    console.error('Translation failed.');
                }
            });
        }
        // ------------------------------------------Screen SHot js code ----------------------------------
        jQuery(document).ready(function() {
            jQuery("#download").click(function() {
                screenshot();
                captureAndStoreScreenshot();
            });
        });



        function screenshot() {
            html2canvas(document.getElementById("photo")).then(function(canvas) {
                downloadImage(canvas.toDataURL(), "Post.png");
            });
        }

        function downloadImage(uri, filename) {

            var link = document.createElement("a");
            if (typeof link.download !== "string") {

                window.open(uri);
            } else {
                link.href = uri;
                link.download = filename;
                accountForFirefox(clickLink, link);
            }
        }

        function clickLink(link) {
            link.click();
        }

        function accountForFirefox(click) {
            var link = arguments[1];
            document.body.appendChild(link);
            click(link);
            document.body.removeChild(link);
        }

        // selected language and image will change accordingly
        var languageSelect = document.getElementById('languageSelect');
        var languageImage = document.getElementById('languageImage');

        languageSelect.addEventListener('change', function() {
            var selectedLanguage = languageSelect.value;

            switch (selectedLanguage) {
                case 'ar':
                    languageImage.src = "{{ asset('Images/bg-arab.png') }}";
                    break;
                case 'hi':
                    languageImage.src = "{{ asset('Images/bg-india.png') }}";
                    break;
                case 'ml':
                    languageImage.src = "{{ asset('Images/bg-kerala.png') }}";
                    break;
                case 'en':
                    languageImage.src = "{{ asset('Images/bg-dubai.png') }}";
                    break;
                default:
                    echo("Plese Select the Language First");
                    break;
            }
        });
    </script>
@endsection
