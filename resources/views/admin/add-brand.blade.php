@extends('layout.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Add New Brand</h4>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" id="b-save-form">

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Brand Name</label>
                                <input type="text" name="bname" id="bname" class="form-control" placeholder="Enter Brand name" required>
                            </div>
                            <div class="mb-3">
                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="bimage">

                            </div>


                            <div class="text-center">
                                <button type="button" onclick="submitBrandForm()" class="btn btn-primary">Add Brand</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        async function submitBrandForm() {
            // try {
            // Get input values
            let name = document.getElementById('bname').value;
            let productImg = document.getElementById('bimage').files[0];

alert(name);

             if (name.length === 0) {
                errorToast("Product Name Required!");
            }  else if (!productImg) {
                errorToast("Product Image Required!");
            } else {
                // Create FormData object to send via POST request
                let formData = new FormData();
                formData.append('name', name);
                formData.append('image', productImg);

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',

                    }
                };

                // showLoader();
                // console.log("Submitting product data...");

                let res = await axios.post("/AddBrand", formData, config);
                // hideLoader();

                if (res.status === 200 || res.status === 201) {
                    successToast('Brand created successfully!');
                    // document.getElementById("save-form").reset();  // Reset form
                } else {
                    errorToast(res.message);
                }
            }
            // } catch (e) {
            //     alert(e);
            //     console.error("Error:", e ,res.messa);
            // }
        }


    </script>
@endsection



