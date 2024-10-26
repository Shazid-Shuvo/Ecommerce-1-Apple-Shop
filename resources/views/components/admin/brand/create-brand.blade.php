<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Brand</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Brand Name *</label>
                                <input type="text" class="form-control" id="brandName">
                            </div>
                            <br/>
                            <div class="col-12 p-1">
                            <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                            <br/>

                            <label class="form-label">Image</label>
                            <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="brandImg">
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<script>


    async function Save() {
        try {
            let brandName = document.getElementById('brandName').value;
            let brandImg = document.getElementById('brandImg').files[0];

            if (brandName.length === 0) {
                errorToast("brand Category Required !")
            }else if (!brandImg) {
                errorToast("brand Image Required !")
            } else {

                document.getElementById('modal-close').click();

                let formData = new FormData();
                formData.append('image', brandImg)
                formData.append('name', brandName)

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                showLoader();
                let res = await axios.post("/AddBrand", formData, config)
                hideLoader();

                if (res.status === 201 || res.status===200) {
                    successToast('Request completed');
                    document.getElementById("save-form").reset();
                    await brandList();
                } else {
                    errorToast("Request fail !")
                }
            }
        }
        catch (e) {
            alert(e);
        }
    }
</script>

